const { Preset } = require('use-preset');

module.exports = Preset.make('laravel-boilerplate-three-preset')

  .editJson('package.json')
  .title('➕ Add JS dependencies')
  .merge({
    dependencies: {
      three: '^0.120.1',
    },
  })
  .chain()

  .edit('webpack.mix.js')
  .title('🔧 Register THREE as global variable')
  .search(/@use-preset-webpack-plugins$/)
  .addAfter([`new webpack.ProvidePlugin({`, `THREE: 'three',`, `}),`])
  .end()
  .chain()

  .editJson('.eslintrc.json')
  .title('🔧 Add THREE to ESLint globals')
  .merge({
    globals: {
      THREE: 'readonly',
    },
  })
  .chain();
