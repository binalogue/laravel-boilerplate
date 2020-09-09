<template>
  <div class="TheCookieBanner">
    <div class="TheCookieBanner__container">
      <p v-html="$trans.get('messages.global.cookie_banner')" />

      <button
        type="button"
        class="TheCookieBanner__close"
        @click="acceptCookies"
      >
        <span>
          ×
        </span>
      </button>
    </div>
  </div>
</template>

<script>
/* Vendor */
import { mapMutations } from 'vuex';
import Cookies from 'js-cookie';

export default {
  methods: {
    ...mapMutations(['TOGGLE_THE_COOKIE_BANNER']),

    acceptCookies() {
      Cookies.set('binalogue_cookies_notice', '1');
      this.TOGGLE_THE_COOKIE_BANNER(false);
    },
  },
};
</script>

<style lang="scss">
.TheCookieBanner {
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
