# Stage 1: Build dependencies and app code
FROM php:8.2-fpm as backend

WORKDIR /var/www

# Instal system dependencies, termasuk library yang dibutuhkan oleh ekstensi
# Sederhanakan perintah dan pastikan semua library yang dibutuhkan ada di sini
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    nginx \
    supervisor \
    # Tambahkan dependensi lain yang diperlukan oleh ekstensi
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instal ekstensi PHP dan aktifkan
# Gunakan docker-php-ext-configure untuk GD jika perlu, lalu docker-php-ext-install
RUN docker-php-ext-install -j$(nproc) pdo pdo_mysql mbstring exif pcntl bcmath zip
# GD memiliki configure yang spesifik, jadi sebaiknya dipisah
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

# Instal Composer
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
# Gunakan image yang sama untuk konsistensi
FROM php:8.2-fpm

# Instal system dependencies yang dibutuhkan untuk RUNTIME (bukan build)
RUN apt-get update && apt-get install -y \
    nginx \
    supervisor \
    # Pastikan dependensi GD juga terinstal di runtime
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Salin ekstensi yang sudah diinstal dari stage 'backend'
# Ini langkah krusial untuk multistage build.
# Copy file ekstensi dari stage pertama ke stage kedua
COPY --from=backend /usr/local/lib/php/extensions/ /usr/local/lib/php/extensions/

# Salin konfigurasi PHP yang mengaktifkan ekstensi
# Jika Anda tidak memiliki file .ini yang spesifik, ini akan sulit.
# Kita bisa coba buat file konfigurasi ekstensi secara manual.
RUN echo "extension=pdo_mysql.so" > /usr/local/etc/php/conf.d/docker-php-ext-pdo_mysql.ini && \
    echo "extension=exif.so" > /usr/local/etc/php/conf.d/docker-php-ext-exif.ini && \
    echo "extension=gd.so" > /usr/local/etc/php/conf.d/docker-php-ext-gd.ini

# Salin kode aplikasi dari stage pertama
COPY --from=backend /var/www /var/www

# Reinstall nginx and supervisor
# Tidak perlu reinstall, cukup copy config
COPY nginx.conf /etc/nginx/sites-enabled/default
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Setup working directory
WORKDIR /var/www

# Expose HTTP port
EXPOSE 80

CMD ["/usr/bin/supervisord"]