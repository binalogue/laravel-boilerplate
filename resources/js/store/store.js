/* Vendor */
import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    /*
    |---------------------------------------------------------------------------
    | Backend Static Data
    |
    | See:
    |  - app/Support/View/AppViewComposer.php
    |---------------------------------------------------------------------------
    */

    // App.
    env: 'production',
    url: 'https://example.com',

    // Config
    settings: {},

    // Localization.
    locale: 'es',

    /*
    |---------------------------------------------------------------------------
    | Backend Inertia.js Data
    |
    | See:
    |  - app/Support/Providers/InertiaServiceProvider.php
    |---------------------------------------------------------------------------
    */

    // Auth.
    user: undefined,

    // Flash.
    flash: {},
    isShownTheFlashStatus: false,

    /*
    |---------------------------------------------------------------------------
    | Frontend Data
    |
    | See:
    |  - resources/js/app.js
    |---------------------------------------------------------------------------
    */

    // Cookies.
    isShownTheCookieBanner: false,

    // Device.
    isMobile: false,
    isPhone: false,

    // Loader.
    isLoading: true,
  },

  getters: {
    getAppLogo: ({ settings }) => settings.logo || '/images/logo.png',

    getAppName: ({ settings }) => settings.app_name || '',

    isAuth: ({ user }) => !!user,

    isGuest: ({ user }) => !user,
  },

  actions: {
    addBackendInertiajsData({ commit }, { auth, flash, meta }) {
      if (auth) {
        commit('SET_AUTH_USER', auth.user);
      }

      if (flash) {
        commit('SET_FLASH_MESSAGE', flash);
        commit('TOGGLE_THE_FLASH_STATUS', !!flash.message);
      }
    },
  },

  mutations: {
    ADD_BACKEND_STATIC_DATA(state, serverPayload) {
      if (serverPayload.env) {
        state.env = serverPayload.env;
      }

      if (serverPayload.url) {
        state.url = serverPayload.url;
      }

      if (serverPayload.settings) {
        state.settings = serverPayload.settings;
      }

      if (serverPayload.locale) {
        state.locale = serverPayload.locale;
      }
    },

    SET_AUTH_USER(state, payload) {
      state.user = payload;
    },

    SET_FLASH_MESSAGE(
      state,
      { message, level = 'success', class: c = 'success' }
    ) {
      state.flash.message = message;
      state.flash.level = level;
      state.flash.class = c;
    },

    TOGGLE_IS_LOADING(state, payload) {
      state.isLoading = payload;
    },

    TOGGLE_IS_MOBILE(state, payload) {
      state.isMobile = payload;
    },

    TOGGLE_IS_PHONE(state, payload) {
      state.isPhone = payload;
    },

    TOGGLE_THE_COOKIE_BANNER(state, payload) {
      state.isShownTheCookieBanner = payload;
    },

    TOGGLE_THE_FLASH_STATUS(state, payload) {
      state.isShownTheFlashStatus = payload;
    },
  },
});
