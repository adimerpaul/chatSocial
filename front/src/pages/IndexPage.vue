<template>
  <q-page class="flex column">
    <div class="q-pa-md column col justify-end">
      <q-chat-message
        v-for="c in store.chats"
        :key="c.id"
        :text="[c.message]"
        :sent="c.userEnviado_id==store.user.id"
      />
    </div>
  </q-page>
</template>

<script>
import {useCounterStore} from "stores/example-store";

export default {
  name: 'IndexPage',
  data(){
    return{
      store:useCounterStore()
    }
  },
  created() {
  },
  methods:{
  }
}
</script>
