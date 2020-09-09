<template>
  <div class="AuthPasswordForceResetPage">
    <div class="AuthPasswordForceResetPage__content">
      <h1 class="AuthPasswordForceResetPagee__content--title">
        Resetear Contraseña
      </h1>

      <AuthPasswordForceResetForm />
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
      title: 'Crear Nueva Contraseña',
    };
  },
};
</script>

<style lang="scss">
.AuthPasswordForceResetPage {
  @include page;

  height: 100%;
  justify-content: flex-start;

  &__content {
    width: 90%;
    max-width: 550px;
    padding: 15vh 0;

    .link {
      color: $white;
      display: inline-block;
      margin: 30px 0;
    }
  }
}

.AuthPasswordForceResetPagee__content--title {
  @include title;

  margin-bottom: 3vh;
}
</style>
