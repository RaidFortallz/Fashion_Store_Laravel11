# Stage 1: Build dependencies and app code
FROM php:8.2-fpm-alpine as backend

WORKDIR /var/www

# Instal dependensi sistem yang dibutuhkan untuk ekstensi PHP
RUN apk add --no-cache \
    curl \
    libxml2-dev \
    zip \
    unzip \
    git \
    build-base \
    imagemagick-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    oniguruma-dev \
    mysql-client \
    nginx \
    supervisor

# Instal ekstensi PHP yang dibutuhkan aplikasi Anda
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    pdo \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    zip \
    gd \
    && rm -rf /usr/local/etc/php/conf.d/docker-php-ext-*.ini

# Salin file Composer agar bisa install dependensi
COPY composer.json composer.lock ./

# Install dependensi Composer
RUN composer install --optimize-autoloader --no-scripts --no-interaction --no-dev

# Salin sisa kode aplikasi Anda
COPY . /var/www

# --- PENTING: KEMBALIKAN BAGIAN LARAVEL SETUP INI ---
RUN chmod -R 775 storage bootstrap/cache && \
    cp .env.example .env && \
    php artisan key:generate && \
    php artisan config:cache
# --- AKHIR BAGIAN LARAVEL SETUP ---


# Stage 2: Run with Nginx + PHP-FPM
FROM php:8.2-fpm-alpine

# Instal system dependencies yang dibutuhkan untuk RUNTIME (bukan build)
RUN apk add --no-cache \
    nginx \
    supervisor \
    libpng \
    libjpeg-turbo \
    libfreetype \
    libwebp

# Salin ekstensi yang sudah diinstal dari stage 'backend'
COPY --from=backend /usr/local/lib/php/extensions/ /usr/local/lib/php/extensions/

# Salin konfigurasi PHP yang mengaktifkan ekstensi
COPY --from=backend /usr/local/etc/php/conf.d /usr/local/etc/php/conf.d

# Salin kode aplikasi dari stage pertama
COPY --from=backend /var/www /var/www

# Reinstall nginx and supervisor
COPY nginx.conf /etc/nginx/sites-enabled/default
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Setup working directory
WORKDIR /var/www

# Expose HTTP port
EXPOSE 80

CMD ["/usr/bin/supervisord"]