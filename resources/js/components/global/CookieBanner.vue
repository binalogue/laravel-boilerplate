<template>
  <div
    class="CookieBanner"
    role="alert"
  >
    <div class="CookieBanner__container">
      <button
        type="button"
        class="CookieBanner__close"
        aria-label="Close"
        @click="acceptCookies"
      >
        <span aria-hidden="true">×</span>
      </button>

      <!-- eslint-disable vue/no-v-html -->
      <p v-html="trans.get('messages.global.cookie_banner')" />
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
  margin-bottom: 0;
  padding: 14px 14px 12px;
  color: $white;
  font-weight: 400;
  font-size: 12px;
  background-color: $alerts;

  a {
    color: $white;
    text-decoration: underline;
  }
}

.CookieBanner__container {
  margin-right: auto;
  margin-left: auto;
  padding-right: 44px;
  padding-left: 15px;

  @media (min-width: 768px) {
    width: 750px;
  }

  @media (min-width: 992px) {
    width: 970px;
  }

  @media (min-width: 1200px) {
    width: 1170px;
  }
}

.CookieBanner__close {
  position: relative;
  top: 0;
  right: 0;
  float: right;
  margin-top: -3px;
  margin-bottom: -3px;
  padding: 0;
  color: $white;
  font-weight: 400;
  font-size: 24px;
  line-height: 1;
  background: transparent;
  border: 0;
  cursor: pointer;
  opacity: 1;
}
</style>
