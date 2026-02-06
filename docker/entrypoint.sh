#!/bin/sh
set -e

# Ensure required Laravel paths exist (volumes may be empty on first run).
mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache database

touch database/database.sqlite

if [ "$(id -u)" = "0" ]; then
  chown -R www-data:www-data storage bootstrap/cache database
fi

if [ -f artisan ]; then
  if [ -z "${APP_KEY:-}" ] && [ "${APP_ENV:-}" != "production" ]; then
    php artisan key:generate --force || true
  fi

  php artisan storage:link || true
fi

exec "$@"
