/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import Categories from './components/CategoriesComponent.vue';
import Subcategories from './components/SubcategoriesComponent.vue';
import Items from './components/ItemsComponent.vue';
// import VeeValidate from 'vee-validate';
// import { ValidationProvider, extend } from 'vee-validate';

// // Vue.use(VeeValidate);
// import { required, email } from 'vee-validate/dist/rules';
// extend('required', required);
// extend('email', email);
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

// Vue.component('ValidationProvider', ValidationProvider);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
   el: '#app',
   components: {
      Categories, Subcategories, Items
   },
   data() {
      return {
         form: {
            successMsg: null,
            errorMsg: null
         }
      }
   },
   methods: {
      //    // setTimeout(() => this.resetForm(), 2000);
      // },
      // categoryDeleted: function (serverResponse) {
      //    (serverResponse.success) ? this.form.successMsg = 'Category removed successfully' : this.form.errorMsg = (serverResponse.msg);
      // },
      // resetForm: function (component) {
      //    console.log('called');
      //    component.form.successMsg = component.form.errorMsg = null;
      // }
   }
});