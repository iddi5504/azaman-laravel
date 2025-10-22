#!/bin/bash

set -e

echo "Install npm packages"

npm install

echo "Install laravel packages"

composer install --no-interaction --prefer-dist --optimize-autoloader

echo "Install telescope"

php artisan telscope:install

echo "Make migrations"

php artisan migrate --force

echo "Serve app"

php artisan serve --host=0.0.0.0 --port=8000 