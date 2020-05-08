<template>
  <div class="HomePage">
    <main class="HomePage__main animated fade-in-up delay-05s">
      <h1 class="HomePage__main--title">
        We ❤️ code
      </h1>

      <inertia-link
        href="#"
        class="btn"
        @click="$gtm.track('test-click', {
          category: 'engagement',
        })"
      >
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
import Page from 'mixins/Page';

export default {
  layout: mainLayout,

  mixins: [Page],

  metaInfo() {
    return {
      title: 'Home',
    };
  },

  data() {
    return {
      pxloader: null,
    };
  },

  created() {
    this.$$setupLoader();
  },

  methods: {
    async $$setupLoader() {
      return [
        await this.$$loadFake(),
        // await this.loadImages(),
      ];
    },

    loadImages() {
      return new Promise((resolve) => {
        this.pxloader = new PxLoader();

        this.pxloader.addImage(this.webp('/images/binalogue-logo.png'));

        if (this.$store.state.isPhone) {
          this.pxloader.addImage(this.webp('/images/binalogue-bg-home-mobile.jpg'));
        } else {
          this.pxloader.addImage(this.webp('/images/binalogue-bg-home-desktop.jpg'));
        }

        this.pxloader.addCompletionListener(() => {
          resolve('loadImages');
        });

        this.pxloader.start();
      });
    },
  },
};
</script>

<style lang="scss">
.HomePage {
  @include page;
  // background: red;

  &__main {
    @include container;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    margin-bottom: 10vh;

    &--title {
      @include title;
      margin-bottom: 3vh;
    }
  }
}
</style>
