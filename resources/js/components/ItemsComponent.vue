<template>
   <div>
      <div class="alert alert-success" v-if="form.successMsg && form.successMsg.length">{{form.successMsg}}</div>
      <div class="alert alert-danger" v-if="form.errorMsg && form.errorMsg.length">{{form.errorMsg}}</div>
      <ValidationObserver v-slot="observerSlotProp" @submit.prevent="createItem">
         <form id="createItemForm">
            <div class="field is-horizontal">
               <div class="field-label is-normal">
                  <label for="item_name" class="label">Item Name</label>
               </div>
               <div class="field-body">
                  <div class="field">
                     <div class="control">
                        <validation-provider
                           name="Item-Name"
                           rules="required|max:30|alpha_dash"
                           v-slot="{ errors, classes }">
                           <input
                              type="text"
                              class="input"
                              :class="{ 'is-danger': form.itemName && errors.length}"
                              id="item_name"
                              name="item_name"
                              v-model="form.itemName">
                           <span
                              class="has-text-danger"
                              v-show="form.itemName && form.itemName.length">
                              {{ errors[0] }}
                           </span>
                        </validation-provider>
                     </div>
                  </div>
               </div>
            </div>

            <div class="field is-horizontal">
               <div class="field-label is-normal">
                  <label for="item_code" class="label">Item Code</label>
               </div>
               <div class="field-body">
                  <div class="field">
                     <div class="control">
                        <validation-provider
                           name="Item-Code"
                           rules="required|max:30|alpha_dash"
                           v-slot="{ errors }">
                           <input
                              type="text"
                              class="input"
                              :class="{'is-danger': form.itemCode && errors.length}"
                              id="item_code"
                              name="item_code"
                              v-model="form.itemCode">
                           <span
                              class="has-text-danger"
                              v-show="form.itemCode && form.itemCode.length">
                                 {{ errors[0] }}
                           </span>
                        </validation-provider>
                     </div>
                  </div>
               </div>
            </div>

            <div class="field is-horizontal">
               <div class="field-label is-normal">
                  <label for="subcategory_id" class="label">Subcategory</label>
               </div>
               <div class="field-body">
                  <div class="field">
                     <div class="control">
                        <validation-provider
                           name="Subcategory"
                           rules="required"
                           v-slot="{ errors }">
                           <div class="select">
                              <select
                                 :class="{'is-danger': form.subCategoryId && errors.length}"
                                 id="subcategory_id"
                                 name="subcategory_id"
                                 v-model="form.subCategoryId">
                                    <option value="" disabled>Please select subcategory</option>
                                    <option v-for="subcat in subcategories" :key="subcat.id" :value="subcat.id">
                                       {{ subcat.name + ' - ' + subcat.name }}
                                    </option>
                              </select>
                              <span class="has-text-danger" v-show="form.subCategoryId">
                                 {{ errors[0] }}
                              </span>
                           </div>
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

      <br>
      
      <div class="columns">
         <div class="column has-text-centered">
            <h4 class="title is-4">Items</h4>
         </div>
         <div class="column is-2 has-text-centered">
            <div class="toolbar has-text-centered">
               <span @click="fetchItems" class="icon fas fa-sync"></span>
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
                     <th class="has-text-centered">Subcategory</th>
                     <th class="has-text-centered">Action</th>
                  </tr>
               </thead>

               <tbody>
                  <tr v-for="subcat in subcategories" :key="subcat.id">
                     <td class="has-text-centered">{{ subcat.subcat_name }}</td>
                     <td class="has-text-centered">{{ subcat.subcat_code }}</td>
                     <td class="has-text-centered">{{ subcat.subcat_code }}</td>
                     <td class="has-text-centered">
                        <button class="btn btn-primary" @click="deleteSubcategory(subcat.id)">Delete</button>
                     </td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
   </div>
</template>


<script>
   import { ValidationObserver, ValidationProvider, extend } from "vee-validate";
   import { required, email, max, alpha_dash } from "vee-validate/dist/rules";
   import { EventBus } from '../__vue_event-bus.js';
import { setTimeout } from 'timers';
  
   extend("required", required);
   extend("email", email);
   extend("max", max);
   extend("alpha_dash", alpha_dash);

   const httpConfig = {
      create: {
         method: "post",
         url: "/item",
         responseType: "json"
      },
      getAll: {
         method: "get",
         url: "/items",
         responseType: "json"
      },
      delete: {
         url: "/item/{item_id}",
         params: {
            data: {
               _token: document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            }
         }         
      }
   };
   export default {
      components: { ValidationObserver, ValidationProvider },
         data() {
            return {
               categories: [],
               subcategories:[],
               items: [],
               form: {
                  itemName: null,
                  itemCode: null,
                  subCategoryId: null,
                  successMsg: null,
                  errorMsg: null
               },
               serverResponseData: {}
            };
         },

      mounted: function() {
         // EventBus.$on('new-subcategory-added', (newCategory) => {
         //    this.categories.push(newCategory);
         // });

         // EventBus.$on('subcategory-deleted', deletedCategoryId => {
         //    this.categories = this.categories.filter(category => {
         //       return category.id != deletedCategoryId;
         //    });

         //    this.subcategories = this.subcategories.filter(subcat => {
         //       return subcat.category.id != deletedCategoryId;
         //    });
         // });

         this.fetchItems();
      },

      computed: {
         postData: function() {
            return {
               item_name: this.form.itemName,
               item_code: this.form.itemCode.toLowerCase(),
               subcategory_id: this.form.subCategoryId,
               // _token: document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            };
         }
      },
      methods: {
         fetchItems: function() {
            axios(httpConfig.getAll)
            .then(({ data }) => {
               // console.log(data);
               if(data !== null && data !== 'undefined') {
                  // console.log(data);
                  this.items = data.items,
                  this.categories = data.categories;
                  this.subcategories = data.subcategories;
               }
            });


            // axios(httpConfig.getAll)
            // .then(({ data }) => {
            //    // console.log(data);
            //    if(data !== null && data !== 'undefined') {
            //       // console.log(data);
            //       this.categories = data.categories;
            //       this.subcategories = data.subcategories;
            //    }
            // });
         },
         createSubcategory: function() {
            httpConfig.create.data = this.postData;
            var vm = this;

            axios(httpConfig.create)
               .then((response) => {
                  this.serverResponseData = response.data;
                  if(this.serverResponseData.success === true) {
                     this.subcategories.push(this.serverResponseData.data);
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

         deleteSubcategory: function(subcategoryId) {
            axios.delete(httpConfig.delete.url.replace('{subcat_id}', subcategoryId), httpConfig.delete.params)
            .then( response => {
               this.serverResponseData = response.data;
               if(response.data.success === true) {
                  this.subcategories = this.subcategories.filter(subcategory => {
                     return subcategory.id !== subcategoryId;
                  });
                  this.form.successMsg = 'Subcategory removed successfully.';
               }
            })
            .catch(errorResponse => {
               this.form.errorMsg = response.data.msg;
            })
            .finally(() => {
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
