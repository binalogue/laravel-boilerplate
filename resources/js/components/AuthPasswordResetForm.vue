<template>
  <form
    class="AuthPasswordResetForm"
    @submit.prevent="$HasVuelidate_submit(resetPassword)"
  >
    <BaseInputText
      v-model="form.password"
      :v="$v.form.password"
      label="Contraseña"
      type="password"
      name="password"
      placeholder="Contraseña"
    />

    <BaseInputText
      v-model="form.password_confirmation"
      :v="$v.form.password_confirmation"
      label="Confirmar Contraseña"
      type="password"
      name="password_confirmation"
      placeholder="Confirmar Contraseña"
    />

    <BaseSubmitButton
      class="btn"
      :class="$HasVuelidate_submitButtonClass"
      :disabled="$HasVuelidate_submitButtonDisabled"
    >
      Resetear Contraseña
    </BaseSubmitButton>
  </form>
</template>

<script>
/* Vendor */
import { required, sameAs } from 'vuelidate/lib/validators';

/* Mixins */
import HasVuelidate from 'mixins/HasVuelidate';

export default {
  mixins: [HasVuelidate],

  validations: {
    form: {
      password: {
        required,
      },
      password_confirmation: {
        sameAsPassword: sameAs('password'),
      },
    },
  },

  data() {
    return {
      form: {
        password: '',
        password_confirmation: '',
        email: this.$page.email,
        token: this.$page.token,
      },
    };
  },

  methods: {
    async resetPassword() {
      await this.$inertia.post(this.route('password.update'), this.form);
    },
  },
};
</script>
