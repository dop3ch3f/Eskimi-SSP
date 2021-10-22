#!/bin/sh

php artisan optimize

php artisan storage:link

# wait for db service to start
sleep 3

php artisan migrate --force

# start the servers
# nginx && php-fpm
php-fpm -D &&  nginx -g "daemon off;"


