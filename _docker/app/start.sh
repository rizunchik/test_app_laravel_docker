#!/bin/sh

composer install --no-interaction --prefer-dist --optimize-autoloader 

php artisan storage:link

if [ ! -f /var/www/.env ]; then
  cp /var/www/.env.example /var/www/.env
fi

php -r "
        \$e = file_get_contents('.env');
        if (!preg_match(\"/^APP_KEY=\\S+/m\", \$e)) { exit(1); }
      " || php artisan key:generate --force

php artisan config:clear

echo "Waiting for database..."
until php artisan migrate --force; do
  echo "Retrying migrations in 5s..."
  sleep 5
done

exec php-fpm
