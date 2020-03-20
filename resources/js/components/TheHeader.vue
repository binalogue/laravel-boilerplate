<template>
  <div class="TheHeader">
    <inertia-link
      :href="route('home')"
      class="TheHeader__logo"
      :style="{
        pointerEvents: route().current() === 'home'
          ? 'none'
          : 'auto',
      }"
      @click.stop="navigateToHome"
    >
      <img
        v-webp="'/images/binalogue-logo.png'"
        alt="Binalogue"
      >
    </inertia-link>
  </div>
</template>

<style lang="scss">
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
