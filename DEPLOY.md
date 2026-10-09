# Deploy a gce.com.py (CloudPanel, servidor "mail" 64.23.176.222)

## 1. Primer deploy (manual, por SSH/Terminal del sitio en CloudPanel)

```bash
cd /home/gce
git clone https://github.com/2972462/gce-web.git
cd gce-web

composer install --no-dev --optimize-autoloader
npm ci
npm run build

cp .env.example .env
php artisan key:generate
# Editar .env con los valores reales:
#   - DB_* (o dejar sqlite si alcanza)
#   - AUX_DB_* (usuario de solo lectura de la base "auxiliar", ver mas abajo)
#   - RECAPTCHA_SITE_KEY / RECAPTCHA_SECRET_KEY
#   - DEPLOY_WEBHOOK_SECRET (generar con: openssl rand -hex 32)
#   - APP_URL=https://gce.com.py
#   - APP_ENV=production
#   - APP_DEBUG=false

php artisan migrate --seed --force
```

Si `DB_CONNECTION=sqlite`, asegurarse de que `database/database.sqlite`
exista y sea escribible por el usuario del sitio (`gce`):

```bash
touch database/database.sqlite
chmod 664 database/database.sqlite
```

## 2. Apuntar CloudPanel a la carpeta `public/`

En CloudPanel, sitio `gce.com.py` > pestaña **Configuración** > **Directorio
Root**: cambiar de `gce.com.py` a `gce-web/public` (es relativo a
`/home/gce/htdocs/`, así que el clone en el paso 1 debería hacerse dentro
de `htdocs`, no en `/home/gce` directo — ajustar el `cd` de arriba a
`/home/gce/htdocs` si corresponde a como esta armado el sitio actual).

**Importante**: nunca apuntar el Directorio Root a la raíz del proyecto
(`gce-web/`) — eso expondría `.env`, `app/`, `vendor/` directamente por
HTTP. Siempre tiene que ser la subcarpeta `public/`.

## 3. Webhook de deploy automático (mismo patrón que erp.gce.com.py)

Este proyecto no usa un script PHP suelto como listener: el webhook es
una ruta de la propia app (`POST /deploy-webhook`, ver
`app/Http/Controllers/DeployWebhookController.php`), protegida con la
firma HMAC que manda GitHub. Al recibir un push a `main` corre
`deploy.sh` (pull + composer/npm install + build + migrate + cache).

En GitHub (`github.com/2972462/gce-web/settings/hooks` → *Add webhook*):

- **Payload URL**: `https://gce.com.py/deploy-webhook`
- **Content type**: `application/json`
- **Secret**: el mismo valor que `DEPLOY_WEBHOOK_SECRET` en el `.env` del
  servidor
- **Which events**: *Just the push event*

## 4. Base auxiliar de RUC (solo lectura)

La base "auxiliar" vive en el servidor del ERP (`stock-gce`,
`143.110.227.152`), **no** en el servidor de gce-web. Se conecta por red
desde gce-web (`mail`, `64.23.176.222`).

En `stock-gce`, como root de MySQL (`sudo mysql`):

```sql
CREATE USER 'gce_web_ro'@'64.23.176.222' IDENTIFIED BY 'CAMBIAR_POR_UNA_CLAVE_FUERTE';
GRANT SELECT, EXECUTE ON auxiliar.* TO 'gce_web_ro'@'64.23.176.222';
FLUSH PRIVILEGES;
```

MySQL en `stock-gce` estaba restringido a `127.0.0.1` por
`/etc/mysql/mysql.conf.d/99-bind-localhost.cnf`. Para aceptar la conexion
remota de gce-web, ese archivo se cambio a `bind-address = 0.0.0.0` (hay
que reiniciar MySQL: `sudo systemctl restart mysql`), y se agrego una
regla de `ufw` para no exponer el puerto a cualquiera:

```
sudo ufw allow from 64.23.176.222 to any port 3306 proto tcp comment 'MySQL auxiliar - solo gce-web'
```

El usuario de MySQL solo puede conectarse desde esa IP y solo tiene
SELECT/EXECUTE sobre `auxiliar`, asi que aunque el puerto 3306 ya no es
puramente local, el acceso real queda acotado a gce-web en modo lectura.

Completar en gce-web `AUX_DB_HOST=143.110.227.152` y `AUX_DB_USERNAME`/
`AUX_DB_PASSWORD` con esas credenciales, despues `php artisan config:clear`
(o `config:cache` de nuevo si se habia cacheado).

## 5. Content-Security-Policy y Alpine.js

El CSP real de gce.com.py no esta en este repo ni en el nginx del host:
lo agrega Mailu (el proxy que realmente atiende el puerto 443 publico)
desde `/mailu/overrides/nginx-http/gce_web.conf` en el servidor "mail".

El `script-src` de ese CSP necesita **`'unsafe-eval'`** ademas de
`'unsafe-inline'`, porque Alpine.js (usado en `welcome.blade.php` para
el menu movil y las calculadoras embebidas) compila las expresiones de
sus directivas (`x-show`, `x-text`, `:value`, etc.) con `new Function()`
en tiempo de ejecucion. Sin `'unsafe-eval'` esas directivas fallan en
silencio (el campo se ve bien pero no calcula nada) — el error solo
aparece en la consola del navegador como `EvalError: ... 'unsafe-eval'
is not an allowed source`.

Si se regenera o resetea ese archivo de Mailu, hay que volver a agregar
`'unsafe-eval'` al `script-src` y recargar: `docker exec mailu_front_1
nginx -s reload`.
