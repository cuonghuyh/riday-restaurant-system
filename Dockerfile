﻿FROM php:8.1-apache

RUN docker-php-ext-install pdo pdo_mysql pdo_pgsql
RUN a2enmod rewrite

WORKDIR /var/www/html
COPY . /var/www/html/

RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

EXPOSE 80
CMD ["apache2-foreground"]
