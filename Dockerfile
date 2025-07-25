# Use official PHP image with Apache
FROM php:8.3-apache

# Enable Apache modules
RUN a2enmod rewrite headers expires deflate

# Install system dependencies including Node.js
RUN apt-get update && \
    apt-get install -y \
        git \
        zip \
        unzip \
        libzip-dev \
        nodejs \
        npm && \
    rm -rf /var/lib/apt/lists/*

# Install required PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mysqli opcache zip bcmath

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . .

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Install Node dependencies and build frontend assets
RUN npm install && npm run build

# Generate key
RUN cp .env.example .env && php artisan key:generate --force

# Clear and cache configs
RUN php artisan config:cache && php artisan route:cache

# Set proper permissions
RUN chown -R www-www-data /var/www/html && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

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