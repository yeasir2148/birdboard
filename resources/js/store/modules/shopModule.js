import { httpConfig } from "@js/utils/httpClient";
import Axios from "axios";
import * as CustomExceptions from "@js/Exceptions";

export const namespaced = true;

export const state = {
   stores: [],
}

export const mutations = {
   POPULATE_STORES(state, stores) {
      state.stores = stores;
   },
   ADD_STORE(state, store) {
      state.stores.push(store);
   },
   DELETE_STORE(state, storeId) {
      let storeIndex = state.stores.findIndex((store) => store.id == storeId);
      if(storeIndex >= 0) {
         state.stores.splice(storeIndex, 1);
      }         
   }
}

export const actions = {
   fetchStores(context) {
      Axios(httpConfig.stores.getAll)
         .then(response => {
            context.commit('POPULATE_STORES', response.data);
            // context.commit('POPULATE_CATEGORIES', response.data.categories);
         })
   },
   createStore(context, postData) {
      httpConfig.stores.create.data = postData;

      return Axios(httpConfig.stores.create)
         .then((response) => {
            const {success, data, message} = response.data;
            if (success === true) {
               context.commit('ADD_STORE', data)
            } else {
               throw new CustomExceptions.RecordExistsEception(message);
            }
         })
   },
   deleteStore(context, storeId) {
      const { stores: {delete: {url}} } = httpConfig;
      const deleteUrl = url.replace('{store_id}', storeId);

      return Axios.delete(deleteUrl)
      .then(({data}) => {
         if(data.success === true) {
            context.commit('DELETE_STORE', storeId);
         }
      })
   },
}