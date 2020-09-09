<template>
  <div class="AuthPasswordRequestPage">
    <div class="AuthPasswordRequestPage__content">
      <h1 class="title">
        Recuperar contraseña
      </h1>

      <AuthPasswordRequestForm />
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
      title: 'Recuperar Contraseña',
    };
  },
};
</script>

<style lang="scss" scoped>
.AuthPasswordRequestPage {
  height: 100%;
  justify-content: flex-start;

  .title {
    margin-bottom: 3vh;
  }

  &__content {
    width: 90%;
    max-width: 550px;
    padding: 15vh 0;
  }
}
</style>
