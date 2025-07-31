# === Stage 1: Build Laravel App ===
FROM php:8.2-fpm as backend

WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    zip unzip curl git libxml2-dev libzip-dev libpng-dev libjpeg-dev libonig-dev \
    sqlite3 libsqlite3-dev libfreetype6-dev libjpeg62-turbo-dev libwebp-dev

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring zip gd bcmath pcntl exif

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy Laravel project files
COPY . .

# Set permissions
RUN chmod -R 775 storage bootstrap/cache

# Copy environment file (gunakan file env sendiri)
COPY .env.production .env

# Laravel setup
RUN composer install --no-interaction --prefer-dist --optimize-autoloader && \
    php artisan key:generate && \
    php artisan migrate --force

# === Stage 2: Final runtime image with Nginx & Supervisor ===
FROM php:8.2-fpm

WORKDIR /var/www

# Install Nginx & Supervisor
RUN apt-get update && apt-get install -y nginx supervisor

# Copy app & env
COPY --from=backend /var/www /var/www
COPY --from=backend /usr/bin/composer /usr/bin/composer

# Copy configs
COPY nginx.conf /etc/nginx/sites-enabled/default
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY php-fpm.conf /usr/local/etc/php-fpm.d/zz-custom.conf

# Expose HTTP port for Railway (must be 80)
EXPOSE 80

# Start supervisor (will start php-fpm and nginx)
CMD ["/usr/bin/supervisord"]

