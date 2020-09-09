<template>
  <div class="AuthLoginPage">
    <div class="AuthLoginPage__content">
      <div class="AuthLoginPage__login-mail">
        <h1 class="AuthLoginPage__login-mail--title">
          O si lo prefieres...
        </h1>

        <AuthLoginForm />
      </div>
      <div class="AuthLoginPage__login-rrss">
        <h2 class="AuthLoginPage__login-mail--title">
          Inicia Sesión
        </h2>

        <!-- Do not use <inertia-link></inertia-link> for OAuth -->
        <a
          class="btn"
          :href="
            route('oauth', {
              driver: 'google',
            })
          "
          @click="
            $gtm.track('login', {
              category: 'engagement',
              label: 'Google',
            })
          "
        >
          Inicia Sesión con Google <LogoGoogle />
        </a>

        <p class="AuthLoginPage__login-rrss--text">
          Si aún no tienes cuenta,
          <inertia-link class="link" :href="route('register')">
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
import Page from 'mixins/Page';

export default {
  layout: mainLayout,

  mixins: [Page],

  metaInfo() {
    return {
      title: 'Login',
    };
  },
};
</script>

<style lang="scss">
.AuthLoginPage {
  @include page;

  height: 100%;
  justify-content: center;

  @include tablet-m {
    justify-content: flex-start;
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

    &--title {
      @include title;

      margin-bottom: 3vh;
    }

    .link {
      color: $white;
      display: inline-block;
      margin: 20px 0 0;
    }
  }

  &__login-rrss {
    width: 100%;
    max-width: 420px;
    padding: 7vh 0 0 0;
    display: flex;
    flex-direction: column;
    align-items: flex-start;

    // @include tablet-m {
    //   width: 50%;
    //   padding: 5vh 0px 5vh 40px;
    // }

    @include tablet-m {
      width: 50%;
      padding: 5vh 40px 5vh 0;
      border-right: 1px solid $white;
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

    &--text {
      @include text;

      margin-top: 10px;
      margin-bottom: 20px;

      @include tablet-m() {
        margin-left: auto;
      }
    }

    .link {
      color: $primary;
      display: inline-block;

      &:hover {
        &::after {
          content: '';
          width: 100%;
          background: $primary;
        }
      }
    }
  }
}
</style>
