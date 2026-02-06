FROM php:8.4-fpm

WORKDIR /var/www/html

ENV COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_NO_INTERACTION=1

RUN apt-get update && apt-get install -y \
        git unzip libpng-dev libjpeg62-turbo-dev libfreetype6-dev libzip-dev \
        sqlite3 libsqlite3-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_sqlite gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --optimize-autoloader

COPY . .

RUN mkdir -p storage bootstrap/cache database \
    && touch database/database.sqlite \
    && php artisan storage:link || true \
    && chown -R www-data:www-data storage bootstrap/cache database

USER www-data

CMD ["php-fpm"]
