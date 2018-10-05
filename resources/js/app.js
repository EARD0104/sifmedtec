
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VTooltip from 'v-tooltip'
Vue.use(VTooltip)
import CheckboxRadio from 'vue-checkbox-radio';
Vue.use(CheckboxRadio);
import Toastr from 'vue-toastr';
require('vue-toastr/src/vue-toastr.scss');
Vue.use(Toastr);




/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('roles', require('./views/roles.vue'));
Vue.component('users', require('./views/users.vue'));
Vue.component('modal', require('./components/Modal.vue'));

const app = new Vue({
    el: '#app'
});
