#!/usr/bin/env bash

set -e

env=${APP_ENV:-production}
role=${CONTAINER_ROLE:-app}

if [ "$env" == "local" ]; then
  echo "[mikelgoig] Removing basic Nginx rules..."
  (cd /etc/nginx/h5bp && rm basic.conf && touch basic.conf)

  if [ ! -z "$DEV_UID" ]; then
    echo "[mikelgoig] Changing www-data UID to $DEV_UID."
    echo "[mikelgoig] The UID should only be changed in development environments."
    usermod -u $DEV_UID www-data
  fi
else
  echo "[mikelgoig] Caching configuration..."
  (cd /var/www && php artisan optimize)

  echo "[mikelgoig] Removing XDebug..."
  rm -rf /usr/local/etc/php/conf.d/{docker-php-ext-xdebug.ini,xdebug.ini}
fi

confd -onetime -backend env

# App
if [ "$role" = "app" ]; then
  ln -sf /etc/supervisor/conf.d-available/app.conf /etc/supervisor/conf.d/app.conf

# Queue
elif [ "$role" = "queue" ]; then
  ln -sf /etc/supervisor/conf.d-available/queue.conf /etc/supervisor/conf.d/queue.conf

# Scheduler
elif [ "$role" = "scheduler" ]; then
  ln -sf /etc/supervisor/conf.d-available/scheduler.conf /etc/supervisor/conf.d/scheduler.conf

else
  echo "[mikelgoig] Could not match the container role \"$role\""
  exit 1
fi

exec supervisord -c /etc/supervisor/supervisord.conf
