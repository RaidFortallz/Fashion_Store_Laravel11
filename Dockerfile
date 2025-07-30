FROM php:8.2-fpm

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    zip unzip curl git libxml2-dev libzip-dev libpng-dev libjpeg-dev libonig-dev \
    sqlite3 libsqlite3-dev

RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . /var/www

RUN chmod -R 775 storage bootstrap/cache
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

COPY .env.example .env
RUN php artisan key:generate
RUN php artisan config:cache

CMD ["php-fpm"]