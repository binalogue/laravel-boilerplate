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

  # Publish Laravel Telescope.
  dc:pa telescope:publish

  # Migrate database.
  dc:pa migrate --force
fi

# Run yarn.
dc:yarn
dc:yarn watch
