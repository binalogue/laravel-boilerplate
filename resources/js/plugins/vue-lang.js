/* global app_server_data */

import Lang from 'lang.js';

export default {
  install(Vue) {
    Vue.prototype.$lang = new Lang({
      messages: app_server_data.messages,
      locale: app_server_data.locale,
      fallback: app_server_data.fallback,
    });
  },
};
