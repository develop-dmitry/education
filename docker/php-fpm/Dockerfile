FROM php:8.1-fpm

ARG PHP_INI_DIR
ARG WWWGROUP
ARG WWWUSER

RUN apt-get update \
    && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
    	libpng-dev \
    	libonig-dev \
    	libzip-dev \
    	libmemcached-dev \
        libcurl4-openssl-dev \
        libpq-dev \
    && pecl install xdebug \
    && docker-php-ext-install -j$(nproc) iconv mbstring zip curl pgsql pdo_pgsql \
    && docker-php-ext-enable xdebug \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && curl -sLS https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm

COPY ./conf.d/php.ini $PHP_INI_DIR/conf.d/php.ini

RUN usermod -u ${WWWUSER} www-data && groupmod -g ${WWWGROUP} www-data
USER "${WWWUSER}:${WWWGROUP}"

EXPOSE 9000

WORKDIR /var/www/html

CMD ["php-fpm"]