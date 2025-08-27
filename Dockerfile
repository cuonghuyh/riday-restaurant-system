# Sử dụng PHP 8.2 với Apache
FROM php:8.2-apache

# Cài đặt các extension PHP cần thiết
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Enable Apache rewrite module
RUN a2enmod rewrite

# Copy source code
COPY . /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expose port
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
