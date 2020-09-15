const { Preset } = require('use-preset');

module.exports = Preset.make('laravel-boilerplate-nova-preset')

  .copyTemplates()

  .prompts()
  .input('Your Nova username', 'nova_username')
  .chain()

  .prompts()
  .input('Your Nova password', 'nova_password')
  .chain()

  .edit('auth.json')
  .title('🔒 Add credentials to auth.json')
  .replace('{NOVA_USERNAME}')
  .with(context => context.prompts.nova_username)
  .replace('{NOVA_PASSWORD}')
  .with(context => context.prompts.nova_password)
  .chain()

  .editJson('composer.json')
  .title('➕ Add PHP dependencies')
  .merge({
    require: {
      'ericlagarda/nova-text-card': '^1.2',
      'gregoriohc/laravel-nova-theme-responsive': '^0.8',
      'laravel/nova': '^3.9',
      'maatwebsite/excel': '^3.1',
      'maatwebsite/laravel-nova-excel': '^1.2',
      'optimistdigital/nova-settings': '^2.5',
      'sbine/route-viewer': '^0.0.7',
      'timothyasp/nova-color-field': '^1.0',
    },
    repositories: [
      {
        type: 'composer',
        url: 'https://nova.laravel.com',
      },
    ],
  })
  .chain()

  .edit('.cli/up.sh')
  .title('🔧 Update CLI scripts')
  .search(/@use-preset-vendor-publish$/)
  .addAfter('dc:pa nova:publish')
  .end()
  .search(/@use-preset-before-yarn$/)
  .addAfter([
    '# Copy logo.',
    '[ -f storage/app/public/nova-settings/logo/logo.png ] || (mkdir -p storage/app/public/nova-settings/logo && cp resources/images/logo.png storage/app/public/nova-settings/logo/logo.png)',
  ])
  .end()
  .chain()

  .edit('app/Support/View/AppViewComposer.php')
  .title('🏗 Add Nova settings to view composer')
  .search(/@use-preset-nova-settings$/)
  .addAfter(
    `
    $settings = collect(nova_get_settings())
        ->mapWithKeys(function ($value, $key) {
            if ($key === 'logo' && $value) {
                $value = asset("storage/{$value}");
            }

            return [$key => $value];
        })
        ->toArray();`
  )
  .end()
  .chain()

  .edit('config/app.php')
  .title('🏗 Add NovaServiceProvider')
  .search(/@use-preset-app-service-providers$/)
  .addAfter('Support\\Providers\\NovaServiceProvider::class,')
  .end()
  .chain()

  .edit('database/seeders/DatabaseSeeder.php')
  .title('🌱 Add Nova seeder')
  .search(/@use-preset-database-seeders$/)
  .addAfter('$this->call(NovaSettingsTableSeeder::class);')
  .end()
  .chain();
