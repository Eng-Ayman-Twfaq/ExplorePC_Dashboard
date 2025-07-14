# Use official PHP image with Apache
FROM php:8.3-apache

# Enable Apache mod_rewrite
RUN a2enmod rewrite headers expires deflate

# Install required PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mysqli opcache

# Copy project files
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html

# Install Composer
RUN curl -sS https://getcomposer.org/installer  | php -- --install-dir=/usr/local/bin --filename=composer

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Generate key (optional, can be done via env)
RUN cp .env.example .env || true
RUN php artisan key:generate --force

# Clear config cache
RUN php artisan config:clear
RUN php artisan route:clear
RUN php artisan view:clear

# Expose port (not needed for Render, but safe to include)
EXPOSE 80