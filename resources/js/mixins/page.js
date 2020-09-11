/* Vendor */
import { mapGetters } from 'vuex';

export default {
  props: {
    auth: {
      type: Object,
      default: () => {},
    },

    csrfToken: {
      type: String,
      required: true,
    },

    errors: {
      type: Object,
      default: () => {},
    },

    flash: {
      type: Object,
      default: () => {},
    },

    hasErrors: {
      type: Boolean,
    },

    hasErrorsOrExceptions: {
      type: Boolean,
    },

    hasExceptions: {
      type: Boolean,
    },

    meta: {
      type: Object,
      default: () => {},
    },
  },

  metaInfo() {
    return {
      title: this.getPageTitle,
    };
  },

  computed: {
    ...mapGetters(['getPageTitle']),
  },

  created() {
    if (this.$store.state.isLoading) {
      this.setupPageLoader()
        .then(result => {
          console.log('[Page] Finished loader:', result);
        })
        .catch(error => {
          console.error(error);
        })
        .finally(() => {
          this.$store.commit('TOGGLE_IS_LOADING', false);
        });
    }
  },

  methods: {
    async setupPageLoader() {
      return [await this.loadFake()];
    },

    loadFake() {
      return new Promise(resolve => {
        setTimeout(() => {
          resolve('loadFake');
        }, 800);
      });
    },
  },
};