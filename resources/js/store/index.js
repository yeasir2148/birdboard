import Vue from "vue";
import Vuex from "vuex";
import { httpConfig } from "@js/utils/httpClient";
import * as categoryStore from "@js/store/modules/categoryModule.js";
import * as subcategoryStore from "@js/store/modules/subcategoryModule.js";
import * as itemStore from "@js/store/modules/itemModule.js";
import * as shopStore from "@js/store/modules/shopModule.js";
import * as invoiceSummaryStore from "@js/store/modules/invoiceSummaryModule.js";
import * as invoiceDetailStore from "@js/store/modules/invoiceDetailModule.js";
import Axios from "axios";
import * as CustomExceptions from "@js/Exceptions";

Vue.use(Vuex);

export default new Vuex.Store({
   modules: { categoryStore, subcategoryStore, itemStore, shopStore, invoiceSummaryStore, invoiceDetailStore },
   state: {
      auth: {
         isLoggedIn: false
      },
      units: [],
      selectedInvoiceId: null,
      selectedInvoiceDetails: []
   },   
   mutations: {
      POPULATE_UNITS(state, units) {
         state.units = units;
      },
      LOGIN_USER(state, isLoggedIn) {
         state.auth.isLoggedIn = isLoggedIn;
      }
   },
   actions: {
      checkLoginStatus(context) {
         Axios.get('/is-authenticated')
         .then(({data}) => {
            context.commit('LOGIN_USER', data.is_authenticated)
         })
      }
   }
});