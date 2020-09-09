<template>
  <div class="TheFooter">
    <div class="TheFooter__left">
      <p class="TheFooter__copyright">
        ©2020 Binalogue
      </p>
    </div>
  </div>
</template>

<style lang="scss">
.TheFooter {
  width: 100%;
  display: flex;
  padding: 2vh 5vw;

  &__copyright {
    @include text;

    color: $grey;
  }
}
</style>
