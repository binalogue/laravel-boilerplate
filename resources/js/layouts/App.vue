<template>
  <main class="App">
    <slot />

    <transition name="fade">
      <TheCookieBanner v-if="$store.state.isShownTheCookieBanner" />
    </transition>

    <transition name="fade">
      <TheLoader v-if="$store.state.isLoading" />
    </transition>
  </main>
</template>

<script>
export default {
  metaInfo() {
    return {
      title: this.$page.meta.title,
      titleTemplate: `${this.$page.meta.title} - %s`,
    };
  },
};
</script>

<style lang="scss">
@import "~@sass/app";

.App {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: space-between;
  width: 100vw;
  min-height: 100vh;
  overflow-x: hidden;
  background-color: $black;
  background-repeat: no-repeat;
  background-size: cover;
}
</style>
