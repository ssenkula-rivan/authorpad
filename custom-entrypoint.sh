#!/bin/bash
set -e

echo "Starting AuthorPad WordPress initialization..."

# Ensure uploads directory exists
mkdir -p /var/www/html/wp-content/uploads

# Ensure proper permissions
chown -R www-data:www-data /var/www/html/wp-content
chmod -R 755 /var/www/html/wp-content

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
