<template>
  <form
    class="AuthVerificationForm"
    @submit.prevent="vuelidate(requestVerificationEmail)"
  >
    <BaseSubmitButton
      :submitting="submitting"
      :disabled="submitting"
      :has-errors="hasErrors"
    >
      Volver a Enviar
    </BaseSubmitButton>
  </form>
</template>

<script>
/* Mixins */
import vuelidate from 'mixins/vuelidate';

export default {
  mixins: [vuelidate],

  methods: {
    async requestVerificationEmail() {
      await this.$inertia.post(this.route('verification.resend'));
    },
  },
};
</script>
