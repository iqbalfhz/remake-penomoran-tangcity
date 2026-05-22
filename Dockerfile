# ============================================================
# Stage 1 â€” Build frontend assets (Node.js)
# ============================================================
FROM node:22-alpine AS node-builder

WORKDIR /app

# Install dependencies first (layer cache)
COPY package*.json ./
RUN npm ci --no-audit --no-fund

# Copy source files needed for Vite/Tailwind build
COPY resources/ resources/
COPY vite.config.js ./
COPY public/ public/

# Build production assets
RUN npm run build

# ============================================================
# Stage 2 â€” PHP application (FrankenPHP)
# ============================================================
FROM dunglas/frankenphp:1-php8.4-alpine

# Install system packages
RUN apk add --no-cache \
    curl \
    git \
    mysql-client \
    libpng \
    libzip \
    icu

# Install required PHP extensions
RUN install-php-extensions \
    pdo_mysql \
    opcache \
    intl \
    zip \
    bcmath \
    gd \
    mbstring \
    pcntl \
    exif \
    fileinfo

# PHP performance config for production
RUN { \
    echo "opcache.enable=1"; \
    echo "opcache.memory_consumption=256"; \
    echo "opcache.interned_strings_buffer=16"; \
    echo "opcache.max_accelerated_files=20000"; \
    echo "opcache.validate_timestamps=0"; \
    echo "opcache.save_comments=1"; \
    echo "opcache.fast_shutdown=1"; \
    echo "expose_php=Off"; \
} >> "$PHP_INI_DIR/conf.d/opcache.ini"

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Install PHP dependencies (separate layer for Docker cache)
COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --no-scripts \
    --no-autoloader \
    --prefer-dist \
    --no-interaction \
    --no-progress

# Copy full application source
COPY . .

# Copy built frontend assets from Stage 1
COPY --from=node-builder /app/public/build ./public/build

# Ensure required directories exist before composer triggers artisan package:discover
RUN mkdir -p bootstrap/cache \
    && mkdir -p storage/framework/views \
    && mkdir -p storage/framework/cache \
    && mkdir -p storage/framework/sessions

# Finalise Composer autoloader
RUN composer dump-autoload \
    --optimize \
    --classmap-authoritative \
    --no-dev

# Copy custom Caddyfile
COPY Caddyfile /etc/caddy/Caddyfile

# Set storage permissions
RUN mkdir -p storage/framework/{cache,sessions,testing,views} \
            storage/app/public \
            bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Copy and prepare entrypoint
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Health check using Laravel's built-in /up route
HEALTHCHECK --interval=30s --timeout=10s --start-period=60s --retries=3 \
    CMD curl -fsS http://localhost/up || exit 1

EXPOSE 80

CMD ["/entrypoint.sh"]
