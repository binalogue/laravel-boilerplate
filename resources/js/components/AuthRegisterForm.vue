<template>
  <form class="AuthRegisterForm" @submit.prevent="vuelidate(register)">
    <h2 class="title">
      Completa tus datos
    </h2>

    <BaseInputText
      v-model="form.name"
      :v="$v.form.name"
      type="text"
      name="name"
      label="Nombre"
      placeholder="Nombre"
    />

    <BaseInputText
      v-model="form.first_surname"
      :v="$v.form.first_surname"
      type="text"
      name="first_surname"
      label="Primer Apellido"
      placeholder="Primer Apellido"
    />

    <BaseInputText
      v-model="form.second_surname"
      :v="$v.form.second_surname"
      type="text"
      name="second_surname"
      label="Segundo Apellido"
      placeholder="Segundo Apellido"
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
      name: {
        required,
      },
      first_surname: {
        required,
      },
      second_surname: {
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
        name: this.$page.newUser.name || '',
        first_surname: this.$page.newUser.first_surname || '',
        second_surname: this.$page.newUser.second_surname || '',
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
    async register() {
      await this.$inertia.post(this.route('register.post'), this.form);

      if (!this.$page.hasErrorsOrExceptions) {
        this.$gtm.track('sign-up', {
          category: 'engagement',
          label: this.signUpMethod,
        });
      }
    },
  },
};
</script>

<style lang="scss" scoped>
.AuthRegisterForm {
  width: 100%;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: start;

  .BaseSubmitButton {
    margin-top: 20px;
  }

  .title {
    margin-bottom: 3vh;
  }
}
</style>
