<template>
  <div class="TheCookieBanner">
    <div class="TheCookieBanner__container">
      <p v-html="$lang.get('components.the_cookie_banner.html')" />

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
export default {
  methods: {
    acceptCookies() {
      this.$cookies.set('bina_cookies_notice', '1');
      this.$store.commit('TOGGLE_THE_COOKIE_BANNER', false);
    },
  },
};
</script>

<style lang="scss">
.TheCookieBanner {
  a {
    @include text-s;

    color: $white;
    text-decoration: underline;
  }
}
</style>

<style lang="scss" scoped>
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
