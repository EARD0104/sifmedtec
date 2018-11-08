
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

Vue.component('schools', require('./views/schools.vue'));
Vue.component('roles', require('./views/roles.vue'));
Vue.component('users', require('./views/users.vue'));
Vue.component('departments', require('./views/departments.vue'));
Vue.component('cities', require('./views/cities.vue'));
Vue.component('areas', require('./views/areas.vue'));
Vue.component('questions', require('./views/questions.vue'));
Vue.component('themes', require('./views/themes.vue'));
Vue.component('preferences', require('./views/preferences.vue'));
Vue.component('groups', require('./views/groups.vue'));
Vue.component('password', require('./views/password.vue'));
Vue.component('evaluations', require('./views/evaluations.vue'));

Vue.component('modal', require('./components/Modal.vue'));

const app = new Vue({
    el: '#app'
});
