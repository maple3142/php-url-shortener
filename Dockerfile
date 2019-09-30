FROM php:7.3-apache

RUN apt-get update && apt-get install -y libpq-dev && docker-php-ext-install pdo pdo_pgsql

WORKDIR /var/www/html
COPY . .

ENV DB_CONN=pgsql:host=172.17.0.2;port=5432;dbname=surl
ENV DB_USER=user
ENV DB_PASS=password
RUN a2enmod rewrite
