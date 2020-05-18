<template>
  <div class="MainLayout">
    <TheHeader />

    <slot />

    <TheFooter />
  </div>
</template>

<style lang="scss">
.MainLayout {
  @include layout;
}
</style>
