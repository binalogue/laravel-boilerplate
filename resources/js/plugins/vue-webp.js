export default {
  install(Vue) {
    const webpSupport = this.hasWebpSupport();

    const convertToWebp = $imagePath =>
      !webpSupport
        ? $imagePath
        : $imagePath.toString().replace(/(\.jpe?g|\.png)/g, '.webp');

    /**
     * Add property to Vue prototype.
     */
    Vue.prototype.$webpSupport = webpSupport;
    Vue.prototype.$webp = convertToWebp;

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
