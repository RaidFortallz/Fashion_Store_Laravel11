# Stage 1: Build PHP
FROM php:8.2-fpm as backend

WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y \
    zip unzip curl git libxml2-dev libzip-dev libpng-dev libjpeg-dev \
    libonig-dev sqlite3 libsqlite3-dev libfreetype6-dev \
    libjpeg62-turbo-dev libwebp-dev libmagickwand-dev \
    default-mysql-client nginx supervisor && \
    docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip && \
    pecl install imagick && docker-php-ext-enable imagick


# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy app code
COPY . .

# Laravel setup
RUN chmod -R 775 storage bootstrap/cache && \
    composer install --no-interaction --prefer-dist --optimize-autoloader && \
    cp .env.example .env && \
    php artisan key:generate && \
    php artisan config:cache

# Stage 2: Run with Nginx + PHP-FPM
FROM php:8.2-fpm

# Reinstall needed PHP extensions
RUN apt-get update && apt-get install -y \
    libzip-dev libpng-dev libjpeg-dev libonig-dev libxml2-dev \
    libfreetype6-dev libjpeg62-turbo-dev libwebp-dev libmagickwand-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip \
    && pecl install imagick && docker-php-ext-enable imagicks

COPY --from=backend /var/www /var/www
COPY --from=backend /etc /etc

# Reinstall nginx and supervisor
RUN apt-get update && apt-get install -y nginx supervisor

# Setup working directory
WORKDIR /var/www

# Copy nginx config
COPY nginx.conf /etc/nginx/sites-enabled/default

# Copy supervisor config
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Expose HTTP port
EXPOSE 80

CMD ["/usr/bin/supervisord"]
