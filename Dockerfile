# Use official PHP image with Apache
FROM php:8.2-apache

# Enable Apache rewrite module
RUN a2enmod rewrite

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libonig-dev libxml2-dev libcurl4-openssl-dev pkg-config libssl-dev \
    && docker-php-ext-install zip pdo pdo_mysql

# Install MongoDB PHP extension
RUN pecl install mongodb && docker-php-ext-enable mongodb

# Install Node.js (LTS)
RUN curl -fsSL https://deb.nodesource.com/setup_lts.x | bash - && \
    apt-get install -y nodejs

# Set working directory
WORKDIR /var/www/html

# Copy Laravel project files
COPY . /var/www/html

# Install npm dependencies
RUN npm ci

# Build Vite/Tailwind assets
RUN npm run build

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader
RUN php artisan config:clear
RUN php artisan cache:clear

# Set Apache to serve the public folder
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf

# Set permissions for Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public/build

# Expose the HTTP port
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
