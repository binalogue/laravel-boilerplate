import { InertiaProgress } from '@inertiajs/progress';

export default {
  install(Vue, store) {
    InertiaProgress.init({
      // The delay after which the progress bar will
      // appear during navigation, in milliseconds.
      delay: 250,

      // The color of the progress bar.
      color: store.state.settings.color_primary,

      // Whether to include the default NProgress styles.
      includeCSS: true,

      // Whether the NProgress spinner will be shown.
      showSpinner: false,
    });
  },
};
