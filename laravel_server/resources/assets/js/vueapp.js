/*jshint esversion: 6 */

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
import VueSocketio from 'vue-socket.io';
import Auth from './auth/auth.js';

Vue.use(VueRouter);
Vue.use(Auth);

//Vue.use(VueSocketio, 'http://192.168.10.10:8080');
Vue.use(VueSocketio, 'http://192.168.10.10:8080');

//const user = Vue.component('user', require('./components/user.vue'));
//const singleplayer_game = Vue.component('singlegame', require('./components/singleplayer_tictactoe.vue'));
const multiplayerGame = Vue.component('multiplayergame', require('./components/multiplayer_tictactoe.vue'));
const login = Vue.component('login', require('./components/login.vue'));
const register = Vue.component('register', require('./components/register.vue'));
const playerManagement = Vue.component('playerManagement', require('./components/playerManagement.vue'));


const routes = [
  { path: '/', redirect: '/login' },
  { path: '/login', component: login },
  { path: '/register', component: register, meta:{forVisitors: true}},
  //{ path: '/users', component: user },
  //{ path: '/singletictactoe', component: singleplayer_game },
  { path: '/multitictactoe', component: multiplayerGame, meta:{forAuth: true}},
  { path: '/playermanagement', component: playerManagement, meta:{forAuth:true}}
];

const router = new VueRouter({
  routes:routes
});

router.beforeEach(
  (to, from, next) => {
    if(to.matched.some(record => record.meta.forVisitors)) {
      if(Vue.auth.isAuthenticated()){
        next({
          path: '/multitictactoe'
        })
      } else next () 
    } else if(to.matched.some(record => record.meta.forAuth)) {
      if(! Vue.auth.isAuthenticated()){
        next({
          path: '/login'
        })
      } else next () 
    }else next ()
  }
)

const app = new Vue({
  router,
  data:{
    player1:undefined,
    player2: undefined,
  }
}).$mount('#app');

