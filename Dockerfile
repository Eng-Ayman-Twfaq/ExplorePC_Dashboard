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

# Expose port
EXPOSE 80