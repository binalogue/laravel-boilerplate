<template>
  <div>
    <slot />

    <span
      v-if="hasFrontendOrBackendErrors"
      class="input-error"
    >
      <IconExclamation />
      {{ error }}
    </span>
  </div>
</template>

<script>
/* Vendor */
import { singleErrorExtractorMixin } from 'vuelidate-error-extractor';

export default {
  mixins: [singleErrorExtractorMixin],

  computed: {
    error() {
      if (this.hasFrontendErrors) {
        return this.activeErrorMessages[0];
      }

      if (this.hasBackendErrors) {
        return this.$page.errors[this.name][0];
      }

      return '';
    },

    hasBackendErrors() {
      return this.$page.hasErrors
        && Object.prototype.hasOwnProperty.call(this.$page.errors, this.name);
    },

    hasFrontendErrors() {
      return this.hasErrors;
    },

    hasFrontendOrBackendErrors() {
      return this.hasFrontendErrors || this.hasBackendErrors;
    },
  },
};
</script>
