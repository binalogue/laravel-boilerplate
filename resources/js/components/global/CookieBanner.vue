<template>
  <div
    class="CookieBanner"
    role="alert"
  >
    <div class="CookieBanner__container">
      <!-- eslint-disable vue/no-v-html -->
      <p v-html="trans.get('messages.global.cookie_banner')" />
      <button
        type="button"
        class="CookieBanner__close"
        aria-label="Close"
        @click="acceptCookies"
      >
        <span aria-hidden="true">×</span>
      </button>
    </div>
  </div>
</template>

<script>
/* Vendor */
import { mapMutations } from 'vuex';
import Cookies from 'js-cookie';

export default {
  name: 'CookieBanner',

  methods: {
    ...mapMutations(['TOGGLE_COOKIE_BANNER']),

    acceptCookies() {
      Cookies.set('cookieNotice', '1');
      this.TOGGLE_COOKIE_BANNER(false);
    },
  },
};
</script>

<style lang="scss">
/* Can not be scoped to style v-html text */

.CookieBanner {
  position: fixed;
  top: 0;
  right: 0;
  left: 0;
  display: flex;
  justify-content: center;
  align-items: center;
  background: $alerts;
  padding: 1vh 0;

  &__container {
    @include container;
    justify-content: space-between;

    p {
      @include text-s;
      margin-right: 5vw;
    }

    a {
      @include text-s;
      color: $white;
      text-decoration: underline;
    }
  }

  &__close {
    border: 0;
    background: transparent;

    span {
      font-size: 30px;
      color: $white;
    }
  }
}
</style>
