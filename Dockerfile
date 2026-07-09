FROM wordpress:php8.1-apache

# Disable conflicting MPM modules and enable prefork (Fixes Railway Apache crash)
RUN a2dismod mpm_event mpm_worker || true
RUN a2enmod mpm_prefork || true

COPY . /var/www/html/
RUN chown -R www-data:www-data /var/www/html
