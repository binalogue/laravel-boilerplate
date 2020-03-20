<template>
  <div class="HomePage">
    <TheHeader />
    <main class="HomePage__main animated fade-in-up delay-05s">
      <h1 class="HomePage__main--title">
        We ❤️ code
      </h1>
      <a
        href="#"
        class="btn"
        @click.stop="gtagDiscoverCampaign"
      >
        Comenzar
      </a>
    </main>
    <TheFooter />
  </div>
</template>

<script>
/* Vendor */
import { mapState, mapMutations } from 'vuex';
import PxLoader from 'pxloader';
import 'pxloader/PxLoaderImage';

export default {
  name: 'HomePage',

  data() {
    return {
      pxloader: null,
    };
  },

  computed: {
    ...mapState(['isPhone']),
  },

  created() {
    this.setupLoader();
  },

  methods: {
    ...mapMutations(['SET_LOADER_PROGRESS', 'TOGGLE_IS_LOADING']),

    handleLoaderProgress(event) {
      const count = Math.floor((event.completedCount / event.totalCount) * 100);
      this.SET_LOADER_PROGRESS(count);
    },

    handleLoaderCompletion() {
      this.TOGGLE_IS_LOADING(false);
    },

    setupLoader() {
      this.pxloader = new PxLoader();

      this.pxloader.addImage(this.webp('/images/binalogue-logo.png'));

      if (this.isPhone) {
        // this.pxloader.addImage(this.webp('/images/binalogue-bg-home-mobile.jpg'));
      } else {
        // this.pxloader.addImage(this.webp('/images/binalogue-bg-home-desktop.jpg'));
      }

      this.pxloader.addProgressListener(this.handleLoaderProgress);
      this.pxloader.addCompletionListener(this.handleLoaderCompletion);
      this.pxloader.start();
    },
  },
};
</script>

<style lang="scss" scoped>
.HomePage {
  @include page;

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
