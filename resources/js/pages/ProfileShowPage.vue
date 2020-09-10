<template>
  <div class="ProfileShowPage">Hola {{ userName }}!</div>
</template>

<script>
/* Helpers */
import { mainLayout } from 'helpers/vue-layouts';

/* Mixins */
import page from 'mixins/page';

export default {
  mixins: [page],

  props: {
    profile: {
      type: Object,
      required: true,
    },
  },

  layout: mainLayout,

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

<style lang="scss" scoped>
.ProfileShowPage {
  @include page;
}
</style>
