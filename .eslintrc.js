module.exports = {
  env: {
    browser: true,
    commonjs: true,
    es6: true,
  },
  extends: ['airbnb-base', 'plugin:vue/recommended'],
  globals: {
    Atomics: 'readonly',
    SharedArrayBuffer: 'readonly',
  },
  parserOptions: {
    // If we want to use other parser, (e.g. "parser": "babel-eslint"), please
    // move it into this options, so it doesn't collide with the
    // `vue-eslint-parser` used by `eslint-plugin-vue`.
    // https://eslint.vuejs.org/user-guide/#what-is-the-use-the-latest-vue-eslint-parser-error

    // Enable ES2018 features (like `async/await`).
    ecmaVersion: 2018,
    sourceType: 'module',
  },
  plugins: [
    // As we already use `eslint-plugin-vue`, we can't use the `eslint-plugin-html`.
    // https://eslint.vuejs.org/user-guide/#why-doesn-t-it-work-on-vue-file
    'vue',
  ],
  rules: {
    'func-names': 'off',
    'global-require': 'off',
    'import/extensions': ['error', 'always', {
      'js': 'never',
      'vue': 'never'
    }],
    'import/no-dynamic-require': 'off',
    'max-len': 'off',
    'no-console': 'off',
    'no-param-reassign': [
      'error',
      {
        props: false,
      },
    ],
    'vue/array-bracket-spacing': 'error',
    'vue/arrow-spacing': 'error',
    'vue/block-spacing': 'error',
    'vue/brace-style': 'error',
    'vue/comma-dangle': ['error', 'always-multiline'],
    'vue/component-name-in-template-casing': 'error',
    'vue/eqeqeq': 'error',
    'vue/key-spacing': 'error',
    'vue/match-component-file-name': [
      'error',
      {
        extensions: ['vue'],
      },
    ],
    'vue/no-boolean-default': 'error',
    'vue/no-restricted-syntax': 'error',
    'vue/no-v-html': 'off',
    'vue/object-curly-spacing': ['error', 'always'],
    'vue/require-direct-export': 'error',
    'vue/script-indent': 'error',
    'vue/space-infix-ops': 'error',
    'vue/v-on-function-call': 'error',
  },
  overrides: [
    {
      files: ['*.vue'],
      rules: {
        indent: 'off',
      },
    },
  ],
  settings: {
    'import/resolver': {
      node: {
        extensions: ['.js', '.vue', '.scss', '.json'],
        moduleDirectory: ['resources/js', 'node_modules', 'vendor'],
      },
    },
  },
};
