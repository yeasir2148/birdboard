var invoiceDetailStore = {

   state: {
      selectedInvoiceId: null,
      selectedInvoiceDetails: []
   },

   setSelectedInvoiceId(selectedId, comp) {
      console.log('selectedInvoiceId updated by ' + comp + ' with value ' + selectedId);
      this.state.selectedInvoiceId = selectedId;
      // console.log(this.state.selectedInvoiceId);
   },

   setSelectedInvoiceDetails(invoiceDetails, comp) {
      console.log('selectedInvoiceDetails updated by ' + comp + ' with value ' + invoiceDetails);
      this.state.selectedInvoiceDetails = invoiceDetails;
   },

   addSelectedInvoiceDetail(invoiceDetail, comp) {
      console.log('InvoiceDetail added by ' + comp + ' with value ' + JSON.stringify(invoiceDetail));
      this.state.selectedInvoiceDetails.push(invoiceDetail);
   },

   removeInvoiceDetail(invoiceId, deletedInvoiceDetailId, comp) {
      console.log('InvoiceDetail deleted by ' + comp + ' with invoice detail id ' + deletedInvoiceDetailId);
      if (invoiceId === this.state.selectedInvoiceId) {
         this.state.selectedInvoiceDetails = this.state.selectedInvoiceDetails.filter(invDetail => {
            return invDetail.id !== deletedInvoiceDetailId;
         });
      }
   }
};

export { invoiceDetailStore };