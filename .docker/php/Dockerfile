FROM php:8.3-fpm

ARG user
ARG uid

COPY .docker/php/php.ini /usr/local/etc/php/
COPY .docker/php/docker.conf /usr/local/etc/php-fpm.d/docker.conf

# Set working directory
WORKDIR /var/www

RUN apt-get update

# Install useful tools
RUN apt-get -y install apt-utils nano wget

# Install system dependencies
RUN apt-get update && apt-get -y install \
    locales \
    zip \
    unzip \
    curl \
    libcurl4 \
    libcurl4-openssl-dev \
    libzip-dev

RUN docker-php-ext-install \
    exif \
    bcmath \
    ctype \
    curl \
    zip \
    pdo   

RUN pecl install xdebug-3.3.2 \
    && docker-php-ext-enable xdebug
    
# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy the application code into the container
COPY . /var/www

# Run Composer install
RUN composer install

RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Change current user to www
USER $user

# Expose port 9000 and start php-fpm server
EXPOSE 9000