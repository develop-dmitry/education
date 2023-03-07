<template lang="pug">
.pagination(:class="componentClass")
  ul.pagination__list
    li.pagination__item(
      v-if="pages.at(0) !== 1"
      @click.prevent="select(1)"
    ) 1
    li.pagination__item.pagination__item_fake(
      v-if="pages.at(0) !== 1"
    ) ...
    li.pagination__item(
      v-for="(page, key) in pages"
      :key="key"
      :class="{'pagination__item_current': page === componentCurrent}"
      @click.prevent="select(page)"
    ) {{ page }}
    li.pagination__item.pagination__item_fake(
      v-if="pages.at(-1) !== this.pageCount"
    ) ...
    li.pagination__item(
      v-if="pages.at(-1) !== this.pageCount"
      @click.prevent="select(this.pageCount)"
    ) {{ this.pageCount }}
</template>

<script lang="ts">
import {defineComponent} from "vue";
import ComponentClassMixin from "../Mixins/ComponentClassMixin.vue";

export default defineComponent({
  name: 'Pagination',

  mixins: [
    ComponentClassMixin
  ],

  emits: {
    select(page: number) {
      return page > 0;
    }
  },

  data() {
    return {
      componentCurrent: this.current
    }
  },

  props: {
    current: {
      type: Number,
      required: true
    },
    pageCount: {
      type: Number,
      required: true
    }
  },

  computed: {
    pages() {
      const pages = [];

      let start = this.componentCurrent - 2;

      if (start < 1) {
        start = 1;
      }

      let end = start + 4;

      if (end > this.pageCount) {
        end = this.pageCount;
      }

      while (end - start < 4 && start > 1) {
        start -= 1;
      }

      do {
        pages.push(start++);
      } while (start <= end);

      return pages;
    }
  },

  methods: {
    select(page: number) {
      this.componentCurrent = page;
      this.$emit('select', page);
    }
  },

  watch: {
    current(value) {
      this.componentCurrent = value;
    }
  }
})
</script>

<style lang="scss">
.pagination {

  &__list {
    display: flex;
    justify-content: center;
    list-style: none;
    column-gap: 10px;
    margin: 0;
    padding: 0;
  }

  &__item {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 30px;
    width: 30px;
    height: 30px;
    box-sizing: border-box;
    padding: 0 5px;
    font-size: 14px;
    border: 1px solid #000000;
    border-radius: 4px;
    text-decoration: none;
    color: #000000;
    cursor: pointer;

    &_current {
      background: #000000;
      color: #ffffff;
      pointer-events: none;
    }

    &_fake {
      border: 0;
      pointer-events: none;
    }
  }
}
</style>