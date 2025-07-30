# Gunakan base image PHP FPM berbasis Alpine
FROM php:8.2-fpm-alpine

# Install dependencies sistem
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
    unzip \
    libwebp-dev

# Install ekstensi PHP dasar + tambahan Laravel
RUN docker-php-ext-install -j$(nproc) \
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
    xml \
    bcmath \
    exif

# Konfigurasi dan install ekstensi GD
RUN docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg \
    --with-webp && \
    docker-php-ext-install gd

# Install Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy composer files terlebih dahulu
COPY composer.json composer.lock ./

# Install dependency composer
RUN composer install --no-dev --no-interaction --optimize-autoloader

# Salin seluruh project
COPY . .

# Expose port default PHP-FPM
EXPOSE 9000

# Jalankan php-fpm
CMD ["php-fpm"]
