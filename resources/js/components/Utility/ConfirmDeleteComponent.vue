<template>
   <div class="modal remove-object-modal modal-active show" tabindex="-1" role="dialog" :id="objectRemoveModalId" data-backdrop="static">
      <div class="modal-dialog modal-dialog-centered modal-sm">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title has-text-weight-bold">Modal title</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="onModalClose">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <slot name="body"></slot>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-primary" @click.prevent="deleteEntity(entityId, entityType)">Confirm</button>
               <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="onModalClose">Cancel</button>
            </div>
         </div>
      </div>
   </div>
</template>

<script>
   import { mapActions } from 'vuex';

   export default {
      props: ['entityId', 'entityType','modalNo'],
      data() {
         return {
         }
      },
      computed: {
         objectRemoveModalId: function() {
            return 'remove_' + this.entityType + '_modal' + (this.modalNo !== null && this.modalNo !== undefined ? `_${this.modalNo}` : '');
         }
      },
      methods: {
         ...mapActions('categoryStore', ['deleteCategory']),
         ...mapActions('subcategoryStore', ['deleteSubcategory']),
         ...mapActions('itemStore', ['deleteItem']),
         ...mapActions('shopStore', ['deleteStore']),
         ...mapActions('invoiceSummaryStore',['deleteInvoiceSummary']),
         ...mapActions('invoiceDetailStore', ['deleteInvoiceDetail']),
         deleteEntity: function(objectId, objectType) {
            switch (objectType) {
               case 'category':
                  this.deleteCategory(objectId)
                  .then(() => {
                     this.$emit('deleted');
                  });
                  break;
               case 'subcategory': 
                  this.deleteSubcategory(objectId)
                  .then(() => {
                     this.$emit('deleted');
                  });
                  break;
               case 'item':
                  this.deleteItem(objectId)
                  .then(() => {
                     this.$emit('deleted');
                  });
                  break;
               case 'store':
                  this.deleteStore(objectId)
                  .then(() => {
                     this.$emit('deleted');
                  });
                  break;
               case 'invoiceSummary':
                  this.deleteInvoiceSummary(objectId)
                  .then(() => {
                     this.$emit('deleted');
                  });
                  break;
               case 'invoiceDetail':
                  this.deleteInvoiceDetail(objectId);
                  this.$emit('deleted');
                  break;
            }
            
         },
         onModalClose: function() {
            this.$emit('delete-modal-closed', this.entityType);
         }
      },
   }
</script>

<style>
   .remove-object-modal {
      z-index: 9999;
   }
   .modal-header {
      background-color: #BDB76B;
      font-weight: bold;
   }
   .modal-body {
      background-color: #DCDCDC;
   }
   .modal-footer {
      background-color: #DCDCDC;
   }
</style>