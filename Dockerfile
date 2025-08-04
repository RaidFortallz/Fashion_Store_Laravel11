# Stage 1: Build dependencies and app code
FROM php:8.2-fpm-alpine as backend

WORKDIR /var/www

# Instal dependensi sistem dan ekstensi PHP dalam satu perintah RUN
# Ini adalah praktik terbaik di Dockerfile
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
    supervisor \
    # Setelah dependensi sistem, install ekstensi PHP
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        zip \
        gd \
    # Bersihkan file .ini sementara agar tidak menyumbat
    && rm -rf /usr/local/etc/php/conf.d/docker-php-ext-*.ini \
    # Bersihkan cache apk untuk layer yang lebih kecil
    && rm -rf /var/cache/apk/*

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

# Reinstall nginx and supervisor
RUN apt-get update && apt-get install -y nginx supervisor


# Salin ekstensi yang sudah diinstal dari stage 'backend'
COPY --from=backend /usr/local/lib/php/extensions/ /usr/local/lib/php/extensions/

# Salin konfigurasi PHP yang mengaktifkan ekstensi
COPY --from=backend /usr/local/etc/php/conf.d /usr/local/etc/php/conf.d

# Salin kode aplikasi dari stage pertama
COPY --from=backend /var/www /var/www

# Konfigurasi Nginx dan Supervisor
COPY nginx.conf /etc/nginx/sites-enabled/default
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Setup working directory
WORKDIR /var/www

# Expose HTTP port
EXPOSE 80

CMD ["/usr/bin/supervisord"]