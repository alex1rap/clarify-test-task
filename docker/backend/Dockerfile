FROM php:8.3-fpm-alpine3.19

COPY docker/backend/wait-for-it.sh /usr/bin/wait-for-it
RUN chmod +x /usr/bin/wait-for-it

RUN apk --no-cache update \
    && apk add --no-cache autoconf g++ make \
    postgresql-dev linux-headers
RUN pecl install xdebug-3.3.0 \
    && rm -rf /tmp/pear
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    \
    && docker-php-ext-install pdo_pgsql

#composer
ENV COMPOSER_ALLOW_SUPERUSER 1
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

#codeception alias
RUN echo 'alias cept="./vendor/bin/codecept"' >> ~/.profile

WORKDIR /var/www

# за два дня я перепробовал кучу вариантов данного конфига, но `php-fpm` постоянно сбрасывает соединение (даже при
# попытке подключиться к нему изнутри его же контейнера) и при этом ничего не пишет в логи, поэтому для разработки
# пришлось ограничиться встроенным сервером php
CMD composer i -o ; wait-for-it postgres:5432 -- bin/console doctrine:migrations:migrate ;  php -S 0.0.0.0:9000 -t public

EXPOSE 9000
