# 1. Build stage: install dependencies
FROM composer:latest AS build
WORKDIR /app
COPY . .
RUN composer install --no-dev --optimize-autoloader

# 2. Serve stage: PHP + Apache
FROM php:8.1.6-apache

# Install extensions
RUN docker-php-ext-install pdo pdo_mysql

# Enable Apache rewrite module
RUN a2enmod rewrite

# Set dynamic port and suppress hostname warning

 RUN apt-get update \
 && apt-get install -y gettext-base \
 && echo "ServerName localhost" >> /etc/apache2/apache2.conf \
 && rm -rf /var/lib/apt/lists/*


# Copy virtual host config and replace placeholder with $PORT
COPY ./docker/apache.conf /etc/apache2/sites-available/000-default.conf.template
RUN envsubst '$PORT' < /etc/apache2/sites-available/000-default.conf.template \
    > /etc/apache2/sites-available/000-default.conf

# Copy Laravel app and set permissions
COPY --from=build /app /var/www/html
WORKDIR /var/www/html
RUN chown -R www-data:www-data storage bootstrap/cache

# Expose port (optional—Railway uses PORT env)
EXPOSE ${PORT}

# Run Apache in the foreground
CMD ["apache2-foreground"]
