/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Vue = require('vue');
import 'jquery-ui/ui/widgets/datepicker.js';
import { EventBus } from './__vue_event-bus.js';
import { ValidationObserver, ValidationProvider } from "vee-validate";
import Toasted from 'vue-toasted';
import AutoCloseToasted from 'vue-toasted';

import Categories from './components/CategoriesComponent.vue';
import Subcategories from './components/SubcategoriesComponent.vue';
import Stores from './components/StoresComponent.vue';
import Items from './components/ItemsComponent.vue';
import InvoiceSummaryForm from './components/InvoiceSummaryFormComponent.vue';
import InvoiceSummaryList from './components/InvoiceSummaryListComponent.vue';
import InvoiceDetailForm from './components/InvoiceDetailFormComponent.vue';
import InvoiceDetailList from './components/InvoiceDetailListComponent.vue';
import DatePickerComponent from './components/Utility/DatePickerComponent.vue';
import { invoiceDetailStore } from './Shared_State/invoice_detail_store.js';
import ConfirmDelete from './components/Utility/ConfirmDeleteComponent.vue';
import store from './store';
import { mapActions, mapState } from 'vuex';

import Axios from 'axios';
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
Vue.component('date-picker', DatePickerComponent);

// Vue.component('ValidationProvider', ValidationProvider);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.use(AutoCloseToasted, {
   duration: 2000
})

const app = new Vue({
   el: '#app',
   store,
   components: {
      Categories, Subcategories, Items, Stores, 
      InvoiceSummaryForm, InvoiceSummaryList, InvoiceDetailForm,
      InvoiceDetailList, ConfirmDelete
   },
   data: {
      form: {
         successMsg: null,
         errorMsg: null
      },
      units: [],
      invoices: [],
      shared: {}
   },

   mounted: function () {
      this.checkLoginStatus();

      // EventBus.$on('new-category-added', newCategory => {
      //    this.categories.push(newCategory);
      // });
   },
   computed: {
      ...mapState({
         selectedInvoice: state => state.invoiceSummaryStore.selectedInvoice
      })
   },
   methods: {
      ...mapActions(['checkLoginStatus']),
      refreshInvoice: function(invoiceSummaryForWhichDetailWasAdded) {
         let targetObjIndex = this.invoices.findIndex(invoice => {
            return invoice.id === invoiceSummaryForWhichDetailWasAdded.id;
         });

         this.$set(this.invoices[targetObjIndex], 'value', invoiceSummaryForWhichDetailWasAdded.value);
         // this.invoices.splice(targetObjIndex, 1);        // remove the old item
         // this.invoices.splice(targetObjIndex, 0, invoiceSummaryForWhichDetailWasAdded);   // add the fresh item
      },
   }
});