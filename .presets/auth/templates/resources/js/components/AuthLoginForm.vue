<template>
  <form class="AuthLoginForm" @submit.prevent="login">
    <BaseInputText
      v-model="form.email"
      :v="$v.form.email"
      type="email"
      name="email"
      label="Email"
      placeholder="Email"
    />

    <BaseInputText
      v-model="form.password"
      :v="$v.form.password"
      type="password"
      name="password"
      label="Contraseña"
      placeholder="Contraseña"
    />

    <BaseInputCheckbox
      v-model="remember"
      :v="$v.form.remember"
      name="remember"
      label="Recuérdame"
    />

    <BaseSubmitButton
      :submitting="submitting"
      :disabled="submitting"
      :has-errors="hasErrors"
    >
      Inicia Sesión
    </BaseSubmitButton>

    <inertia-link class="link" :href="route('password.request')">
      ¿Has olvidado tu contraseña?
    </inertia-link>
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
    login() {
      this.$inertia.post(this.route('login'), this.form, {
        onStart: () => this.handleStartEvent(),
        onSuccess: () => {
          if (!this.$page.hasErrorsOrExceptions) {
            this.$gtm.track('login', {
              category: 'engagement',
              label: 'Email',
            });
          }

          this.handleSuccessEvent();
        },
      });
    },
  },
};
</script>

<style lang="scss" scoped>
.AuthLoginForm {
  display: flex;
  flex-direction: column;
  align-items: flex-start;

  .BaseSubmitButton {
    margin-top: 30px;
    margin-bottom: 20px;
  }
}
</style>
