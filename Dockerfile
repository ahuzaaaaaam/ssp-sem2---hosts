FROM php:8.2-fpm

# Install required packages
RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev libpng-dev libonig-dev libxml2-dev libicu-dev libcurl4-openssl-dev pkg-config libssl-dev \
    && docker-php-ext-install zip pdo_mysql bcmath intl

# ✅ Install MongoDB extension
RUN pecl install mongodb && docker-php-ext-enable mongodb

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy project files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

CMD ["php-fpm"]
