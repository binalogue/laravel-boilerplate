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
  align-items: center;
  width: 100%;
  padding: 10px 15px;

  @media (min-width: 576px) {
    padding: 30px 50px;
  }

  &__logo {
    width: 150px;
    height: auto;
    margin-left: auto;

    @media (min-width: 576px) {
      width: 250px;
    }

    img {
      width: 100%;
    }
  }
}
</style>
