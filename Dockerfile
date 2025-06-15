# 1. Build stage: install dependencies
FROM composer:latest AS build
WORKDIR /app
COPY . .
RUN composer install --no-dev --optimize-autoloader

# 2. Serve stage: PHP + Apache
FROM php:8.2.12-apache

# Install extensions
RUN docker-php-ext-install pdo pdo_mysql

# Enable Apache rewrite module
RUN a2enmod rewrite

# Install gettext-base for envsubst and set ServerName
RUN apt-get update \
    && apt-get install -y gettext-base \
    && echo "ServerName localhost" >> /etc/apache2/apache2.conf \
    && rm -rf /var/lib/apt/lists/*

# Copy virtual host template
COPY ./docker/apache.conf /etc/apache2/sites-available/000-default.conf.template

# Copy Laravel app and set permissions
COPY --from=build /app /var/www/html
WORKDIR /var/www/html
RUN chown -R www-data:www-data storage bootstrap/cache

# Create startup script
RUN echo '#!/bin/bash\n\
# Set default port if not provided\n\
export PORT=${PORT:-90}\n\
# Generate Apache config with environment variables\n\
envsubst '"'"'$PORT'"'"' < /etc/apache2/sites-available/000-default.conf.template > /etc/apache2/sites-available/000-default.conf\n\
# Start Apache\n\
exec apache2-foreground' > /usr/local/bin/start-apache.sh \
    && chmod +x /usr/local/bin/start-apache.sh

# Use port 90 for local development
EXPOSE 90

# Use the startup script
CMD ["/usr/local/bin/start-apache.sh"]