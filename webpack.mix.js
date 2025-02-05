/* global path */
/* eslint-disable import/no-extraneous-dependencies */

/* Laravel Mix */
const mix = require('laravel-mix');
require('laravel-mix-purgecss');

/* Webpack Plugins */
const StyleLintPlugin = require('stylelint-webpack-plugin');

/* Imagemin */
const imagemin = require('imagemin');
const ImageminMozjpeg = require('imagemin-mozjpeg');
const ImageminWebp = require('imagemin-webp');

/* PostCSS */
const autoprefixer = require('autoprefixer');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
  .js('resources/js/app.js', 'public/js')

  .browserSync({
    files: 'resources/**/*',
    proxy: mix.config.hmr ? '0.0.0.0' : process.env.APP_URL,
    open: false,
  })

  .copyDirectory('resources/fonts', 'public/fonts')
  .copyDirectory('resources/video', 'public/video')

  .sourceMaps(!mix.inProduction())

  .webpackConfig(webpack => ({
    devServer: {
      proxy: {
        host: '0.0.0.0',
        port: 8080,
      },
      watchOptions: {
        aggregateTimeout: 200,
        poll: 5000,
      },
    },

    plugins: [
      new StyleLintPlugin({
        files: ['./resources/**/*.{scss,vue}'],
        fix: true,
      }),

      // @use-preset-webpack-plugins
    ],

    module: {
      rules: [
        {
          enforce: 'pre',
          test: /\.(js|vue)$/,
          exclude: [/node_modules/, /vendor/],
          loader: 'eslint-loader',
          options: {
            fix: true,
            cache: false,
          },
        },
      ],
    },

    resolve: {
      extensions: ['.js', '.vue', '.scss', '.json'],
      modules: ['resources/js', 'node_modules', 'vendor'],
      alias: {
        '@sass': path.resolve(__dirname, 'resources/sass/'),
        vue$: 'vue/dist/vue.runtime.esm.js',
      },
    },
  }))

  .then(async () => {
    const outputFolder = './public/images';
    const allImages = './resources/images/*';
    const pngImages = './resources/images/*.png';
    const jpegImages = './resources/images/*.{jpg,jpeg}';

    await imagemin([allImages], {
      destination: outputFolder,
      pngquant: {
        quality: '65-65',
      },
      plugins: [
        ImageminMozjpeg({
          quality: 65,
        }),
      ],
    });

    await imagemin([pngImages], {
      destination: outputFolder,
      plugins: [
        ImageminWebp({
          lossless: true,
        }),
      ],
    });

    await imagemin([jpegImages], {
      destination: outputFolder,
      plugins: [
        ImageminWebp({
          quality: 65,
        }),
      ],
    });
  })

  .options({
    // Extract `.vue` component styling to a dedicated file.
    extractVueStyles: 'public/css/app.css',

    // Include CSS variables in every component styles.
    // This option only works when `extractVueStyles` is enabled.
    globalVueStyles: 'resources/sass/_variables.scss',

    // Since we don't do any image preprocessing and write url's that are relative
    // to the site root, we don't want the css loader to try to follow paths in
    // `url()` functions.
    processCssUrls: false,

    // By default, Mix will pipe all of our CSS through:
    // - [Autoprefixer PostCSS plugin](https://github.com/postcss/autoprefixer)
    // - [browserslist](https://github.com/browserslist/browserslist)
    autoprefixer: true,
    postCss: [autoprefixer],

    ...(mix.inProduction()
      ? {
          terser: {
            terserOptions: {
              compress: {
                drop_console: true,
              },
            },
          },
        }
      : {}),
  });

if (mix.inProduction()) {
  mix
    // Enable file hashing to assist with long-term caching, such as
    // `app.js?id=8e5c48eadbfdd5458ec6`.
    .version()

    .purgeCss({
      whitelistPatternsChildren: [
        /active/,
        /hooper/,
        /nprogress/,
        /v-select/,
        /vs/,
      ],
    });
}
