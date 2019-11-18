/* global gtag */

/*
|------------------------------------------------------------------------------
| Project Dependencies
|------------------------------------------------------------------------------
| First we will load all of this project's JavaScript dependencies which
| includes Vue and other libraries. It is a great starting point when
| building robust, powerful web applications using Vue and Laravel.
*/

/* App Bootstrap */
import './bootstrap';

/* Vue */
import Vue from 'vue';
import Vuex from 'vuex';
import VueWebP from 'plugins/webp';

/* Other dependencies */

// [mobile-detect](https://www.npmjs.com/package/mobile-detect)
import MobileDetect from 'mobile-detect';

// [js-cookie](https://github.com/js-cookie/js-cookie)
import Cookies from 'js-cookie';

/* Vue Instance */
import App from 'pages/App';
import store from 'store';
import router from './router';

/*
|------------------------------------------------------------------------------
| Vue Setup
|------------------------------------------------------------------------------
| Next, we will setup the Vue application.
*/

if (process.env.MIX_APP_ENV === 'production') {
  Vue.config.devtools = false;
  Vue.config.debug = false;
  Vue.config.silent = true;
  Vue.config.productionTip = false;
}

Vue.use(Vuex);
Vue.use(VueWebP);

Vue.mixin({
  methods: {
    /* Global */

    gtagOutboundLink(name, label) {
      gtag('event', name, {
        event_category: 'outbound-links',
        event_label: label,
        send_to: 'binalogue',
      });
    },

    gtagShare(method, url) {
      gtag('event', 'share', {
        method,
        event_action: 'share',
        content_type: 'app',
        content_id: url,
        send_to: 'binalogue',
      });
    },

    /* HomePage */

    gtagDiscoverCampaign() {
      gtag('event', 'discover-campaign', {
        event_category: 'engagement',
        send_to: 'binalogue',
      });
    },
  },
});

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan the Vue components directory and
 * automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context('./components/', true, /\.vue$/i);
files.keys().map((key) => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

/*
|------------------------------------------------------------------------------
| Vue Application
|------------------------------------------------------------------------------
| Finally, we will create a fresh Vue application instance and attach it to
| the main page.
*/

window.Laravel = new Vue({
  render: (h) => h(App),
  router,
  store,
});

/* Check device type */
if (window.navigator) {
  const md = new MobileDetect(window.navigator.userAgent, 450);
  window.Laravel.$store.commit('TOGGLE_IS_MOBILE', !!md.mobile());
  window.Laravel.$store.commit('TOGGLE_IS_PHONE', !!md.phone());
}

/* Check cookies */
window.Laravel.$store.commit('TOGGLE_COOKIE_BANNER', !Cookies.get('cookieNotice'));

window.Laravel.$mount('#app');
