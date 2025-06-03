FROM php:8.2-apache

# Install dependencies
RUN apt-get update && apt-get install -y \
    git zip unzip curl libpng-dev libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-install pdo_mysql zip

# Install MongoDB extension
RUN pecl install mongodb && docker-php-ext-enable mongodb

# Enable Apache modules and set the Laravel public folder as root
RUN a2enmod rewrite

# ✅ Change Apache DocumentRoot to Laravel public/
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# ✅ Replace default Apache site config with new root
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf

# Set working directory
WORKDIR /var/www/html

# Copy everything and install dependencies
COPY . .

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chown -R www-data:www-data storage bootstrap/cache

# Expose Apache port
EXPOSE 80

CMD ["apache2-foreground"]
