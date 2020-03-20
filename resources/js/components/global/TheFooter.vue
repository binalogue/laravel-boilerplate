<template>
  <div class="TheFooter">
    <div class="TheFooter__left">
      <p class="TheFooter__copyright">
        ©2020 Binalogue
      </p>
    </div>
  </div>
</template>

<script>
export default {
  name: 'TheFooter',

  methods: {
    navigateToHome() {
      this.$router.push('/');
    },
  },
};
</script>

<style lang="scss" scoped>
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
