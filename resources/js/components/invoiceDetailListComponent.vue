<template>
   <div class="invoice-detail-list" :class="visibleModalInstanceIndicator === true ? 'not-sticky' : 'sticky'">
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
            <table class="table is-bordered is-hoverable custom-color">
               <thead>
                  <tr>
                     <!--th-- class="has-text-centered">Invoice No</!--th-->
                     <th class="has-text-centered green">Item</th>
                     <th class="has-text-centered green">Quantity</th>
                     <th class="has-text-centered green">Unit</th>
                     <th class="has-text-centered green">Price</th>
                     <th class="has-text-centered green">Action</th>
                  </tr>
               </thead>

               <tbody>
                  <tr v-for="invoiceDetail in selectedInvoiceDetails" :key="invoiceDetail.id">
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

      <div class="columns">
         <confirm-delete 
            :entityId="invoiceDetailIdToDelete" 
            :entityType="entityType"
            :modalNo="modal_no"
            v-if="showDeleteModal_1 || showDeleteModal_2"
            @deleted="afterDeleteInvoiceDetail(modal_no)"
            @delete-modal-closed="afterHideModal(modal_no)"
         >
            <template v-slot:body>
               Confirm Deletion of invoice item?
            </template>
         </confirm-delete>
      </div>
      <!-- <slot v-if="$scopedSlots['confirm-delete-modal']" name="confirm-delete-modal" :invoiceDetailIdToDelete="invoiceDetailIdToDelete" :entityType="entityType"></slot> -->
   </div>
   

</template>


<script>
   import ConfirmDelete from './Utility/ConfirmDeleteComponent.vue';
   import { setTimeout } from 'timers';
   import { invoiceDetailStore } from '../Shared_State/invoice_detail_store.js';
   import { mapState, mapActions } from "vuex";
   import { commonMethods } from "@js/mixins/commonMethodMixin.js";

   export default {  
      mixins: [commonMethods],
      components: { ConfirmDelete },
      // props: ['items', 'invoices', 'active-nav'],
      props: {
         'modal_no': {
            default: "1"
         }
      },
      data() {
         return {
            entityType: 'invoiceDetail',
            invoiceDetailIdToDelete: null,
            showDeleteModal_1: false,
            showDeleteModal_2: false,
         };
      },

      computed: {
         ...mapState('invoiceSummaryStore', ['selectedInvoice','selectedInvoiceId']),
         ...mapState('invoiceDetailStore', ['selectedInvoiceDetails']),
         removeModal: function() {
            return `#remove_invoiceDetail_modal_${this.modal_no}`;
         },
         visibleModalInstanceIndicator: function() {
            return this[`showDeleteModal_${this.modal_no}`];
         }
      },

      watch: {
         selectedInvoiceId: function(newValue, oldValue) {
            if(newValue && newValue !== oldValue) {
               this.fetchInvoiceDetails(newValue);
            }
         }
      },
      methods: {
         ...mapActions('invoiceDetailStore',['fetchInvoiceDetails']),
         confirmDelete: function(invoiceDetailId, modalNo) {
            this.invoiceDetailIdToDelete = invoiceDetailId;
            this[`showDeleteModal_${modalNo}`] = true;
            this.$nextTick(() => {
               $(this.removeModal).modal({
                  backdrop: 'static'
               });
            });
         },
         afterDeleteInvoiceDetail: function(delModalNumber) {
            this.$toasted.show('Invoice item deleted');

            $(this.removeModal).modal('hide');            
            this.$nextTick(() => {
               this.afterHideModal(delModalNumber);
            });
         },
         // deleteInvoiceDetail: function(invoiceDetailId) {
         //    axios.delete(httpConfig.delete.url.replace('{invoice_detail_id}', invoiceDetailId), httpConfig.delete.params)
         //    .then( response => {
         //       this.serverResponseData = response.data;
         //       if(response.data.success === true) {
         //          invoiceDetailStore.removeInvoiceDetail(this.selectedInvoiceId, invoiceDetailId, 'invoice-detail-list component');
         //          this.form.successMsg = 'Item removed successfully from Invoice';
         //          this.$emit('invoice-detail-removed', this.serverResponseData.invoice);
         //       }
         //    })
         //    .catch(errorResponse => {
         //       this.form.errorMsg = errorResponse.message;
         //    })
         //    .finally(() => {
         //       $(this.removeModalId).modal('hide');
         //       this.removeModalId = null;
         //       setTimeout(() => this.resetForm(), 1000);
         //    });
         // },
         // afterHideModal: function(delModalNumber) {
         //    this[`showDeleteModal_${delModalNumber}`] = false;
         // },
         resetForm: function() {
            for (var key in this.form) {
               this.form[key] = null;
            }
         }
      }
   };
</script>

<style lang="scss">
.not-sticky {
   position: none;
}
.sticky {
   position: sticky;
   top: 100px;
}
</style>