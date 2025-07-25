# Use official PHP image with Apache
FROM php:8.3-apache

# Enable Apache modules
RUN a2enmod rewrite headers expires deflate

# Install system dependencies (including libzip-dev)
RUN apt-get update && \
    apt-get install -y \
        git \
        zip \
        unzip \
        libzip-dev && \
    rm -rf /var/lib/apt/lists/*

# Install required PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mysqli opcache zip

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . .

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Generate key (if needed)
RUN cp .env.example .env && php artisan key:generate --force

# Clear caches
RUN php artisan config:clear && php artisan route:clear && php artisan view:clear

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html/bootstrap/cache /var/www/html/storage && \
    chmod -R 775 /var/www/html/bootstrap/cache /var/www/html/storage

# Configure Apache document root
RUN echo "DocumentRoot /var/www/html/public" > /etc/apache2/sites-available/000-default.conf && \
    echo "<Directory /var/www/html/public>" >> /etc/apache2/sites-available/000-default.conf && \
    echo "    AllowOverride All" >> /etc/apache2/sites-available/000-default.conf && \
    echo "    Require all granted" >> /etc/apache2/sites-available/000-default.conf && \
    echo "</Directory>" >> /etc/apache2/sites-available/000-default.conf

# Expose port
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]