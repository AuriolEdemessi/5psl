#!/bin/bash
echo "Starting Railway deployment script..."

echo "1. Creating caching directories..."
mkdir -p storage/framework/cache/data
mkdir -p storage/framework/views
mkdir -p storage/framework/sessions
mkdir -p bootstrap/cache

echo "2. Applying permissions..."
chmod -R 775 storage bootstrap/cache

echo "3. Running migrations..."
php artisan migrate --force || echo "Migration failed! Continuing anyway..."

echo "4. Caching configurations..."
php artisan config:cache || echo "Config cache failed!"
php artisan route:cache || echo "Route cache failed!"
php artisan view:cache || echo "View cache failed!"

echo "5. Starting PHP-FPM and Nginx..."
# We will use the built-in Nixpacks command to start the server properly
# The environment variables below ensure Laravel works seamlessly
export IS_LARAVEL="yes"
export NIXPACKS_PHP_ROOT_DIR="/app/public"
export PORT=${PORT:-80}

# Generate Nginx template
echo "Generating Nginx template..."
node /assets/scripts/prestart.mjs /assets/nginx.template.conf /nginx.conf || { echo "Prestart failed!"; exit 1; }

# Start PHP-FPM in background
echo "Starting php-fpm..."
php-fpm -y /assets/php-fpm.conf &

# Start Nginx
echo "Starting Nginx..."
exec nginx -c /nginx.conf
