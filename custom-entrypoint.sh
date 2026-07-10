#!/bin/bash
set -e

# Dismod and enmod MPM (Fix for Railway Apache MPM crash)
a2dismod mpm_event || true
a2enmod mpm_prefork || true

# Restore uploads from image backup to the persistent volume if the volume is empty
if [ -z "$(ls -A /var/www/html/wp-content/uploads 2>/dev/null)" ]; then
    echo "Uploads volume is empty - restoring from image backup..."
    mkdir -p /var/www/html/wp-content/uploads
    if [ -d "/var/www/html/wp-content/uploads_backup" ]; then
        cp -r /var/www/html/wp-content/uploads_backup/. /var/www/html/wp-content/uploads/ 2>/dev/null || true
        echo "Uploads restored successfully."
    fi
    chown -R www-data:www-data /var/www/html/wp-content/uploads
else
    echo "Uploads volume already has files - skipping restore."
fi

# Call the original WordPress entrypoint
exec docker-entrypoint.sh "$@"
