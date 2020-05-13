import { httpConfig } from "@js/utils/httpClient";
import Axios from "axios";
import * as CustomExceptions from "@js/Exceptions";

export const namespaced = true;

export const state = {
   invoices: [],
   selectedInvoiceId: null,
   selectedInvoice: null
}

export const mutations = {
   POPULATE_INVOICES(state, inv) {
      state.invoices = inv;
   },
   ADD_INVOICE(state, inv) {
      state.invoices.push(inv);
   },
   DELETE_INVOICE(state, invId) {
      let invIndex = state.invoices.findIndex((invoice) => invoice.id == invId);
      if(invIndex >= 0) {
         state.invoices.splice(invIndex, 1);
      } 
   },
   SET_SELECTED_INVOICE_ID(state, invId) {
      state.selectedInvoiceId = invId;
   },
   SET_SELECTED_INVOICE(state, inv) {
      state.selectedInvoice = inv;
   },
}

export const actions = {
   fetchInvoices: function(context) {
      Axios(httpConfig.invoiceSummary.getAll)
      .then(({ data }) => {
         console.log(data);

         if(data !== null && data !== 'undefined') {
            context.commit('POPULATE_INVOICES', data.invoices);
            context.commit('itemStore/POPULATE_ITEMS', data.items, {root: true});
            context.commit('shopStore/POPULATE_STORES', data.stores, {root: true});
            context.commit('POPULATE_UNITS', data.units, {root: true});

         }
      });
   },
   createInvoiceSummary: function(context, postData) {
      httpConfig.invoiceSummary.create.data = postData;

      return Axios(httpConfig.invoiceSummary.create)
         .then((response) => {
            const {success, data, message} = response.data;
            if (success === true) {
               context.commit('ADD_INVOICE', data)
            } else {
            }
         });
   },
   deleteInvoiceSummary: function(context, invoiceSummaryId) {
      const { invoiceSummary: {delete: {url}} } = httpConfig;
      const deleteUrl = url.replace('{invoice_id}', invoiceSummaryId);
      return Axios.delete(deleteUrl)
      .then( response => {
         if(response.data.success === true) {
            context.commit('DELETE_INVOICE', invoiceSummaryId);
            context.commit('SET_SELECTED_INVOICE_ID', null);
            context.commit('SET_SELECTED_INVOICE', null);
         }
      })
   },
}