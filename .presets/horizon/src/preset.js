const { Preset } = require('use-preset');

module.exports = Preset.make('laravel-boilerplate-horizon-preset')

  .copyTemplates()

  .editJson('composer.json')
  .title('➕ Add Horizon PHP dependencies')
  .merge({
    require: {
      'laravel/horizon': '^5.2.0',
    },
  })
  .chain()

  .edit('config/app.php')
  .title('🏗 Publish Horizon service provider')
  .search(/@use-preset-app-service-providers$/)
  .addAfter('Support\\Providers\\HorizonServiceProvider::class,')
  .end()
  .chain()

  .edit('.docker/supervisor/conf.d/queue.conf')
  .title(`🔧 Replace queue command`)
  .search(/@use-preset-docker-supervisor-queue$/)
  .removeAfter(1)
  .end()
  .search(/@use-preset-docker-supervisor-queue$/)
  .addAfter(`command=php /var/www/artisan horizon`)
  .end()
  .chain()

  .edit('.cli/up.sh')
  .title(`🔧 Add Horizon's publish command to CLI scripts`)
  .search(/@use-preset-vendor-publish$/)
  .addAfter('dc:pa horizon:publish')
  .end()
  .chain()

  .edit('.cli/up.sh')
  .title(`🔧 Add Horizon's terminate command to CLI scripts`)
  .search(/@use-preset-vendor-horizon-terminate$/)
  .addAfter('dc exec queue php artisan horizon:terminate')
  .end()
  .chain()

  .edit('app/Support/Console/Kernel.php')
  .title(`⏰ Schedule Horizon's snapshots`)
  .search(/@use-preset-schedule$/)
  .addAfter(`$schedule->command('horizon:snapshot')->everyFiveMinutes();`)
  .end()
  .chain();
