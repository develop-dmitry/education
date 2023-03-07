<template lang="pug">
Header
.container
  FormOperation
</template>

<script lang="ts">
import {defineComponent} from "vue";
import Header from "../Header/Header.vue";
import FormOperation from "../../Operation/FormOperation/FormOperation.vue";

export default defineComponent({
  name: 'App',
  components: {
    Header,
    FormOperation
  }
})
</script>