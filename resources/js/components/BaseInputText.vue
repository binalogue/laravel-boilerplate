<template>
  <BaseFormGroup
    class="BaseInputText"
    :class="{ active: isActive }"
    :validator="v"
    :name="name"
    :attribute="label | toLowerCase"
  >
    <label :for="name" class="BaseInputText__label">
      {{ label }}
    </label>

    <input
      :id="name"
      class="BaseInputText__input"
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

    <div v-if="icon" class="BaseInputText__icon">
      <component :is="icon" />
    </div>
  </BaseFormGroup>
</template>

<script>
export default {
  props: {
    autocomplete: {
      type: String,
      default: '',
    },

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

<style lang="scss" scoped>
.BaseInputText {
  position: relative;
  display: flex;
  flex-direction: column;
  width: 100%;
  min-width: 300px;

  &__label {
    font-size: 14px;
    margin-bottom: 5px;
    color: $white;
  }

  &__input {
    @include transition;

    outline: none;
    background: transparent;
    color: $white;
    padding: 12px 15px 11px 15px;
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 20px;
    border: 1px solid $white;

    &::placeholder {
      opacity: 0.3;
      font-size: 16px;
    }
  }

  &__icon {
    position: absolute;
    fill: $white;
    right: 15px;
    top: 26px;

    svg {
      height: 22px;
      width: auto;
    }
  }

  &.active {
    .BaseInputText__input {
      border: 1px solid $primary;
    }
  }
}
</style>
