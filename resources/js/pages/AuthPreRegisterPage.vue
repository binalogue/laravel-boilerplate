<template>
  <div class="AuthPreRegisterPage">
    <div class="AuthPreRegisterPage__content">
      <div class="AuthPreRegisterPage__register">
        <h2 class="AuthPreRegisterPage__register--title">
          Regístrate con:
        </h2>

        <!-- Do not use <inertia-link></inertia-link> for OAuth -->
        <a
          class="btn"
          :href="
            route('oauth', {
              driver: 'google',
            })
          "
        >
          Regístrate con Google
          <LogoGoogle />
        </a>

        <h2 class="AuthPreRegisterPage__register--title">
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
import Page from 'mixins/Page';

export default {
  layout: mainLayout,

  mixins: [Page],

  metaInfo() {
    return {
      title: 'Registro',
    };
  },
};
</script>

<style lang="scss">
.AuthPreRegisterPage {
  @include page;

  height: 100%;
  justify-content: flex-start;

  &__content {
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

  &__register {
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

    &--title {
      @include title;

      margin-bottom: 3vh;
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

        @include transition;
      }

      &:hover {
        background: $primary;

        svg {
          fill: $white;
        }
      }
    }
  }
}
</style>
