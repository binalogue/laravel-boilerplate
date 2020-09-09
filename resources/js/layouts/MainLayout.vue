<template>
  <div class="MainLayout">
    <TheHeader />

    <slot />

    <TheFooter />
  </div>
</template>

<style lang="scss" scoped>
.MainLayout {
  @include layout;
}
</style>
