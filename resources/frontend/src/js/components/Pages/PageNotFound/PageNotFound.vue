<template lang="pug">
Header
.page-not-found
  .container
    .page-not-found__message
      | Страница не найдена, вернуться на&nbsp
      router-link(to="/") главную
</template>

<script lang="ts">
import {defineComponent} from "vue";
import Header from "../Header/Header.vue";

export default defineComponent({
  name: 'PageNotFound',

  components: {
    Header
  }
});
</script>

<style lang="scss">
.page-not-found {
  padding: 50px 0;

  &__message {
    font-size: 16px;

    a {
      color: #000;
    }
  }
}
</style>