<template>
  <div class="TheHeader">
    <inertia-link
      class="TheHeader__logo"
      :class="{
        'pointer-events-none': $page.request.route_name === 'pages.home',
      }"
      :href="route('pages.home')"
      @click="handleClickLogo"
    >
      <img :src="$store.getters.getAppLogo" :alt="$store.getters.getAppName" />
    </inertia-link>
  </div>
</template>

<script>
export default {
  methods: {
    handleClickLogo() {
      this.$gtm.track('go-to-home-page', {
        category: 'engagement',
      });
    },
  },
};
</script>

<style lang="scss" scoped>
.TheHeader {
  display: flex;
  width: 100%;
  padding: 3vh 5vw;

  &__logo {
    width: 150px;
    height: auto;
    margin-left: auto;

    img {
      width: 100%;
    }
  }
}
</style>
