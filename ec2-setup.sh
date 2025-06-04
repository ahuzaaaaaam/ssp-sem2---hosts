#!/bin/bash
# EC2 Setup Script for Laravel 12 with MongoDB
# Run this script as root on your EC2 instance

# Update system packages
apt-get update
apt-get upgrade -y

# Install Apache, PHP, and required extensions
apt-get install -y apache2 php8.2 php8.2-cli php8.2-common php8.2-curl php8.2-mbstring php8.2-mysql php8.2-xml php8.2-zip php8.2-bcmath php8.2-intl php8.2-gd unzip git

# Install MongoDB PHP extension
apt-get install -y php-pear php8.2-dev
pecl install mongodb
echo "extension=mongodb.so" > /etc/php/8.2/mods-available/mongodb.ini
ln -s /etc/php/8.2/mods-available/mongodb.ini /etc/php/8.2/apache2/conf.d/30-mongodb.ini
ln -s /etc/php/8.2/mods-available/mongodb.ini /etc/php/8.2/cli/conf.d/30-mongodb.ini

# Install Composer
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Configure Apache for Laravel
cat > /etc/apache2/sites-available/laravel.conf << 'EOL'
<VirtualHost *:80>
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/html/public

    <Directory /var/www/html/public>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
EOL

# Enable the site and required modules
a2ensite laravel.conf
a2dissite 000-default.conf
a2enmod rewrite
systemctl restart apache2

# Set proper permissions
chown -R www-data:www-data /var/www/html
find /var/www/html -type f -exec chmod 644 {} \;
find /var/www/html -type d -exec chmod 755 {} \;
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Instructions for deploying your Laravel app
echo "======================================================"
echo "EC2 server setup complete!"
echo "======================================================"
echo "Next steps:"
echo "1. Upload your Laravel files to /var/www/html"
echo "2. Set up your .env file with proper credentials"
echo "3. Run: cd /var/www/html && composer install"
echo "4. Run: php artisan key:generate"
echo "5. Run: php artisan migrate"
echo "6. Run: php artisan storage:link"
echo "======================================================"
