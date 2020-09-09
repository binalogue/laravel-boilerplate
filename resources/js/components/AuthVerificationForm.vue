<template>
  <form class="AuthVerificationForm" @submit.prevent="requestVerificationEmail">
    <BaseSubmitButton
      class="btn"
      :class="submitButtonClass"
      :disabled="submitButtonDisabled"
    >
      Volver a Enviar
    </BaseSubmitButton>
  </form>
</template>

<script>
export default {
  data() {
    return {
      submitButtonClass: null,
      submitButtonDisabled: false,
    };
  },

  methods: {
    async requestVerificationEmail() {
      this.submitButtonClass = 'btn-loading';
      this.submitButtonDisabled = true;

      await this.$inertia.post(this.route('verification.resend'));

      this.submitButtonClass = '';
      this.submitButtonDisabled = false;
    },
  },
};
</script>
