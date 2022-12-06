FROM php:8.1-apache
RUN apt-get update && apt upgrade -y
RUN docker-php-ext-install pdo pdo_mysql && docker-php-ext-enable pdo pdo_mysql

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf