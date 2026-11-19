#!/bin/sh
set -e

DB_PATH="${DB_DATABASE:-/var/www/html/database/data/database.sqlite}"
DB_DIR="$(dirname "$DB_PATH")"

# Un volumen nuevo puede montarse con dueño root: se crea el archivo y se le da a www-data
mkdir -p "$DB_DIR"
if [ ! -f "$DB_PATH" ]; then
    touch "$DB_PATH"
fi
chown -R www-data:www-data "$DB_DIR"

# Ejecuta artisan como www-data para que logs y cachés no queden como root
su-exec www-data php artisan optimize
su-exec www-data php artisan migrate --force

exec supervisord -c /etc/supervisor/conf.d/supervisord.conf
