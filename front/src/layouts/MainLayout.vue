<template>
  <q-layout view="lHh Lpr lFf" class="bg-grey-2">
    <q-header class="bg-grey-2">
      <q-toolbar>
        <q-btn
          flat
          dense
          round
          color="primary"
          icon="menu"
          aria-label="Menu"
          @click="toggleLeftDrawer"
        />
        <q-toolbar-title class="text-bold text-primary">
          <q-item v-if="store.userChat.avatar!=undefined">
            <q-item-section avatar>
              <q-avatar>
                <img  :src="store.userChat.avatar">
              </q-avatar>
            </q-item-section>
            <q-item-section>
              <q-item-label lines="1">
                {{ store.userChat.name }}
              </q-item-label>
              <q-item-label class="conversation__summary" caption>
                En linea {{ store.userChat.fechaConexion }}
              </q-item-label>
            </q-item-section>
          </q-item>
        </q-toolbar-title>
        <div class="row q-pt-xs">
          <div class="col-8">
            <q-input dense rounded outlined v-model="search" placeholder="Buscar">
              <template v-slot:prepend>
                <q-icon name="search" />
              </template>
            </q-input>
          </div>
          <div class="col-2 flex flex-center">
            <q-btn
              flat
              dense
              round
              color="primary"
              icon="o_notifications"
              aria-label="Notifications">
              <q-badge color="primary" floating transparent>
                4
              </q-badge>
            </q-btn>
          </div>
          <div class="col-2 flex flex-center">
              <q-btn round>
                <q-avatar size="38px">
                  <img v-if="store.user.avatar!=undefined" :src="url+'../imagenes/'+store.user.avatar">
                </q-avatar>
              <q-menu>
                <q-list style="min-width: 100px">
                  <q-item clickable v-ripple>
                    <q-item-section avatar>
                      <q-icon color="primary" name="perm_contact_calendar" />
                    </q-item-section>
                    <q-item-section>{{store.user.name}}</q-item-section>
                  </q-item>
                  <q-separator />
                  <q-item clickable v-ripple @click="logout">
                    <q-item-section avatar>
                      <q-icon color="primary" name="logout" />
                    </q-item-section>
                    <q-item-section>Salir</q-item-section>
                  </q-item>
                </q-list>
              </q-menu>
            </q-btn>
          </div>
        </div>
      </q-toolbar>
    </q-header>

    <q-drawer
      v-model="leftDrawerOpen"
      show-if-above
      bordered
    >
      <q-list>
        <q-item-label class="q-pa-xs">
          <div class="row">
            <div class="col-3 flex flex-center">
<!--              <q-avatar size="48px">-->
                <q-icon color="primary" size="48px" name="o_question_answer" />
<!--              </q-avatar>-->
            </div>
            <div class="col-9">
              <div class="text-h6 text-bold " >Chat Social</div>
              <div class="text-caption">{{store.version}}</div>
            </div>
          </div>
        </q-item-label>
        <q-separator />
        <q-toolbar class="bg-primary text-white shadow-2">
          <q-toolbar-title>Usuarios Conectados</q-toolbar-title>
        </q-toolbar>

        <q-list bordered>
          <q-list>
            <q-item
              v-for="(conversation, index) in users"
              :key="conversation.id"
              clickable
              v-ripple
              @click="setCurrentConversation(index)"
            >
              <q-item-section avatar>
                <q-avatar>
                  <img :src="conversation.avatar">
                </q-avatar>
              </q-item-section>

              <q-item-section>
                <q-item-label lines="1">
                  {{ conversation.person }}
                </q-item-label>
                <q-item-label class="conversation__summary" caption>
                  <q-icon name="check" v-if="conversation.sent" />
                  <q-icon name="not_interested" v-if="conversation.deleted" />
                  {{ conversation.caption }}
                </q-item-label>
              </q-item-section>

              <q-item-section side>
                <q-item-label caption>
                  {{ conversation.time }}
                </q-item-label>
                <q-icon name="keyboard_arrow_down" />
              </q-item-section>
            </q-item>
          </q-list>
          <q-separator />
          <q-item-label header>Desconectados</q-item-label>

          <q-item v-for="contact in offline" :key="contact.id" class="q-mb-sm" clickable v-ripple>
            <q-item-section avatar>
              <q-avatar>
                <img :src="`https://cdn.quasar.dev/img/${contact.avatar}`">
              </q-avatar>
            </q-item-section>

            <q-item-section>
              <q-item-label>{{ contact.name }}</q-item-label>
              <q-item-label caption lines="1">{{ contact.email }}</q-item-label>
            </q-item-section>

            <q-item-section side>
              <q-icon name="chat_bubble" color="grey" />
            </q-item-section>
          </q-item>
        </q-list>
      </q-list>
    </q-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>
    <q-footer>
      <q-toolbar class="bg-grey-3 text-black row">
        <!--          <q-form @submit.prevent="chatInsert">-->
        <q-btn round flat icon="insert_emoticon" class="q-mr-sm" />
        <q-input @keyup.enter="chatInsert" rounded outlined dense class="WAL__field col-grow q-mr-sm" bg-color="white" v-model="message" placeholder="Escriba un mensaje" />
        <q-btn round flat icon="mic" :loading="loading" />
        <!--          </q-form>-->
      </q-toolbar>
    </q-footer>
  </q-layout>
</template>

<script>
import {useCounterStore} from "stores/example-store";
import {date} from "quasar";
import io from "socket.io-client";
export default {
  name: 'MainLayout',
  data () {
    return {
      loading: false,
      url:process.env.API,
      leftDrawerOpen: false,
      search: '',
      store:useCounterStore(),
      menu:false,
      message:'',
      contacts : [ {
        id: 1,
        name: 'Ruddy Jedrzej',
        email: 'rjedrzej0@discuz.net',
        letter: 'R'
      }, {
        id: 2,
        name: 'Mallorie Alessandrini',
        email: 'malessandrini1@marketwatch.com',
        letter: 'M'
      }, {
        id: 3,
        name: 'Elisabetta Wicklen',
        email: 'ewicklen2@microsoft.com',
        letter: 'E'
      }, {
        id: 4,
        name: 'Seka Fawdrey',
        email: 'sfawdrey3@wired.com',
        letter: 'S'
      } ],
      offline : [
        {
          id: 5,
          name: 'Brunhilde Panswick',
          email: 'bpanswick4@csmonitor.com',
          avatar: 'avatar2.jpg'
        },
        {
          id: 6,
          name: 'Winfield Stapforth',
          email: 'wstapforth5@pcworld.com',
          avatar: 'avatar6.jpg'
        },
      ],
      users : [
        {
          id: 1,
          person: 'Razvan Stoenescu',
          avatar: 'https://cdn.quasar.dev/team/razvan_stoenescu.jpeg',
          caption: 'I\'m working on Quasar!',
          time: '15:00',
          sent: true
        },
        {
          id: 2,
          person: 'Dan Popescu',
          avatar: 'https://cdn.quasar.dev/team/dan_popescu.jpg',
          caption: 'I\'m working on Quasar!',
          time: '16:00',
          sent: true
        },
        {
          id: 3,
          person: 'Jeff Galbraith',
          avatar: 'https://cdn.quasar.dev/team/jeff_galbraith.jpg',
          caption: 'I\'m working on Quasar!',
          time: '18:00',
          sent: true
        },
        {
          id: 4,
          person: 'Allan Gaunt',
          avatar: 'https://cdn.quasar.dev/team/allan_gaunt.png',
          caption: 'I\'m working on Quasar!',
          time: '17:00',
          sent: true
        }
      ]
    }
  },
  created() {
    this.socketInstance = io(process.env.API_SOCKET);
    this.socketInstance.on(
      "message:received", (data) => {
        this.store.chats.push(data);
      }
    )
    if (this.store.users.length == 0) {
      this.$api.get('user').then(res=>{
        res.data.forEach(r=>{
          r.person=r.name,
            r.avatar=this.url+'../imagenes/'+r.avatar,
            r.caption='I\'m working on Quasar!',
            r.time='17:00',
            r.sent=true
        })
        this.users=res.data
        // if (this.users.length>0){
        //   this.user = this.users[0]
        //   this.chatGet()
        // }
      })
    }
  },
  methods: {
    chatInsert(){
      if(this.message=='' || this.message==null){
        return
      }
      let chat={
        fecha:date.formatDate(new Date(),'YYYY-MM-DD HH:mm:ss'),
        message:this.message,
        userEnviado_id:this.store.user.id,
        userRecibido_id:this.store.userChat.id,
      }
      this.store.chats.push(chat)
      this.socketInstance.emit('message', chat);
      this.$api.post('chat',{
        message:this.message,
        userEnviado_id:this.store.user.id,
        userRecibido_id:this.store.userChat.id,
      })
      this.message=''
    },
    setCurrentConversation (index) {
      this.store.userChat=this.users[index]
      this.store.chats=[]
      this.$api.get('user/'+this.store.userChat.id).then(res=>{
        this.store.chats=res.data
      })
    },
    logout(){
      this.$q.dialog({
        message:'¿Quieres cerrar sesión?',
        title:"Salir",
        ok:{
          push:true
        },
        cancel:{
          push:true,
          color:'negative'
        }
      }).onOk(()=>{
        this.$q.loading.show()
        this.$api.post('logout').then(res=>{
          this.$api.defaults.headers.common['Authorization']=''
          this.store.user={}
          this.store.negocio={}
          localStorage.removeItem('tokenmi')
          this.store.isLoggedIn=false
          this.$router.push('/login')
          this.$q.loading.hide()
        })
      })
    },
    toggleLeftDrawer () {
      this.leftDrawerOpen = !this.leftDrawerOpen
    }
  }
}
</script>
