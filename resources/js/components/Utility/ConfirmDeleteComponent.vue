<template>
   <div class="modal" tabindex="-1" role="dialog" id="confirmDelete">
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
               <button type="button" class="btn btn-primary" @click.prevent="deleteEntity(deleteCategoryId)">Confirm</button>
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
         </div>
      </div>
   </div>
</template>

<script>
   export default {
      props: ['deleteCategoryId'],
      data() {
         return {
            // toDeleteId: this.deleteCategory
         }
      },
      methods: {
         deleteEntity: function(deleteCategoryId) {
            this.$parent.deleteCategory(deleteCategoryId);
         }
      },
   }
</script>

<style>
   #confirmDelete {
      z-index: 9999
   }
</style>