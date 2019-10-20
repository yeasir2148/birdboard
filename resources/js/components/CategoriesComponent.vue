<template>
   <div>
      <div class="alert alert-success" v-if="form.successMsg && form.successMsg.length">{{form.successMsg}}</div>
      <div class="alert alert-danger" v-if="form.errorMsg && form.errorMsg.length">{{form.errorMsg}}</div>
      <div class="form" v-if="isAuthenticated">
         <ValidationObserver v-slot="observerSlotProp" @submit.prevent="createCategory">
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
                              v-slot="{ errors, classes }"
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
                                 v-show="form.name && form.name.length"
                              >{{ errors[0] }}</span>
                           </validation-provider>
                        </div>
                     </div>
                  </div>
               </div>

               <!--<div class="field is-horizontal" v-if="false">
                  <div class="field-label is-normal">
                     <label for="category_code" class="label">Category Code</label>
                  </div>
                  <div class="field-body">
                     <div class="field">
                        <div class="control">
                           <validation-provider
                              name="category-code"
                              rules="required|max:30|alpha_dash"
                              v-slot="{ errors }"
                           >
                              <input
                                 type="text"
                                 class="input"
                                 :class="{'is-danger': form.categoryCode && errors.length}"
                                 id="category_code"
                                 name="category_code"
                                 v-model="form.categoryCode"
                              >
                              <span
                                 class="has-text-danger"
                                 v-show="form.categoryCode && form.categoryCode.length"
                              >{{ errors[0] }}</span>
                           </validation-provider>
                        </div>
                     </div>
                  </div>
               </div>-->

               <div class="field is-horizontal">
                  <div class="field-label"></div>
                  <div class="field-body">
                     <div class="field">
                        <div class="control">
                           <button
                              class="button is-link"
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
         <div class="column is-2 has-text-centered">
            <div class="toolbar has-text-centered">
               <span @click="fetchCategory" class="icon fas fa-sync"></span>
            </div>            
         </div>
      </div>

      <div class="columns">
         <div class="column">
            <table class="table is-bordered is-hoverable">
               <thead>
                  <tr>
                     <th class="has-text-centered">Name</th>
                     <th class="has-text-centered">Category code</th>
                     <th class="has-text-centered" v-if="isAuthenticated">Action</th>
                  </tr>
               </thead>

               <tbody>
                  <tr>
                     <td class="has-text-centered">
                        <input class="input" type="text" 
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
                        <button class="btn btn-primary" @click="confirmDelete(category.id)">Delete</button>
                     </td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
      <div class="columns">
         <confirm-delete :entityId="categoryIdToDelete" entityType="category">
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
   import { required, max, alpha_dash } from "vee-validate/dist/rules";
   import { alpha_space_dash } from '../__custom_validation_rules.js';
   import { EventBus } from '../__vue_event-bus.js';
   import _ from 'lodash';

   extend("required", required);
   extend("max", max);
   extend("alpha_dash", alpha_dash);

   const httpConfig = {
      create: {
         method: "post",
         url: "/categories",
         responseType: "json"
      },
      get: {
         method: "get",
         url: "/categories",
         responseType: "json"
      },
      delete: {
         url: "/categories/{category_id}",
         params: {
            data: {
               // _token: document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            }
         }         
      }
   };
   export default {
      components: { ValidationObserver, ValidationProvider, ConfirmDelete },
      props: ['categories', 'isLoggedIn'],
      data() {
         return {
            form: {
               name: null,
               categoryCode: null,
               successMsg: null,
               errorMsg: null
            },
            search: {
               categoryName: null,
            },
            serverResponseData: {},
            categoryIdToDelete: null,
            isAuthenticated: this.isLoggedIn,
            filteredCategories: null
         };
      },

      mounted: function() {
         this.fetchCategory();
      },

      computed: {
         postData: function() {
            return {
               name: this.form.name,
               // category_code: this.form.categoryCode.toLowerCase(),
               // _token: document.querySelector('meta[name="csrf-token"]').getAttribute("content")
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
         fetchCategory: function() {
             axios(httpConfig.get)
            .then(({ data }) => {
               // console.log(data);
               if(data.length) {
                  EventBus.$emit('update-data','category',data);
               }
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

         createCategory: function() {
            httpConfig.create.data = this.postData;
            var vm = this;

            axios(httpConfig.create)
            .then((response) => {
               this.serverResponseData = response.data;
               if(this.serverResponseData.success === true) {
                  this.form.successMsg = 'Category added successfully';
                  this.$emit('new-category-added', this.serverResponseData.data);
               } else {
                  this.form.errorMsg = this.serverResponseData.message;
               }
            })
            .catch(errorResponse => {
               this.form.errorMsg = errorResponse.message;
            })
            .finally(() => {
               setTimeout(() => this.resetForm(), 1000);
            });         
         },

         confirmDelete: function(categoryId) {
            this.categoryIdToDelete = categoryId;
            $(this.removeModal).modal({
               backdrop: 'static'
            });
         },

         deleteCategory: function(categoryId) {
            axios.delete(httpConfig.delete.url.replace('{category_id}', categoryId), httpConfig.delete.params)
            .then( response => {
               this.serverResponseData = response.data;
               if(response.data.success === true) {
                  this.form.successMsg = "Category removed successfully";
                  this.$emit('category-deleted', categoryId);
               }
            })
            .catch(errorResponse => {
               this.form.errorMsg = errorResponse.message;
            })
            .finally(() => {
               $(this.removeModal).modal('hide');
               setTimeout(() => this.resetForm(), 1000);
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
   .fas.icon {
      line-height: inherit;
      cursor: pointer;
      &:hover {
         background-color: #EDE7E6;
      }
   }

</style>
