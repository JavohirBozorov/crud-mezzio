FROM php:8.0-apache
LABEL maintainer="qarshidanjavohir@gmail.com"
WORKDIR /var/www/html
COPY ./bin/000-default.conf /etc/apache2/sites-available/
RUN docker-php-ext-install pdo pdo_mysql && a2enmod rewrite
