<template>
  <BaseFormGroup
    :validator="v"
    :name="name"
    :attribute="label | toLowerCase"
    class="BaseInputCheckbox"
  >
    <div class="BaseInputCheckbox__container">
      <div
        class="BaseInputCheckbox__checkbox"
        :class="{ active: value }"
        @click="toggle"
      />

      <span class="BaseInputCheckbox__label" @click="toggle" v-html="label" />
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
  a {
    text-decoration: underline;
  }
}
</style>

<style lang="scss" scoped>
.BaseInputCheckbox {
  display: flex;
  flex-direction: column;

  &__container {
    display: flex;
    align-items: center;
  }

  &__label {
    margin-left: 10px;
    color: $grey;
  }

  &__checkbox {
    width: 15px;
    height: 15px;
    cursor: pointer;
    background-color: transparent;
    border: 1px solid $grey;

    &.active {
      width: 15px;
      height: 15px;
      cursor: pointer;
      background: $primary;
      border: 1px solid $grey;
    }
  }
}
</style>
