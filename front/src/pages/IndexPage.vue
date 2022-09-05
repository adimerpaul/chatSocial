<template>
  <q-page ref="pageChat" class="flex column" v-if="store.userChat.avatar!=undefined">
    <div class="q-pa-md column col justify-end" :style="'visibility: '+showMessages?'hidden':'visible'">
      <q-chat-message
        v-for="c in store.chats"
        :key="c.id"
        :text="[c.message]"
        :sent="c.userEnviado_id==store.user.id"
        :stamp="hora(c.fecha)"
      />
    </div>
    <q-footer v-if="store.userChat.avatar!=undefined">
      <q-toolbar class="bg-grey-3 text-black row">
        <q-btn round flat icon="insert_emoticon" class="q-mr-sm" />
        <q-input @keyup.enter="chatInsert" rounded outlined dense class="WAL__field col-grow q-mr-sm" bg-color="white" v-model="message" placeholder="Escriba un mensaje" />
        <q-btn round flat icon="mic" :loading="loading" />
      </q-toolbar>
    </q-footer>
  </q-page>
  <q-page class="flex flex-center" v-else>
    <div class="row">
      <div class="col-12 text-center">
        <q-icon color="grey-5" size="150px" name="o_question_answer" />
      </div>
      <div class="col-12 text-center">
        <div class="text-h3 text-grey-5">Envia y recibe mensajes</div>
      </div>
    </div>

  </q-page>
</template>

<script>
import {useCounterStore} from "stores/example-store";
import {date} from "quasar";
import { mapWritableState  } from 'pinia';
import io from "socket.io-client";
import TimeAgo from 'javascript-time-ago'
import es from 'javascript-time-ago/locale/es'
TimeAgo.addDefaultLocale(es)

export default {
  name: 'IndexPage',
  data(){
    return{
      store:useCounterStore(),
      message:'',
      loading:false,
      // chats:[],
      socketInstance:null,
      showMessages:false,
      timeAgo : new TimeAgo('es-ES')
    }
  },
  created() {
    if (this.store.socketShow==false){
      this.store.socketShow=true;
      this.socketInstance = io(process.env.API_SOCKET);
      this.socketInstance.on("message:received", (data) => {
        // console.log(data)
        // console.log(this.store.userChat)
        if (data.userEnviado_id==this.store.userChat.id){
          this.store.chats = [...this.store.chats,data]
        }
        // if (data.userRecibido_id==this.store.user.id){
        //   this.store.chats = [...this.store.chats,data]
        // }
      })
    }
  },
  computed: {
    ...mapWritableState(useCounterStore, ['chats']),
  },
  watch:{
    chats:function (val){
      if (val.length!=0){
        if (Object.keys(val).length){
          this.scrollToBottom()
          // setTimeout(()=>{
          //   this.showMessages=true
          // },200)
        }
      }
    }
  },
  methods:{
    hora(fecha){
      return this.timeAgo.format(new Date(fecha))
    },
    scrollToBottom(){
      // this.$nextTick(() => {
      let pageChat = this.$refs.pageChat.$el
      setTimeout(() => {
        // console.log(pageChat.scrollHeight)
        window.scrollTo(0, pageChat.scrollHeight)
      }, 20);

      // })
    },
    chatInsert(){
      if(this.message=='' || this.message==null){
        return
      }
      let chat={
        id:new Date().getTime(),
        fecha:date.formatDate(new Date(),'YYYY-MM-DD HH:mm:ss'),
        message:this.message,
        userEnviado_id:this.store.user.id,
        userRecibido_id:this.store.userChat.id,
      }
      // this.store.chats = []
      // setTimeout(() => {
      this.store.chats = [...this.store.chats,chat]
      // },100)
      // this.chats=[{a:11}]
      this.socketInstance.emit('message', chat);
      this.$api.post('chat',{
        message:this.message,
        userEnviado_id:this.store.user.id,
        userRecibido_id:this.store.userChat.id,
      })
      this.message=''
      this.store.users.find(u=>u.id==this.store.userChat.id).message=chat.message
      this.store.users.find(u=>u.id==this.store.userChat.id).time=chat.fecha.substring(11,16)
    },
  }
}
</script>
