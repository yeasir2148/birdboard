<template>
   <div>
      <div class="columns">
         <div class="column has-text-centered">
            <h4 class="title is-4">Invoices</h4>
         </div>
         <Fetch class="column is-2 has-text-centered" objectToFetch="invoiceSummaries"></Fetch>
      </div>                    

      <div class="columns">
         <div class="column">
            <table class="table is-bordered is-hoverable custom-color">
               <thead>
                  <tr>
                     <th class="has-text-centered green">Invoice No</th>
                     <th class="has-text-centered green">Value</th>
                     <th class="has-text-centered green">Invoice Date</th>
                     <th class="has-text-centered green">Store Name</th>
                     <th class="has-text-centered green">Action</th>
                  </tr>
               </thead>

               <tbody  v-if="isAuthenticated">
                  <tr v-for="invoice in invoices" :key="invoice.id">
                     <td class="has-text-centered">
                        <a href="#" class="has-text-black" @click.prevent="showInvoiceDetails(invoice)">{{ invoice.invoice_no }}</a>
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
            <div v-if="!isAuthenticated">
               Please login to view your invoices
            </div>
         </div>
      </div>

      <div class="columns">
         <confirm-delete ref="removeModal"
            :entityId="invoiceSummaryIdToDelete" 
            :entityType="entityType"
            v-if="showDeleteModal"
            @deleted="afterDeleteInvoice"
            @delete-modal-closed="afterHideModal()"
         >
            <template v-slot:body>
               Confirm Delete?
            </template>
         </confirm-delete>
      </div>
   </div>
</template>


<script>
   // import { ValidationObserver, ValidationProvider, extend } from "vee-validate";
   import ConfirmDelete from './Utility/ConfirmDeleteComponent.vue';
   // import { required, max, alpha_dash, numeric } from "vee-validate/dist/rules";
   // import { alpha_space_dash } from '../__custom_validation_rules.js';
   // import { EventBus } from '../__vue_event-bus.js';
   // import { setTimeout } from 'timers';
   import { mapState, mapActions, mapMutations } from 'vuex';
   import Fetch from "@js/components/Fetch.vue";
   import store from "@js/store";
   import { commonMethods } from "@js/mixins/commonMethodMixin.js";

   // extend("required", required);
   // extend("max", max);
   // extend("alpha_dash", alpha_dash);
   // extend("numeric", numeric);

   export default {
      mixins: [commonMethods],
      components: { ConfirmDelete, Fetch },  //ValidationObserver, ValidationProvider, 
      data() {
         return {
            serverResponseData: {},
            invoiceSummaryIdToDelete: null,
            entityType: 'invoiceSummary',
            showDeleteModal: false,
         };
      },

      mounted: async function() {
         try {
            await this.fetchInvoices();
         } catch (error) {
            console.log(error.message);
         }
      },
      computed: {
         ...mapState({
            invoices: state => state.invoiceSummaryStore.invoices,
            items: state => state.itemStore.items,
            stores: state => state.shopStore.stores,
            units: state => state.units,
            selectedInvoiceId: state => state.invoiceSummaryStore.selectedInvoiceId,
            isAuthenticated: state => state.auth.isLoggedIn
         }),
         removeModal: function() {
            return '#remove_invoiceSummary_modal';
         },
      },
      watch: {
         selectedInvoiceId: function(newValue, oldValue) {

            if(newValue && newValue !== oldValue) {
               const selectedInvoice = this.invoices.find(invoice => invoice.id == newValue);
               this.setSelectedInvoice(selectedInvoice);
            }
         }
      },
      methods: {
         ...mapActions('invoiceSummaryStore', ['fetchInvoices']),
         ...mapMutations({
            setSelectedInvoiceId: 'invoiceSummaryStore/SET_SELECTED_INVOICE_ID',
            setSelectedInvoice: 'invoiceSummaryStore/SET_SELECTED_INVOICE'
         }),
         showInvoiceDetails: function(invoice) {
            this.setSelectedInvoiceId(invoice.id);
         },
         confirmDelete: function(invoiceSummaryId) {
            this.invoiceSummaryIdToDelete = invoiceSummaryId;
            this.showDeleteModal = true;
            this.$nextTick(() => {
               $(this.removeModal).modal({
                  backdrop: 'static'
               });
            });
         },
         afterDeleteInvoice: function() {
            this.$toasted.show('Invoice deleted');

            $(this.removeModal).modal('hide');            
            this.$nextTick(() => {
               this.afterHideModal();
            });
         },
      }
   };
</script>
