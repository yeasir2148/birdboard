export const httpConfig = {
   categories: {
      create: {
         method: "post",
         url: "/categories",
         responseType: "json"
      },
      get: {
         method: "get",
         url: "/categories",
         responseType: "json"
      },
      delete: {
         method: "delete",
         url: "/categories/{category_id}",
         params: {
            data: {
               // _token: document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            }
         }         
      }
   },
   subcategories: {
      create: {
         method: "post",
         url: "/subcategory",
         responseType: "json"
      },
      getAll: {
         method: "get",
         url: "/subcategories",
         responseType: "json"
      },
      delete: {
         method: "delete",
         url: "/subcategory/{subcat_id}",
         params: {
            data: {
               // _token: document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            }
         }         
      }
   },
   items: {
      create: {
         method: "post",
         url: "/item",
         responseType: "json"
      },
      getAll: {
         method: "get",
         url: "/items",
         responseType: "json"
      },
      delete: {
         url: "/item/{item_id}",
         params: {
            data: {
               // _token: document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            }
         }         
      }
   },   
   stores: {
      create: {
         method: "post",
         url: "/store",
         responseType: "json"
      },
      getAll: {
         method: "get",
         url: "/stores",
         responseType: "json"
      },
      delete: {
         url: "/store/{store_id}",
         params: {
            data: {
               // _token: document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            }
         }         
      }
   },
   invoiceSummary: {
      getAll: {
         method: "get",
         url: "/invoices",
         responseType: "json"
      },
      get: {
         method: "get",
         url: "/invoice/{invoice_id}",
         responseType: "json"
      },
      create: {
         method: "post",
         url: "/invoice",
         responseType: "json"
      },
      delete: {
         url: "/invoice/{invoice_id}",
         params: {
            data: {
               // _token: document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            }
         }         
      }
   },
   invoiceDetail: {
      getItems: {
         method: "get",
         url: "/invoice/items/{invoice_id}",
         responseType: "json"
      },
      getAll: {
         method: "get",
         url: "/invoice-detail",
         responseType: "json"
      },
      create: {
         method: "post",
         url: "/invoice-detail",
         responseType: "json"
      },
      delete: {
         url: "/invoice-detail/{invoice_detail_id}",
         params: {
            data: {
               // _token: document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            }
         }         
      },
      get: {
         method: "get",
         url: "/invoice-detail/{invoice_detial_id}",
         responseType: "json"
      },
   }
};