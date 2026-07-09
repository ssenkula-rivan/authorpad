#!/bin/bash
set -e

echo "Starting AuthorPad WordPress initialization..."

# Ensure uploads directory exists
mkdir -p /var/www/html/wp-content/uploads

# Ensure proper permissions
chown -R www-data:www-data /var/www/html/wp-content
chmod -R 755 /var/www/html/wp-content

echo "WordPress initialization complete. Starting Apache..."

# Call the original entrypoint
exec docker-entrypoint.sh "$@"
