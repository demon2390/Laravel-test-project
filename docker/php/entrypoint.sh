#!/usr/bin/env sh

composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan l5-swagger:generate

php-fpm
