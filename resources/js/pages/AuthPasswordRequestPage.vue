<template>
  <div class="AuthPasswordRequestPage">
    <div class="AuthPasswordRequestPage__content">
      <h1 class="AuthPasswordRequestPage__content--title">
        Recuperar Contraseña
      </h1>

      <AuthPasswordRequestForm />
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
      title: 'Recuperar Contraseña',
    };
  },
};
</script>

<style lang="scss">
.AuthPasswordRequestPage {
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
  }
}
</style>
