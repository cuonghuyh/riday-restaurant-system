# Sử dụng PHP 8.2 với Apache
FROM php:8.2-apache

# Cài đặt các dependencies cần thiết
RUN apt-get update && apt-get install -y \
    sqlite3 \
    libsqlite3-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_sqlite pdo_mysql mysqli

# Cài đặt Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Enable Apache rewrite module
RUN a2enmod rewrite

# Copy source code
COPY . /var/www/html/

# Cài đặt dependencies PHP
RUN cd /var/www/html && composer install --no-dev --optimize-autoloader

# Tạo database directory và set permissions
RUN mkdir -p /var/www/html/database \
    && touch /var/www/html/database/restaurant.db \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod 664 /var/www/html/database/restaurant.db

# Expose port cho Render
EXPOSE $PORT

# Start Apache với port từ environment variable
CMD sed -i "s/80/$PORT/g" /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf && apache2-foreground
