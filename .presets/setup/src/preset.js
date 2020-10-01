const { Preset } = require('use-preset');

const files = [
  '.*',
  '!(node_modules|public|vendor)/**/*.+(conf|js|json|md|php|vue|yml)',
];

module.exports = Preset.make('laravel-boilerplate-setup-preset')

  .prompts()
  .input('App name (default: "Laravel Boilerplate")', 'app_name')
  .chain()

  .prompts()
  .input('App short name (default: "Binaplate")', 'app_short_name')
  .chain()

  .prompts()
  .input('App description (default: "We ❤️ code")', 'app_description')
  .chain()

  .prompts()
  .input('Repository owner (default: "binalogue")', 'repository_owner')
  .chain()

  .prompts()
  .input('Repository name (default: "laravel-boilerplate")', 'repository_name')
  .chain()

  .prompts()
  .input(
    'Production domain name (default: "laravel.binalogue.dev")',
    'domain_name_production'
  )
  .chain()

  .edit(files)
  .title('💬 Update app name')
  .replace('Laravel Boilerplate')
  .with(context => context.prompts.app_name)
  .replace('Binaplate')
  .with(context => context.prompts.app_short_name)
  .chain()

  .edit(files)
  .title('💬 Update app description')
  .replace('We ❤️ code')
  .with(context => context.prompts.app_description)
  .chain()

  .edit(files)
  .title('💬 Update repository')
  .replace('binalogue/laravel-boilerplate')
  .with(
    context =>
      `${context.prompts.repository_owner}/${context.prompts.repository_name}`
  )
  .replace('laravel-boilerplate')
  .with(context => context.prompts.repository_name)
  .chain()

  .edit(files)
  .title('💬 Update domain')
  .replace('laravel.binalogue.dev')
  .with(context => context.prompts.domain_name_production)
  .chain()

  .edit(['README.md'])
  .title('📝 Update README')
  .search(/@use-preset-readme-intro/)
  .removeAfter(3) // Removes into
  .end()
  .chain()

  .edit(['.gitlab-ci.yml'])
  .title('👷‍♂️ Remove production job')
  .search(/@use-preset-gitlab-production-forge$/)
  .removeAfter(11) // Removes job
  .end()
  .chain();
