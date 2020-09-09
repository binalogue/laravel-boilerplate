<template>
  <div class="AuthLoginPage">
    <div class="AuthLoginPage__content">
      <div class="AuthLoginPage__login-mail">
        <h1 class="title">
          O si lo prefieres...
        </h1>

        <AuthLoginForm />
      </div>

      <div class="AuthLoginPage__login-rrss">
        <h2 class="title">
          Inicia Sesión
        </h2>

        <!-- Do not use <inertia-link> for OAuth -->
        <a
          class="btn"
          :href="route('oauth', { driver: 'google' })"
          @click="trackClick('Google')"
        >
          Inicia Sesión con Google <LogoGoogle />
        </a>

        <p class="text">
          Si aún no tienes cuenta,
          <inertia-link class="link" :href="route('preRegister.form')">
            Regístrate
          </inertia-link>
        </p>
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
  mixins: [page],

  layout: mainLayout,

  metaInfo() {
    return {
      title: 'Login',
    };
  },

  methods: {
    trackClick(label) {
      this.$gtm.track('login', {
        category: 'engagement',
        label,
      });
    },
  },
};
</script>

<style lang="scss" scoped>
.AuthLoginPage {
  @include page;

  height: 100%;
  justify-content: center;

  @include tablet-m {
    justify-content: flex-start;
  }

  .title {
    margin-bottom: 3vh;
  }

  .text {
    margin-top: 10px;
    margin-bottom: 20px;

    @include tablet-m() {
      margin-left: auto;
    }
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
      svg {
        fill: $white;
      }
    }
  }

  &__content {
    @include container;

    flex-direction: column-reverse;
    align-items: center;

    @include tablet-m {
      flex-direction: row-reverse;
      justify-content: center;
      align-items: initial;
      padding: 10vh 0;
    }
  }

  &__login-mail {
    width: 100%;
    max-width: 420px;
    padding: 0 0 5vh 0;

    @include tablet-m {
      width: 50%;
      padding: 5vh 0 5vh 40px;
    }
  }

  &__login-rrss {
    width: 100%;
    max-width: 420px;
    padding: 7vh 0 0 0;
    display: flex;
    flex-direction: column;
    align-items: flex-start;

    @include tablet-m {
      width: 50%;
      padding: 5vh 40px 5vh 0;
      border-right: 1px solid $white;
    }
  }
}
</style>
