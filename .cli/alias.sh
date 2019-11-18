#!/bin/zsh

alias dc="docker-compose"

dc:exec() {
  dc exec app $@
}
dc:composer() {
  dc:exec composer $@
}
dc:pa() {
  dc:exec php artisan $@
}
dc:yarn() {
  dc:exec yarn $@
}
