<template>
  <div class="Loader">
    <div class="Loader__count">
      {{ loaderProgress }}%
    </div>

    <div class="Loader__image">
      <div class="loader-circle" />
      <div class="loader-line-mask">
        <div class="loader-line" />
      </div>
    </div>
  </div>
</template>

<script>
/* Vendor */
import { mapState } from 'vuex';

export default {
  name: 'Loader',

  computed: {
    ...mapState(['loaderProgress']),
  },
};
</script>

<style lang="scss" scoped>
.Loader {
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  z-index: 99;
  color: $white;
  background: linear-gradient(0deg, $black 0%, $white 100%);
  transition: all 1s;

  &__count {
    position: absolute;
    top: 50%;
    width: 100%;
    font-weight: 800;
    font-size: 13px;
    text-align: center;
    transform: translateY(-50%);

    @media (min-width: 769px) {
      font-size: calc(16px + 1vw);
    }
  }

  &__image {

    .loader-circle {
      position: absolute;
      top: 50%;
      left: 50%;
      width: 16vw;
      height: 16vw;
      margin-top: -8vw;
      margin-left: -8vw;
      border-radius: 50%;
      box-shadow: inset 0 0 0 6px $black_transparent;

      @media (min-width: 769px) {
        width: 10vw;
        height: 10vw;
        margin-top: -5vw;
        margin-left: -5vw;
      }
    }

    .loader-line-mask {
      position: absolute;
      top: 50%;
      left: 50%;
      width: 8vw;
      height: 16vw;
      margin-top: -8vw;
      margin-left: -8vw;
      overflow: hidden;
      transform-origin: 8vw 8vw;
      animation: rotate 1.2s infinite linear;

      @media (min-width: 769px) {
        width: 5vw;
        height: 10vw;
        margin-top: -5vw;
        margin-left: -5vw;
        transform-origin: 5vw 5vw;
      }

      .loader-line {
        width: 16vw;
        height: 16vw;
        border-radius: 50%;
        box-shadow: inset 0 0 0 6px $black_transparent;

        @media (min-width: 769px) {
          width: 10vw;
          height: 10vw;
        }
      }
    }
  }
}
</style>
