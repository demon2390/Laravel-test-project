FROM php:8.4-fpm

RUN apt-get update && apt-get install -y libpq-dev supervisor

RUN pecl install redis && docker-php-ext-enable redis

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
  && docker-php-ext-install pdo pdo_pgsql pgsql

COPY ./docker/supervisor/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

WORKDIR /var/www

ENTRYPOINT ["/entrypoint.sh"]
