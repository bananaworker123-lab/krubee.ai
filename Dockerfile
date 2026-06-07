FROM wordpress:latest

# Copy custom theme
COPY wp-content/themes/creator-academy /var/www/html/wp-content/themes/creator-academy

# Set permissions
RUN chown -R www-data:www-data /var/www/html/wp-content/themes/creator-academy
