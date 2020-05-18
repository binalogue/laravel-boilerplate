<template>
  <form
    class="AuthRegisterForm"
    @submit.prevent="$HasVuelidate_submit(register)"
  >
    <h2 class="AuthRegisterForm__title">
      Completa tus datos
    </h2>

    <BaseInputText
      v-model="form.name"
      :v="$v.form.name"
      label="Nombre"
      type="text"
      name="name"
      placeholder="Nombre"
    />

    <BaseInputText
      v-model="form.first_surname"
      :v="$v.form.first_surname"
      label="Primer Apellido"
      type="text"
      name="first_surname"
      placeholder="Primer Apellido"
    />

    <BaseInputText
      v-model="form.second_surname"
      :v="$v.form.second_surname"
      label="Segundo Apellido"
      type="text"
      name="second_surname"
      placeholder="Segundo Apellido"
    />

    <BaseInputText
      v-model="form.email"
      :v="$v.form.email"
      label="Email"
      type="email"
      name="email"
      placeholder="Email"
      :disabled="signUpMethod !== 'Email'"
    />

    <template v-if="signUpMethod === 'Email'">
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
    </template>

    <BaseSubmitButton
      class="btn AuthRegisterForm__privacy--button"
      :class="$HasVuelidate_submitButtonClass"
      :disabled="$HasVuelidate_submitButtonDisabled"
    >
      Crear Perfil
    </BaseSubmitButton>
  </form>
</template>

<script>
/* Vendor */
import { email, required, sameAs } from 'vuelidate/lib/validators';

/* Mixins */
import HasVuelidate from 'mixins/HasVuelidate';

export default {
  mixins: [HasVuelidate],

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

    if (this.signUpMethod === 'Facebook') {
      return {
        form: Object.assign(baseValidations, {
          facebook_id: {
            required,
          },
        }),
      };
    }

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
        legal1: '',
        legal2: '',
        legal3: '',

        // Hidden fields from OAuth.
        facebook_id: this.$page.newUser.facebook_id || '',
        google_id: this.$page.newUser.google_id || '',
        avatar: this.$page.newUser.avatar || '',
      },

      isShownFirstPrivacyText: false,
      isShownSecondPrivacyText: false,
    };
  },

  computed: {
    vFacebookIdInvalid() {
      return this.$v.form.facebook_id
        ? this.$v.form.facebook_id.$invalid
        : null;
    },

    vGoogleIdInvalid() {
      return this.$v.form.google_id
        ? this.$v.form.google_id.$invalid
        : null;
    },
  },

  watch: {
    vFacebookIdInvalid(newValue) {
      if (newValue) {
        console.error('The field "facebook_id" is not provided!');
      }
    },

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

<style lang="scss">
.AuthRegisterForm {
  display: flex;
  flex-direction: column;
  width: 100%;

  &__text {

    p {
      text-align: left;
      font-family: "Gotham";
      font-weight: 400;
      font-size: 13px;
      line-height: 17px;
      margin-bottom: 10px;
    }

    .link-teaser {
      text-align: left;
      font-family: "Gotham";
      font-weight: 400;
      font-size: 13px;
      line-height: 17px;
      margin-bottom: 10px;
    }

    .link-teaser {
      color: $primary;
      margin-bottom: 0;

      &:hover {
        text-decoration: underline;
      }
    }
  }

  &__title {
    @include title;
    margin-bottom: 3vh;
  }

  &__privacy {
    border: 1px solid $white;
    padding: 20px;

    &--title {
      margin-bottom: 10px;
    }

    &--question {
      @include text;
      margin-bottom: 10px;
    }

    &--answer {
      display: flex;
      align-items: center;
      position: relative;

      span {
        display: flex;
        align-items: center;
        margin-right: 30px;
        margin-bottom: 15px;

        @include text;
        color: $primary;
        font-weight: 800;
      }
    }

    &--aditional {
      font-weight: 800;
      cursor: pointer;
      position: absolute;
      top: 0;
      left: 140px;
    }

    &--aditional-show {
      font-size: 14px;
      line-height: 20px;
      background: rgba($black, .4);
      height: 0;
      overflow: hidden;

      @include transition;

      // &.active {
      //   height: 125px;
      //   background: transparent;
      //   margin-bottom: 10px;

      //   @include tablet {
      //     height: 80px;
      //   }
      // }
    }

    &--button {
      margin-bottom: 10px;
    }

    &--text {
      text-align: left;
      font-family: "Gotham";
      font-weight: 400;
      font-size: 13px;
      line-height: 17px;
      margin-bottom: 10px;

      .link-teaser {
        text-align: left;
        font-family: "Gotham";
        font-weight: 400;
        font-size: 13px;
        line-height: 17px;
        margin-bottom: 10px;
      }

      .link-teaser {
        color: $primary;
        margin-bottom: 0;

        &:hover {
          text-decoration: underline;
        }
      }
    }
  }

  .link {
    display: inline-block;
    color: $primary;

    &:hover {

      &::after {
        background: $primary;
      }
    }
  }

}
</style>
