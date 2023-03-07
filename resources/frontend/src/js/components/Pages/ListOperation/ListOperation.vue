<template lang="pug">
Header
.container
  .list-operation
    .list-operation__wrapper(v-if="isLoading")
      RowOperation(
        v-for="key in (11)"
        :key="key"
        :is-fake="true"
      )
    .list-operation__wrapper(v-else)
      RowOperation(
        :component-class="['list-operation__row']"
        is-head
      )
      RowOperation(
        v-for="item in items[this.currentPage]"
        :key="item.id"
        :id="item.id"
        :amount="item.amount"
        :date="item.date"
        :is-disabled="item.isDisabled"
        :component-class="['list-operation__row']"
        :can-delete="true"
        @delete="deleteOperation"
      )
    Pagination(
      v-if="pageCount > 1"
      :component-class="['list-operation__pagination']"
      :current="currentPage"
      :page-count="pageCount"
      @select="changePage"
    )
</template>

<script lang="ts">
import {defineComponent} from "vue";
import {useOperationStore} from "../../../stores/Operation/OperationStore";
import DeleteOperationRequest from "../../../stores/Operation/Requests/DeleteOperationRequest";
import GetOperationRequest from "../../../stores/Operation/Requests/GetOperationRequest";
import Header from "../Header/Header.vue";
import RowOperation from "../../Operation/RowOperation/RowOperation.vue";
import Pagination from "../../Pagination/Pagination.vue";
import GetOperationResponse from "../../../stores/Operation/Responses/GetOperationResponse";
import GetOperationCountResponse from "../../../stores/Operation/Responses/GetOperationCountResponse";

export default defineComponent({
  name: 'ListOperation',

  components: {
    Header,
    RowOperation,
    Pagination
  },

  data() {
    return {
      isLoading: false,
      items: {} as {[index: number]: Array<{id: number, amount: number, date: Date, isDisabled: boolean}>},
      limit: 10,
      currentPage: 1,
      pageCount: 1
    }
  },

  methods: {
    changePage(page: number) {
      this.currentPage = page;

      if (!this.items[page]) {
        this.loadOperations();
      }
    },

    loadOperations(): Promise<GetOperationResponse> {
      this.isLoading = true;
      const page = this.currentPage;
      const promise = this.operationStore.getOperations(new GetOperationRequest(this.limit, this.currentPage))

      this.items[page] = [];

      promise
          .then(response => {
            if (response.success) {
              response.items.forEach(operation => {
                this.items[page].push({
                  id: operation.id,
                  amount: operation.amount,
                  date: operation.date,
                  isDisabled: false
                });
              })
            }
          })
          .catch(() => {
            this.items = [];
          })
          .finally(() => {
            setTimeout(() => {
              this.isLoading = false;
            }, 1000)
          })

      return promise;
    },

    deleteOperation(id: number) {
      const operation = this.getOperation(id);

      if (!operation) {
        return;
      }

      operation.isDisabled = true;

      this.operationStore.deleteOperation(new DeleteOperationRequest(id))
          .then(response => {
            if (response.success) {
              this.items = {};

              this.loadOperationCount()
                  .then(() => {
                    this.loadOperations();
                  });
            }
          })
          .catch (() => {
            // todo допилить уведомление пользователю
          })
          .finally(() => {
            operation.isDisabled = false;
          })
    },

    getOperation(id: number): {id: number, amount: number, date: Date, isDisabled: boolean}|null {
      let operation = null;

      Object.values(this.items).forEach(value => {
        value.forEach(item => {
          if (item.id === id) {
            operation = item;
          }
        })
      })

      if (!operation) {
        return null;
      }

      return operation;
    },

    loadOperationCount(): Promise<GetOperationCountResponse> {
      const promise = this.operationStore.getOperationCount();

      promise
          .then(response => {
            this.pageCount = Math.ceil(response.count / this.limit);

            if (this.pageCount < this.currentPage) {
              this.currentPage = this.pageCount;
            }
          });

      return promise;
    }
  },

  mounted() {
    this.loadOperations()
        .then(() => {
          this.loadOperationCount();
        })
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

  &__pagination {
    margin-top: 40px;
  }
}
</style>