# =============================================================================
# Production Dockerfile for Laravel 12 + Filament 4 on Render
# =============================================================================

# Stage 1: Build frontend assets
FROM node:20-alpine AS frontend
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY . .
RUN npm run build

# Stage 2: PHP Application Environment
FROM php:8.3-cli-alpine

# Environment variables for Composer
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_MEMORY_LIMIT=-1

# Install system dependencies, git, unzip & PHP extensions required by Laravel & Filament
RUN apk add --no-cache \
    git \
    unzip \
    zip \
    bash \
    icu-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    postgresql-dev \
    oniguruma-dev \
    linux-headers \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo_pgsql \
        pgsql \
        gd \
        intl \
        zip \
        bcmath \
        opcache

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy project files
COPY . .

# Copy built Vite assets from frontend stage
COPY --from=frontend /app/public/build ./public/build

# Install PHP production dependencies with git fallback if GitHub zip CDN rate limits (HTTP 429)
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist || \
    composer install --no-dev --optimize-autoloader --no-interaction --prefer-source

# Copy entrypoint script and make it executable
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Set directory permissions for app, storage and public assets
RUN chown -R www-data:www-data /var/www/html

EXPOSE 8080

ENTRYPOINT ["docker-entrypoint.sh"]
