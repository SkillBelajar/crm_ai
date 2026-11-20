#!/bin/sh
set -e

# Ensure storage and bootstrap directories exist
mkdir -p /var/www/html/storage/framework/cache/data
mkdir -p /var/www/html/storage/framework/sessions
mkdir -p /var/www/html/storage/framework/views
mkdir -p /var/www/html/storage/logs
mkdir -p /var/www/html/bootstrap/cache

chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache

# Generate application key if missing
if [ -f /var/www/html/.env ]; then
    if ! grep -q "^APP_KEY=base64:" /var/www/html/.env; then
        php artisan key:generate --force || true
    fi
fi

echo "Starting Laravel Octane FrankenPHP on port 8000..."
exec php artisan octane:start --server=frankenphp --host=0.0.0.0 --port=8000
