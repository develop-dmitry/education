<template lang="pug">
form.operation-form
  Input(
    label="Сумма операции"
    type="number"
    :error="errors.amount"
    @change="changeAmount"
  )
  Input(
    label="Дата совершения операции"
    type="date"
    :value="today"
    :error="errors.date"
    :component-class="['operation-form__input']"
    @change="changeDate"
  )
  Button(text="Добавить" :component-class="['operation-form__button']" @click="submit")
  span(v-if="message").operation-form__message {{ message }}
</template>

<script lang="ts">
import {defineComponent} from "vue";
import {useOperationStore} from "../../../stores/Operation/OperationStore";
import Input from "../../Form/Input/Input.vue";
import Button from "../../Form/Button/Button.vue";
import CreateOperationRequest from "../../../stores/Operation/Requests/CreateOperationRequest";
import CreateOperationResponse from "../../../stores/Operation/Responses/CreateOperationResponse";

export default defineComponent({
  name: 'FormOperation',

  components: {
    Input,
    Button
  },

  data() {
    return {
      amount: 0,
      date: '',
      errors: {
        amount: '',
        date: ''
      } as {[index: string]:string},
      message: ''
    }
  },

  computed: {
    today(): string {
      const now = new Date();

      let today: string = now.getFullYear() + '-';

      if (now.getMonth() < 10) {
        today += '0' + now.getMonth() + '-';
      } else {
        today += now.getMonth() + '-';
      }

      if (now.getDate() < 10) {
        today += '0' + now.getDate();
      } else {
        today += now.getDate();
      }

      return today;
    },

    hasErrors(): boolean {
      let hasErrors: boolean = false;

      Object.values(this.errors).forEach(value => {
        if (value) {
          hasErrors = true;
        }
      })

      return hasErrors;
    }
  },

  methods: {
    submit(): void {
      this.validate();

      if (this.hasErrors) {
        return;
      }

      const request = new CreateOperationRequest(this.amount, new Date(this.date));

      this.operationStore.createOperation(request)
          .then((response: CreateOperationResponse) => {
            let message: string = response.message;

            if (!message) {
              if (response.success) {
                this.message = 'Операция успешно добавлена';
              } else {
                this.message = 'При добавлении операции произошла ошибка';
              }
            }
          })
          .catch(error => {
            if (error.statusCode === 400) {
              this.message = 'Заполнить все поля';
            } else {
              this.message = 'При выполнении запроса произошла ошибка'
            }
          });
    },

    validate(): void {
      this.clearErrors();

      if (!this.date) {
        this.errors.date = 'Выберите дату операции';
      }

      if (this.amount <= 0) {
        this.errors.amount = 'Введите сумму операции';
      }
    },

    changeAmount(amount: string): void {
      let number = Number.parseFloat(amount);

      this.amount = isNaN(number) ? 0 : number;
    },

    changeDate(date: string): void {
      this.date = date;
    },

    clearErrors(): void {
      Object.keys(this.errors).forEach(key => {
        this.errors[key] = '';
      })
    }
  },

  mounted() {
    this.date = this.today;
  },

  setup() {
    const operationStore = useOperationStore();

    return {
      operationStore
    }
  }
})
</script>

<style lang="scss">
.operation-form {
  width: 500px;
  padding-top: 30px;
  margin: 0 auto;

  &__input,
  &__button {
    margin-top: 15px;
  }

  &__message {
    font-size: 14px;
    text-align: center;
    margin-top: 30px;
    display: block;
    color: #000000;
  }
}
</style>