FROM php:fpm

RUN apt-get update && apt-get upgrade -y && apt-get install -y libpq-dev libmcrypt-dev libicu-dev git vim\
    && docker-php-ext-install pdo pdo_pgsql pdo_mysql mcrypt pgsql opcache intl \
    && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*	

RUN mkdir -p /var/www/html/app

# why do we make a volumn here
VOLUME /var/www/html/app

WORKDIR /var/www/html/app

COPY . ./

COPY ./docker/php.ini /usr/local/etc/php/php.ini 

