#!/usr/bin/env bash
# =============================================================================
# Docker Entrypoint Script for Laravel 12 on Render
# =============================================================================
set -e

# Ensure .env exists
if [ ! -f .env ]; then
    cp .env.example .env
fi

# Ensure APP_KEY is valid base64 key
if [ -z "$APP_KEY" ] || [[ "$APP_KEY" != base64:* ]]; then
    echo "=== Generating Laravel APP_KEY ==="
    php artisan key:generate --force
fi

echo "=== Running Laravel Database Migrations ==="
php artisan migrate --force

if [ "${SEED_DATABASE:-false}" = "true" ]; then
    echo "=== Running Initial Database Seeder ==="
    php artisan db:seed --force || true
fi

echo "=== Caching Configuration & Routes ==="
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

echo "=== Creating Storage Symlink ==="
php artisan storage:link || true

# Ensure permissions
chmod -R 775 storage bootstrap/cache || true

echo "=== Starting Laravel Application on Port ${PORT:-8080} ==="
exec php artisan serve --host=0.0.0.0 --port="${PORT:-8080}"
