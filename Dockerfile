FROM php:8.2-fpm

WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    nginx supervisor zip unzip curl git libzip-dev libpng-dev libjpeg-dev libfreetype6-dev \
    libonig-dev libxml2-dev libsqlite3-dev sqlite3

# PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring zip gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy project
COPY . /var/www

# Set permission
RUN chmod -R 775 storage bootstrap/cache

# Install dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Copy env & generate key
COPY .env.example .env
RUN php artisan key:generate
RUN php artisan config:cache

# Copy Nginx & Supervisor config
COPY nginx.conf /etc/nginx/sites-available/default
COPY supervisord.conf /etc/supervisord.conf

EXPOSE 80

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
