<template lang="pug">
label.input(:class="componentClass")
  span(v-if="label").input__label {{ label }}
  input(:type="type" v-model="componentValue" :placeholder="placeholder").input__item
  span(v-if="error").input__error {{ error }}
</template>

<script lang="ts">
import {defineComponent} from "vue";
import ComponentClassMixin from "../../Mixins/ComponentClassMixin.vue";

export default defineComponent({
  name: 'Input',

  mixins: [
      ComponentClassMixin
  ],

  emits: [
      'change'
  ],

  data() {
    return {
      componentValue: '',
      quietUpdate: false
    }
  },

  props: {
    type: {
      type: String,
      default: 'text'
    },
    value: {
      type: [String, Number],
      default: ''
    },
    placeholder: {
      type: String,
      default: ''
    },
    label: {
      type: String,
      default: ''
    },
    error: {
      type: String,
      default: ''
    }
  },

  watch: {
    value: {
      handler(value) {
        this.quietUpdate = true;
        this.componentValue = value;
      },
      immediate: true
    },

    componentValue(value) {
      if (!this.quietUpdate) {
        this.$emit('change', value);
      }

      this.quietUpdate = false;
    }
  }
});
</script>

<style lang="scss">
.input {
  display: block;

  &__label {
    font-size: 14px;
    display: block;
    padding-bottom: 5px;
  }

  &__item {
    width: 100%;
    display: block;
    height: 50px;
    font-family: sans-serif;
    box-sizing: border-box;
    padding: 0 10px;
    font-size: 14px;
    border-radius: 10px;
    box-shadow: none;
    border: 1px solid #000000;
    color: #000000;

    &:focus {
      outline: none;
    }
  }

  &__error {
    font-size: 12px;
    font-family: sans-serif;
    display: block;
    margin-top: 5px;
    color: red;
  }
}
</style>