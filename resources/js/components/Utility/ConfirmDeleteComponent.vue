<template>
   <div class="modal remove-object-modal" tabindex="-1" role="dialog" :id="objectRemoveModalId">
      <div class="modal-dialog modal-dialog-centered modal-sm">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title">Modal title</h5>
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
      props: ['entityId', 'entityType'],
      data() {
         return {
            // toDeleteId: this.deleteCategory
         }
      },
      computed: {
         objectRemoveModalId: function() {
            return 'remove_' + this.entityType + '_modal';
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
               default:
                  break;
            }
            
         }
      },
   }
</script>

<style>
   .remove-object-modal {
      z-index: 9999
   }
</style>