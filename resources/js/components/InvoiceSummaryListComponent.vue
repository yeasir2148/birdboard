<template>
   <div>
      <div class="alert alert-success" v-if="form.successMsg && form.successMsg.length">{{form.successMsg}}</div>
      <div class="alert alert-danger" v-if="form.errorMsg && form.errorMsg.length">{{form.errorMsg}}</div>

      <div class="columns">
         <div class="column has-text-centered">
            <h4 class="title is-4">Invoices</h4>
         </div>
         <div class="column is-2 has-text-centered">
            <div class="toolbar has-text-centered">
               <span @click="fetchInvoices" class="icon fas fa-sync" id="sync_invoices"></span>
            </div>            
         </div>
      </div>                    

      <div class="columns">
         <div class="column">
            <table class="table is-bordered is-hoverable">
               <thead>
                  <tr>
                     <th class="has-text-centered">Invoice No</th>
                     <th class="has-text-centered">Value</th>
                     <th class="has-text-centered">Invoice Date</th>
                     <th class="has-text-centered">Store Name</th>
                     <th class="has-text-centered">Action</th>
                  </tr>
               </thead>

               <tbody>
                  <tr v-for="invoice in invoices">
                     <td class="has-text-centered">
                        <a href="#" @click="showInvoiceDetails(invoice.id)">{{ invoice.invoice_no }}</a>
                     </td>
                     <td class="has-text-centered">{{ invoice.value }}</td>
                     <td class="has-text-centered">{{ invoice.invoice_date }}</td>
                     <td class="has-text-centered" v-if="invoice.store">{{ invoice.store.store_name }}</td>
                     <td class="has-text-centered">
                        <slot name="delete-btn" v-bind:invoice="invoice" v-bind:confirmDelete="confirmDelete"></slot>
                     </td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>

      <div class="columns">
         <confirm-delete :entityId="invoiceSummaryIdToDelete" :entityType="entityType">
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
   import { required, max, alpha_dash, numeric } from "vee-validate/dist/rules";
   import { alpha_space_dash } from '../__custom_validation_rules.js';
   import { EventBus } from '../__vue_event-bus.js';
   import { setTimeout } from 'timers';
   import { invoiceDetailStore } from '../Shared_State/invoice_detail_store.js';
  
   extend("required", required);
   extend("max", max);
   extend("alpha_dash", alpha_dash);
   extend("numeric", numeric);

   const httpConfig = {
      getAll: {
         method: "get",
         url: "/invoices",
         responseType: "json"
      },
      delete: {
         url: "/invoice/{invoice_id}",
         params: {
            data: {
               _token: document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            }
         }         
      }
   };

   export default {
      components: { ValidationObserver, ValidationProvider, ConfirmDelete },
      props: ['items','units','invoices','stores'],
      data() {
         return {
            // items: [],
            // units: [],
            form: {
               successMsg: null,
               errorMsg: null
            },
            serverResponseData: {},
            invoiceSummaryIdToDelete: null,
            entityType: 'invoiceSummary',
            shared: invoiceDetailStore.state
         };
      },

      mounted: function() {
         this.fetchInvoices();
      },

      computed: {
         removeModal: function() {
            return '#remove_invoiceSummary_modal';
         },
      },
      methods: {
         showInvoiceDetails: function(invoiceId) {
            invoiceDetailStore.setSelectedInvoiceId(invoiceId, 'invoiceSummaryList');
            // $('#invoice_detail_tab').trigger('click');
         },
         fetchInvoices: function() {
            axios(httpConfig.getAll)
            .then(({ data }) => {
               if(data !== null && data !== 'undefined') {
                  EventBus.$emit('update-data', 'invoiceSummary', data);
               }
            });
         },

         confirmDelete: function(invoiceSummaryId) {
            this.invoiceSummaryIdToDelete = invoiceSummaryId;
            $(this.removeModal).modal({
               backdrop: 'static'
            });
         },

         deleteInvoiceSummary: function(invoiceSummaryId) {
            axios.delete(httpConfig.delete.url.replace('{invoice_id}', invoiceSummaryId), httpConfig.delete.params)
            .then( response => {
               this.serverResponseData = response.data;
               if(response.data.success === true) {
                  this.$emit('invoice-summary-deleted', invoiceSummaryId);
                  this.form.successMsg = 'Invoice removed successfully.';
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
