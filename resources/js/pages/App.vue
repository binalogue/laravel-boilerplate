<template>
  <div class="App">
    <transition name="fade">
      <Loader v-if="isLoading" />
    </transition>

    <transition name="fade">
      <CookieBanner v-if="isShownCookieBanner" />
    </transition>

    <router-view />
  </div>
</template>

<script>
/* Vendor */
import { mapState } from 'vuex';
import Cookies from 'js-cookie';

/* Components */
import Loader from 'components/global/Loader';
import CookieBanner from 'components/global/CookieBanner';

export default {
  name: 'App',

  components: {
    CookieBanner,
    Loader,
  },

  computed: {
    ...mapState(['isLoading', 'isShownCookieBanner']),
  },

  created() {
    Cookies.get('cookieNotice');
  },
};
</script>

<style lang="scss">
@import "~@/app";

.App {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: space-between;
  width: 100vw;
  min-height: 100vh;
  overflow-x: hidden;
  //background-image: url('/images-mobile/.jpg');
  background-color: #2b2b2b;
  background-repeat: no-repeat;
  background-size: cover;

  @media (min-width: 576px) {
    //background-image: url('/images/mobile.jpg');
  }
}
</style>
