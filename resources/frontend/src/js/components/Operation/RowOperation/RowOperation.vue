<template lang="pug">
.row-operation(:class="componentClass" v-if="isHead")
  .row-operation__column Номер операции
  .row-operation__column Сумма операции
  .row-operation__column Дата операции
.row-operation(
  :class="{componentClass, 'row-operation_disabled': isDisabled, 'row-operation_fake': isFake}"
  v-else
)
  .row-operation__column {{ id }}
  .row-operation__column {{ amount }}
  .row-operation__column {{ displayDate }}
  .row-operation__delete(
    v-if="canDelete && id"
    @click.prevent="deleteRow"
  )
    span
    span
</template>

<script lang="ts">
import {defineComponent} from "vue";
import ComponentClassMixin from "../../Mixins/ComponentClassMixin.vue";
import DateFormatter from "../../../helpers/DateFormatter";

export default defineComponent({
  name: 'RowOperation',

  mixins: [
      ComponentClassMixin
  ],

  emits: {
    delete(id: number) {
      return id > 0;
    }
  },

  data() {
    return {
      dateFormatter: new DateFormatter()
    }
  },

  props: {
    id: Number,
    amount: Number,
    date: Date,
    isHead: {
      type: Boolean,
      default: false
    },
    canDelete: {
      type: Boolean,
      default: false
    },
    isDisabled: {
      type: Boolean,
      default: false
    },
    isFake: {
      type: Boolean,
      default: false
    }
  },

  computed: {
    displayDate() {
      if (this.date) {
        return this.dateFormatter.displayDate(this.date);
      }

      return '';
    }
  },

  methods: {
    deleteRow(): void {
      if (this.id && !this.isDisabled) {
        this.$emit('delete', this.id);
      }
    }
  }
});
</script>

<style lang="scss">
@keyframes blink {
  from {
    opacity: 1;
  }

  50% {
    opacity: 0;
  }

  to {
    opacity: 1;
  }
}

.row-operation {
  display: flex;
  justify-content: center;
  column-gap: 30px;
  padding: 7px 0;
  position: relative;
  transition: background-color .2s ease-in-out;
  box-sizing: border-box;

  &_disabled {
    pointer-events: none;
    opacity: .8;
  }

  &_fake {
    min-height: 32px;
    background: #cccccc;
    animation: blink 1s linear infinite;

    &:nth-child(2n + 1) {
      animation-delay: .5s;
    }
  }

  &:hover .row-operation__delete {
    opacity: 1;
  }

  &:not(:last-child) {
    border-bottom: 1px solid #cccccc;
  }

  &__column {
    font-size: 14px;
    text-align: center;
    flex-basis: 200px;
  }

  &__delete {
    position: absolute;
    right: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 20px;
    height: 20px;
    opacity: 0;
    transition: opacity .2s ease-in-out;
    cursor: pointer;

    span {
      position: absolute;
      width: 24px;
      height: 2px;
      background: #000;
      top: 50%;
      left: 50%;
      margin: -1px 0 0 -12px;
    }

    span:first-child {
      transform: rotate(-45deg)
    }

    span:last-child {
      transform: rotate(45deg)
    }
  }
}
</style>