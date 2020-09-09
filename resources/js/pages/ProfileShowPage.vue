<template>
  <div class="ProfileShowPage">Hola {{ userName }}!</div>
</template>

<script>
/* Helpers */
import { mainLayout } from 'helpers/vue-layouts';

/* Mixins */
import Page from 'mixins/Page';

export default {
  layout: mainLayout,

  mixins: [Page],

  props: {
    profile: {
      type: Object,
      required: true,
    },
  },

  metaInfo() {
    return {
      title: 'Perfil',
    };
  },

  computed: {
    userName() {
      return this.$lodash.get(this.profile, 'name');
    },
  },
};
</script>

<style lang="scss">
.ProfileShowPage {
  @include page;
}
</style>
