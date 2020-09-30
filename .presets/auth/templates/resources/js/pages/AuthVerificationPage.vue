<template>
  <div class="AuthVerificationPage">
    <div class="AuthVerificationPage__content">
      <h1 class="title">
        Verificar Email
      </h1>

      <h2 class="text">
        Antes de continuar, debes verificar tu email.

        <br />

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
import page from 'mixins/page';

export default {
  mixins: [page],

  layout: mainLayout,

  metaInfo() {
    return {
      title: 'Verificar Email',
    };
  },
};
</script>

<style lang="scss" scoped>
.AuthVerificationPage {
  @include page;

  justify-content: flex-start;
  height: 100%;

  .title {
    margin-bottom: 3vh;
  }

  .text {
    margin-bottom: 3vh;
    font-weight: 400;
  }

  &__content {
    width: 90%;
    max-width: 550px;
    padding: 15vh 0;
  }
}
</style>
