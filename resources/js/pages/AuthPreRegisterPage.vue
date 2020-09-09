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

  height: 100%;
  justify-content: flex-start;

  .title {
    margin-bottom: 3vh;
  }

  &__container {
    width: 90%;
    padding: 10vh 0;
    display: flex;
    justify-content: center;
    flex-direction: column-reverse;
    align-items: center;

    @include tablet-m {
      flex-direction: row;
      align-items: start;
    }
  }

  &__content {
    width: auto;
    padding: 0;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    margin-bottom: 30px;

    @include tablet {
      width: 550px;
      margin-bottom: 0;
      padding: 0 50px;
    }

    .btn {
      width: 100%;
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 15px;

      svg {
        fill: $black;
        height: 29px;
        width: auto;
        margin-left: 15px;
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
