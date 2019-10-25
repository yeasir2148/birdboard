<template>
   <div class="invoice-detail-list">
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
                  <tr v-for="invoiceDetail in shared.selectedInvoiceDetails" :key="invoiceDetail.id">
                     <td class="has-text-centered">{{ invoiceDetail.item_name }}</td>
                     <td class="has-text-centered">{{ invoiceDetail.quantity }}</td>
                     <td class="has-text-centered">{{ invoiceDetail.unit_name }}</td>
                     <td class="has-text-centered">{{ invoiceDetail.price }}</td>
                     <td class="has-text-centered">
                        <slot v-if="$scopedSlots['delete-btn']" name="delete-btn" v-bind:invoiceDetail="invoiceDetail" v-bind:confirmDelete="confirmDelete">Delete</slot>
                     </td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
      <slot v-if="$scopedSlots['confirm-delete-modal']" name="confirm-delete-modal" :invoiceDetailIdToDelete="invoiceDetailIdToDelete" :entityType="entityType"></slot>
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
            entityType: 'invoiceDetail',
            serverResponseData: {},
            invoiceDetailIdToDelete: null,
            shared: invoiceDetailStore.state,
            selectedInvoice: {},
            removeModalId: null
         };
      },

      mounted: function() {
      },

      computed: {
         removeModal: function() {
            return '#remove_invoiceDetail_modal';
         },
         selectedInvoiceId: function() {
            return this.shared.selectedInvoiceId;
         }
      },

      watch: {
         selectedInvoiceId: function(newValue, oldValue) {
            if(newValue && newValue !== oldValue) {
               // console.log(newValue);
               httpConfig.getItems.url = httpConfig.getItems.url.replace('{invoice_id}', newValue);
               axios(httpConfig.getItems)
               .then(response => {
                  this.selectedInvoice = response.data.invoice_summary;
                  invoiceDetailStore.setSelectedInvoiceDetails(response.data.invoice_details,'invoice-detail-list component');
               })
               .catch(errorResponse => {
                  this.form.errorMsg = errorResponse.message;
               })
               .finally(() => {
                  //reset to placeholder string for invoice summary id
                  httpConfig.getItems.url = '/invoice/items/{invoice_id}';
               });
            }
         }
      },
      methods: {
         fetchInvoiceDetails: function(invoiceId) {
            console.log(invoiceId);
         },
         confirmDelete: function(invoiceDetailId, modalNo) {
            this.removeModalId = `${this.removeModal}_${modalNo}`;
            console.log(this.removeModalId);
            this.invoiceDetailIdToDelete = invoiceDetailId;
            $(this.removeModalId).modal({
               // backdrop: 'static'
            });
         },

         deleteInvoiceDetail: function(invoiceDetailId) {
            axios.delete(httpConfig.delete.url.replace('{invoice_detail_id}', invoiceDetailId), httpConfig.delete.params)
            .then( response => {
               this.serverResponseData = response.data;
               if(response.data.success === true) {
                  invoiceDetailStore.removeInvoiceDetail(this.selectedInvoiceId, invoiceDetailId, 'invoice-detail-list component');
                  this.form.successMsg = 'Item removed successfully from Invoice';
                  this.$emit('invoice-detail-removed', this.serverResponseData.invoice);
               }
            })
            .catch(errorResponse => {
               this.form.errorMsg = errorResponse.message;
            })
            .finally(() => {
               $(this.removeModalId).modal('hide');
               this.removeModalId = null;
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
