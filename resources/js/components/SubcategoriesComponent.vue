<template>
   <div>
      <div class="alert alert-success" v-if="form.successMsg && form.successMsg.length">{{form.successMsg}}</div>
      <div class="alert alert-danger" v-if="form.errorMsg && form.errorMsg.length">{{form.errorMsg}}</div>
      <div class="form" v-if="isAuthenticated">
         <ValidationObserver v-slot="observerSlotProp" @submit.prevent="createSubcategory">
            <form id="createSubCategoryForm">
               <div class="field is-horizontal">
                  <div class="field-label is-normal">
                     <label for="subcategory_name" class="label">Subcategory Name</label>
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
                                 v-model="form.subcategoryName">
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
                     <label for="subcategory_code" class="label">Subcategory Code</label>
                  </div>
                  <div class="field-body">
                     <div class="field">
                        <div class="control">
                           <validation-provider
                              name="subcategory-code"
                              rules="required|max:30|alpha_dash"
                              v-slot="{ errors }">
                              <input
                                 type="text"
                                 class="input"
                                 :class="{'is-danger': form.subcategoryCode && errors.length}"
                                 id="category_code"
                                 name="category_code"
                                 v-model="form.subcategoryCode">
                              <span
                                 class="has-text-danger"
                                 v-show="form.subcategoryCode && form.subcategoryCode.length">
                                    {{ errors[0] }}
                              </span>
                           </validation-provider>
                        </div>
                     </div>
                  </div>
               </div>

               <div class="field is-horizontal">
                  <div class="field-label is-normal">
                     <label for="category_name" class="label">Category Name</label>
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
      
      <div class="columns">
         <div class="column has-text-centered">
            <h4 class="title is-4">Subcategories</h4>
         </div>
         <div class="column is-2 has-text-centered">
            <div class="toolbar has-text-centered">
               <span @click="fetchSubcategory" class="icon fas fa-sync"></span>
            </div>            
         </div>
      </div>      

      <div class="columns">
         <div class="column">
            <table class="table is-bordered is-hoverable">
               <thead>
                  <tr>
                     <th class="has-text-centered">Name</th>
                     <th class="has-text-centered">Code</th>
                     <th class="has-text-centered">Category Name</th>
                     <th class="has-text-centered" v-if="isAuthenticated">Action</th>
                  </tr>
               </thead>

               <tbody>
                  <tr v-for="subcat in subcategories" :key="subcat.id">
                     <td class="has-text-centered">{{ subcat.subcat_name }}</td>
                     <td class="has-text-centered">{{ subcat.subcat_code }}</td>
                     <td class="has-text-centered">{{ subcat.category.name }}</td>
                     <td class="has-text-centered" v-if="isAuthenticated">
                        <button class="btn btn-primary" @click="confirmDelete(subcat.id)">Delete</button>
                     </td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
      <div class="columns">
         <confirm-delete :entityId="subcategoryIdToDelete" entityType="subcategory">
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
  
   extend("required", required);
   extend("max", max);
   extend("alpha_dash", alpha_dash);

   const httpConfig = {
      create: {
         method: "post",
         url: "/subcategory",
         responseType: "json"
      },
      getAll: {
         method: "get",
         url: "/subcategories",
         responseType: "json"
      },
      delete: {
         url: "/subcategory/{subcat_id}",
         params: {
            data: {
               _token: document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            }
         }         
      }
   };
   export default {
      components: { ValidationObserver, ValidationProvider, ConfirmDelete },
      props: ['categories', 'subcategories','isLoggedIn'],
      data() {
         return {
            form: {
               subcategoryName: null,
               subcategoryCode: null,
               categoryId: null,
               successMsg: null,
               errorMsg: null
            },
            serverResponseData: {},
            subcategoryIdToDelete: null,
            isAuthenticated: this.isLoggedIn
         };
      },

      mounted: function() {
         this.fetchSubcategory();
      },

      computed: {
         postData: function() {
            return {
               subcat_name: this.form.subcategoryName,
               subcat_code: this.form.subcategoryCode.toLowerCase(),
               category_id: this.form.categoryId,
               // _token: document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            };
         },
         removeModal: function() {
            return '#remove_subcategory_modal';
         },
      },
      methods: {
         fetchSubcategory: function() {
            axios(httpConfig.getAll)
            .then(({ data }) => {
               if(data !== null && data !== 'undefined') {
                  EventBus.$emit('update-data','subcategory',data.subcategories);
               }
            });
         },
         createSubcategory: function() {
            httpConfig.create.data = this.postData;
            var vm = this;

            axios(httpConfig.create)
               .then((response) => {
                  this.serverResponseData = response.data;
                  if(this.serverResponseData.success === true) {
                     this.$emit('new-subcategory-added', this.serverResponseData.data);
                     this.form.successMsg = 'subcategory added successfully';
                  }
               })
               .catch(response => {
                  this.form.errorMsg = response.data.msg;
               })
               .finally(() => {
                  setTimeout(() => this.resetForm(), 1000);
               });
         },

         confirmDelete: function(subcategoryId) {
            this.subcategoryIdToDelete = subcategoryId;
            $(this.removeModal).modal({
               backdrop: 'static'
            });
         },

         deleteSubcategory: function(subcategoryId) {
            axios.delete(httpConfig.delete.url.replace('{subcat_id}', subcategoryId), httpConfig.delete.params)
            .then( response => {
               this.serverResponseData = response.data;
               if(response.data.success === true) {
                  this.$emit('subcategory-deleted',subcategoryId);
                  this.form.successMsg = 'Subcategory removed successfully.';
               }
            })
            .catch(errorResponse => {
               this.form.errorMsg = response.data.msg;
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
