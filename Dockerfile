FROM wordpress:6.4-php8.1-apache

# Fix apache2 MPM conflict
RUN a2dismod mpm_event mpm_worker 2>/dev/null || true && \
    a2enmod mpm_prefork

# Copy custom theme
COPY wp-content/themes/creator-academy /var/www/html/wp-content/themes/creator-academy

# Set permissions
RUN chown -R www-data:www-data /var/www/html/wp-content/themes/creator-academy
