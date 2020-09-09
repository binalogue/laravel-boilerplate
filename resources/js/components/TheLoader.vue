<template>
  <div class="TheLoader">
    <img
      v-webp="'/images/logo.png'"
      alt="Binalogue"
    >
  </div>
</template>

<style lang="scss">
.TheLoader {
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  z-index: 99;
  color: $white;
  background: $black;
  transition: all 1s;
  display: flex;
  justify-content: center;
  align-items: center;

  img {
    height: 50px;
    width: auto;
  }
}
</style>
