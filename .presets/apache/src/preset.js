const { Preset } = require('use-preset');

module.exports = Preset.make('laravel-boilerplate-apache-preset')

  .delete(['app.nginx.dockerfile', 'app.nginx.sh', 'docker-compose.yml'])
  .title('🐳 Remove docker-compose files')
  .chain()

  .delete()
  .title('🐳 Remove nginx config files')
  .directories([
    '.docker/confd',
    '.docker/nginx',
    '.docker/php/php-fpm.d',
    '.docker/supervisor',
  ])
  .chain()

  .copyTemplates();
