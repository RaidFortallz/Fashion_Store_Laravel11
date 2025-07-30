FROM php:8.2-fpm-alpine

# Install system dependencies
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
    libwebp-dev \
    libexif-dev \
    imagemagick-dev

# Install PHP extensions
RUN docker-php-ext-install -j$(nproc) \
    ctype \
    curl \
    dom \
    fileinfo \
    mbstring \
    openssl \
    pdo \
    pdo_mysql \
    session \
    tokenizer \
    xml \
    bcmath \
    exif

# Configure and install GD
RUN docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg \
    --with-webp && \
    docker-php-ext-install gd

# Install Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy composer files
COPY composer.json composer.lock ./

# Install composer dependencies
RUN composer install --no-dev --no-interaction --optimize-autoloader

# Copy the rest of the app
COPY . .

# Expose PHP-FPM port
EXPOSE 9000

# Run php-fpm
CMD ["php-fpm"]
