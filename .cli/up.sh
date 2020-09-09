#!/bin/zsh

source .cli/alias.sh

# Run Docker in "detached" mode.
dc up -d

# Install Composer dependencies.
dc:composer check-platform-reqs
dc:composer install --prefer-dist --no-progress --no-suggest --no-interaction

if [ -f artisan ]; then
  # Copy config files.
  [ -f .env ] || ( cp .env.docker .env && dc:pa key:generate )

  # Create a symbolic link from "public/storage" to "storage/app/public".
  [ -L 'public/storage' ] || ( dc:pa storage:link )

  # Publish any vendor packages assets.
  dc:pa telescope:publish
  dc:pa horizon:publish
  dc:pa nova:publish

  # Migrate database.
  dc:pa migrate:fresh --force --seed

  # Terminate the master Horizon process.
  dc exec queue php artisan horizon:terminate
fi

# Copy logo.
[ -f storage/app/public/nova-settings/logo/logo.png ] || (mkdir -p storage/app/public/nova-settings/logo && cp resources/images/logo.png storage/app/public/nova-settings/logo/logo.png)

# Run yarn.
dc:yarn
dc:yarn watch
