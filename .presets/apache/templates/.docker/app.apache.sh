#!/usr/bin/env bash

set -e

env=${APP_ENV:-production}
role=${CONTAINER_ROLE:-app}

if [ "$env" != "local" ]; then
  echo "[mikelgoig] Caching configuration---"
  (cd /var/www && php artisan optimize)

  echo "[mikelgoig] Removing XDebug..."
  rm -rf /usr/local/etc/php/conf.d/{docker-php-ext-xdebug.ini,xdebug.ini}
fi

# App

if [ "$role" = "app" ]; then
  exec apache2-foreground

# Queue
elif [ "$role" = "queue" ]; then
  exec php /var/www/artisan queue:work --verbose --tries=3 --timeout=90

# Scheduler
elif [ "$role" = "scheduler" ]; then
  while [ true ]
  do
    php /var/www/artisan schedule:run --verbose --no-interaction &
    sleep 60
  done

else
  echo "[mikelgoig] Could not match the container role \"$role\""
  exit 1
fi
