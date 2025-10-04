#!/bin/sh

composer install --no-interaction --prefer-dist --optimize-autoloader 

php artisan storage:link

if [ ! -f /var/www/.env ]; then
  cp /var/www/.env.example /var/www/.env
fi


php -r "
    $e=".env"; $s=file_get_contents($e);
    $set=function($k,$v) use (&$s){ if(!preg_match("/^$k=\\S+/m",$s)) $s.="\n$k=$v"; };
    function rnd(){ return bin2hex(random_bytes(12)); }
    $set("DB_PASSWORD", rnd());
    $set("DB_ROOT_PASSWORD", rnd());
    file_put_contents($e,$s);
    ";

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
