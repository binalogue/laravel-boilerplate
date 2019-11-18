#!/bin/zsh

# Run "alias.sh" script.
source .cli/alias.sh

# Copy config files.
[ -f .env ] || ( cp .env.docker .env )

# Build Docker.
dc build

# Run Docker in "detached" mode.
dc up -d

# Generate Laravel encryption key.
dc:pa key:generate

# Run "down.sh" script.
.cli/down.sh
