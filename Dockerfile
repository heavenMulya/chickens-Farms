FROM composer:latest AS build

WORKDIR /app

COPY . .

RUN composer install --no-dev --optimize-autoloader

FROM php:8.1.6-apache

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Enable Apache rewrite module

RUN a2enmod rewrite \
 && sed -i 's/Listen 80/Listen 90/' /etc/apache2/ports.conf \
 && sed -i 's/:80>/:90>/' /etc/apache2/sites-available/000-default.conf

# Suppress "Could not reliably determine" warning
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Copy app and configure permissions
COPY --from=build /app /var/www/html

EXPOSE 90
