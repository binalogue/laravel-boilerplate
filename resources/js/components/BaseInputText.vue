<template>
  <BaseFormGroup
    :validator="v"
    :name="name"
    :attribute="label | toLowerCase"
    class="BaseInputText input"
    :class="{
      active: isActive,
    }"
  >
    <div
      class="BaseInputText__input-container"
      :class="{
        active: value,
      }"
    >
      <label
        v-if="fakeLabel"
        :for="name"
        class="fake-label"
        :class="{
          active: isActive,
        }"
      >
        {{ fakeLabel }}
      </label>

      <label :for="name">
        {{ label }}
      </label>

      <input
        :id="name"
        :value="value"
        :type="type"
        :name="name"
        :placeholder="placeholder"
        :disabled="disabled"
        :autocomplete="autocomplete"
        @input="$emit('input', $event.target.value)"
        @focusin="handleFocus(true)"
        @focusout="handleFocus(false)"
      >

      <div
        v-if="icon"
        class="BaseInputText__icon icon"
      >
        <component :is="icon" />
      </div>
    </div>
  </BaseFormGroup>
</template>

<script>
export default {
  props: {
    disabled: {
      type: Boolean,
    },

    fakeLabel: {
      type: String,
      default: '',
    },

    icon: {
      type: String,
      default: undefined,
    },

    label: {
      type: String,
      default: '',
    },

    name: {
      type: String,
      required: true,
    },

    placeholder: {
      type: String,
      default: '',
    },

    type: {
      type: String,
      default: '',
    },

    autocomplete: {
      type: String,
      default: '',
    },

    v: {
      type: Object,
      default: () => {},
    },

    value: {
      type: String,
      default: '',
    },
  },

  data() {
    return {
      isActive: false,
    };
  },

  mounted() {
    this.handleFocus();
  },

  methods: {
    handleFocus(value) {
      if (this.value) {
        this.isActive = true;
        return;
      }

      this.isActive = value;
    },
  },
};
</script>
<style lang="scss">
.BaseInputText {

  &__icon {
    width: 50px;
    background: $black;
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;

    svg {
      width: 16px;
      top: 50%;
      position: absolute;
      left: 50%;
      transform: translate(-50%, -50%);
      fill: $white;
    }
  }

  &__input-container {
    position: relative;
  }
}
</style>
