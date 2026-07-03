FROM wordpress:php8.1-apache

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

# Ensure permissions
RUN chown -R www-data:www-data /var/www/html

ENTRYPOINT ["custom-entrypoint.sh"]
CMD ["apache2-foreground"]
