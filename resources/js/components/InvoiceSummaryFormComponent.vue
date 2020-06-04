<template>
   <div>   
      <div class="alert alert-success" v-if="form.successMsg && form.successMsg.length">{{form.successMsg}}</div>
      <div class="alert alert-danger" v-if="form.errorMsg && form.errorMsg.length">{{form.errorMsg}}</div>
      
      <div class="form" v-if="isAuthenticated">
         <validation-observer v-slot="observerSlotProp" @submit.prevent="addInvoice(postData)">
            <form id="createInvoiceForm">
               <!-- Invoice No -->
               <div class="field is-horizontal">
                  <div class="field-label is-normal">
                     <label for="invoice_no" class="label">Invoice No <sup>*</sup></label>
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
                                 :class="{ 'is-danger': form.invoiceNo && errors.length}"
                                 id="invoice_no"
                                 name="invoice_no"
                                 v-model="form.invoiceNo"
                                 autocomplete="off">
                              <span class="has-text-danger" v-show="form.invoiceNo && errors.length">
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
                     <label for="unit_id" class="label">Store <sup>*</sup></label>
                  </div>
                  <div class="field-body">
                     <div class="field">
                        <div class="control">
                           <validation-provider
                              name="Store"
                              rules="required"
                              v-slot="{ errors }">
                              <div class="select">
                                 <select
                                    :class="{'is-danger': form.storeId && errors.length}"
                                    id="store_id"
                                    name="store_id"
                                    v-model="form.storeId">
                                       <option value="" disabled selected>Select Store</option>
                                       <option v-for="store in stores" :key="store.id" :value="store.id">
                                          {{ store.store_name }}
                                       </option>
                                 </select>
                                 <span class="has-text-danger" v-show="form.storeId && errors.length">
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
                     <label for="invoice_date" class="label">Invoice Date <sup>*</sup></label>
                  </div>
                  <div class="field-body">
                     <div class="field">
                        <div class="control">
                           <validation-provider
                              name="Invoice date"
                              rules="required"
                              v-slot="{ errors }">
                              <DatePickerComponent v-model="form.invoiceDate" :class="form.invoiceDate && errors.length"></DatePickerComponent>
                              <span class="has-text-danger" v-show="form.invoiceDate && errors.length">
                                 {{ errors[0] }}
                              </span>
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
         </validation-observer>
      </div>
   </div>
</template>

<script>
   import { ValidationObserver, ValidationProvider, extend } from "vee-validate";
   // import ConfirmDelete from './Utility/ConfirmDeleteComponent.vue';
   import { EventBus } from '../__vue_event-bus.js';
   import { required, alpha_dash, numeric } from "vee-validate/dist/rules";
   import DatePickerComponent from './Utility/DatePickerComponent.vue';
   import { mapState, mapActions } from 'vuex';
   import Fetch from "@js/components/Fetch.vue";
  
   extend("required", required);
   extend("alpha_dash", alpha_dash);
   extend("numeric", numeric);

   export default {
      components: { ValidationObserver, ValidationProvider, DatePickerComponent },
      data() {
         return {
            form: {
               invoiceNo: null,
               storeId: null,              
               value: null,
               invoiceDate: null,
               successMsg: null,
               errorMsg: null
            },
            serverResponseData: {},
         };
      },

      // mounted: function() {
      //    // this.fetchInvoices();
      // },

      computed: {
         ...mapState({
            stores: state => state.shopStore.stores,
            invoices: state => state.invoiceSummaryStore.invoices,
            isAuthenticated: state => state.auth.isLoggedIn
         }),
         postData: function() {
            return {
               invoice_no: this.form.invoiceNo,
               invoice_date: this.form.invoiceDate,
               store_id: this.form.storeId,
               // _token: document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            };
         },
      },
      methods: {
         ...mapActions('invoiceSummaryStore', ['fetchInvoices','createInvoiceSummary']),
         addInvoice: function(postData) {
            this.createInvoiceSummary(postData)
            .then(() => {
               this.$toasted.show('Invoice added successfully');
               setTimeout(() => this.resetForm(), 1000);
            })
            .catch(errorResponse => {
               this.$toasted.show(errorResponse.message);
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