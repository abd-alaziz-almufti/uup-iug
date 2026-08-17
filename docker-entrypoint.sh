#!/usr/bin/env bash
# =============================================================================
# Docker Entrypoint Script for Laravel 12 on Render
# =============================================================================
set -e

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
