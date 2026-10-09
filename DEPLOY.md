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

Pedir que se corra en el servidor de la base "auxiliar" (compartida con
el ERP):

```sql
CREATE USER 'gce_web_ro'@'%' IDENTIFIED BY 'CAMBIAR_POR_UNA_CLAVE_FUERTE';
GRANT SELECT, EXECUTE ON auxiliar.* TO 'gce_web_ro'@'%';
FLUSH PRIVILEGES;
```

Idealmente reemplazar `'%'` por la IP real del servidor donde corre
gce-web, no dejarlo abierto a cualquier host. Completar `AUX_DB_*` en el
`.env` con esas credenciales.
