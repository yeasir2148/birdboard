<template>
   <div>
      <!-- <div class="alert alert-success" v-if="form.successMsg && form.successMsg.length">{{form.successMsg}}</div>
      <div class="alert alert-danger" v-if="form.errorMsg && form.errorMsg.length">{{form.errorMsg}}</div> -->
      <div class="form" v-if="isAuthenticated">
         <ValidationObserver v-slot="observerSlotProp" @submit.prevent="addCategory(postData)">
            <form method="post" action="/categories" id="createCategoryForm">
               <div class="field is-horizontal">
                  <div class="field-label is-normal">
                     <label for="category_name" class="label">Category Name <sup>*</sup></label>
                  </div>
                  <div class="field-body">
                     <div class="field">
                        <div class="control">
                           <validation-provider
                              name="category-name"
                              rules="required|max:30|alpha_space_dash"
                              v-slot="{ errors, classes, valid }"
                           >
                              <input
                                 type="text"
                                 class="input"
                                 :class="{ 'is-danger': form.name && errors.length}"
                                 name="name"
                                 v-model="form.name"
                                 autocomplete="off"
                              >
                              <span
                                 class="has-text-danger"
                                 v-show="!valid"
                              >{{ errors[0] }}</span>
                           </validation-provider>
                        </div>
                     </div>
                  </div>
               </div>

               <div class="field is-horizontal">
                  <div class="field-label"></div>
                  <div class="field-body">
                     <div class="field">
                        <div class="control">
                           <button
                              class="button is-link create-category"
                              type="submit"
                              :disabled="!observerSlotProp.valid || observerSlotProp.pristine"
                           >Create</button>
                        </div>
                     </div>
                  </div>
               </div>
            </form>
         </ValidationObserver>
      </div>

      <br>

      <div class="columns is-vcentered">
         <div class="column has-text-centered">
            <h4 class="title is-4">All Categories</h4>
         </div>
         <Fetch class="column is-2 has-text-centered" objectToFetch="categories"></Fetch>
      </div>

      <div class="columns">
         <div class="column">
            <table class="table is-bordered is-hoverable custom-color">
               <thead>
                  <tr>
                     <th class="has-text-centered green">Name</th>
                     <th class="has-text-centered green">Category code</th>
                     <th class="has-text-centered green" v-if="isAuthenticated">Action</th>
                  </tr>
               </thead>

               <tbody>
                  <tr>
                     <td class="has-text-centered">
                        <input class="input" type="text" placeholder="search category..."
                           v-model="search.categoryName" @keyup="filterCategories"
                        />
                     </td>
                     <td></td>
                     <td v-if="isAuthenticated"></td>
                  </tr>
                  <tr v-for="category in filteredCategories" :key="category.id">
                     <td class="has-text-centered">{{ category.name }}</td>
                     <td class="has-text-centered">{{ category.category_code }}</td>
                     <td class="has-text-centered" v-if="isAuthenticated">
                        <button class="fas fa-trash-alt remove" @click="confirmDelete(category.id)"></button>
                     </td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
      <div class="columns">
         <confirm-delete 
            :entityId="categoryIdToDelete"
            entityType="category"
            v-if="showDeleteModal"
            @deleted="afterDeleteCategory"
            @delete-modal-closed="afterHideModal()"
         >
            <template v-slot:body>
               Confirm Delete? All related subcategories and items will also be deleted!!
            </template>
         </confirm-delete>
      </div>
   </div>
</template>


<script>
   import { ValidationObserver, ValidationProvider, extend } from "vee-validate";
   import ConfirmDelete from './Utility/ConfirmDeleteComponent.vue';
   import { required, max, alpha_dash } from "vee-validate/dist/rules.umd.js";
   import { alpha_space_dash } from '../__custom_validation_rules.js';
   import _ from 'lodash';
   import { mapState, mapActions } from 'vuex';
   import Fetch from "@js/components/Fetch.vue";
   import { commonMethods } from "@js/mixins/commonMethodMixin.js";

   extend("required", required);
   extend("max", max);
   extend("alpha_dash", alpha_dash);

   export default {
      mixins: [ commonMethods ],
      components: { ValidationObserver, ValidationProvider, ConfirmDelete, Fetch },
      data() {
         return {
            form: {
               name: null,
               // categoryCode: null,
            },
            search: {
               categoryName: null,
            },
            serverResponseData: {},
            showDeleteModal: false,
            categoryIdToDelete: null,
            filteredCategories: null
         };
      },

      mounted: function() {
         this.fetchCategories();
      },

      computed: {
         ...mapState({
            categories: state => state.categoryStore.categories,
            isAuthenticated: state => state.auth.isLoggedIn
         }),
         postData: function() {
            return {
               name: this.form.name,
            };
         },
         removeModal: function() {
            return '#remove_category_modal';
         },
      },

      watch: {
         categories(newValue) {
            if(this.form.name) {
               this.filterCategories();
            } else {
               this.filteredCategories = newValue;
            }
         }
      },

      methods: {
         ...mapActions('categoryStore',['fetchCategories','createCategory']),
         addCategory: function(postData) {
            this.createCategory(postData)
            .then(() => {
               this.$toasted.show('Category added successfully');
               setTimeout(() => this.resetForm(), 1000);
            })
            .catch(errorResponse => {
               this.$toasted.show(errorResponse.message);
            });
         },
         filterCategories: _.debounce(function() {
            let tmp = this.categories;

            for(let field in this.search) {
               if(this.search[field] && this.search.hasOwnProperty(field)) {
                  tmp = tmp.filter(category => {
                     switch(field) {
                        case 'categoryName':
                           return category.name.toLowerCase().includes(this.search[field].toLowerCase());
                           break;
                     }                     
                  });
               }
               this.filteredCategories = tmp;
            }
         }, 500),
         confirmDelete: function(categoryId) {
            this.categoryIdToDelete = categoryId;
            this.showDeleteModal = true;
            this.$nextTick(() => {
               $(this.removeModal).modal({
                  backdrop: 'static'
               });
            });
         },
         afterDeleteCategory: function() {
            this.$toasted.show('category deleted');

            $(this.removeModal).modal('hide');            
            this.$nextTick(() => {
               this.showDeleteModal = false;
            });
         },
         resetForm: function() {
            for (var key in this.form) {
               this.form[key] = null;
            }
         }
      }
   };
</script>

<style lang="scss">
</style>
