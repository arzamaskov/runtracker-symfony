FROM php:8.4-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    git \
    curl \
    postgresql-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_pgsql zip opcache

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configure PHP
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Set working directory
WORKDIR /var/www/backend

# Copy application files
COPY backend/ /var/www/backend/

# Install dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction || true

# Set permissions
RUN chown -R www-data:www-data /var/www/backend

# Create system user to run Composer and Artisan Commands
ARG UID=1000
ARG GID=1000
RUN addgroup -g $GID app && \
    adduser -u $UID -G app -s /bin/sh -D app

USER app

EXPOSE 9000

CMD ["php-fpm"]
