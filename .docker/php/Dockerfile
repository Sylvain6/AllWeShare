FROM php:7.2-fpm-alpine

RUN apk add --update --no-cache icu-dev \
    postgresql-dev

RUN docker-php-ext-install intl pdo pgsql pdo_pgsl

WORKDIR /var/www/AllWeShare