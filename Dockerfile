FROM wordpress:php8.1-apache

# Enable Apache modules needed for WordPress
RUN a2enmod rewrite
RUN a2enmod headers
RUN a2enmod expires

# Copy website files
COPY . /var/www/html/

# Move existing uploads to a backup directory, so we can copy them to the volume if empty
RUN if [ -d "/var/www/html/wp-content/uploads" ]; then \
        mv /var/www/html/wp-content/uploads /var/www/html/wp-content/uploads_backup && \
        mkdir -p /var/www/html/wp-content/uploads; \
    fi

# Copy our custom entrypoint script
COPY custom-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/custom-entrypoint.sh

# Ensure proper permissions
RUN chown -R www-data:www-data /var/www/html
RUN chmod 644 /var/www/html/.htaccess

# Set proper Apache configuration
RUN echo '<Directory /var/www/html/>' >> /etc/apache2/apache2.conf && \
    echo '    AllowOverride All' >> /etc/apache2/apache2.conf && \
    echo '    Require all granted' >> /etc/apache2/apache2.conf && \
    echo '</Directory>' >> /etc/apache2/apache2.conf

ENTRYPOINT ["custom-entrypoint.sh"]
CMD ["apache2-foreground"]
