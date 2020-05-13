<template>
   <div>
      <div class="alert alert-success" v-if="form.successMsg && form.successMsg.length">{{form.successMsg}}</div>
      <div class="alert alert-danger" v-if="form.errorMsg && form.errorMsg.length">{{form.errorMsg}}</div>
      <div class="form" v-if="isAuthenticated">
         <ValidationObserver v-slot="observerSlotProp" @submit.prevent="addSubcategory(postData)">
            <form id="createSubCategoryForm">
               <div class="field is-horizontal">
                  <div class="field-label is-normal">
                     <label for="subcategory_name" class="label">Subcategory Name <sup>*</sup></label>
                  </div>
                  <div class="field-body">
                     <div class="field">
                        <div class="control">
                           <validation-provider
                              name="subcategory-name"
                              rules="required|max:30|alpha_space_dash"
                              v-slot="{ errors, classes }">
                              <input
                                 type="text"
                                 class="input"
                                 :class="{ 'is-danger': form.subcategoryName && errors.length}"
                                 name="name"
                                 v-model="form.subcategoryName"
                                 autocomplete="off">
                              <span
                                 class="has-text-danger"
                                 v-show="form.subcategoryName && form.subcategoryName.length">
                                 {{ errors[0] }}
                              </span>
                           </validation-provider>
                        </div>
                     </div>
                  </div>
               </div>

               <div class="field is-horizontal">
                  <div class="field-label is-normal">
                     <label for="category_name" class="label">Category Name <sup>*</sup></label>
                  </div>
                  <div class="field-body">
                     <div class="field">
                        <div class="control">
                           <validation-provider
                              name="category"
                              rules="required"
                              v-slot="{ errors }">
                              <div class="select">
                                 <select
                                    :class="{'is-danger': form.category && errors.length}"
                                    id="category"
                                    name="category"
                                    v-model="form.categoryId">
                                       <option value="" disabled>Please select category</option>
                                       <option v-for="category in categories" :key="category.id" :value="category.id">
                                          {{ category.name }}
                                       </option>
                                 </select>
                                 <span class="has-text-danger" v-show="errors.length">
                                    {{ errors[0] }}
                                 </span>
                              </div>
                           </validation-provider>
                        </div>
                     </div>
                  </div>
               </div>
               <br>
               <div class="field is-horizontal">
                  <div class="field-label"></div>
                  <div class="field-body">
                     <div class="field">
                        <div class="control">
                           <button
                              class="button is-link"
                              type="submit"
                              :disabled="!observerSlotProp.valid || observerSlotProp.pristine">
                                 Create
                           </button>
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
            <h4 class="title is-4">Subcategories</h4>
         </div>
         <Fetch class="column is-2 has-text-centered" objectToFetch="subcategories"></Fetch>
      </div>      

      <div class="columns">
         <div class="column">
            <table class="table is-bordered is-hoverable custom-color">
               <thead>
                  <tr>
                     <th class="has-text-centered green">Name</th>
                     <th class="has-text-centered green">Code</th>
                     <th class="has-text-centered green">Category Name</th>
                     <th class="has-text-centered green" v-if="isAuthenticated">Action</th>
                  </tr>
               </thead>
               <tbody>
                  <tr>
                     <td class="has-text-centered">
                        <input class="input" type="text" 
                           v-model="search.subcategoryName"
                           placeholder="search sub-cat"
                           @keyup="filterSubcategories"
                        />
                     </td>
                     <td></td>
                     <td class="has-text-centered">
                        <input class="input" type="text" 
                           v-model="search.categoryName"
                           placeholder="search category"
                           @keyup="filterSubcategories"
                        />
                     </td>
                     <td v-if="isAuthenticated"></td>
                  </tr>
                  <tr v-for="subcat in filteredSubcategories" :key="subcat.id">
                     <td class="has-text-centered">{{ subcat.subcat_name }}</td>
                     <td class="has-text-centered">{{ subcat.subcat_code }}</td>
                     <td class="has-text-centered">{{ subcat.category.name }}</td>
                     <td class="has-text-centered" v-if="isAuthenticated">
                        <button class="fas fa-trash-alt" @click="confirmDelete(subcat.id)"></button>
                     </td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
      <div class="columns">
         <confirm-delete
            :entityId="subcategoryIdToDelete"
            entityType="subcategory"
            v-if="showDeleteModal"
            @deleted="afterDeleteSubcategory"
            @delete-modal-closed="afterHideModal()"
         >
            <template v-slot:body>
               Confirm Delete? All related Items will also be deleted!!
            </template>
         </confirm-delete>
      </div>
   </div>
</template>


<script>
   import { ValidationObserver, ValidationProvider, extend } from "vee-validate";
   import ConfirmDelete from './Utility/ConfirmDeleteComponent.vue';
   import { required, max, alpha_dash } from "vee-validate/dist/rules";
   import { alpha_space_dash } from '../__custom_validation_rules.js';
   import { EventBus } from '../__vue_event-bus.js';
   import { setTimeout } from 'timers';
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
               subcategoryName: null,
               subcategoryCode: null,
               categoryId: null,
               successMsg: null,
               errorMsg: null
            },
            search: {
               subcategoryName: null,
               categoryName: null
            },
            serverResponseData: {},
            subcategoryIdToDelete: null,
            showDeleteModal: false,
            filteredSubcategories: null
         };
      },

      mounted: function() {
         this.fetchSubcategories();
      },

      computed: {
            ...mapState({
            categories: state => state.categoryStore.categories,
            subcategories: state => state.subcategoryStore.subcategories,
            isAuthenticated: state => state.auth.isLoggedIn
         }),
         postData: function() {
            return {
               subcat_name: this.form.subcategoryName,
               category_id: this.form.categoryId,
            };
         },
         removeModal: function() {
            return '#remove_subcategory_modal';
         },
      },

      watch: {
         subcategories(newValue) {
            if(this.form.subcategoryName) {
               this.filterSubcategories();
            } else if(this.form.categoryId) {         // If already subcategory is selected then filter according to that
               let catId = this.form.categoryId;
               this.form.categoryId = null;
               this.form.categoryId = catId;
            } else {
               this.filteredSubcategories = newValue;
            }
         }
      },

      methods: {
         ...mapActions('subcategoryStore', ['fetchSubcategories','createSubcategory']),
         filterSubcategories: _.debounce(function() {
            let tmp = this.subcategories;

            for(let field in this.search) {
               if(this.search[field] && this.search.hasOwnProperty(field)) {
                  tmp = tmp.filter(subcategory => {
                     switch(field) {
                        case 'subcategoryName':
                           return subcategory.subcat_name.toLowerCase().includes(this.search[field].toLowerCase());
                           break;
                        case 'categoryName':
                           return subcategory.category.name.toLowerCase().includes(this.search[field].toLowerCase());
                           break;
                     }                     
                  });
               }
               this.filteredSubcategories = tmp;
            }
         }, 500),
         addSubcategory: function(postData) {
            this.createSubcategory(postData)
            .then(() => {
               this.$toasted.show('Subcategory added successfully');
               setTimeout(() => this.resetForm(), 1000);
            })
            .catch(errorResponse => {
               this.$toasted.show(errorResponse.message);
            });
         },
         confirmDelete: function(subcategoryId) {
            this.subcategoryIdToDelete = subcategoryId;
            this.showDeleteModal = true;
            this.$nextTick(() => {
               $(this.removeModal).modal({
                  backdrop: 'static'
               });
            });
         },
         afterDeleteSubcategory: function() {
            this.$toasted.show('subcategory deleted');

            $(this.removeModal).modal('hide');            
            this.$nextTick(() => {
               this.showDeleteModal = false;
            });
         },
         showFilteredSubcategoriesByCategory: function() {
            // reset the subcategory name before filtering by category ID, as subcat name also filters the list that is displayed
            // this.form.subcategoryName = null;

            // now filter the subcategories by selected category id
            this.filteredSubcategories = this.subcategories.filter(subcategory => {
               return subcategory.category_id === this.form.categoryId;
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
