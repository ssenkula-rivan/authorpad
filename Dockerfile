FROM wordpress:php8.1-apache

# Fix Apache MPM conflict - disable event/worker, enable prefork
RUN a2dismod mpm_event mpm_worker || true && \
    a2enmod mpm_prefork || true && \
    a2enmod rewrite headers || true

# Copy website files
COPY . /var/www/html/

# Copy and enable our custom entrypoint
COPY custom-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/custom-entrypoint.sh

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html/wp-content

# Enable AllowOverride for .htaccess (needed for WordPress pretty permalinks)
RUN echo '<Directory /var/www/html/>' >> /etc/apache2/apache2.conf && \
    echo '    AllowOverride All' >> /etc/apache2/apache2.conf && \
    echo '    Require all granted' >> /etc/apache2/apache2.conf && \
    echo '</Directory>' >> /etc/apache2/apache2.conf

ENTRYPOINT ["custom-entrypoint.sh"]
CMD ["apache2-foreground"]
