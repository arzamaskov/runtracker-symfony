FROM php:8.4-fpm-alpine

# Install build dependencies (needed for compiling PHP extensions)
RUN apk add --no-cache --virtual .build-deps \
    git \
    curl \
    postgresql-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_pgsql zip opcache \
    && apk del .build-deps \
    && apk add --no-cache \
    postgresql-libs \
    libzip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configure PHP
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Set working directory
WORKDIR /var/www/backend

# Copy composer files first (for better layer caching)
COPY backend/composer.json backend/composer.lock ./

# Create minimal .env file for composer scripts
RUN echo "APP_ENV=prod" > .env && \
    echo "APP_SECRET=dummy_secret_for_build" >> .env

# Install dependencies (without optimized autoload yet)
RUN composer install --no-dev --no-interaction --no-scripts

# Copy application files (before autoload optimization)
COPY backend/ ./

# Optimize autoload AFTER all files are copied
RUN composer dump-autoload --optimize --no-dev --classmap-authoritative && \
    rm -rf /usr/bin/composer

# Create system user
ARG UID=1000
ARG GID=1000
RUN addgroup -g $GID app && \
    adduser -u $UID -G app -s /bin/sh -D app

# Create cache and log directories with proper permissions
RUN mkdir -p var/cache/prod var/log && \
    chown -R www-data:www-data /var/www/backend && \
    chmod -R 755 /var/www/backend && \
    chmod 775 var && \
    chmod -R 775 var/cache var/log

EXPOSE 9000

CMD ["php-fpm"]
