#!/bin/bash
set -e

# If the uploads directory is empty (e.g. new volume mounted), copy pre-existing uploads from backup
if [ -z "$(ls -A /var/www/html/wp-content/uploads 2>/dev/null)" ]; then
    echo "uploads directory is empty, copying pre-existing uploads from backup..."
    mkdir -p /var/www/html/wp-content/uploads
    if [ -d "/var/www/html/wp-content/uploads_backup" ]; then
        cp -r /var/www/html/wp-content/uploads_backup/* /var/www/html/wp-content/uploads/ 2>/dev/null || true
    fi
    chown -R www-data:www-data /var/www/html/wp-content/uploads
fi

# Call the original entrypoint
exec docker-entrypoint.sh "$@"
