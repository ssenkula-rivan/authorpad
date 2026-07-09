#!/bin/bash
set -e

echo "Starting AuthorPad WordPress initialization..."

# If the uploads directory is empty (e.g. new volume mounted), copy pre-existing uploads from backup
if [ -z "$(ls -A /var/www/html/wp-content/uploads 2>/dev/null)" ]; then
    echo "Uploads directory is empty, copying pre-existing uploads from backup..."
    mkdir -p /var/www/html/wp-content/uploads
    if [ -d "/var/www/html/wp-content/uploads_backup" ]; then
        cp -r /var/www/html/wp-content/uploads_backup/* /var/www/html/wp-content/uploads/ 2>/dev/null || true
    fi
    chown -R www-data:www-data /var/www/html/wp-content/uploads
fi

# Ensure proper permissions
chown -R www-data:www-data /var/www/html/wp-content
chmod 755 /var/www/html/wp-content
chmod 644 /var/www/html/.htaccess || true

# Enable Apache modules
a2enmod rewrite || true
a2enmod headers || true
a2enmod expires || true

# Disable and enable MPM modules to fix Railway Apache issues
a2dismod mpm_event || true
a2enmod mpm_prefork || true

# Ensure Apache configuration allows .htaccess overrides
if ! grep -q "AllowOverride All" /etc/apache2/apache2.conf; then
    echo '<Directory /var/www/html/>' >> /etc/apache2/apache2.conf
    echo '    AllowOverride All' >> /etc/apache2/apache2.conf
    echo '    Require all granted' >> /etc/apache2/apache2.conf
    echo '</Directory>' >> /etc/apache2/apache2.conf
fi

echo "WordPress initialization complete. Starting Apache..."

# Call the original entrypoint
exec docker-entrypoint.sh "$@"
