#!/usr/bin/env bash
# Deploy de gce-web. Pensado para correr vía webhook en cada push a main,
# igual que /home/stockapp/deploy.sh en erp.gce.com.py.
set -euo pipefail
cd "$(dirname "$0")"

# El webhook lo dispara PHP-FPM, que no hereda el PATH de una shell
# interactiva: node/npm instalados vía nvm no aparecen sin esto.
export PATH="/home/gce/.nvm/versions/node/v20.20.2/bin:$PATH"

antes="$(git rev-parse HEAD)"
git pull origin main
despues="$(git rev-parse HEAD)"

# bash ya tiene este archivo leído en memoria: si git pull lo cambió,
# nos reiniciamos para correr con el contenido nuevo en vez de seguir
# ejecutando el script viejo hasta el final.
if [ "$antes" != "$despues" ]; then
    exec bash "$0" "$@"
fi

composer install --no-dev --optimize-autoloader
npm ci
npm run build

php artisan migrate --force
php artisan storage:link
php artisan config:cache
php artisan view:cache
# route:cache no se usa: routes/web.php define '/' y '/dashboard' como
# closures, y Laravel no puede serializar closures para cachear rutas
# (falla con "Uses Closure" y aborta el deploy antes de llegar a view:cache).
