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

# Install PHP dependencies
RUN composer update --no-dev --optimize-autoloader --ignore-platform-reqs

EXPOSE 10000

CMD php artisan config:clear && php artisan migrate --force && php artisan serve --host 0.0.0.0 --port $PORT
