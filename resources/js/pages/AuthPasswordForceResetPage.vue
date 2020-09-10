<template>
  <div class="AuthPasswordForceResetPage">
    <div class="AuthPasswordForceResetPage__content">
      <h1 class="title">
        Resetear contraseña
      </h1>

      <AuthPasswordForceResetForm />
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
      title: 'Crear Nueva Contraseña',
    };
  },
};
</script>

<style lang="scss" scoped>
.AuthPasswordForceResetPage {
  @include page;

  justify-content: flex-start;
  height: 100%;

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
