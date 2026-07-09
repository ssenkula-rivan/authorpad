FROM wordpress:php8.1-apache

# Disable and enable MPM modules to fix Railway Apache issues
RUN a2dismod mpm_event && \
    a2enmod mpm_prefork

# Enable Apache modules needed for WordPress
RUN a2enmod rewrite && \
    a2enmod headers && \
    a2enmod expires

# Copy our custom entrypoint script first
COPY custom-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/custom-entrypoint.sh

# Copy website files
COPY . /var/www/html/

# Ensure proper permissions
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html/wp-content

# Set proper Apache configuration
RUN echo '<Directory /var/www/html/>' >> /etc/apache2/apache2.conf && \
    echo '    AllowOverride All' >> /etc/apache2/apache2.conf && \
    echo '    Require all granted' >> /etc/apache2/apache2.conf && \
    echo '</Directory>' >> /etc/apache2/apache2.conf

ENTRYPOINT ["custom-entrypoint.sh"]
CMD ["apache2-foreground"]
