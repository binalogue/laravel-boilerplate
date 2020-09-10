<template>
  <div class="TheFooter">
    <p class="TheFooter__copyright">
      ©2020 Binalogue
    </p>
  </div>
</template>

<style lang="scss" scoped>
.TheFooter {
  display: flex;
  width: 100%;
  padding: 2vh 5vw;

  &__copyright {
    @include text;

    color: $grey;
  }
}
</style>
