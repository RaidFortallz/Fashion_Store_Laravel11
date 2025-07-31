# Stage 1: Build Laravel App
FROM php:8.2-fpm as backend

WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y \
    zip unzip curl git libxml2-dev libzip-dev libpng-dev libjpeg-dev libonig-dev \
    sqlite3 libsqlite3-dev libfreetype6-dev libjpeg62-turbo-dev libwebp-dev \
    nginx supervisor

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring zip gd bcmath pcntl exif

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy Laravel project files
COPY . .

# Set correct permissions
RUN chmod -R 775 storage bootstrap/cache

# Laravel setup
RUN composer install --no-interaction --prefer-dist --optimize-autoloader && \
    cp .env.example .env && \
    php artisan key:generate && \
    php artisan config:cache

# Stage 2: Final image with Nginx and Supervisor
FROM php:8.2-fpm

# Copy app & environment from build stage
COPY --from=backend /var/www /var/www
COPY --from=backend /etc /etc

# Install Nginx and Supervisor
RUN apt-get update && apt-get install -y nginx supervisor

WORKDIR /var/www

# Copy custom config files
COPY nginx.conf /etc/nginx/sites-enabled/default
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Expose web port
EXPOSE 80

# Run supervisord to manage services
CMD ["/usr/bin/supervisord"]

COPY php-fpm.conf /usr/local/etc/php-fpm.d/zz-custom.conf
