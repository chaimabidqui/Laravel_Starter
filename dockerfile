FROM php:8.2-fpm

# Set working directory to /app
WORKDIR /app

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install zip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy composer.json (ignore composer.lock)
COPY composer.json /app/

# Install Composer dependencies without strict version checks
RUN composer install --ignore-platform-reqs --no-scripts --no-autoloader
# Copy the rest of the application files
COPY . /app/

EXPOSE 8081

# Set the CMD command to run PHP's built-in web server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8081"]