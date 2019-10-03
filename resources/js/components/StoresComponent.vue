<template>
   <div>
      <div class="alert alert-success" v-if="form.successMsg && form.successMsg.length">{{form.successMsg}}</div>
      <div class="alert alert-danger" v-if="form.errorMsg && form.errorMsg.length">{{form.errorMsg}}</div>
      <div class="form" v-if="isAuthenticated">
         <ValidationObserver v-slot="observerSlotProp" @submit.prevent="createStore">
            <form id="createStoreForm">
               <div class="field is-horizontal">
                  <div class="field-label is-normal">
                     <label for="store_name" class="label">Store Name</label>
                  </div>
                  <div class="field-body">
                     <div class="field">
                        <div class="control">
                           <validation-provider
                              name="store-name"
                              rules="required|max:100|alpha_space_dash"
                              v-slot="{ errors, classes }"
                           >
                              <input
                                 type="text"
                                 class="input"
                                 :class="{ 'is-danger': form.storeName && errors.length}"
                                 name="store_name"
                                 id="store_name"
                                 v-model="form.storeName"
                                 autocomplete="off"
                              >
                              <div class="field-suggest" v-if="form.status == 'pending' && form.storeName && filteredStores.length">
                                 <ul>
                                    <li>Available stores....</li>
                                    <li v-for="store of filteredStores" :key="store.id">{{store.store_name}}</li>
                                 </ul>
                              </div>
                              <span
                                 class="has-text-danger"
                                 v-show="form.storeName && form.storeName.length"
                              >{{ errors[0] }}</span>
                           </validation-provider>
                        </div>
                     </div>
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

               <div class="field is-horizontal" v-if="false">
                  <div class="field-label is-normal">
                     <label for="store_code" class="label">Store Code</label>
                  </div>
                  <div class="field-body">
                     <div class="field">
                        <div class="control">
                           <validation-provider
                              name="store-code"
                              rules="required|max:50|alpha_dash"
                              v-slot="{ errors }"
                           >
                              <input
                                 type="text"
                                 class="input"
                                 :class="{'is-danger': form.storeCode && errors.length}"
                                 id="store_code"
                                 name="store_code"
                                 v-model="form.storeCode"
                              >
                              <span
                                 class="has-text-danger"
                                 v-show="form.storeCode && form.storeCode.length"
                              >{{ errors[0] }}</span>
                           </validation-provider>
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
            <h4 class="title is-4">Stores</h4>
         </div>
         <div class="column is-2 has-text-centered">
            <div class="toolbar has-text-centered">
               <span @click="fetchStores" class="icon fas fa-sync"></span>
            </div>            
         </div>
      </div>

      <div class="columns">
         <div class="column">
            <table class="table is-bordered is-hoverable">
               <thead>
                  <tr>
                     <th class="has-text-centered">Store Name</th>
                     <th class="has-text-centered">Store code</th>
                     <th class="has-text-centered" v-if="isAuthenticated">Action</th>
                  </tr>
               </thead>

               <tbody>
                  <tr v-for="store in stores" :key="store.id">
                     <td class="has-text-centered">{{ store.store_name }}</td>
                     <td class="has-text-centered">{{ store.store_code }}</td>
                     <td class="has-text-centered" v-if="isAuthenticated">
                        <button class="btn btn-primary" @click="confirmDelete(store.id)">Delete</button>
                     </td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
      <div class="columns">
         <confirm-delete :entityId="storeIdToDelete" entityType="store">
            <template v-slot:body>
               Confirm Delete?
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

   extend("required", required);
   extend("max", max);

   const httpConfig = {
      create: {
         method: "post",
         url: "/store",
         responseType: "json"
      },
      get: {
         method: "get",
         url: "/stores",
         responseType: "json"
      },
      delete: {
         url: "/store/{store_id}",
         params: {
            data: {
               // _token: document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            }
         }         
      }
   };
   export default {
      components: { ValidationObserver, ValidationProvider, ConfirmDelete },
      props: ['stores', 'isLoggedIn'],
      data() {
         return {
            form: {
               status: 'pending',
               storeName: null,
               storeCode: null,
               successMsg: null,
               errorMsg: null
            },
            serverResponseData: {},
            storeIdToDelete: null,
            isAuthenticated: this.isLoggedIn
         };
      },

      mounted: function() {
         this.fetchStores();
      },

      computed: {
         formStatus: function() {
            return this.form.status == 'pending' && this.form.storeName && this.filteredStores.length;
         },
         postData: function() {
            return {
               store_name: this.form.storeName
               // store_code: this.form.storeCode.toLowerCase(),
               // _token: document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            };
         },
         removeModal: function() {
            return '#remove_store_modal';
         },
         filteredStores: function() {
            return this.stores.filter(store => {
               return this.form.storeName && store.store_name.toLowerCase().startsWith(this.form.storeName.toLowerCase());
            });
         }
      },
      methods: {
         fetchStores: function() {
             axios(httpConfig.get)
            .then(({ data }) => {
               if(data.length) {
                  EventBus.$emit('update-data','store',data);
               }
            });            
         },
         createStore: function() {
            this.form.status = 'submitting';
            httpConfig.create.data = this.postData;
            this.form.storeName = null;
            var vm = this;

            axios(httpConfig.create)
            .then((response) => {
               this.serverResponseData = response.data;
               if(this.serverResponseData.success === true) {
                  this.form.successMsg = 'Store added successfully';
                  this.$emit('new-store-added', this.serverResponseData.data);
               } else {
                  this.form.errorMsg = this.serverResponseData.message;
               }
            })
            .catch(errorResponse => {
               this.form.errorMsg = errorResponse.message;
            })
            .finally(() => {
               setTimeout(() => this.resetForm(), 500);
               this.form.status = 'pending';
            });         
         },

         confirmDelete: function(storeId) {
            this.storeIdToDelete = storeId;
            $(this.removeModal).modal({
               backdrop: 'static'
            });
         },

         deleteStore: function(storeId) {
            axios.delete(httpConfig.delete.url.replace('{store_id}', storeId), httpConfig.delete.params)
            .then( response => {
               this.serverResponseData = response.data;
               if(response.data.success === true) {
                  this.form.successMsg = "Store removed successfully";
                  this.$emit('store-deleted', storeId);
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
               this.form.status = 'pending';
               if(key !== 'status') {
                  this.form[key] = null;
               }               
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

   .field-suggest {
      position: absolute;
      background-color: white;
      z-index: 9999;
      border: 1px solid lightgrey;
      padding: 5px;
      width: 200px;
      border-radius: 5px;
   }
   input:-webkit-autofill {
      // z-index: 999;
      border: 1px solid red;
   }

</style>
