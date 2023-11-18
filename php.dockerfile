FROM php:8.2.1-fpm
WORKDIR /var/www/html
RUN apt-get update && apt-get install -y git
RUN docker-php-ext-install bcmath mysqli pdo pdo_mysql exif
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=2.2.1