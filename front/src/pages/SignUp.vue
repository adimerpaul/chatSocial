<template>
  <q-layout view="lHh Lpr lFf" class="bg-grey-2">
<!--    <q-page-container>-->
      <q-page>
        <div class="row">
          <div class="col-1 col-sm-4"></div>
          <div class="col-10 col-sm-4">
            <div class="text-subtitle1 text-center q-pt-lg text-grey">CUENTA</div>
            <div class="text-h3 text-center q-pa-lg text-black text-bold">Crea Cuenta</div>
            <q-card flat bordered>
              <q-card-section >
                <q-form class="q-px-lg q-py-md" @submit.prevent="signUp">
                  <div class="row">
                    <div class="col-12">
                      <q-input outlined v-model="name" label="Nombre Completo" type="name" required />
                    </div>
                    <div class="col-12 q-pt-lg">
                      <q-input outlined v-model="email" label="Email" type="email" required/>
                    </div>
                    <div class="col-12 q-pt-lg">
                      <q-input outlined v-model="password" label="Contraseña" :type="typePassword?'password':'text'" required>
                        <template v-slot:append>
                          <q-icon @click="typePassword=!typePassword" :name="typePassword?'visibility':'visibility_off'" />
                        </template>
                      </q-input>
                    </div>
                    <div class="col-12 q-pt-lg">
                      <q-input outlined v-model="password_confirmation" label="Confirmar Contraseña" :type="typePassword?'password':'text'" required>
                        <template v-slot:append>
                          <q-icon @click="typePassword=!typePassword" :name="typePassword?'visibility':'visibility_off'" />
                        </template>
                      </q-input>
                    </div>
                    <div class="col-12 q-pt-lg">
                      <q-btn size="22px" outline class="full-width bold" color="primary" label="Registrate" type="submit" no-caps />
                    </div>
                    <div class="col-12 q-pt-xs">
                      <q-btn size="22px" to="login" class="full-width bold" color="primary" label="Iniciar Sesión" type="submit" no-caps />
                    </div>
<!--                    <div class="col-12 text-center q-py-md">-->
<!--                      <a href="" class="text-blue-8 ">¿Olvidaste tu contraseña?</a>-->
<!--                    </div>-->
                    <div class="col-12 text-center q-py-xs text-caption">
                      <div class="linea"><span>O INICIAR SESIÓN CON</span></div>
                    </div>
                    <div class="col-6 q-pt-md q-pr-xs">
                      <q-btn outline icon="fa-brands fa-facebook" color="primary" class="full-width "/>
                    </div>
                    <div class="col-6 q-pt-md q-pl-xs">
                      <q-btn outline icon="fa-brands fa-google" color="primary" class="full-width "/>
                    </div>
                  </div>
                </q-form>
              </q-card-section>
            </q-card>
            <div class="text-subtitle1 text-center text-caption q-pt-lg text-grey">AL INICIAR SESIÓN, USTED ACEPTA LOS
              <a href="" class="text-blue-8 ">TÉRMINOS DEL SERVICIO</a> Y <a href="" class="text-blue-8 ">LA POLÍTICA DE PRIVACIDAD</a>
            </div>
          </div>
          <div class="col-1 col-sm-4"></div>
        </div>
      </q-page>
<!--    </q-page-container>-->
  </q-layout>
</template>

<script>
import {useCounterStore} from "stores/example-store";

export default {
  name: `SignUp`,
  data () {
    return {
      email: '',
      name: '',
      password: '',
      password_confirmation: '',
      store:useCounterStore(),
      typePassword:true,
    }
  },
  mounted() {
    if (this.store.isLoggedIn){
      this.$router.push('/')
    }
  },
  methods: {
    signUp () {
      this.$q.loading.show()
      this.$api.post('register', {
        email: this.email,
        name: this.name,
        password: this.password,
        password_confirmation: this.password_confirmation,
      }).then((res) => {
        this.$q.notify({
          message: 'Usuario creado correctamente',
          color: 'positive',
          icon: 'check_circle',
          position: 'top'
        })
        this.$router.push('/')
        this.store.user=res.data.user
        this.store.isLoggedIn=true
        this.$api.defaults.headers.common['Authorization'] = 'Bearer '+res.data.token
        localStorage.setItem('tokenChat',res.data.token)
      })
        .catch((error) => {
        console.log(error)
        this.$q.notify({
          message: error.response.data.message,
          color: 'negative',
          icon: 'error',
          position: 'top'
        })
      })
        .finally(() => {
        this.$q.loading.hide()
      })

    }
  }
}
</script>

<style scoped>

div.linea {
  position: relative;
  z-index: 1;
}
div.linea:before {
  border-top: 1px solid grey;
  content: "";
  margin: 0 auto;
  position: absolute;
  top: 50%;
  left: 0;
  right: 0;
  bottom: 0;
  width: 95%;
  z-index: -1;
}
div.linea span {
  background: #fff;
  padding: 0 10px;
  color: grey;
}
</style>
