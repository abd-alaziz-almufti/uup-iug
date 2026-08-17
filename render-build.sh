#!/usr/bin/env bash
# =============================================================================
# Render Build Script for UUP-IUG (Laravel 12 + Filament 4)
# =============================================================================
set -e

echo "=== [1/7] Installing PHP dependencies ==="
composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

echo "=== [2/7] Installing Node.js dependencies ==="
npm ci

echo "=== [3/7] Building frontend assets (Vite + Tailwind) ==="
npm run build

echo "=== [4/7] Setting up environment ==="
# Copy example env if .env doesn't exist (it won't on Render)
if [ ! -f .env ]; then
    cp .env.example .env
fi

echo "=== [5/6] Generating application key (if missing) ==="
php artisan key:generate --force

echo "=== [6/6] Running database migrations & caching ==="
php artisan migrate --force

# Seed database on first deployment (or if SEED_ON_BUILD is true)
if [ "${SEED_DATABASE:-false}" = "true" ]; then
    echo "Running database seeder..."
    php artisan db:seed --force
fi

# Cache configuration for better performance
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Create storage symlink
php artisan storage:link || true

# Set proper permissions for storage and cache
chmod -R 775 storage bootstrap/cache

echo "=== Build complete! ==="
