import { httpConfig } from "@js/utils/httpClient";
import Axios from "axios";
import * as CustomExceptions from "@js/Exceptions";

export const namespaced = true;

export const state = {
   selectedInvoiceDetails: []
}

export const mutations = {
   SET_SELETECTED_INVOICE_DETAIL(state, detail) {
      state.selectedInvoiceDetails = detail;
   },
   ADD_SELETECTED_INVOICE_DETAIL(state, invItem) {
      state.selectedInvoiceDetails.push(invItem);
   },
   DELETE_INVOICE_DETAIL(state, invDetailId) {
      let invDetailIndex = state.selectedInvoiceDetails.findIndex((invD) => invD.id == invDetailId);
      if(invDetailIndex >= 0) {
         state.selectedInvoiceDetails.splice(invDetailIndex, 1);
      } 
   },
}

export const actions = {
   fetchInvoiceDetails(context, invoiceId) {
      const {invoiceDetail: { getItems: { url } } } = httpConfig;
      const invUrl = url.replace('{invoice_id}', invoiceId);

      Axios.get(invUrl)
      .then(response => {
         context.commit('SET_SELETECTED_INVOICE_DETAIL', response.data.invoice_details);
      })
   },
   createInvoiceDetail(context, postData) {
      httpConfig.invoiceDetail.create.data = postData;

      Axios(httpConfig.invoiceDetail.create)
         .then(({data}) => {
            // this.serverResponseData = response.data;
            if(data.success === true) {
               let relatedInvoice = data.data.model.invoice;
               context.commit('invoiceSummaryStore/SET_SELECTED_INVOICE_ID', data.data.model.invoice_id, { root: true });
               context.commit('invoiceSummaryStore/SET_SELECTED_INVOICE', relatedInvoice, { root: true });
               context.commit('ADD_SELETECTED_INVOICE_DETAIL', data.data.withDetails);
            }
         })
   },
   deleteInvoiceDetail(context, invoiceDetailId) {
      const { invoiceDetail: {delete: { url } } } = httpConfig;
      const deleteUrl = url.replace('{invoice_detail_id}', invoiceDetailId);

      return Axios.delete(deleteUrl)
      .then(({data}) => {
         if(data.success === true) {
            context.commit('DELETE_INVOICE_DETAIL', invoiceDetailId);
            // invoiceDetailStore.removeInvoiceDetail(this.selectedInvoiceId, invoiceDetailId, 'invoice-detail-list component');
            // this.form.successMsg = 'Item removed successfully from Invoice';
            // this.$emit('invoice-detail-removed', this.serverResponseData.invoice);
         }
      })
   },
}