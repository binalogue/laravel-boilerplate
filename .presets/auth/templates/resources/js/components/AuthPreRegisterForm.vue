<template>
  <form class="AuthPreRegisterForm" @submit.prevent="registerWithEmail">
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
      Siguiente
    </BaseSubmitButton>
  </form>
</template>

<script>
/* Vendor */
import { email, required } from 'vuelidate/lib/validators';

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
    registerWithEmail() {
      this.$inertia.get(this.route('register.form'), this.form);
    },
  },
};
</script>

<style lang="scss" scoped>
.AuthPreRegisterForm {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  width: 100%;
}
</style>
