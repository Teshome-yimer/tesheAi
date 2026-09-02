FROM php:8.2-cli

# Required system dependencies
RUN apt-get update && apt-get install -y \
    git unzip libpng-dev libonig-dev libxml2-dev curl

# PHP Extensions
RUN docker-php-ext-install pdo_mysql mbstring gd

# Increase Upload Limits to 50MB
RUN echo "upload_max_filesize = 50M" > /usr/local/etc/php/conf.d/uploads.ini \
 && echo "post_max_size = 50M" >> /usr/local/etc/php/conf.d/uploads.ini

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

# ስትራይፕ ፓኬጅን በቀጥታ እዚህ ጋር ማስገባት ይቻላል (አማራጭ 1 - አሁን በቀጥታ ለመጨመር)
RUN COMPOSER_MEMORY_LIMIT=-1 composer require stripe/stripe-php

RUN chmod -R 775 storage bootstrap/cache

# Set Directory Permissions
RUN chmod -R 777 storage bootstrap/cache

# Install PHP dependencies
RUN COMPOSER_MEMORY_LIMIT=-1 composer update --no-dev --optimize-autoloader --ignore-platform-reqs
CMD php artisan config:clear && php artisan migrate --force && php artisan serve --host 0.0.0.0 --port $PORT
