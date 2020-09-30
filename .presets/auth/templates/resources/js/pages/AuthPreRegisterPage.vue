<template>
  <div class="AuthPreRegisterPage">
    <div class="AuthPreRegisterPage__container">
      <div class="AuthPreRegisterPage__content">
        <h2 class="title">
          Regístrate con:
        </h2>

        <!-- Do not use <inertia-link></inertia-link> for OAuth -->
        <a class="btn" :href="route('oauth', { driver: 'google' })">
          Regístrate con Google
          <LogoGoogle />
        </a>

        <hr class="AuthPreRegisterPage__separator" />

        <h2 class="title">
          O si lo prefieres...
        </h2>

        <AuthPreRegisterForm />
      </div>
    </div>
  </div>
</template>

<script>
/* Helpers */
import { mainLayout } from 'helpers/vue-layouts';

/* Mixins */
import page from 'mixins/page';

export default {
  layout: mainLayout,

  mixins: [page],

  metaInfo() {
    return {
      title: 'Registro',
    };
  },
};
</script>

<style lang="scss" scoped>
.AuthPreRegisterPage {
  @include page;

  justify-content: flex-start;
  height: 100%;

  .title {
    margin-bottom: 3vh;
  }

  &__container {
    display: flex;
    flex-direction: column-reverse;
    align-items: center;
    justify-content: center;
    width: 90%;
    padding: 10vh 0;

    @include tablet-m {
      flex-direction: row;
      align-items: flex-start;
    }
  }

  &__content {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    width: auto;
    padding: 0;
    margin-bottom: 30px;

    @include tablet {
      width: 550px;
      padding: 0 50px;
      margin-bottom: 0;
    }

    .btn {
      display: flex;
      align-items: center;
      justify-content: space-between;
      width: 100%;
      margin-bottom: 15px;

      svg {
        width: auto;
        height: 29px;
        margin-left: 15px;
        fill: $black;
      }
    }
  }

  &__separator {
    width: 100%;
    margin-top: 20px;
    margin-bottom: 30px;
  }
}
</style>
