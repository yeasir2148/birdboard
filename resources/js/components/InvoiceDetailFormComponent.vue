<template>
   <div>
      <div class="form">
         <ValidationObserver v-slot="observerSlotProp" @submit.prevent="addInvoiceDetail(postData)">
            <form id="createInvoiceForm">
               <!--Invoice Id -->
               <!--<div class="field is-horizontal">
                  <div class="field-label is-normal">
                     <label for="invoice_detail_id" class="label">Invoice No <sup>*</sup></label>
                  </div>
                  <div class="field-body">
                     <div class="field">
                        <div class="control">
                           <validation-provider
                              name="Invoice No"
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
                                 <span class="has-text-danger" v-show="form.invoiceId && errors.length">
                                    {{ errors[0] }}
                                 </span>
                              </div>
                           </validation-provider>
                        </div>
                     </div>
                  </div>
               </div> -->
               <!--<br>-->
               <!-- Item Id -->
               <!--<div class="field is-horizontal">
                  <div class="field-label is-normal">
                     <label for="item_id" class="label">Item <sup>*</sup></label>
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
                                    :class="{'is-danger': form.itemId && errors.length}"
                                    id="item_id"
                                    name="item_id"
                                    v-model="form.itemId">
                                       <option value="" disabled>Please select item</option>
                                       <option v-for="item in items" :key="item.id" :value="item.id">
                                          {{ item.item_name }}
                                       </option>
                                 </select>
                                 <span class="has-text-danger" v-show="form.itemId && errors.length">
                                    {{ errors[0] }}
                                 </span>
                              </div>
                           </validation-provider>
                        </div>
                     </div>
                  </div>
               </div>-->
               <!-- Search invoice no -->
               <div class="field is-horizontal">
                  <div class="field-label is-normal">
                     <label for="search_invoice_no" class="label">Invoice No <sup>*</sup></label>
                  </div>
                  <div class="field-body">
                     <div class="field">
                        <div class="control">
                           <input type="text"
                              class="input" name="search-item" id="search_invoice_no"
                              placeholder="search invoice no..." v-model="form.searchedInvoiceNo" autocomplete="off">
                        </div>
                     </div>
                  </div>
               </div>

               <div class="field is-horizontal">
                  <div class="field-label is-normal"></div>
                     <div class="field-body">
                        <div class="field">
                           <div class="control invoice-suggestion">
                              <validation-provider 
                                 name="invoice" :rules="{ required: { allowFalse: false } }">
                                 <label class="radio" v-for="invoice in filteredInvoices" :key="invoice.id">
                                    <input type="radio" name="invoice_id" :value="invoice.id" v-model="form.invoiceId">
                                    {{invoice.invoice_no}}
                                 </label>
                              </validation-provider>
                           </div>
                        </div>
                     </div>                     
               </div>

               <!-- Search Item -->
               <div class="field is-horizontal">
                  <div class="field-label is-normal">
                     <label for="search_item" class="label">Item <sup>*</sup></label>
                  </div>
                  <div class="field-body">
                     <div class="field">
                        <div class="control">
                           <input type="text"
                              class="input" name="search-item" id="search_item"
                              placeholder="search item name..." v-model="form.searchedItem" autocomplete="off">
                        </div>
                     </div>
                  </div>
               </div>
               
               <br>

               <div class="field is-horizontal">
                  <div class="field-label is-normal"></div>
                     <div class="field-body">
                        <div class="field">
                           <div class="control item-suggestion">
                           <validation-provider :rules="{ required: { allowFalse: false } }"
                              name="item" v-slot="{ errors, classes }">
                              <label class="radio" v-for="item in filteredItems" :key="item.id">
                                 <input type="radio" name="item_id" :value="item.id" v-model="form.itemId">
                                 {{item.item_name}}
                              </label>
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
               <!-- quantity -->
               <div class="field is-horizontal">
                  <div class="field-label is-normal">
                     <label for="quantity" class="label">Quantity<sup>*</sup></label>
                  </div>
                  <div class="field-body">
                     <div class="field">
                        <div class="control">
                           <validation-provider
                              name="quantity"
                              :rules="{ required: true, regex:/^[0-9\.]+$/ }"
                              v-slot="{ errors, classes }">
                              <input
                                 type="text"
                                 class="input"
                                 :class="{ 'is-danger': errors.length}"
                                 id="quantity"
                                 name="quantity"
                                 v-model="form.quantity" autocomplete="off">
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
                     <label for="unit_id" class="label">Unit <sup>*</sup></label>
                  </div>
                  <div class="field-body">
                     <div class="field">
                        <div class="control">
                           <validation-provider :bails="false"
                              name="Unit"
                              rules="required|numeric"
                              v-slot="{ errors }">
                              <label class="radio" v-for="unit in units" :key="unit.id">
                                 <input type="radio" name="unit_id" :value="unit.id" v-model="form.unitId">
                                 {{unit.unit_name}}
                              </label>
                              <span
                                 class="has-text-danger" v-show="errors.length">
                                 {{ errors[0] }}
                              </span>
                              <!--<div class="select">
                                 <select
                                    :class="{'is-danger': form.unitId && errors.length}"
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
                              </div>-->
                           </validation-provider>
                        </div>
                     </div>
                  </div>
               </div>
               <br>
               <!-- Price -->
               <div class="field is-horizontal">
                  <div class="field-label is-normal">
                     <label for="price" class="label">Price <sup>*</sup></label>
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
                                 :class="{'is-danger': form.price && errors.length}"
                                 id="price"
                                 name="price"
                                 v-model="form.price" autocomplete="off">
                              <span
                                 class="has-text-danger" v-show="form.price && errors.length">
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
   import { setTimeout } from 'timers';
   import { invoiceDetailStore } from '../Shared_State/invoice_detail_store.js';
   import { mapState, mapActions } from "vuex";

   extend("required", required);
   extend("max", max);
   extend("alpha_dash", alpha_dash);
   extend("alpha", alpha);
   extend("numeric", numeric);
   extend("regex", regex);
   
   export default {
      components: { ValidationObserver, ValidationProvider, ConfirmDelete },
      data() {
         return {
            form: {
               invoiceId: null,
               itemId: null,
               quantity: null,
               unitId: null,               
               price: null,
               invoiceDate: null,
               searchedItem: null,
               searchedInvoiceNo: null,
            },
            serverResponseData: {},
            invoiceIdToDelete: null,
         };
      },

      mounted: function() {

      },

      computed: {
         ...mapState('itemStore', ['items']),
         ...mapState('invoiceSummaryStore', ['invoices']),
         ...mapState(['units']),

         postData: function() {
            return {
               invoice_id: this.form.invoiceId,
               item_id: this.form.itemId,
               quantity: this.form.quantity,
               unit_id: this.form.unitId,
               price: this.form.price
            };
         },

         removeModal: function() {
            return '#remove_item_modal';
         },

         filteredItems: function() {
            if(this.items.length && this.form.searchedItem) {
               let filtered = this.items.filter(item => {
                  return item.item_name.toLowerCase().includes(this.form.searchedItem.toLowerCase());
               });
               return filtered;
            }
            return [];
         },
         filteredInvoices: function() {
            if(this.invoices.length && this.form.searchedInvoiceNo) {
               let filtered = this.invoices.filter(invoice => {
                  return invoice.invoice_no.toString().toLowerCase().includes(this.form.searchedInvoiceNo.toLowerCase());
               });
               return filtered;
            }
            return [];
         }
      },
      methods: {
         ...mapActions('invoiceDetailStore', ['createInvoiceDetail']),
         addInvoiceDetail: function(postData) {
            this.createInvoiceDetail(postData)
            .then(() => {
               this.$toasted.show('Invoice detail added successfully');
               setTimeout(() => this.resetForm(), 1000);
            })
            .catch(errorResponse => {
               this.$toasted.show(errorResponse.message);
            });
         },
         confirmDelete: function(itemId) {
            this.itemIdToDelete = itemId;
            $(this.removeModal).modal({
               backdrop: 'static'
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
<style>
   .radio:first-of-type {
      margin-left: 8px;
   }
</style>