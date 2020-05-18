<script>
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

  created() {
    if (this.$store.state.isLoading) {
      this.$$setupLoader()
        .then((result) => {
          console.log('[Page] Finished loader:', result);
        })
        .catch((error) => {
          console.error(error);
        })
        .finally(() => {
          this.$store.commit('TOGGLE_IS_LOADING', false);
        });
    }
  },

  methods: {
    async $$setupLoader() {
      return [
        await this.$$loadFake(),
        // await this.loadImages(),
      ];
    },

    $$loadFake() {
      return new Promise((resolve) => {
        setTimeout(() => {
          resolve('loadFake');
        }, 800);
      });
    },
  },
};
</script>
