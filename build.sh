#!/bin/bash

set -e

echo "Install npm packages"

npm install

echo "Install laravel packages"

composer install --no-interaction --prefer-dist --optimize-autoloader

# echo "Install telescope"

# php artisan telescope:install

echo "Copy env"

cp .env.test .env

echo "Setup database"

touch database/database.sqlite

echo "Make migrations"

php artisan migrate:refresh --force

echo "Serve app"

php artisan serve --host=0.0.0.0 --port=8000 