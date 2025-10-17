FROM php:8.3-fpm-alpine
WORKDIR /var/www/html

RUN apk add --no-cache bash git curl zip unzip icu-dev oniguruma-dev libzip-dev \
    && docker-php-ext-install intl pdo_mysql opcache

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY . /var/www/html

RUN chown -R www-data:www-data storage bootstrap/cache
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

CMD ["php-fpm","-F"]