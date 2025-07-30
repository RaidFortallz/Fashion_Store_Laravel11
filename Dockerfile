# Gunakan base image PHP FPM yang stabil dari Docker Hub
FROM php:8.2-fpm-alpine

# Instal dependensi sistem yang dibutuhkan untuk ekstensi PHP
# Pastikan setiap baris diakhiri dengan backslash (\) TANPA SPASI SETELAHNYA,
# dan TIDAK ADA BARIS KOSONG di dalam daftar ini.
RUN apk add --no-cache \
    curl-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    build-base \
    imagemagick-dev \
    libpng-dev \
    libjpeg-turbo-dev

# Instal ekstensi PHP yang dibutuhkan aplikasi Anda
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
    pdo_mysql \
    session \
    tokenizer \
    xml \
    exif \
    gd

# Atur direktori kerja ke /app di dalam container
WORKDIR /app

# Salin file Composer agar bisa install dependensi
COPY composer.json composer.lock ./

# Install dependensi Composer
RUN composer install --optimize-autoloader --no-scripts --no-interaction --no-dev

# Salin sisa kode aplikasi Anda
COPY . /app

# Expose port PHP-FPM (default 9000)
EXPOSE 9000

# Jalankan PHP-FPM ketika container dimulai
CMD ["php-fpm"]