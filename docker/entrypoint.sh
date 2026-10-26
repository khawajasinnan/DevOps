#!/bin/sh
set -e
cd /var/www
echo "Running database migrations..."
php artisan migrate --force
chown -R www-data:www-data storage bootstrap/cache
exec "$@"
