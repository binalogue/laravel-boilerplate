<template>
  <button type="submit" class="BaseSubmitButton" :disabled="disabled">
    <slot />

    <div class="BaseSubmitButton__dots">
      <span>.</span>
      <span>.</span>
      <span>.</span>
    </div>
  </button>
</template>

<script>
export default {
  props: {
    disabled: {
      type: Boolean,
    },
  },
};
</script>

<style lang="scss" scoped>
.BaseSubmitButton {
  @include btn;

  &__dots {
    display: none;
  }
}

.BaseSubmitButton.loading {
  color: transparent;

  &:hover {
    color: transparent;
  }

  .BaseSubmitButton__dots {
    display: block;

    span {
      position: absolute;
      top: 40%;
      margin: 0;
      font-size: 22px;
      color: $white;
      transform: translateY(-50%);
      animation: btnLoading 0.9s infinite ease-in;

      &:nth-child(1) {
        left: 40%;
      }

      &:nth-child(2) {
        left: 50%;
        animation-delay: 0.3s;
      }

      &:nth-child(3) {
        left: 60%;
        animation-delay: 0.6s;
      }
    }
  }
}
</style>
