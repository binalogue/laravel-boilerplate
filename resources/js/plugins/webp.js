export default {
  install(Vue) {
    const webpSupport = this.hasWebpSupport();

    /**
     * Add property to Vue prototype.
     */
    Vue.prototype.$webp = webpSupport;

    /**
     * Add class to the `html` tag.
     */
    if (webpSupport) {
      document.querySelector('html').classList.add('webp');
    }

    /**
     * Add Vue directive.
     */
    Vue.directive('webp', (el, binding, vnode) => {
      if (vnode.tag !== 'img') {
        return;
      }

      if (!webpSupport) {
        el.src = binding.value.toString();
        return;
      }

      try {
        el.src = binding.value.toString().replace(/(\.jpe?g|\.png)/g, '.webp');
      } catch (err) {
        console.error(err);
      }
    });

    /**
     * Add Vue global method.
     */
    Vue.mixin({
      methods: {
        webp($imagePath) {
          if (!webpSupport) {
            return $imagePath;
          }

          return $imagePath.toString().replace(/(\.jpe?g|\.png)/g, '.webp');
        },
      },
    });
  },

  hasWebpSupport() {
    try {
      if (window.app_server_data.webp_support) {
        return true;
      }
    } catch (err) {
      console.error(err);
    }

    return false;
  },
};
