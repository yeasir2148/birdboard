<template>
   <div class="column is-2 has-text-centered">
      <div class="toolbar has-text-centered">
         <span @click="fetchObjects(objectToFetch)" class="icon fas fa-sync"></span>
      </div>
   </div>
</template>

<script>
import { mapActions } from "vuex";

export default {
   props: {
      objectToFetch: {
         type: String,
         required: true
      }
   },
   methods: {
      ...mapActions('categoryStore', ["fetchCategories"]),
      ...mapActions('subcategoryStore', ["fetchSubcategories"]),
      ...mapActions('itemStore', ["fetchItems"]),
      ...mapActions('shopStore', ["fetchStores"]),
      ...mapActions('invoiceSummaryStore', ['fetchInvoices']),
      
      fetchObjects(objName) {
         switch (objName) {
            case "categories":
               this.fetchCategories();
               break;
            case "subcategories":
               this.fetchSubcategories();
               break;
            case "items":
               this.fetchItems();
               break;
            case "stores":
               this.fetchStores();
               break;
            case "invoiceSummaries":
               this.fetchInvoices();
               break;
         }
      }
   }
};
</script>

<style>
</style>