#!/bin/zsh

source .cli/alias.sh

# Run Docker in "detached" mode.
dc up -d

# Delete cache files.
find bootstrap/cache/ -name "*.php" -type f -delete

# Install Composer dependencies.
[ -f composer.lock ] && ( dc:composer check-platform-reqs )
dc:composer install --prefer-dist --no-progress --no-suggest --no-interaction

if [ -f artisan ]; then
  # Copy config files.
  [ -f .env ] || ( cp .env.docker .env && dc:pa key:generate )

  # Create a symbolic link from "public/storage" to "storage/app/public".
  [ -L 'public/storage' ] || ( dc:pa storage:link )

  # Publish any vendor packages assets.
  # @use-preset-vendor-publish
  dc:pa horizon:publish

  # Migrate database.
  dc:pa migrate:fresh --force --seed

  # Terminate the master Horizon process.
  dc exec queue php artisan horizon:terminate
fi

# @use-preset-before-yarn

# Run yarn.
dc:yarn
dc:yarn watch
