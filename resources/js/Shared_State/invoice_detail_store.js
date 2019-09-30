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

            setSelectedInvoiceDetails(invoiceDetails, comp)  {
               console.log('selectedInvoiceDetails updated by ' + comp + ' with value ' + invoiceDetails);
               this.state.selectedInvoiceDetails = invoiceDetails;
            },

            addSelectedInvoiceDetail(invoiceDetail, comp) {
               console.log('InvoiceDetail added by ' + comp + ' with value ' + invoiceDetail);
               this.state.selectedInvoiceDetails.push(invoiceDetail);
            }
         };

         export { invoiceDetailStore };