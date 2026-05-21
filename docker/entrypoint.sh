#!/bin/sh
set -e

echo "==> Caching Laravel configuration..."
php artisan config:cache

echo "==> Caching routes..."
php artisan route:cache

echo "==> Caching views..."
php artisan view:cache

echo "==> Caching events..."
php artisan event:cache

echo "==> Running database migrations..."
php artisan migrate --force

echo "==> Creating storage symlink..."
php artisan storage:link 2>/dev/null || true

echo "==> Fixing storage permissions..."
chown -R www-data:www-data /app/storage /app/bootstrap/cache

echo "==> Starting FrankenPHP..."
exec frankenphp run --config /etc/caddy/Caddyfile
