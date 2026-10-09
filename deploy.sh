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
php artisan route:cache
php artisan view:cache
