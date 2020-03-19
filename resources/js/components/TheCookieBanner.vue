<template>
  <div class="TheCookieBanner">
    <div class="TheCookieBanner__container">
      <button
        type="button"
        class="TheCookieBanner__close"
        @click="acceptCookies"
      >
        <span>
          ×
        </span>
      </button>

      <p v-html="$trans.get('messages.global.cookie_banner')" />
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

.TheCookieBanner__container {
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

.TheCookieBanner__close {
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
