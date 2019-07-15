<template>
  <div class="HomePage">
    <CustomHeader />
    <main class="HomePage__main animated fade-in-up delay-05s">
      <h1 class="HomePage__main--title">
        We ❤️ code
      </h1>
      <a
        href="#"
        class="HomePage__main--button custom-button"
        @click.stop="gtagDiscoverCampaign"
      >
        Comenzar
      </a>
    </main>
  </div>
</template>

<script>
/* Components */
import CustomHeader from 'components/global/CustomHeader';

/* Vendor */
import { mapState, mapMutations } from 'vuex';
import PxLoader from 'pxloader';
import 'pxloader/PxLoaderImage';

export default {
  name: 'HomePage',

  components: {
    CustomHeader,
  },

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
  display: flex;
  flex-direction: column;
  width: 100%;
  height: 100%;

  &__main {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-top: 20vh;

    &--title {
      margin-bottom: 3vh;
      font-size: 60px;
    }
  }
}
</style>
