<template>
   <div>
      <div class="alert alert-success" v-if="form.successMsg && form.successMsg.length">{{form.successMsg}}</div>
      <div class="alert alert-danger" v-if="form.errorMsg && form.errorMsg.length">{{form.errorMsg}}</div>
      <div class="form">
         <ValidationObserver v-slot="observerSlotProp" @submit.prevent="createItem">
            <form id="createInvoiceForm">
               <!-- Invoice No -->
               <div class="field is-horizontal">
                  <div class="field-label is-normal">
                     <label for="invoice_no" class="label">Invoice No</label>
                  </div>
                  <div class="field-body">
                     <div class="field">
                        <div class="control">
                           <validation-provider
                              name="Invoice-Number"
                              rules="required"
                              v-slot="{ errors, classes }">
                              <input
                                 type="text"
                                 class="input"
                                 :class="{ 'is-danger': errors.length}"
                                 id="invoice_no"
                                 name="invoice_no"
                                 v-model="form.invoiceNo">
                              <span
                                 class="has-text-danger" v-show="errors.length">
                                 {{ errors[0] }}
                              </span>
                           </validation-provider>
                        </div>
                     </div>
                  </div>
               </div>
               
               <!--Store -->
               <div class="field is-horizontal">
                  <div class="field-label is-normal">
                     <label for="unit_id" class="label">Store</label>
                  </div>
                  <div class="field-body">
                     <div class="field">
                        <div class="control">
                           <validation-provider
                              name="Store"
                              rules="required|numeric"
                              v-slot="{ errors }">
                              <div class="select">
                                 <select
                                    :class="{'is-danger': errors.length}"
                                    id="store_id"
                                    name="store_id"
                                    v-model="form.store">
                                       <option value="" disabled selected>Select Store</option>
                                       <option v-for="store in stores" :key="store.id" :value="store.id">
                                          {{ store.store_name }}
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
               <!-- Invoice Date -->
               <div class="field is-horizontal">
                  <div class="field-label is-normal">
                     <label for="invoice_date" class="label">Invoice Date</label>
                  </div>
                  <div class="field-body">
                     <div class="field">
                        <div class="control">
                           <validation-provider
                              name="Invoice date"
                              rules="required"
                              v-slot="{ errors }">
                              <input
                                 type="text"
                                 class="input"
                                 :class="{'is-danger': errors.length}"
                                 id="invoice_date"
                                 name="invoice_date"
                                 v-model="form.invoiceDate">
                              <span
                                 class="has-text-danger" v-show="errors.length">
                                    {{ errors[0] }}
                              </span>
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
   </div>
</template>


<script>
   import { ValidationObserver, ValidationProvider, extend } from "vee-validate";
   import ConfirmDelete from './Utility/ConfirmDeleteComponent.vue';
   import { required, max, alpha_dash, numeric } from "vee-validate/dist/rules";
   import { alpha_space_dash } from '../__custom_validation_rules.js';
   import { EventBus } from '../__vue_event-bus.js';
   import { setTimeout } from 'timers';
  
   extend("required", required);
   extend("max", max);
   extend("alpha_dash", alpha_dash);
   extend("numeric", numeric);

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
      components: { ValidationObserver, ValidationProvider, ConfirmDelete },
      props: ['items', 'units', 'invoices','stores'],
      data() {
         return {
            // items: [],
            // units: [],
            form: {
               invoiceNo: null,
               store: null,              
               value: null,
               invoiceDate: null,
               successMsg: null,
               errorMsg: null
            },
            serverResponseData: {},
            invoiceIdToDelete: null,
         };
      },

      mounted: function() {
         this.fetchItems();
      },

      computed: {
         postData: function() {
            return {
               item_name: this.form.itemName,
               item_code: this.form.itemCode.toLowerCase(),
               subcat_id: this.form.subCategoryId,
               // _token: document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            };
         },
         removeModal: function() {
            return '#remove_item_modal';
         },
      },
      methods: {
         fetchItems: function() {
            axios(httpConfig.getAll)
            .then(({ data }) => {
               if(data !== null && data !== 'undefined') {
                  EventBus.$emit('update-data', 'item', data.items);
               }
            });
         },
         createItem: function() {
            httpConfig.create.data = this.postData;
            var vm = this;

            axios(httpConfig.create)
               .then((response) => {
                  this.serverResponseData = response.data;
                  if(this.serverResponseData.success === true) {
                     this.$emit('new-item-added', this.serverResponseData.data);
                     this.form.successMsg = 'Item added successfully';
                  }
               })
               .catch(response => {
                  this.form.errorMsg = response.data.msg;
               })
               .finally(() => {
                  setTimeout(() => this.resetForm(), 1000);
               });
         },

         confirmDelete: function(itemId) {
            this.itemIdToDelete = itemId;
            $(this.removeModal).modal({
               backdrop: 'static'
            });
         },

         deleteItem: function(itemId) {
            axios.delete(httpConfig.delete.url.replace('{item_id}', itemId), httpConfig.delete.params)
            .then( response => {
               this.serverResponseData = response.data;
               if(response.data.success === true) {
                  this.$emit('item-deleted', itemId);
                  this.form.successMsg = 'Item removed successfully.';
               }
            })
            .catch(errorResponse => {
               this.form.errorMsg = response.data.msg;
            })
            .finally(() => {
               this.removeModal.modal('hide');
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
