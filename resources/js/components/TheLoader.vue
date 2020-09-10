<template>
  <div class="TheLoader">
    <img :src="$store.getters.getClientLogo" :alt="$store.getters.getAppName" />
  </div>
</template>

<style lang="scss" scoped>
.TheLoader {
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  z-index: 99;
  display: flex;
  align-items: center;
  justify-content: center;
  color: $white;
  background: $black;
  transition: all 1s;

  img {
    width: auto;
    height: 50px;
  }
}
</style>
