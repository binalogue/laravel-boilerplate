/* global _, moment, route */

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

/* App Bootstrap */
import './bootstrap';

/* Vue */
import Vue from 'vue';

/* Vue Plugins */
import { InertiaApp } from '@inertiajs/inertia-vue';
import Vuex from 'vuex';
import VueGtm from 'plugins/gtm';
import VueMeta from 'vue-meta';
import VueWebP from 'plugins/webp';
import Vuelidate from 'vuelidate';
import VuelidateErrorExtractor from 'vuelidate-error-extractor';
import BaseFormGroup from 'components/BaseFormGroup';

/* Vue Helpers */
import { scroll, clickOutside } from 'helpers/vue-directives';
import { capitalize, toLowerCase } from 'helpers/vue-filters';
import mixin from 'helpers/vue-mixin';

/* Vue Instance */
import store from 'store';

/* Other dependencies */
import Cookies from 'js-cookie';
import Lang from 'lang.js';
import MobileDetect from 'mobile-detect';

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

Vue.prototype.$lodash = _;
Vue.prototype.$moment = moment;
Vue.prototype.$trans = new Lang({
  messages: window.app_server_data.messages,
  locale: window.app_server_data.locale,
  fallback: window.app_server_data.fallback,
});

Vue.use(InertiaApp);
Vue.use(Vuex);
Vue.use(VueGtm);
Vue.use(VueMeta);
Vue.use(VueWebP);
Vue.use(Vuelidate);
Vue.use(VuelidateErrorExtractor, {
  template: BaseFormGroup,
  name: 'BaseFormGroup',
  messages: {
    checked: 'Es obligatorio confirmar este campo.',
    email: 'El email no tiene un formato válido.',
    maxLength: 'Este campo es demasiado largo.',
    required: 'Este campo no puede estar vacío.',
    sameAsPassword: 'Las contraseñas deben ser iguales.',
  },
});

Vue.directive('scroll', scroll);
Vue.directive('click-outside', clickOutside);
Vue.filter('capitalize', capitalize);
Vue.filter('toLowerCase', toLowerCase);

Vue.mixin(mixin);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan the Vue components directory and
 * automatically register them with their "basename".
 */
const components = require.context('./components/', true, /\.vue$/i);
components.keys().map((key) => Vue.component(key.split('/').pop().split('.')[0], components(key).default));

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
  render: (h) => h(InertiaApp, {
    props: {
      initialPage: JSON.parse(app.dataset.page),

      resolveComponent: (name) => require(`./pages/${name}`).default,

      transformProps: (props) => {
        window.Laravel.$gtm.page(route().current(), window.location.pathname);

        window.Laravel.$store.commit('ADD_BACKEND_INERTIAJS_DATA', props);

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

/* Handle server data */
window.Laravel.$store.commit('ADD_BACKEND_STATIC_DATA', window.app_server_data);

/* Handle device type */
if (window.navigator) {
  const md = new MobileDetect(window.navigator.userAgent, 450);
  window.Laravel.$store.commit('TOGGLE_IS_MOBILE', !!md.mobile());
  window.Laravel.$store.commit('TOGGLE_IS_PHONE', !!md.phone());
}

/* Handle cookies */
window.Laravel.$store.commit('TOGGLE_THE_COOKIE_BANNER', !Cookies.get('binalogue_cookies_notice'));

/* Handle loader */
window.Laravel.$store.commit('TOGGLE_IS_LOADING', true);

window.Laravel.$mount(app);
