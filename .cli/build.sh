#!/bin/zsh

source .cli/alias.sh

# Copy config files.
[ -f .env ] || ( cp .env.docker .env )

# Build Docker.
dc build

# Run Docker in "detached" mode.
dc up -d

# Install Composer dependencies.
dc:composer install --prefer-dist --no-progress --no-suggest --no-interaction

# Generate Laravel encryption key.
dc:pa key:generate

.cli/down.sh
