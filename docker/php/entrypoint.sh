#!/bin/sh
set -e

# Ensure cache directories exist with proper permissions
# Entrypoint runs as root before PHP-FPM switches to www-data
mkdir -p /var/www/backend/var/cache/prod \
         /var/www/backend/var/cache/dev \
         /var/www/backend/var/cache/test \
         /var/www/backend/var/log

# Set proper ownership and permissions (entrypoint runs as root)
chown -R www-data:www-data /var/www/backend/var
chmod -R 775 /var/www/backend/var

# Execute the main command (PHP-FPM will switch to www-data internally)
exec "$@"