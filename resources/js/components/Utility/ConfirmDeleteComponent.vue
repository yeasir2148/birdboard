<template>
   <div class="modal remove-object-modal" tabindex="-1" role="dialog" :id="objectRemoveModalId" data-backdrop="false">
      <div class="modal-dialog modal-dialog-centered modal-sm">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title has-text-weight-bold">Modal title</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <slot name="body"></slot>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-primary" @click.prevent="deleteEntity(entityId, entityType)">Confirm</button>
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
         </div>
      </div>
   </div>
</template>

<script>
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
         deleteEntity: function(objectId, objectType) {
            switch (objectType) {
               case 'category':
                  this.$parent.deleteCategory(objectId);
                  break;
               case 'subcategory': 
                  this.$parent.deleteSubcategory(objectId);
                  break;
               case 'item':
                  this.$parent.deleteItem(objectId);
                  break;
               case 'store':
                  this.$parent.deleteStore(objectId);
                  break;
               case 'invoiceSummary':
                  this.$parent.deleteInvoiceSummary(objectId);
                  break;
               case 'invoiceDetail':
                  this.$parent.deleteInvoiceDetail(objectId);
                  break;
               default:
                  break;
            }
            
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