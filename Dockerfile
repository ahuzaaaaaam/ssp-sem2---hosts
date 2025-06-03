FROM php:8.2-apache

# Install dependencies
RUN apt-get update && apt-get install -y \
    unzip curl git libpng-dev libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-install pdo_mysql zip

# ✅ Install MongoDB extension
RUN pecl install mongodb && docker-php-ext-enable mongodb

# Enable Apache rewrite and set correct doc root
RUN a2enmod rewrite

# ✅ Set DocumentRoot to public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# ✅ Update Apache config
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf

# Composer
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --optimize-autoloader --no-dev

RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 80
