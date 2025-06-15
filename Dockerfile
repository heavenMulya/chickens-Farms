FROM composer:latest AS build

WORKDIR /app

COPY . .

RUN composer install --no-dev --optimize-autoloader

FROM php:8.1.6-apache

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Enable Apache rewrite module
RUN a2enmod rewrite

# Change Apache to listen on port 8080 (for Railway)
RUN sed -i 's/Listen 80/Listen 8080/' /etc/apache2/ports.conf && \
    sed -i 's/:80>/:8080>/' /etc/apache2/sites-available/000-default.conf

# Copy Laravel app from builder stage
COPY --from=build /app /var/www/html

WORKDIR /var/www/html

# Set proper permissions for Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Apache config (make sure this file exists)
COPY ./docker/apache.conf /etc/apache2/sites-available/000-default.conf

EXPOSE 8080
