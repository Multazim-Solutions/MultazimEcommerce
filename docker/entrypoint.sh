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

    if [ -z "${APP_KEY:-}" ] && [ -f .env ]; then
      APP_KEY="$(grep -E '^APP_KEY=' .env | head -n1 | cut -d= -f2-)"
      export APP_KEY
    fi
  fi

  php artisan storage:link || true

  if [ "${APP_ENV:-}" != "production" ]; then
    if [ "${APP_SEED_ON_START:-}" = "1" ]; then
      php artisan migrate:fresh --seed --force
    else
      php artisan migrate --force
    fi
  fi
fi

exec "$@"
