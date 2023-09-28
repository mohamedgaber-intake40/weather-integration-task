FROM php:8.1-apache

RUN a2enmod rewrite headers
RUN docker-php-ext-install pdo_mysql
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN apt-get update && apt-get install -y \
    curl \
    git \
    sudo \
    unzip \
    zip

ARG uid
ARG user
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

COPY . /var/www/html
RUN chown -R $user:www-data /var/www/html && a2enmod rewrite
RUN chmod -R 775 /var/www/html/storage
RUN chmod -R 775 /var/www/html/bootstrap/cache
USER $user
