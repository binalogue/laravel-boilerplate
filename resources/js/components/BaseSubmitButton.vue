<template>
  <button type="submit" class="BaseSubmitButton" :disabled="disabled">
    <slot />

    <div class="dots">
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
