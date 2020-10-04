<template>
  <form class="AuthPasswordRequestForm" @submit.prevent="requestPassword">
    <BaseInputText
      v-model="form.email"
      :v="$v.form.email"
      type="email"
      name="email"
      label="Email"
      placeholder="Email"
    />

    <BaseSubmitButton
      :submitting="submitting"
      :disabled="submitting"
      :has-errors="hasErrors"
    >
      Recuperar contraseña
    </BaseSubmitButton>
  </form>
</template>

<script>
/* Vendor */
import { required, email } from 'vuelidate/lib/validators';

/* Mixins */
import vuelidate from 'mixins/vuelidate';

export default {
  mixins: [vuelidate],

  validations: {
    form: {
      email: {
        required,
        email,
      },
    },
  },

  data() {
    return {
      form: {
        email: '',
      },
    };
  },

  methods: {
    requestPassword() {
      this.$inertia.post(this.route('password.email'), this.form, {
        onStart: () => this.handleStartEvent(),
        onSuccess: () => this.handleSuccessEvent(),
      });
    },
  },
};
</script>
