# ---- Etapa 1: build de assets (Vite/Node) ----
FROM node:24-alpine AS node_builder
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY . .
RUN npm run build

# ---- Etapa 2: dependencias de PHP (Composer) ----
FROM composer:2 AS composer_builder
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --no-interaction
COPY . .
RUN composer dump-autoload --optimize --no-dev

# ---- Etapa 3: imagen final ----
FROM php:8.4-fpm-alpine

RUN apk add --no-cache \
    nginx supervisor su-exec sqlite sqlite-dev \
    libpng-dev libjpeg-turbo-dev freetype-dev libzip-dev oniguruma-dev icu-dev postgresql-dev \
    && docker-php-ext-configure gd --with-jpeg --with-freetype \
    && docker-php-ext-install pdo pdo_sqlite pdo_mysql pdo_pgsql mbstring zip gd bcmath intl opcache pcntl

COPY docker/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

WORKDIR /var/www/html

COPY --from=composer_builder /app /var/www/html
COPY --from=node_builder /app/public/build /var/www/html/public/build

COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

RUN mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

VOLUME ["/var/www/html/database"]

EXPOSE 80

ENTRYPOINT ["/entrypoint.sh"]
