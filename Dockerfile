# Gunakan base image PHP FPM yang stabil dari Docker Hub
# Railway biasanya menggunakan image berbasis Alpine (lebih kecil) atau Debian
# Pilih versi PHP yang sesuai dengan lingkungan lokal Anda (misal 8.2)
FROM php:8.2-fpm-alpine 

# Instal dependensi sistem yang dibutuhkan untuk ekstensi PHP
# Pastikan Anda menginstal semua dependensi yang diperlukan oleh ekstensi Anda
# Termasuk gd, libzip (untuk zip), dan lain-lain jika diperlukan oleh ekstensi PHP lainnya
RUN apk add --no-cache \
    curl-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    build-base \
    imagemagick-dev \ # Untuk gd/imagick jika dipakai
    libpng-dev \      # Untuk gd
    libjpeg-turbo-dev # Untuk gd

# Instal ekstensi PHP yang dibutuhkan aplikasi Anda
# Pastikan ini dijalankan setelah dependensi sistem diinstal
RUN docker-php-ext-install \
    ctype \
    curl \
    dom \
    fileinfo \
    filter \
    hash \
    mbstring \
    openssl \
    pcre \
    pdo_mysql \ # Umumnya butuh ini untuk MySQL
    session \
    tokenizer \
    xml \
    exif \      # <--- PASTIKAN 'exif' ADA DI SINI!
    gd          # <--- Jika Anda menggunakan gd (umum untuk manipulasi gambar)

# Atur direktori kerja ke /app di dalam container
WORKDIR /app

# Salin file Composer agar bisa install dependensi
# Ini adalah optimasi: copy composer.json dan composer.lock duluan untuk caching layer Docker
COPY composer.json composer.lock ./

# Install dependensi Composer
# --no-dev untuk produksi agar tidak instal dev dependencies
RUN composer install --optimize-autoloader --no-scripts --no-interaction --no-dev

# Salin sisa kode aplikasi Anda
COPY . /app

# Expose port PHP-FPM (default 9000)
EXPOSE 9000

# Jalankan PHP-FPM ketika container dimulai
CMD ["php-fpm"]