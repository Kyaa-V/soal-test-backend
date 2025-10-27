# ============================================
# Stage 1: Builder
# ============================================
FROM phpswoole/swoole:php8.3-alpine AS builder

WORKDIR /var/www

# Install system dependencies
RUN apk add --no-cache \
    git curl zip unzip bash \
    libpng-dev libjpeg-turbo-dev freetype-dev \
    icu-dev oniguruma-dev libxml2-dev sqlite-dev libzip-dev \
    autoconf gcc g++ make linux-headers

RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install -j$(nproc) \
    gd bcmath intl pdo_mysql pdo_sqlite zip opcache sockets pcntl

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

# Copy composer files
COPY composer.json composer.lock* ./

# Install dependencies tanpa horizon dulu
RUN composer install --no-scripts --no-autoloader --prefer-dist --no-interaction --no-progress

# Copy seluruh aplikasi
COPY . .

# INSTALL HORIZON DAN OCTANE SECARA EKSPLISIT
RUN composer require laravel/octane --no-interaction --with-all-dependencies
RUN composer require laravel/horizon --no-interaction

# Update composer.json untuk memastikan horizon tercatat
RUN composer update --no-interaction --no-progress

# Final autoload
RUN composer dump-autoload --optimize --classmap-authoritative

# ============================================
# Stage 2: Runtime
# ============================================
FROM phpswoole/swoole:php8.3-alpine AS base-runtime

WORKDIR /var/www

RUN apk add --no-cache \
    bash git unzip \
    libzip libpng libjpeg-turbo freetype icu oniguruma sqlite-libs \
    nginx supervisor mysql-client nodejs npm

# Copy PHP extensions
COPY --from=builder /usr/local/etc/php/conf.d /usr/local/etc/php/conf.d
COPY --from=builder /usr/local/lib/php/extensions /usr/local/lib/php/extensions

# Copy seluruh aplikasi termasuk vendor
COPY --from=builder --chown=www-data:www-data /var/www /var/www

# Setup directories
RUN mkdir -p \
    storage/app/public \
    storage/framework/{cache/data,sessions,views} \
    storage/logs \
    bootstrap/cache \
    /var/run/php \
    /var/log/supervisor && \
    chown -R www-data:www-data \
    storage bootstrap/cache /var/run/php /var/log/supervisor && \
    chmod -R 775 storage bootstrap/cache

# Copy configs
COPY ./docker/supervisord/supervisord-octane-dev.conf /etc/supervisor/conf.d/supervisord.conf
COPY ./docker/common/init.sh /usr/local/bin/init.sh
RUN chmod +x /usr/local/bin/init.sh

EXPOSE 8000 80 443

ENTRYPOINT ["/usr/local/bin/init.sh"]
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
# ============================================
# Stage 3: Development
# ============================================
FROM base-runtime AS development

RUN apk add --no-cache nodejs npm vim nano
RUN npm install chokidar

COPY ./docker/supervisord/supervisord-octane-dev.conf /etc/supervisor/conf.d/supervisord.conf

COPY ./docker/common/init.sh /usr/local/bin/init.sh
RUN chmod +x /usr/local/bin/init.sh

EXPOSE 8000 80 443

ENTRYPOINT ["/usr/local/bin/init.sh"]
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]

# ============================================
# Stage 4: Production
# ============================================
FROM base-runtime AS production

# Untuk production, install tanpa dev dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress && \
    composer dump-autoload --optimize && \
    php artisan package:discover --no-interaction

COPY ./docker/supervisord/supervisord-octane-prod.conf /etc/supervisor/conf.d/supervisord.conf

COPY ./docker/common/init.sh /usr/local/bin/init.sh
RUN chmod +x /usr/local/bin/init.sh

RUN php artisan config:cache || true && \
    php artisan route:cache || true && \
    php artisan view:cache || true

EXPOSE 8000 80 443

HEALTHCHECK --interval=30s --timeout=10s --start-period=40s --retries=3 \
    CMD php artisan octane:status || exit 1

ENTRYPOINT ["/usr/local/bin/init.sh"]
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]