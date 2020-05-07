<template>
  <form
    class="AuthLoginForm"
    @submit.prevent="$HasVuelidate_submit(login)"
  >
    <BaseInputText
      v-model="form.email"
      :v="$v.form.email"
      label="Email"
      type="email"
      name="email"
      placeholder="Email"
    />

    <BaseInputText
      v-model="form.password"
      :v="$v.form.password"
      label="Contraseña"
      type="password"
      name="password"
      placeholder="Contraseña"
    />

    <BaseInputCheckbox
      v-model="remember"
      :v="$v.form.remember"
      label="Recuérdame"
      name="remember"
    />

    <BaseSubmitButton
      class="btn"
      :class="$HasVuelidate_submitButtonClass"
      :disabled="$HasVuelidate_submitButtonDisabled"
    >
      Inicia Sesión
    </BaseSubmitButton>

    <inertia-link
      class="link"
      :href="route('password.request')"
    >
      ¿Has olvidado tu contraseña?
    </inertia-link>
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
      password: {
        required,
      },
    },
  },

  data() {
    return {
      form: {
        email: '',
        password: '',
        remember: false,
      },
    };
  },

  computed: {
    remember: {
      get() {
        return !!this.form.remember;
      },
      set(value) {
        this.form.remember = value;
      },
    },
  },

  methods: {
    async login() {
      await this.$inertia.post(this.route('login'), this.form);

      if (!this.$page.hasErrorsOrExceptions) {
        this.$gtm.track('login', {
          category: 'engagement',
          label: 'Email',
        });
      }
    },
  },
};
</script>

<style lang="scss">
  .AuthLoginForm {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
  }

</style>
