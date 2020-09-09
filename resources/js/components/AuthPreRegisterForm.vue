<template>
  <form
    class="AuthPreRegisterForm"
    @submit.prevent="vuelidate(registerWithEmail)"
  >
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
    async registerWithEmail() {
      await this.$inertia.visit(this.route('register.form'), {
        data: this.form,
      });
    },
  },
};
</script>

<style lang="scss" scoped>
.AuthPreRegisterForm {
  width: 100%;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
}
</style>
