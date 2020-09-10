import moment from 'moment';

export default {
  install(Vue) {
    moment.locale('es');
    Vue.prototype.$moment = moment;
  },
};
