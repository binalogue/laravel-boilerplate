<template>
  <BaseFormGroup
    :validator="v"
    :name="name"
    :attribute="label | toLowerCase"
  >
    <div class="BaseInputCheckboxDouble">
      <div
        class="BaseInputCheckboxDouble__checkbox"
        :class="{
          active: isAffirmed,
        }"
        @click="affirm"
      />

      <p>
        {{ optionTrue }}
      </p>

      <div
        class="BaseInputCheckboxDouble__checkbox right-checkbox"
        :class="{
          active: isDenied,
        }"
        @click="deny"
      />

      <p>
        {{ optionFalse }}
      </p>
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

    optionFalse: {
      type: String,
      required: true,
    },

    optionTrue: {
      type: String,
      required: true,
    },

    v: {
      type: Object,
      default: () => {},
    },

    value: {
      type: [String, Boolean],
      default: null,
    },
  },

  computed: {
    isDenied() {
      if (typeof this.value === 'boolean') {
        return !this.value;
      }

      return false;
    },

    isAffirmed() {
      if (typeof this.value === 'boolean') {
        return this.value;
      }

      return false;
    },
  },

  methods: {
    affirm() {
      // Do not touch!
      this.$emit('input', true);
    },

    deny() {
      // Do not touch!
      this.$emit('input', false);
    },
  },
};
</script>

<style lang="scss">
.BaseInputCheckboxDouble {
  display: flex;
  align-items: flex-start;

  @include tablet {
    align-items: center;
  }

  &__checkbox {
    width: 15px;
    height: 15px;
    background: $white;
    margin-right: 10px;
    cursor: pointer;
    border: 1px solid $white;

    @include transition;

    &.right-checkbox {
      margin-left: 30px;
    }
  }

  // .active {
  //   width: 15px;
  //   height: 15px;
  //   background: $primary;
  //   cursor: pointer;
  //   border: 1px solid $white;

  //   @include transition;
  // }
}
</style>
