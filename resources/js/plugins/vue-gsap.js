import { gsap } from 'gsap';
import { CSSPlugin } from 'gsap/CSSPlugin';

gsap.registerPlugin(CSSPlugin);

export default {
  install(Vue) {
    Vue.prototype.$gsap = gsap;
  },
};
