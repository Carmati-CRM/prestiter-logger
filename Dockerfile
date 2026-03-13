FROM php:7.4-cli-alpine

LABEL maintainer="Alfabiz srl <info@prestiter.it>"
LABEL description="Development environment for Prestiter Logger"

# Install system dependencies
RUN apk add --no-cache \
    git \
    curl \
    zip \
    unzip \
    $PHPIZE_DEPS

# Install PHP extensions
RUN docker-php-ext-install pcntl

# Install Xdebug for code coverage (version compatible with PHP 7.4)
RUN pecl install xdebug-3.1.6 && docker-php-ext-enable xdebug

# Configure Xdebug
RUN echo "xdebug.mode=coverage" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Install Composer
COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy composer files first for better caching
COPY composer.json ./

# Install dependencies
RUN composer install --prefer-dist --no-interaction --no-scripts

# Copy the rest of the application
COPY . .

# Regenerate autoload with all files
RUN composer dump-autoload

# Default command
CMD ["php", "-v"]
