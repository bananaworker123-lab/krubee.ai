FROM wordpress:6.4-php8.1-apache

# Fix MPM conflict
RUN a2dismod mpm_event mpm_worker 2>/dev/null || true && \
    a2enmod mpm_prefork && \
    echo "Mutex posixsem" >> /etc/apache2/apache2.conf

# Copy custom theme
COPY wp-content/themes/creator-academy /var/www/html/wp-content/themes/creator-academy

# Copy custom entrypoint
COPY docker-entrypoint-custom.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint-custom.sh

RUN chown -R www-data:www-data /var/www/html/wp-content/themes/creator-academy

ENTRYPOINT ["docker-entrypoint-custom.sh"]
