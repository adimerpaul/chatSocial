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
        <q-toolbar-title class="text-bold">
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
          <q-item v-for="contact in contacts" :key="contact.id" class="q-my-sm" clickable v-ripple>
            <q-item-section avatar>
              <q-avatar color="primary" text-color="white">
                {{ contact.letter }}
              </q-avatar>
            </q-item-section>

            <q-item-section>
              <q-item-label>{{ contact.name }}</q-item-label>
              <q-item-label caption lines="1">{{ contact.email }}</q-item-label>
            </q-item-section>

            <q-item-section side>
              <q-icon name="chat_bubble" color="green" />
            </q-item-section>
          </q-item>

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
  </q-layout>
</template>

<script>
import {useCounterStore} from "stores/example-store";

export default {
  name: 'MainLayout',
  data () {
    return {
      url:process.env.API,
      leftDrawerOpen: false,
      search: '',
      store:useCounterStore(),
      menu:false,
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
      ]
    }
  },
  methods: {
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
