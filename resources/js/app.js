/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import { EventBus } from './__vue_event-bus.js';
import Categories from './components/CategoriesComponent.vue';
import Subcategories from './components/SubcategoriesComponent.vue';
// import ConfirmDelete from './components/Utility/ConfirmDeleteComponent.vue';
import Items from './components/ItemsComponent.vue';

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
   data: {
      form: {
         successMsg: null,
         errorMsg: null
      },
      categories: [],
      subcategories: [],
      items: []
   },

   mounted: function () {
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
         }
      });

      EventBus.$on('new-category-added', newCategory => {
         this.categories.push(newCategory);
      });
   },
   methods: {
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

      itemDeleted: function(deletedItemid) {
         this.items = this.items.filter(item => {
            return item.id != deletedItemid;
         });
      }
   }
});