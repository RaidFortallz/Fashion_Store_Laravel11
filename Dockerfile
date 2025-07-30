# Gunakan base image PHP FPM yang stabil
FROM php:8.2-fpm-alpine

# Install tools dan library yang diperlukan
RUN apk add --no-cache \
    bash \
    libxml2-dev \
    oniguruma-dev \
    icu-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    zlib-dev \
    curl-dev \
    openssl-dev \
    libzip-dev \
    autoconf \
    g++ \
    make \
    git \
    unzip

# Install ekstensi PHP dasar
RUN docker-php-ext-install \
    ctype \
    curl \
    dom \
    fileinfo \
    filter \
    hash \
    mbstring \
    openssl \
    pdo \
    pdo_mysql \
    session \
    tokenizer \
    xml

# Build dan install ekstensi GD (harus dikonfigurasi terlebih dahulu)
RUN docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg \
    --with-webp && \
    docker-php-ext-install gd

# Install Composer secara global
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Salin file composer.json dan composer.lock ke container
COPY composer.json composer.lock ./

# Install dependency PHP menggunakan Composer (tanpa dev dan non-interaktif)
RUN composer install --no-dev --no-interaction --optimize-autoloader

# Salin semua file project ke dalam container
COPY . .

# Expose port PHP-FPM
EXPOSE 9000

# Jalankan php-fpm saat container dijalankan
CMD ["php-fpm"]
