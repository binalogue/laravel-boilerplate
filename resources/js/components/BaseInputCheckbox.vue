<template>
  <BaseFormGroup
    :validator="v"
    :name="name"
    :attribute="label | toLowerCase"
    class="checkbox"
  >
    <div
      class="checkbox__check"
      :class="{
        active: value,
      }"
      @click="toggle"
    />

    <span
      v-if="label"
      class="checkbox__label"
    >
      {{ label }}
    </span>
  </BaseFormGroup>
</template>

<script>
export default {
  props: {
    label: {
      type: String,
      required: true,
    },

    name: {
      type: String,
      required: true,
    },

    v: {
      type: Object,
      default: () => {},
    },

    value: {
      type: Boolean,
    },
  },

  methods: {
    toggle() {
      this.$emit('input', !this.value);
    },
  },
};
</script>
