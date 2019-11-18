/* global gtag */

/* Vendor */
import Vue from 'vue';
import VueRouter from 'vue-router';
import Lang from 'lang.js';

/* Helpers */
import {
  addSeoMetaTagsToTheCurrentPage,
  populateMetaTags,
} from 'helpers/app';

/* Pages */
import HomePage from 'pages/HomePage';

/* Store */
import store from 'store';

/*
|------------------------------------------------------------------------------
| Setup Application Data
|------------------------------------------------------------------------------
*/

// Import application data.
const serverData = window.app_server_data;

// Store server data.
store.commit('ADD_SERVER_DATA', serverData);

// Set up Vue localization.
Vue.prototype.trans = new Lang({
  messages: serverData.messages,
  locale: serverData.locale,
  fallback: serverData.fallback,
});

/*
|------------------------------------------------------------------------------
| Vue Router
|------------------------------------------------------------------------------
*/

Vue.use(VueRouter);

const router = new VueRouter({
  mode: 'history',
  routes: [{
    path: '/',
    component: HomePage,
    name: 'home',
  }],
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) {
      return savedPosition;
    }

    if (
      [
        localStorage,
        to.name && to.name.match(/home/),
      ].every((condition) => condition)
    ) {
      return {
        x: Number(localStorage.getItem('scrollX')) || 0,
        y: Number(localStorage.getItem('scrollY')) || 0,
      };
    }

    return {
      x: 0,
      y: 0,
    };
  },
});

router.beforeEach(async (to, from, next) => {
  store.commit('TOGGLE_IS_LOADING', true);

  // Store SEO meta tags.
  const meta = serverData.meta[to.name];
  store.commit('SET_META', meta);
  addSeoMetaTagsToTheCurrentPage(populateMetaTags(
    meta.title,
    meta.description,
    meta.image,
    meta.image_width,
    meta.image_height,
  ));

  // Handle routes that don't need data.
  const routeDoesNotNeedData = (
    to.name === 'home'
  );

  if (routeDoesNotNeedData) {
    next();
  } else {
    store.commit('ADD_SERVER_DATA', serverData);
    next();
  }
});

router.afterEach((to, from) => {
  if (localStorage && from.name === 'home') {
    localStorage.setItem('scrollX', window.scrollX);
    localStorage.setItem('scrollY', window.scrollY);
  }

  const gtagConfigOptions = {
    app_name: 'Binalogue x Laravel Boilerplate',
    page_title: to.name,
    page_location: window.location.href,
    page_path: to.path,
  };

  if (
    process.env.MIX_APP_ENV === 'production'
    && window.location.host !== 'localhost'
  ) {
    // gtag('config', 'UA-XXXXXXXXX-X', Object.assign({
    //   groups: 'client',
    // }, gtagConfigOptions));
  }

  gtag('config', serverData.google_analytics_id, { groups: 'binalogue', ...gtagConfigOptions });
});

export default router;
