<template>
  <div class="AuthRegisterPage">
    <main class="AuthRegisterPage__main">
      <div class="AuthRegisterPage__form">
        <AuthRegisterForm :sign-up-method="signUpMethod" />
      </div>
    </main>
  </div>
</template>

<script>
/* Helpers */
import { mainLayout } from 'helpers/vue-layouts';

/* Mixins */
import page from 'mixins/page';

export default {
  mixins: [page],

  props: {
    newUser: {
      type: Object,
      default: () => {},
    },
  },

  layout: mainLayout,

  metaInfo() {
    return {
      title: 'Registro',
    };
  },

  computed: {
    oauth() {
      if (this.newUser.google_id) {
        return 'google';
      }

      return false;
    },

    signUpMethod() {
      return this.$lodash.upperFirst(this.oauth || 'email');
    },
  },

  mounted() {
    this.$gtm.track('begin-sign-up', {
      category: 'engagement',
      label: this.signUpMethod,
    });
  },
};
</script>

<style lang="scss" scoped>
.AuthRegisterPage {
  @include page;

  height: 100%;
  justify-content: flex-start;

  &__main {
    width: 90%;
    padding: 10vh 0;
    display: flex;
    justify-content: center;
    flex-direction: column;
    align-items: center;
  }

  &__form {
    width: 90vw;
    max-width: 550px;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    margin-bottom: 30px;

    @include tablet {
      margin-bottom: 0;
    }
  }
}
</style>
