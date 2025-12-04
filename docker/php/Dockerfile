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

# Create minimal .env file for composer scripts
RUN echo "APP_ENV=prod" > /var/www/backend/.env && \
    echo "APP_SECRET=dummy_secret_for_build" >> /var/www/backend/.env

# Install dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts || true && \
    composer dump-autoload --optimize --no-dev --classmap-authoritative || true

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
