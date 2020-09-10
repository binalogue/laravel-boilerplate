import VueCookies from 'vue-cookies';

export default {
  install(Vue) {
    Vue.use(VueCookies);
    Vue.$cookies.config('7d');
  },
};
