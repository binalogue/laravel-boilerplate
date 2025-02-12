export default {
  data() {
    return {
      hasErrors: false,
      submitting: false,
    };
  },

  methods: {
    handleStartEvent() {
      console.log('[vuelidate]', 'on start');

      this.submitting = true;

      if (this.$v) {
        this.$v.$touch();

        if (this.$v.$invalid) {
          this.$_vuelidate_handleErrors();
          return false;
        }
      }

      return true;
    },

    handleSuccessEvent() {
      console.log('[vuelidate]', 'on success');

      if (this.$page.hasErrorsOrExceptions) {
        this.$_vuelidate_handleErrors();
        return;
      }

      this.$_vuelidate_resetForm();
    },

    $_vuelidate_handleErrors() {
      this.hasErrors = true;

      setTimeout(() => {
        this.submitting = false;
        this.hasErrors = false;
      }, 1200);
    },

    $_vuelidate_resetForm() {
      if (this.form) {
        this.$lodash.mapValues(this.form, () => '');
      }

      this.submitting = false;

      if (this.$v) {
        this.$v.$reset();
      }
    },
  },
};
