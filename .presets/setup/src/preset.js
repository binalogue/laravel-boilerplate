const { Preset } = require('use-preset');

// const files = [
//   '+(.*|*)',
//   '.docker/**/*',
//   '.favicon/*',
//   '.gitlab/**/*',
//   '.presets/!(setup)/+(.*|*)',
//   'config/*.php',
//   'resources/**/*.+(css|js|json|php|scss|vue)',
// ];

module.exports = Preset.make('laravel-boilerplate-setup-preset')

  .delete('README.md')
  .title('🔥 Remove README.md')
  .chain()

  .copyTemplates()

  .delete('composer.lock')
  .title('🔥 Remove composer.lock')
  .chain()

  .delete('yarn.lock')
  .title('🔥 Remove yarn.lock')
  .chain()

  .edit(['.gitlab-ci.yml'])
  .title('👷‍♂️ Remove production job')
  .search(/@use-preset-gitlab-production-forge$/)
  .removeAfter(11) // Removes job
  .end()
  .chain();

// .prompts()
// .input('App name (default: "Laravel Boilerplate")', 'app_name')
// .chain()

// .prompts()
// .input('App short name (default: "Binaplate")', 'app_short_name')
// .chain()

// .prompts()
// .input('App description (default: "We ❤️ code")', 'app_description')
// .chain()

// .prompts()
// .input('Repository owner (default: "binalogue")', 'repository_owner')
// .chain()

// .prompts()
// .input('Repository name (default: "laravel-boilerplate")', 'repository_name')
// .chain()

// .prompts()
// .input(
//   'Production domain name (default: "laravel.binalogue.dev")',
//   'domain_name_production'
// )
// .chain()

// .edit(files)
// .title('💬 Update app name')
// .replaceAll('Laravel Boilerplate')
// .with(context => context.prompts.app_name)
// .replaceAll('Binaplate')
// .with(context => context.prompts.app_short_name)
// .chain()

// .edit(files)
// .title('💬 Update app description')
// .replaceAll('We ❤️ code')
// .with(context => context.prompts.app_description)
// .chain()

// .edit(files)
// .title('💬 Update repository')
// .replaceAll('binalogue/laravel-boilerplate')
// .with(
//   context =>
//     `${context.prompts.repository_owner}/${context.prompts.repository_name}`
// )
// .replaceAll('laravel-boilerplate')
// .with(context => context.prompts.repository_name)
// .chain()

// .edit(files)
// .title('💬 Update domain')
// .replaceAll('laravel.binalogue.dev')
// .with(context => context.prompts.domain_name_production)
// .chain()
