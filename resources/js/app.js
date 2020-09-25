/* global _, route */

/*
|------------------------------------------------------------------------------
| Project Dependencies
|------------------------------------------------------------------------------
|
| First we will load all of this project's JavaScript dependencies which
| includes Vue and other libraries. It is a great starting point when
| building robust, powerful web applications using Vue and Laravel.
|
*/

/* Vue */
import Vue from 'vue';

/* Vendor */
import MobileDetect from 'mobile-detect';
import Vuex from 'vuex';
import { InertiaApp } from '@inertiajs/inertia-vue';

/* Inertia Plugins */
import InertiaProgress from 'plugins/inertia-progress';

/* Vue Plugins */
import VueCookies from 'plugins/vue-cookies';
import VueGsap from 'plugins/vue-gsap';
import VueGtm from 'plugins/vue-gtm';
import VueLang from 'plugins/vue-lang';
import VueLodash from 'plugins/vue-lodash';
import VueMeta from 'plugins/vue-meta';
import VueVuelidate from 'plugins/vue-vuelidate';
import VueWebp from 'plugins/vue-webp';

// Optional
// import VueSelect from 'plugins/vue-select';
// import VueYoutube from 'plugins/vue-youtube';

/* Vue Helpers */
import { toLowerCase } from 'helpers/vue-filters';
import mixin from 'helpers/vue-mixin';

// Optional
// import { scroll, clickOutside } from 'helpers/vue-directives';

/* Vue Instance */
import store from 'store/store';

/*
|------------------------------------------------------------------------------
| Vue Setup
|------------------------------------------------------------------------------
|
| Next, we will setup the Vue application.
|
*/

if (process.env.MIX_APP_ENV === 'production') {
  Vue.config.devtools = false;
  Vue.config.debug = false;
  Vue.config.silent = true;
  Vue.config.productionTip = false;
}

/* Inertia Plugins */
Vue.use(InertiaApp);

/* Vue Plugins */
Vue.use(Vuex);
Vue.use(VueCookies);
Vue.use(VueGsap);
Vue.use(VueGtm);
Vue.use(VueLang);
Vue.use(VueLodash);
Vue.use(VueMeta);
Vue.use(VueVuelidate);
Vue.use(VueWebp);

// Vue.directive('foo', foo);

Vue.filter('toLowerCase', toLowerCase);

Vue.mixin(mixin);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan the Vue components directory and
 * automatically register them with their "basename".
 */
const components = require.context('./components/', true, /\.vue$/i);
components.keys().map(key =>
  Vue.component(
    key
      .split('/')
      .pop()
      .split('.')[0],
    components(key).default
  )
);

/*
|------------------------------------------------------------------------------
| Vue Application
|------------------------------------------------------------------------------
|
| Finally, we will create a fresh Vue application instance and attach it to
| the main page.
|
*/

const app = document.getElementById('app');

window.Laravel = new Vue({
  mounted() {
    Vue.use(InertiaProgress, this.$store);
  },
  render: h =>
    h(InertiaApp, {
      props: {
        initialPage: JSON.parse(app.dataset.page),

        resolveComponent: name => require(`./pages/${name}`).default,

        transformProps: props => {
          window.Laravel.$gtm.page(route().current(), window.location.pathname);

          window.Laravel.$store.dispatch('addBackendInertiajsData', props);

          const hasErrors = !_.isEmpty(props.errors);
          if (hasErrors) {
            console.warn('[app] Form error:', props.errors);
          }

          const hasExceptions = !!props.flash.isError;
          if (hasExceptions) {
            console.warn('[app] Exception:', props.flash.status);
          }

          return Object.assign(props, {
            hasErrors,
            hasExceptions,
            hasErrorsOrExceptions: hasErrors || hasExceptions,
          });
        },
      },
    }),
  store,
});

/* Handle loader */
window.Laravel.$store.commit('TOGGLE_IS_LOADING', true);

/* Handle server data */
window.Laravel.$store.commit('ADD_BACKEND_STATIC_DATA', window.app_server_data);

/* Handle device type */
if (window.navigator) {
  const md = new MobileDetect(window.navigator.userAgent, 450);
  window.Laravel.$store.commit('TOGGLE_IS_MOBILE', !!md.mobile());
  window.Laravel.$store.commit('TOGGLE_IS_PHONE', !!md.phone());
}

/* Handle cookies */
window.Laravel.$store.commit(
  'TOGGLE_THE_COOKIE_BANNER',
  !Vue.$cookies.isKey('bina_cookies_notice')
);

window.Laravel.$mount(app);
