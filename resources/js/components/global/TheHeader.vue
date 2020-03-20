<template>
  <div class="TheHeader">
    <div
      class="TheHeader__logo"
      :style="{
        cursor: this.$route.name === 'home' ? 'default' : 'pointer',
      }"
      @click.stop="navigateToHome"
    >
      <img
        v-webp="'/images/binalogue-logo.png'"
        alt="Binalogue"
      >
    </div>
  </div>
</template>

<script>
export default {
  name: 'TheHeader',

  methods: {
    navigateToHome() {
      this.$router.push('/');
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

    @include tablet-m() {
      width: 200px;
    }

    img {
      width: 100%;
    }
  }
}
</style>
