require('./bootstrap');

window.Vue = require('vue');

import VueIziToast from 'vue-izitoast';
import 'izitoast/dist/css/iziToast.min.css';

Vue.use(VueIziToast);

import authorize from "./authorization/authorize";
Vue.use(authorize);


Vue.component('questions', require('./components/Questions.vue').default);


const app = new Vue({
    el: '#app',
});
