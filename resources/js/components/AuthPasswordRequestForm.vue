<template>
  <form
    class="AuthPasswordRequestForm"
    @submit.prevent="$HasVuelidate_submit(requestPassword)"
  >
    <BaseInputText
      v-model="form.email"
      :v="$v.form.email"
      label="Email"
      type="email"
      name="email"
      placeholder="Email"
    />

    <BaseSubmitButton
      class="btn"
      :class="$HasVuelidate_submitButtonClass"
      :disabled="$HasVuelidate_submitButtonDisabled"
    >
      Recuperar Contraseña
    </BaseSubmitButton>
  </form>
</template>

<script>
/* Vendor */
import { required, email } from 'vuelidate/lib/validators';

/* Mixins */
import HasVuelidate from 'mixins/HasVuelidate';

export default {
  mixins: [HasVuelidate],

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
    async requestPassword() {
      await this.$inertia.post(this.route('password.email'), this.form);
    },
  },
};
</script>

<style lang="scss">
.AuthPasswordRequestForm {

  .input {
    color: $white;

    input {
      background: transparent;
      border: 1px solid $white;
      color: $white;
    }
  }
}
</style>
