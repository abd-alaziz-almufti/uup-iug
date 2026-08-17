#!/usr/bin/env bash
# =============================================================================
# Docker Entrypoint Script for Laravel 12 on Render
# =============================================================================
set -e

# Ensure .env exists and uses environment variables
cp .env.example .env

if [ -n "$DB_CONNECTION" ]; then
    sed -i "s|^DB_CONNECTION=.*|DB_CONNECTION=$DB_CONNECTION|" .env || true
fi
if [ -n "$SESSION_DRIVER" ]; then
    sed -i "s|^SESSION_DRIVER=.*|SESSION_DRIVER=$SESSION_DRIVER|" .env || true
fi
if [ -n "$CACHE_STORE" ]; then
    sed -i "s|^CACHE_STORE=.*|CACHE_STORE=$CACHE_STORE|" .env || true
fi

# Ensure APP_KEY is valid base64 key
if [ -z "$APP_KEY" ] || [[ "$APP_KEY" != base64:* ]]; then
    echo "=== Generating Valid Base64 Laravel APP_KEY ==="
    GENERATED_KEY=$(php -r 'echo "base64:".base64_encode(random_bytes(32));')
    export APP_KEY="$GENERATED_KEY"
    echo "APP_KEY set to: ${APP_KEY:0:20}..."
    if grep -q "^APP_KEY=" .env; then
        sed -i "s|^APP_KEY=.*|APP_KEY=$GENERATED_KEY|" .env
    else
        echo "APP_KEY=$GENERATED_KEY" >> .env
    fi
fi

echo "=== Running Laravel Database Migrations ==="
php artisan migrate --force

if [ "${SEED_DATABASE:-false}" = "true" ]; then
    echo "=== Running Initial Database Seeder ==="
    php artisan db:seed --force || true
fi

echo "=== Clearing & Caching Configuration & Routes ==="
php artisan config:clear || true
php artisan route:clear || true
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

echo "=== Publishing & Linking Assets ==="
php artisan storage:link || true
php artisan filament:upgrade || true
php artisan vendor:publish --tag=laravel-assets --ansi --force || true

# Ensure permissions
chmod -R 777 storage bootstrap/cache || true
chmod -R 755 public || true

echo "=== Starting Laravel Application on Port ${PORT:-8080} ==="
exec php artisan serve --host=0.0.0.0 --port="${PORT:-8080}"
