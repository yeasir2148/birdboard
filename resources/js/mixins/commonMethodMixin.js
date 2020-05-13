export const commonMethods = {
   methods: {
      afterHideModal(modalNo) {
         if(modalNo == undefined) {
            this.showDeleteModal = false;
         } else {
            this[`showDeleteModal_${modalNo}`] = false;
         }
      }
   }
}