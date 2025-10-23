#!/bin/bash

set -e

echo "Use more memory"

export NODE_OPTIONS="--max-old-space-size=2000"

echo "Install npm packages"

npm install

echo "Install laravel packages"

composer install --no-interaction --prefer-dist --optimize-autoloader

# echo "Install telescope"

# php artisan telescope:install

echo "Copy env"

cp .env.test .env


echo "Generate app key"

php artisan key:generate

echo "Setup database"

touch database/database.sqlite


echo "Make migrations"

php artisan migrate --force

echo "Build app"

npm run build



