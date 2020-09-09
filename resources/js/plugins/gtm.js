export default {
  install(Vue) {
    window.dataLayer = window.dataLayer || [];

    Vue.prototype.$gtm = {
      page: this.page,
      track: this.track,
      social: this.social,
    };
  },

  page(title, path) {
    window.dataLayer.push({
      event: 'binalogue.page',
      page_title: title,
      page_path: path,
    });
  },

  social(network, action, target) {
    window.dataLayer.push({
      event: 'binalogue.social',
      social_network: network,
      social_action: action,
      social_target: target,
    });

    console.table({
      network,
      action,
      target,
    });
  },

  track(action, { category, label, value }) {
    window.dataLayer.push({
      event: 'binalogue.track',
      event_category: category,
      event_action: action,
      event_label: label,
      event_value: value,
    });

    console.table({
      action,
      category,
      label,
    });
  },
};
