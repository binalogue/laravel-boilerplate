/* global __dirname, path */
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

const options = {
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
  postCss: [
    autoprefixer,
  ],
};

mix
  .js('resources/js/app.js', 'public/js')

  .browserSync({
    files: 'resources/**/*',
    proxy: process.env.APP_URL,
    open: false,
  })

  .copyDirectory('resources/fonts', 'public/fonts')
  .copyDirectory('resources/images/svgs', 'public/images/svgs')
  .copyDirectory('resources/video', 'public/video')

  .sourceMaps()

  .webpackConfig(() => ({
    plugins: [
      new StyleLintPlugin({
        files: ['./resources/**/*.{scss,vue}'],
      }),
    ],

    module: {
      rules: [
        {
          enforce: 'pre',
          test: /\.(js|vue)$/,
          exclude: /node_modules/,
          loader: 'eslint-loader',
          options: {
            fix: true,
            cache: true,
          },
        },
      ],
    },

    resolve: {
      extensions: ['.js', '.vue', '.scss', '.json'],
      modules: ['resources/js', 'node_modules'],
      alias: {
        '@': path.resolve(__dirname, 'resources/sass/'),
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
      pngquant: ({
        quality: '65-65',
      }),
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

  .options(options);

/*
 |--------------------------------------------------------------------------
 | Production Mode
 |--------------------------------------------------------------------------
 */

if (mix.inProduction()) {
  mix
    .sourceMaps(false)

    // Enable file hashing to assist with long-term caching, such as
    // `app.js?id=8e5c48eadbfdd5458ec6`.
    .version()

    .options(
      Object.assign({
        // Remove console logs.
        terser: {
          terserOptions: {
            compress: {
              drop_console: true,
            },
          },
        },
      }, options),
    )

    .purgeCss({
      whitelistPatternsChildren: [
        /active/,
        /animated/,
        /delay/,
        /enter/,
        /fade-in/,
        /fade-out/,
        /leave/,
      ],
    });
}
