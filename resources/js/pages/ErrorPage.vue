<template>
  <div class="ErrorPage">
    <div class="ErrorPage__wrapper">
      <div class="ErrorPage__content">
        <div v-if="code" class="ErrorPage__code">
          {{ code }}
        </div>

        <div class="ErrorPage__message">
          {{ message }}
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    code: {
      type: Number,
      default: 0,
    },
  },

  computed: {
    message() {
      try {
        return {
          401: 'Unauthorized',
          403: 'Forbidden',
          404: 'Page Not Found',
          419: 'Page Expired',
          429: 'Too Many Requests',
          500: 'Server Error',
          503: 'Service Unavailable',
        }[this.code];
      } catch {
        return 'Unknown Error';
      }
    },
  },
};
</script>

<style lang="scss" scoped>
.ErrorPage {
  position: relative;
  display: flex;
  justify-content: center;
  min-height: 100vh;
  background-color: rgba(26, 32, 44, 1);

  @media (min-width: 640px) {
    align-items: center;
    padding-top: 0;
  }

  &__wrapper {
    max-width: 36rem;
    margin-right: auto;
    margin-left: auto;

    @media (min-width: 640px) {
      padding-right: 1.5rem;
      padding-left: 1.5rem;
    }

    @media (min-width: 1024px) {
      padding-right: 2rem;
      padding-left: 2rem;
    }
  }

  &__content {
    display: flex;
    align-items: center;
    padding-top: 2rem;

    @media (min-width: 640px) {
      justify-content: flex-start;
      padding-top: 0;
    }
  }

  &__code {
    padding-right: 1rem;
    padding-left: 1rem;
    font-size: 1.125rem;
    color: rgba(160, 174, 192, 1);
    letter-spacing: 0.05em;
    border-color: rgba(203, 213, 224, 1);
    border-right-style: solid;
    border-right-width: 1px;
  }

  &__message {
    margin-left: 1rem;
    font-size: 1.125rem;
    color: rgba(160, 174, 192, 1);
    text-transform: uppercase;
    letter-spacing: 0.05em;
  }
}
</style>
