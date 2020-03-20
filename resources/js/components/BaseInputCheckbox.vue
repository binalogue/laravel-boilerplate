<template>
  <BaseFormGroup
    :validator="v"
    :name="name"
    :attribute="label | toLowerCase"
  >
    <div class="BaseInputCheckbox">
      <div
        :class="{
          active: value,
          checkbox: !value,
        }"
        @click="toggle"
      />
    </div>
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

<style lang="scss">
.BaseInputCheckbox {
  display: flex;
  align-items: flex-start;

  @include tablet {
    align-items: center;
  }

  .checkbox {
    width: 15px;
    height: 15px;
    background: $white;
    margin-right: 10px;
    cursor: pointer;
    border: 1px solid $black;

    @include transition;
  }

  .active {
    width: 15px;
    height: 15px;
    background: $primary;
    cursor: pointer;
    border: 1px solid $white;

    @include transition;
  }
}

.active {
  width: 15px;
  height: 15px;
  background: $primary;
  margin-right: 10px;
  cursor: pointer;
  border: 1px solid $white;

  @include transition;
}
</style>
