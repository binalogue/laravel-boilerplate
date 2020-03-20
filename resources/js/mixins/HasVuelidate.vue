<script>
export default {
  data() {
    return {
      submitButtonClass: null,
      submitButtonDisabled: false,
    };
  },

  computed: {
    $HasVuelidate_submitButtonClass() {
      return this.submitButtonClass;
    },

    $HasVuelidate_submitButtonDisabled() {
      return this.submitButtonDisabled;
    },
  },

  methods: {
    async $HasVuelidate_submit(next) {
      if (!next) {
        return;
      }

      this.$v.$touch();
      this.submitButtonClass = 'btn-loading';
      this.submitButtonDisabled = true;

      if (this.$v.$invalid) {
        this.$_HasVuelidate_startErrorsAnimation();
        return;
      }

      await next();

      if (this.$page.hasErrorsOrExceptions) {
        this.$_HasVuelidate_startErrorsAnimation();
        return;
      }

      this.$_HasVuelidate_resetForm();
    },

    $_HasVuelidate_resetForm() {
      if (this.form) {
        this.$lodash.mapValues(this.form, () => '');
      }

      this.submitButtonClass = '';
      this.submitButtonDisabled = false;
      this.$v.$reset();
    },

    $_HasVuelidate_startErrorsAnimation() {
      this.submitButtonClass = 'btn-error';

      setTimeout(() => {
        this.submitButtonClass = '';
        this.submitButtonDisabled = false;
      }, 1200);
    },
  },
};
</script>
