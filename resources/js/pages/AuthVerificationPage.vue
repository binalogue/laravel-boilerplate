<template>
  <div class="AuthVerificationPage">
    <div class="AuthVerificationPage__content">
      <h1 class="AuthVerificationPage__content--title">
        Verificar Email
      </h1>

      <h2 class="AuthVerificationPage__content--subtitle">
        Antes de continuar, debes verificar tu email.

        <br>

        Si no has recibido ningún email:
      </h2>

      <AuthVerificationForm />
    </div>
  </div>
</template>

<script>
/* Helpers */
import { mainLayout } from 'helpers/vue-layouts';

/* Mixins */
import Page from 'mixins/Page';

export default {
  layout: mainLayout,

  mixins: [Page],

  metaInfo() {
    return {
      title: 'Verificar Email',
    };
  },
};
</script>

<style lang="scss">
.AuthVerificationPage {
  @include page;

  height: 100%;
  justify-content: flex-start;

  &__content {
    width: 90%;
    max-width: 550px;
    padding: 15vh 0;

    &--title {
      @include title;
      margin-bottom: 3vh;
    }

    &--subtitle {
      @include title;

      font-weight: 400;
      margin-bottom: 3vh;
    }

    .link {
      color: $white;
      display: inline-block;
      margin: 30px 0 ;
    }
  }
}
</style>
