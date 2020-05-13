import { httpConfig } from "@js/utils/httpClient";
import Axios from "axios";
import * as CustomExceptions from "@js/Exceptions";

export const namespaced = true;

export const state = {
   items: [],
}

export const mutations = {
   POPULATE_ITEMS(state, items) {
      state.items = items;
   },
   ADD_ITEM(state, item) {
      state.items.push(item);
   },
   DELETE_ITEM(state, itemId) {
      let itemIndex = state.items.findIndex((item) => item.id == itemId);
      if(itemIndex >= 0) {
         state.items.splice(itemIndex, 1);
      } 
   }
}

export const actions = {
   fetchItems(context) {
      Axios(httpConfig.items.getAll)
      .then(({ data }) => {
         if(data !== null && data !== 'undefined') {
            context.commit('POPULATE_ITEMS', data.items);
            // context.commit('POPULATE_SUBCATEGORIES', data.subcategories);
            // context.commit('POPULATE_CATEGORIES', data.categories);
         }
      });
   },
   createItem(context, postData) {
      httpConfig.items.create.data = postData;

      return Axios(httpConfig.items.create)
         .then((response) => {
            const {success, data, message} = response.data;
            if (success === true) {
               context.commit('ADD_ITEM', data)
            } else {
               // this.form.errorMsg = serverResponseData.message;
            }
         })
   },
   deleteItem(context, itemId) {
      const { items: {delete: {url}} } = httpConfig;
      const deleteUrl = url.replace('{item_id}', itemId);

      return Axios.delete(deleteUrl)
      .then(({data}) => {
         if(data.success === true) {
            context.commit('DELETE_ITEM', itemId);
         }
      })
   },
}