<template>
   <div>
      <div class="alert alert-success" v-if="form.successMsg && form.successMsg.length">{{form.successMsg}}</div>
      <div class="alert alert-danger" v-if="form.errorMsg && form.errorMsg.length">{{form.errorMsg}}</div>
      <div class="form">
         <ValidationObserver v-slot="observerSlotProp" @submit.prevent="createItem">
            <form id="createInvoiceForm">
               <!--Invoice Id -->
               <div class="field is-horizontal">
                  <div class="field-label is-normal">
                     <label for="invoice_detail_id" class="label">Invoice No</label>
                  </div>
                  <div class="field-body">
                     <div class="field">
                        <div class="control">
                           <validation-provider
                              name="Invoice-No"
                              rules="required"
                              v-slot="{ errors }">
                              <div class="select">
                                 <select
                                    :class="{'is-danger': form.invoiceId && errors.length}"
                                    id="invoice_detail_id"
                                    name="invoice_id"
                                    v-model="form.invoiceId">
                                       <option value="" disabled>Select Invoice</option>
                                       <option v-for="invoice in invoices" :key="invoice.id" :value="invoice.id">
                                          {{ invoice.invoice_no }}
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
               <!-- Item Id -->
               <div class="field is-horizontal">
                  <div class="field-label is-normal">
                     <label for="item_id" class="label">Item</label>
                  </div>
                  <div class="field-body">
                     <div class="field">
                        <div class="control">
                           <validation-provider
                              name="Item"
                              rules="required|numeric"
                              v-slot="{ errors }">
                              <div class="select">
                                 <select
                                    :class="{'is-danger': errors.length}"
                                    id="item_id"
                                    name="item_id"
                                    v-model="form.itemId">
                                       <option value="" disabled>Please select item</option>
                                       <option v-for="item in items" :key="item.id" :value="item.id">
                                          {{ item.item_name }}
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
               <!-- quantity -->
               <div class="field is-horizontal">
                  <div class="field-label is-normal">
                     <label for="quantity" class="label">Quantity</label>
                  </div>
                  <div class="field-body">
                     <div class="field">
                        <div class="control">
                           <validation-provider
                              name="quantity"
                              rules="required|numeric"
                              v-slot="{ errors, classes }">
                              <input
                                 type="text"
                                 class="input"
                                 :class="{ 'is-danger': errors.length}"
                                 id="quantity"
                                 name="quantity"
                                 v-model="form.quantity">
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
               <!--Unit -->
               <div class="field is-horizontal">
                  <div class="field-label is-normal">
                     <label for="unit_id" class="label">Unit</label>
                  </div>
                  <div class="field-body">
                     <div class="field">
                        <div class="control">
                           <validation-provider :bails="false"
                              name="Unit"
                              rules="required|numeric"
                              v-slot="{ errors }">
                              <div class="select">
                                 <select
                                    :class="{'is-danger': errors.length}"
                                    id="unit_id"
                                    name="unit_id"
                                    v-model="form.unitId">
                                       <option value="" disabled>Select unit</option>
                                       <option v-for="unit in units" :key="unit.id" :value="unit.id">
                                          {{ unit.unit_name }}
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
               <!-- Price -->
               <div class="field is-horizontal">
                  <div class="field-label is-normal">
                     <label for="price" class="label">Price</label>
                  </div>
                  <div class="field-body">
                     <div class="field">
                        <div class="control">
                           <validation-provider
                              name="price"
                              :rules="{ required: true, regex:/^[0-9\.]+$/ }"
                              v-slot="{ errors }">
                              <input
                                 type="text"
                                 class="input"
                                 :class="{'is-danger': errors.length}"
                                 id="price"
                                 name="price"
                                 v-model="form.price">
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
   import { required, max, alpha_dash, alpha, numeric, regex } from "vee-validate/dist/rules";
   import { alpha_space_dash } from '../__custom_validation_rules.js';
   import { EventBus } from '../__vue_event-bus.js';
   import { setTimeout } from 'timers';
  
   extend("required", required);
   extend("max", max);
   extend("alpha_dash", alpha_dash);
   extend("alpha", alpha);
   extend("numeric", numeric);
   extend("regex", regex);
   
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
      props: ['items', 'units', 'invoices'],
      data() {
         return {
            // items: [],
            // units: [],
            form: {
               invoiceId: null,
               itemId: null,
               quantity: null,
               unitId: null,               
               price: null,
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
