const { Preset } = require('use-preset');

module.exports = Preset.make('laravel-boilerplate-telescope-preset')

  .copyTemplates()

  .editJson('composer.json')
  .title('➕ Add Telescope PHP dependencies')
  .merge({
    require: {
      'ext-json': '*',
      'laravel/telescope': '^4.0',
    },
  })
  .chain()

  .edit('config/app.php')
  .title('🏗 Publish Telescope service provider')
  .search(/@use-preset-app-service-providers$/)
  .addAfter('Support\\Providers\\TelescopeServiceProvider::class,')
  .end()
  .chain()

  .edit(['.env.docker', '.env.forge'])
  .title('🔧 Enable Telescope')
  .replace('TELESCOPE_ENABLED=false')
  .with('TELESCOPE_ENABLED=true')
  .chain()

  .edit('.cli/up.sh')
  .title(`🔧 Add Telescope's publish command to CLI scripts`)
  .search(/@use-preset-vendor-publish$/)
  .addAfter('dc:pa telescope:publish')
  .end()
  .chain()

  .edit('app/Support/Console/Kernel.php')
  .title(`⏰ Schedule Telescope's data pruning`)
  .search(/@use-preset-schedule$/)
  .addAfter([
    `if (config('telescope.enabled')) {`,
    `$schedule->command('telescope:prune')->daily();`,
    `}`,
  ])
  .end()
  .chain();
