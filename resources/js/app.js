require('./bootstrap');

window.Vue = require('vue');

import store from './store'

const app = new Vue({
  el: '#app',
  store
});
