<template>
  <form class="AuthVerificationForm" @submit.prevent="requestVerificationEmail">
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
    requestVerificationEmail() {
      this.$inertia.post(
        this.route('verification.resend'),
        {},
        {
          onStart: () => this.handleStartEvent(),
          onSuccess: () => this.handleSuccessEvent(),
        }
      );
    },
  },
};
</script>
