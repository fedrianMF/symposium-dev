#!/bin/sh
set -e

mkdir -p /var/www/html/database
if [ ! -f /var/www/html/database/database.sqlite ]; then
    touch /var/www/html/database/database.sqlite
fi
chown -R www-data:www-data /var/www/html/database

# Ejecuta artisan como www-data para que logs y cachés no queden como root
su-exec www-data php artisan optimize
su-exec www-data php artisan migrate --force

exec supervisord -c /etc/supervisor/conf.d/supervisord.conf
