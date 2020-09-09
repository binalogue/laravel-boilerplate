/* Vendor */
import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    /*
    |---------------------------------------------------------------------------
    | Backend Data
    |
    | See:
    |  - app/Support/View/AppViewComposer.php
    |  - app/Support/Providers/AppServiceProvider.php
    |---------------------------------------------------------------------------
    */

    // App.
    env: 'production',
    url: 'https://laravel.binalogue.dev',
    locale: 'es',

    /*
    |---------------------------------------------------------------------------
    | Frontend Data
    |---------------------------------------------------------------------------
    */

    // Auth.
    user: undefined,

    // Device.
    isMobile: false,
    isPhone: false,

    // Loader.
    isLoading: false,

    // Visibility.
    isShownTheCookieBanner: false,
    isShownTheFlashStatus: false,
  },

  getters: {
    isAuth: state => !!state.user,
    isGuest: state => !state.user,
  },

  actions: {
    //
  },

  mutations: {
    ADD_BACKEND_STATIC_DATA(state, serverPayload) {
      if (serverPayload.env) {
        state.env = serverPayload.env;
      }
      if (serverPayload.url) {
        state.url = serverPayload.url;
      }
      if (serverPayload.locale) {
        state.locale = serverPayload.locale;
      }
    },

    ADD_BACKEND_INERTIAJS_DATA(state, serverPayload) {
      if (serverPayload.auth) {
        state.user = serverPayload.auth.user;
      }

      if (serverPayload.flash) {
        state.isShownTheFlashStatus = !!serverPayload.flash.status;
      }
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
