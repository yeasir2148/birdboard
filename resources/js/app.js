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
import Categories from './components/CategoriesComponent.vue';
import Subcategories from './components/SubcategoriesComponent.vue';
import Stores from './components/StoresComponent.vue';
import Items from './components/ItemsComponent.vue';
import InvoiceSummaryForm from './components/InvoiceSummaryFormComponent.vue';
import InvoiceSummaryList from './components/InvoiceSummaryListComponent.vue';
import InvoiceDetailForm from './components/InvoiceDetailFormComponent.vue';
import InvoiceDetailList from './components/InvoiceDetailListComponent.vue';
import DatePickerComponent from './components/Utility/DatePickerComponent.vue';
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

const app = new Vue({
   el: '#app',
   components: {
      Categories, Subcategories, Items, Stores, 
      InvoiceSummaryForm, InvoiceSummaryList, InvoiceDetailForm,
      InvoiceDetailList
   },
   data: {
      form: {
         successMsg: null,
         errorMsg: null
      },
      categories: [],
      subcategories: [],
      items: [],
      stores: [],
      units: [],
      invoices: [],
      // activeNav: {
      //    inventory: null,
      //    purchases: 'invoices_tab'
      // }
   },

   mounted: function () {
      // this.fetchInvoices();
      // $('#invoice_date').datepicker();

      EventBus.$on('update-data', (entityName, data) => {
         switch (entityName) {
            case 'category':
               this.categories = data;
               break;
            case 'subcategory':
               this.subcategories = data;
               break;
            case 'item':
               this.items = data;
               break;
            case 'store':
               this.stores = data;
               break;
            case 'invoiceSummary':
               this.invoices = data.invoices;
               this.stores = data.stores;
               this.items = data.items;
               this.units = data.units;
               break;
         }
      });

      EventBus.$on('new-category-added', newCategory => {
         this.categories.push(newCategory);
      });
   },

   methods: {
      fetchInvoices: function() {
         axios.get('/invoices')
         .then(({ data }) => {
            // console.log(response);
            if(data !== null && data !== undefined) {
               this.invoices = data.invoices;
               this.units = data.units;
               this.items = data.items;
               this.stores = data.stores;
            }
         });
      },

      categoryDeleted: function(deletedCategoryId) {
         this.categories = this.categories.filter(category => {
            return category.id != deletedCategoryId;
         });

         this.subcategories = this.subcategories.filter(subcat => {
            return subcat.category.id != deletedCategoryId;
         });

         this.items = this.items.filter(item => {
            return item.subcategory.category.id != deletedCategoryId;
         });
      },

      subcategoryDeleted: function(deletedSubcatId) {
         this.subcategories = this.subcategories.filter(subcat => {
            return subcat.id != deletedSubcatId;
         });

         this.items = this.items.filter(item => {
            return item.subcategory.id != deletedSubcatId;
         });
      },

      itemDeleted: function(deletedItemId) {
         this.items = this.items.filter(item => {
            return item.id != deletedItemId;
         });
      },

      storeDeleted: function(deletedStoreId) {
         this.stores = this.stores.filter(store => {
            return store.id != deletedStoreId;
         });
      },

      invoiceSummaryDeleted: function(deletedInvoiceSummaryId) {
         this.invoices = this.invoices.filter(invoice => {
            return invoice.id != deletedInvoiceSummaryId;
         });
      },

      newInvoiceDetailAdded: function(invoiceSummaryForWhichDetailWasAdded) {
         let targetObjIndex = this.invoices.findIndex(invoice => {
            return invoice.id === invoiceSummaryForWhichDetailWasAdded.id;
         });
         console.log(targetObjIndex);
         this.invoices[targetObjIndex] = invoiceSummaryForWhichDetailWasAdded;
      },
      setActiveNav: function() {
         // $(event.target).parents('ul.navbar-nav').find('li.nav-item').removeClass('active');
         // event.target.parentNode.classList.add('active');
      }
   }
});