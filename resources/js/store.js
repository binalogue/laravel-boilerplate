/* Vendor */
import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    csrfToken: window.csrf_token,

    /*
    |---------------------------------------------------------------------------
    | AppService
    |
    | See: app/Services/AppService.php
    |---------------------------------------------------------------------------
    */

    // App.
    env: 'production',
    url: 'https://laravel.binalogue.dev',
    locale: 'es',
    serverPath: '',

    // SEO meta tags for the current page.
    // IMPORTANT: do not add to the ADD_SERVER_DATA mutation.
    meta: {},

    /*
    |---------------------------------------------------------------------------
    | Other
    |---------------------------------------------------------------------------
    */

    // Device.
    isMobile: false,
    isPhone: false,

    // Cookies.
    isShownCookieBanner: true,

    // Loader.
    isLoading: true,
    loaderProgress: 0,

    // Footer.
    isShownModalFooter: false,
  },

  mutations: {
    ADD_SERVER_DATA(state, serverData) {
      // AppService
      if (serverData.env) {
        state.env = serverData.env;
      }
      if (serverData.url) {
        state.url = serverData.url;
      }
      if (serverData.locale) {
        state.locale = serverData.locale;
      }
      if (serverData.path) {
        state.serverPath = serverData.path;
      }

      // Controllers
      if (serverData.customPlaylist) {
        state.customPlaylist = serverData.customPlaylist;
      }
    },

    SET_LOADER_PROGRESS(state, value) {
      state.loaderProgress = value;
    },

    SET_META(state, value) {
      state.meta = value;
    },

    TOGGLE_COOKIE_BANNER(state, value) {
      state.isShownCookieBanner = value;
    },

    TOGGLE_IS_LOADING(state, value) {
      state.isLoading = value;
    },

    TOGGLE_IS_MOBILE(state, value) {
      state.isMobile = value;
    },

    TOGGLE_IS_PHONE(state, value) {
      state.isPhone = value;
    },

    TOGGLE_MODAL_FOOTER(state, value) {
      state.isShownModalFooter = value;
    },
  },
});
