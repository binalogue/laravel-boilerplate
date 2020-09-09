<template>
  <form
    class="AuthPasswordForceResetForm"
    @submit.prevent="vuelidate(createNewPassword)"
  >
    <BaseInputText
      v-model="form.password"
      :v="$v.form.password"
      type="password"
      name="password"
      label="Contraseña"
      placeholder="Contraseña"
    />

    <BaseInputText
      v-model="form.password_confirmation"
      :v="$v.form.password_confirmation"
      type="password"
      name="password_confirmation"
      label="Confirmar contraseña"
      placeholder="Confirmar contraseña"
    />

    <BaseSubmitButton
      :submitting="submitting"
      :disabled="submitting"
      :has-errors="hasErrors"
    >
      Resetear contraseña
    </BaseSubmitButton>
  </form>
</template>

<script>
/* Vendor */
import { required, sameAs } from 'vuelidate/lib/validators';

/* Mixins */
import vuelidate from 'mixins/vuelidate';

export default {
  mixins: [vuelidate],

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
      },
    };
  },

  methods: {
    async createNewPassword() {
      await this.$inertia.post(
        this.route('password.force_reset_update'),
        this.form
      );
    },
  },
};
</script>
