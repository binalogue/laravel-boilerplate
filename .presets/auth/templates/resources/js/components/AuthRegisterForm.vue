<template>
  <form class="AuthRegisterForm" @submit.prevent="register">
    <h2 class="title">
      Completa tus datos
    </h2>

    <BaseInputText
      v-model="form.first_name"
      :v="$v.form.first_name"
      type="text"
      name="first_name"
      label="Nombre"
      placeholder="Nombre"
    />

    <BaseInputText
      v-model="form.last_name"
      :v="$v.form.last_name"
      type="text"
      name="last_name"
      label="Apellido"
      placeholder="Apellido"
    />

    <BaseInputText
      v-model="form.email"
      :v="$v.form.email"
      type="email"
      name="email"
      label="Email"
      placeholder="Email"
      :disabled="signUpMethod !== 'Email'"
    />

    <template v-if="signUpMethod === 'Email'">
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
        label="Confirmar Contraseña"
        placeholder="Confirmar Contraseña"
      />
    </template>

    <BaseSubmitButton
      :submitting="submitting"
      :disabled="submitting"
      :has-errors="hasErrors"
    >
      Crear Perfil
    </BaseSubmitButton>
  </form>
</template>

<script>
/* Vendor */
import { email, required, sameAs } from 'vuelidate/lib/validators';

/* Mixins */
import vuelidate from 'mixins/vuelidate';

export default {
  mixins: [vuelidate],

  props: {
    signUpMethod: {
      type: String,
      default: 'Email',
    },
  },

  validations() {
    const baseValidations = {
      first_name: {
        required,
      },
      last_name: {
        required,
      },
      email: {
        required,
        email,
      },
    };

    if (this.signUpMethod === 'Google') {
      return {
        form: Object.assign(baseValidations, {
          google_id: {
            required,
          },
        }),
      };
    }

    return {
      form: Object.assign(baseValidations, {
        password: {
          required,
        },
        password_confirmation: {
          sameAsPassword: sameAs('password'),
        },
      }),
    };
  },

  data() {
    return {
      form: {
        first_name: this.$page.newUser.first_name || '',
        last_name: this.$page.newUser.last_name || '',
        email: this.$page.newUser.email || '',
        password: '',
        password_confirmation: '',

        // Hidden fields from OAuth.
        google_id: this.$page.newUser.google_id || '',
        avatar: this.$page.newUser.avatar || '',
      },
    };
  },

  computed: {
    vGoogleIdInvalid() {
      return this.$v.form.google_id ? this.$v.form.google_id.$invalid : null;
    },
  },

  watch: {
    vGoogleIdInvalid(newValue) {
      if (newValue) {
        console.error('The field "google_id" is not provided!');
      }
    },
  },

  methods: {
    register() {
      this.$inertia.post(this.route('register'), this.form, {
        onStart: () => this.handleStartEvent(),
        onFinish: () => {
          if (!this.$page.hasErrorsOrExceptions) {
            this.$gtm.track('sign-up', {
              category: 'engagement',
              label: this.signUpMethod,
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
.AuthRegisterForm {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: center;
  width: 100%;

  .BaseSubmitButton {
    margin-top: 20px;
  }

  .title {
    margin-bottom: 3vh;
  }
}
</style>
