FROM php:8.2-apache

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHP extensions
RUN apt update \
    && apt install -y \
    libzip-dev \
    libsodium-dev \
    && docker-php-ext-install zip \
    && docker-php-ext-install sodium

# Set FQDN
RUN echo "ServerName 127.0.0.1" >> "/etc/apache2/apache2.conf"

# Enable apache rewrite mod
RUN a2enmod rewrite
