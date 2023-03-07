<template lang="pug">
header.header
  .container
    nav.header__nav
      ul.header__list
        li.header__item
          router-link(to="/") Главная
        li.header__item
          router-link(to="/operations") Операции
</template>

<script lang="ts">
import {defineComponent} from "vue";

export default defineComponent({
  name: 'Header'
});
</script>

<style lang="scss">
.header {
  border-bottom: 1px solid #cccccc;
  padding: 15px 0;

  &__list {
    margin: 0;
    padding: 0;
    list-style: none;
    display: flex;
    justify-content: center;
    column-gap: 15px;
  }

  &__item {
    font-size: 16px;

    a {
      text-decoration: none;
      color: #000000;
    }
  }
}
</style>