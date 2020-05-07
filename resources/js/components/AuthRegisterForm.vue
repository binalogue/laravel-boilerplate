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

    <div class="AuthRegisterForm__privacy">
      <h3 class="AuthRegisterForm__privacy--title">
        Para nosotros tu privacidad es muy importante, ¿Nos dices cómo usar tus datos?
      </h3>

      <p class="AuthRegisterForm__privacy--question">
        ¿Te gustaría recibir descuentos y novedades de Volkswagen?
      </p>

      <div class="AuthRegisterForm__privacy--answer">
        <span>
          <BaseInputCheckboxDouble
            v-model="form.legal1"
            :v="$v.form.legal1"
            label="Sí"
            name="legal1"
            option-true="Sí"
            option-false="No"
          />
          <p
            class="link AuthRegisterForm__privacy--aditional"
            @click="isShownFirstPrivacyText = !isShownFirstPrivacyText"
          >
            + info
          </p>
        </span>
      </div>

      <p
        class="AuthRegisterForm__privacy--aditional-show"
        :class="{
          active: isShownFirstPrivacyText,
        }"
      >
        Estarás mejor informado. Recibirás información sobre los próximos lanzamientos, así como invitaciones a eventos, promociones y condiciones especiales.
      </p>

      <p class="AuthRegisterForm__privacy--question">
        ¿Podemos mejorar nuestras ofertas y servicios personalizándolos según tu perfil?
      </p>

      <div class="AuthRegisterForm__privacy--answer">
        <span>
          <BaseInputCheckboxDouble
            v-model="form.legal2"
            :v="$v.form.legal2"
            label="Sí"
            name="legal2"
            option-true="Sí"
            option-false="No"
          />
          <p
            class="link AuthRegisterForm__privacy--aditional"
            @click="isShownSecondPrivacyText = !isShownSecondPrivacyText"
          >
            + info
          </p>
        </span>
      </div>

      <p
        class="AuthRegisterForm__privacy--aditional-show"
        :class="{
          active: isShownSecondPrivacyText,
        }"
      >
        ¡Adiós mensajes genéricos! Activando esta opción podremos enviarte información y ofertas personalizadas de productos y servicios adecuadas a tu perfil. Para ello nos basaremos en tu comportamiento, preferencias personales y cómo usas nuestros productos y servicios.
      </p>

      <p class="AuthRegisterForm__privacy--question">
        Confirmo que he leído y acepto la
        <inertia-link
          href="#"
          class="link"
        >
          Política de Privacidad
        </inertia-link>
        ,
        <inertia-link
          href="#"
          class="link"
        >
          Bases de la Promoción
        </inertia-link>
        y
        <inertia-link
          href="#"
          class="link"
        >
          Condiciones de Uso
        </inertia-link>
        .
      </p>
      <div class="AuthRegisterForm__privacy--answer">
        <span>
          <BaseInputCheckboxDouble
            v-model="form.legal3"
            :v="$v.form.legal3"
            label="Sí"
            name="legal3"
            option-true="Sí"
            option-false="No"
          />
        </span>
      </div>
      <BaseSubmitButton
        class="btn AuthRegisterForm__privacy--button"
        :class="$HasVuelidate_submitButtonClass"
        :disabled="$HasVuelidate_submitButtonDisabled"
      >
        Crear Perfil
      </BaseSubmitButton>

      <p class="AuthRegisterForm__privacy--text">
        Te informamos que el responsable del tratamiento de tus datos es la compañía VOLKSWAGEN GROUP ESPAÑA DISTRIBUCION, S.A.U., con la finalidad de atender tus consultas y solicitudes, realizar un control de calidad sobre los productos y servicios solicitados, realizar encuestas de opinión y estudios de mercado con fines estadísticos. En caso que nos hayas dado tu consentimiento, para las finalidades descritas en los consentimientos adicionales.
      </p>

      <p class="AuthRegisterForm__privacy--text">
        Le informamos que tienes derecho a retirar tu consentimiento en cualquier momento así como a oponerte al tratamiento, limitar el mismo, acceder, rectificar,suprimir los datos y ejercer tu derecho a la portabilidad, mediante peticiónescrita a
        <a
          href="mailto:atencioncliente@volkswagen.es"
          class="link-teaser"
        >
          atencioncliente@volkswagen.es
        </a>
      </p>

      <p class="AuthRegisterForm__privacy--text">
        Puedes consultar con mayor detalle la información adicional sobre Protección de datos aquí
        <inertia-link
          href="#"
          class="link-teaser"
        >
          aquí
        </inertia-link>
        .
      </p>
    </div>
  </form>
</template>

<script>
/* Vendor */
import { email, required, sameAs } from 'vuelidate/lib/validators';

/* Mixins */
import HasVuelidate from 'mixins/HasVuelidate';

/* helpers */
import { checked } from 'helpers/vuelidate';

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
      legal1: {
        required,
      },
      legal2: {
        required,
      },
      legal3: {
        required,
        checked,
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

      &.active {
        height: 125px;
        background: transparent;
        margin-bottom: 10px;

        @include tablet {
          height: 80px;
        }
      }
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
