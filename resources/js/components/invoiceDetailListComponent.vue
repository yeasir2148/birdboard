<template>
   <div>
      <div class="alert alert-success" v-if="form.successMsg && form.successMsg.length">{{form.successMsg}}</div>
      <div class="alert alert-danger" v-if="form.errorMsg && form.errorMsg.length">{{form.errorMsg}}</div>

      <div class="columns">
         <div class="column has-text-centered">
            <h4 class="title is-4">Invoice Detail - <span v-if="selectedInvoice">{{ selectedInvoice.invoice_no }}</span></h4>
         </div>
         <div class="column is-2 has-text-centered">
            <div class="toolbar has-text-centered">
               <span class="icon fas fa-sync" id="sync_invoice_details" @click="fetchInvoiceDetails(selectedInvoiceId)"></span>
            </div>            
         </div>
      </div>                    

      <div class="columns">
         <div class="column">
            <table class="table is-bordered is-hoverable">
               <thead>
                  <tr>
                     <!--th-- class="has-text-centered">Invoice No</!--th-->
                     <th class="has-text-centered">Item</th>
                     <th class="has-text-centered">Quantity</th>
                     <th class="has-text-centered">Unit</th>
                     <th class="has-text-centered">Price</th>
                     <th class="has-text-centered">Action</th>
                  </tr>
               </thead>

               <tbody>
                  <tr v-for="row in shared.selectedInvoiceDetails">
                     <td class="has-text-centered">{{ row.item_name }}</td>
                     <td class="has-text-centered">{{ row.quantity }}</td>
                     <td class="has-text-centered">{{ row.unit_name }}</td>
                     <td class="has-text-centered">{{ row.price }}</td>
                     <td class="has-text-centered">
                        <slot name="delete-btn" v-bind:confirmDelete="confirmDelete">Delete</slot>
                     </td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>

      <div class="columns">
         <confirm-delete :entityId="invoiceDetailIdToDelete" :entityType="entityType">
            <template v-slot:body>
               Confirm Delete?
            </template>
         </confirm-delete>
      </div>
   </div>
</template>


<script>
   import ConfirmDelete from './Utility/ConfirmDeleteComponent.vue';
   import { setTimeout } from 'timers';
   import { invoiceDetailStore } from '../Shared_State/invoice_detail_store.js';
  
   const httpConfig = {
      getItems: {
         method: "get",
         url: "/invoice/items/{invoice_id}",
         responseType: "json"
      },
      getAll: {
         method: "get",
         url: "/invoice-detail",
         responseType: "json"
      },
      delete: {
         url: "/invoice-detail/{invoice_detail_id}",
         params: {
            data: {
               _token: document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            }
         }         
      }
   };
   export default {
      components: { ConfirmDelete },
      props: ['items', 'invoices', 'active-nav'],
      data() {
         return {
            form: {
               successMsg: null,
               errorMsg: null
            },
            entityType: 'invoice_detail',
            serverResponseData: {},
            invoiceDetailIdToDelete: null,
            shared: invoiceDetailStore.state,
            selectedInvoice: {},
         };
      },

      mounted: function() {
      },

      computed: {
         removeModal: function() {
            return '#remove_invoice_detail_modal';
         },
         selectedInvoiceId: function() {
            return this.shared.selectedInvoiceId;
         }
      },

      watch: {
         selectedInvoiceId: function(newValue, oldValue) {
            // console.log(newValue);
            if(newValue !== oldValue) {
               httpConfig.getItems.url = httpConfig.getItems.url.replace('{invoice_id}', newValue);
               console.log(httpConfig.getItems);
               axios(httpConfig.getItems)
               .then(response => {
                  this.selectedInvoice = response.data.invoice_summary;
                  invoiceDetailStore.setSelectedInvoiceDetails(response.data.invoice_details);
               })
               .catch(errorResponse => {
                  this.form.errorMsg = errorResponse.message;
               })
               .finally(() => {
                  httpConfig.getItems.url = '/invoice/items/{invoice_id}';
               });
            }
         }
      },
      methods: {
         fetchInvoiceDetails: function(invoiceId) {
            console.log(invoiceId);
         },
         confirmDelete: function(invoiceDetailId) {
            this.invoiceDetailIdToDelete = invoiceDetailId;
            $(this.removeModal).modal({
               backdrop: 'static'
            });
         },

         deleteInvoiceDetail: function(invoiceDetailId) {
            axios.delete(httpConfig.delete.url.replace('{invoice_detail_id}', invoiceDetailId), httpConfig.delete.params)
            .then( response => {
               this.serverResponseData = response.data;
               if(response.data.success === true) {
                  this.$emit('invoice-detail-deleted', invoiceDetailId);
                  this.form.successMsg = 'Item removed successfully from Invoice';
               }
            })
            .catch(errorResponse => {
               this.form.errorMsg = errorResponse.message;
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
