import VueLodash from 'vue-lodash';
import lodash from 'lodash';

export default {
  install(Vue) {
    Vue.use(VueLodash, { name: '$lodash', lodash });
  },
};
