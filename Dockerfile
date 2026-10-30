FROM php:8.2-fpm-alpine

RUN apk add --no-cache libpng libpng-dev libzip libzip-dev oniguruma-dev mysql-client \
    && docker-php-ext-install pdo pdo_mysql bcmath gd zip

WORKDIR /var/www/html
COPY . .
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true

EXPOSE 9000
CMD ["php-fpm"]
