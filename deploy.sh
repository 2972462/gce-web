#!/usr/bin/env bash
# Deploy de gce-web. Pensado para correr vía webhook en cada push a main,
# igual que /home/stockapp/deploy.sh en erp.gce.com.py.
set -euo pipefail
cd "$(dirname "$0")"

git pull origin main

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
