<template>
  <div class="HomePage">
    <main class="HomePage__main animated fade-in-up delay-05s">
      <h1 class="title">
        We ❤️ code
      </h1>

      <inertia-link href="#" class="btn" @click="trackClick">
        Comenzar
      </inertia-link>
    </main>
  </div>
</template>

<script>
/* Vendor */
import PxLoader from 'pxloader';
import 'pxloader/PxLoaderImage';

/* Helpers */
import { mainLayout } from 'helpers/vue-layouts';

/* Mixins */
import page from 'mixins/page';

export default {
  mixins: [page],

  layout: mainLayout,

  metaInfo() {
    return {
      title: 'Home',
    };
  },

  created() {
    this.setupPageLoader();
  },

  methods: {
    async setupPageLoader() {
      return [
        await this.loadFake(),
        // await this.loadImages(),
      ];
    },

    loadImages() {
      return new Promise(resolve => {
        const pxloader = new PxLoader();

        pxloader.addImage(this.webp('/images/logo.png'));

        if (this.$store.state.isPhone) {
          pxloader.addImage(this.webp('/images/binalogue-bg-home-mobile.jpg'));
        } else {
          pxloader.addImage(this.webp('/images/binalogue-bg-home-desktop.jpg'));
        }

        pxloader.addCompletionListener(() => {
          resolve('loadImages');
        });

        pxloader.start();
      });
    },

    trackClick() {
      this.$gtm.track('test-click', {
        category: 'engagement',
      });
    },
  },
};
</script>

<style lang="scss" scoped>
.HomePage {
  @include page;

  .title {
    margin-bottom: 3vh;
  }

  &__main {
    @include container;

    flex-direction: column;
    align-items: center;
    justify-content: center;
    margin-bottom: 10vh;
  }
}
</style>
