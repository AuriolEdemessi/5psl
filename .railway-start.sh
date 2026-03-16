#!/bin/bash
echo "Starting Railway deployment script..."

echo "1. Running migrations..."
php artisan migrate --force || echo "Migration failed! Continuing anyway..."

echo "2. Caching configurations..."
php artisan config:cache || echo "Config cache failed!"
php artisan route:cache || echo "Route cache failed!"
php artisan view:cache || echo "View cache failed!"

echo "3. Preparing Nginx config..."
export NIXPACKS_PHP_ROOT_DIR="/app/public"
export IS_LARAVEL="yes"
node /assets/scripts/prestart.mjs /assets/nginx.template.conf /nginx.conf || echo "Prestart Nginx script failed!"

echo "4. Starting PHP-FPM..."
php-fpm -y /assets/php-fpm.conf &

echo "5. Starting Nginx..."
exec nginx -c /nginx.conf
