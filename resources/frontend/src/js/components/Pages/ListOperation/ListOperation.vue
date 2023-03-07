<template lang="pug">
Header
.container
  .list-operation
    RowOperation(
      :component-class="['list-operation__row']"
      is-head
    )
    RowOperation(
      v-for="item in items"
      :key="item.id"
      :id="item.id"
      :amount="item.amount"
      :date="item.date"
      :is-disabled="item.isDisabled"
      :component-class="['list-operation__row']"
      :can-delete="true"
      @delete="deleteOperation"
    )
</template>

<script lang="ts">
import {defineComponent} from "vue";
import {useOperationStore} from "../../../stores/Operation/OperationStore";
import DeleteOperationRequest from "../../../stores/Operation/Requests/DeleteOperationRequest";
import Header from "../Header/Header.vue";
import RowOperation from "../../Operation/RowOperation/RowOperation.vue";

export default defineComponent({
  name: 'ListOperation',

  data() {
    return {
      items: [] as Array<{id: number, amount: number, date: Date, isDisabled: boolean}>
    }
  },

  components: {
    Header,
    RowOperation
  },

  methods: {
    loadOperations() {
      this.operationStore.getOperations()
          .then(response => {
            if (response.success) {
              response.items.forEach(operation => {
                this.items.push({
                  id: operation.id,
                  amount: operation.amount,
                  date: operation.date,
                  isDisabled: false
                })
              })
            }
          })
          .catch(() => {
            this.items = [];
          })
    },

    deleteOperation(id: number) {
      try {
        const operation = this.getOperation(id);

        operation.isDisabled = true;

        this.operationStore.deleteOperation(new DeleteOperationRequest(id))
            .then(response => {
              if (response.success) {
                this.items = this.items.filter(item => item.id !== id);
              } else {
                operation.isDisabled = false;
              }
            })
            .catch(() => {
              operation.isDisabled = false;
            })
      } catch (error) {
        // todo допилить уведомление пользователю
      }
    },

    getOperation(id: number): {id: number, amount: number, date: Date, isDisabled: boolean} {
      let operation = this.items.find(operation => operation.id === id);

      if (!operation) {
        throw Error('Operation not found');
      }

      return operation;
    }
  },

  mounted() {
    this.loadOperations();
  },

  setup() {
    const operationStore = useOperationStore();

    return {
      operationStore
    }
  }
});
</script>

<style lang="scss">
.list-operation {

  padding: 50px 0;
}
</style>