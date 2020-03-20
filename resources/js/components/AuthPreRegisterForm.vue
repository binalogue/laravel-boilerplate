<template>
  <form
    class="AuthPreRegisterForm"
    @submit.prevent="$HasVuelidate_submit(registerWithEmail)"
  >
    <BaseInputText
      v-model="form.email"
      :v="$v.form.email"
      label="Email"
      type="email"
      name="email"
      placeholder="Email"
      class="AuthPreRegisterForm__input"
    />

    <BaseSubmitButton
      class="AuthPreRegisterForm__button btn"
      :class="$HasVuelidate_submitButtonClass"
      :disabled="$HasVuelidate_submitButtonDisabled"
    >
      Siguiente
    </BaseSubmitButton>
  </form>
</template>

<script>
/* Vendor */
import { email, required } from 'vuelidate/lib/validators';

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
    async registerWithEmail() {
      await this.$inertia.visit(this.route('register.email'), {
        data: this.form,
      });
    },
  },
};
</script>

<style lang="scss">
.AuthPreRegisterForm {
  display: flex;
  flex-direction: column;
  width: 100%;

  &__input {

    label {
      color: $white;
    }
  }

  &__button {
    width: 100%;

    @include tablet-m {
      width: 150px;
    }
  }

  .input {

    input {
      background: transparent;
      color: $white;
      border: 1px solid $white ;
    }
  }
}

</style>
