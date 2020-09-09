<template>
  <BaseFormGroup
    :validator="v"
    :name="name"
    :attribute="label | toLowerCase"
    class="input"
    :class="{
      active: isActive,
    }"
  >
    <label :for="name" class="input__label">
      {{ label }}
    </label>

    <input
      :id="name"
      class="input__input"
      :value="value"
      :type="type"
      :name="name"
      :placeholder="placeholder"
      :disabled="disabled"
      :autocomplete="autocomplete"
      @input="$emit('input', $event.target.value)"
      @focusin="handleFocus(true)"
      @focusout="handleFocus(false)"
    />

    <div v-if="icon" class="input__icon">
      <component :is="icon" />
    </div>
  </BaseFormGroup>
</template>

<script>
export default {
  props: {
    disabled: {
      type: Boolean,
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
