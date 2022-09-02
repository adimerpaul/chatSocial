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
                <q-form class="q-px-lg q-py-md">
                  <div class="row">
                    <div class="col-12">
                      <q-input outlined v-model="name" label="Nombre Completo" type="email" />
                    </div>
                    <div class="col-12 q-pt-lg">
                      <q-input outlined v-model="email" label="Email" type="email" />
                    </div>
                    <div class="col-12 q-pt-lg">
                      <q-input outlined v-model="password" label="Contraseña" type="password" />
                    </div>
                    <div class="col-12 q-pt-lg">
                      <q-input outlined v-model="confirmPassword" label="Confirmar Contraseña" type="password" />
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
              <div class="text-subtitle1 text-center text-caption q-pt-lg text-grey">AL INICIAR SESIÓN, USTED ACEPTA LOS
                <a href="" class="text-blue-8 ">TÉRMINOS DEL SERVICIO</a> Y <a href="" class="text-blue-8 ">LA POLÍTICA DE PRIVACIDAD</a></div>
            </q-card>
          </div>
          <div class="col-1 col-sm-4"></div>
        </div>
      </q-page>
<!--    </q-page-container>-->
  </q-layout>
</template>

<script>
export default {
  name: `Login`,
  data () {
    return {
      email: '',
      name: '',
      password: '',
      confirmPassword: '',
      remember:false
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
