<template lang="pug">
button.button(:class="componentClass" @click.prevent="clickHandler") {{ text }}
</template>

<script lang="ts">
import {defineComponent} from "vue";
import ComponentClassMixin from "../../Mixins/ComponentClassMixin.vue";

export default defineComponent({
  name: 'Button',

  mixins: [
    ComponentClassMixin
  ],

  emits: [
    'click'
  ],

  props: {
    text: {
      type: String,
      required: true
    }
  },

  methods: {
    clickHandler() {
      this.$emit('click');
    }
  }
});
</script>

<style lang="scss">
.button {
  width: 100%;
  height: 50px;
  background: #000000;
  color: #ffffff;
  border: none;
  border-radius: 10px;
  font-size: 14px;
  font-weight: 700;
  
  &:hover {
    cursor: pointer;
  }
}
</style>