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
<!--          Your Account-->
        </q-toolbar-title>
        <div class="row">
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
          <div class="col-12 flex flex-center">
            <q-btn-dropdown
              class="q-pa-none q-ma-none"
              no-icon-animation
              outline
              split
              v-model="menu"
              @click="menu= !menu"
            >
              <template v-slot:label >
                <q-avatar size="35px" >
                  <img src="https://cdn.quasar.dev/img/avatar.png" />
                  <q-badge floating color="teal"></q-badge>
                </q-avatar>
              </template>

              <q-list>
                <q-item clickable v-close-popup >
                  <q-item-section avatar>
                    <q-avatar icon="folder" color="primary" text-color="white" />
                  </q-item-section>
                  <q-item-section>
                    <q-item-label>Photos</q-item-label>
                    <q-item-label caption>February 22, 2016</q-item-label>
                  </q-item-section>
                  <q-item-section side>
                    <q-icon name="info" color="amber" />
                  </q-item-section>
                </q-item>

                <q-item clickable v-close-popup >
                  <q-item-section avatar>
                    <q-avatar icon="assignment" color="secondary" text-color="white" />
                  </q-item-section>
                  <q-item-section>
                    <q-item-label>Vacation</q-item-label>
                    <q-item-label caption>February 22, 2016</q-item-label>
                  </q-item-section>
                  <q-item-section side>
                    <q-icon name="info" color="amber" />
                  </q-item-section>
                </q-item>
              </q-list>
            </q-btn-dropdown>
<!--            <q-avatar size="35px" push>-->
<!--              <img src="https://cdn.quasar.dev/img/avatar.png" />-->
<!--              <q-badge floating color="teal"></q-badge>-->
<!--              <q-popup-proxy >-->
<!--                <q-list bordered class="bg-grey-2">-->
<!--                  <q-item clickable v-ripple>-->
<!--                    <q-item-section avatar>-->
<!--                      <q-icon color="primary" name="perm_contact_calendar" />-->
<!--                    </q-item-section>-->
<!--                    <q-item-section>Perfil</q-item-section>-->
<!--                  </q-item>-->
<!--                  <q-separator/>-->
<!--                  <q-item clickable v-ripple>-->
<!--                    <q-item-section avatar>-->
<!--                      <q-icon color="primary" name="logout" />-->
<!--                    </q-item-section>-->
<!--                    <q-item-section>Salir</q-item-section>-->
<!--                  </q-item>-->
<!--                </q-list>-->
<!--              </q-popup-proxy>-->
<!--            </q-avatar>-->

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
                <q-icon size="48px" name="o_question_answer" />
<!--              </q-avatar>-->
            </div>
            <div class="col-9">
              <div class="text-h6 text-bold">Chat Social</div>
              <div class="text-caption">{{store.version}}</div>
            </div>
          </div>
        </q-item-label>
        <q-separator />
        <q-item-label header class="q-py-none q-pt-xs">Usuarios Conectados</q-item-label>
        <q-item clickable v-ripple>
          <q-item-section avatar>
            <q-icon name="home" />
          </q-item-section>
          <q-item-section>
            Inicio
          </q-item-section>
        </q-item>
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
      leftDrawerOpen: false,
      search: '',
      store:useCounterStore(),
      menu:false,
    }
  },
  methods: {
    toggleLeftDrawer () {
      this.leftDrawerOpen = !this.leftDrawerOpen
    }
  }
}
</script>
