import { httpConfig } from "@js/utils/httpClient";
import Axios from "axios";
import * as CustomExceptions from "@js/Exceptions";

export const namespaced = true;

export const state = {
   subcategories: [],
}

export const mutations = {
   POPULATE_SUBCATEGORIES(state, subcategories) {
      state.subcategories = subcategories;
   },
   ADD_SUBCATEGORY(state, subcategory) {
      state.subcategories.push(subcategory);
   },
   DELETE_SUBCATEGORY(state, subcatId) {
      let subcatIndex = state.subcategories.findIndex((subcat) => subcat.id == subcatId);
      if(subcatIndex >= 0) {
         state.subcategories.splice(subcatIndex, 1);
      } 
   }
}

export const actions = {
   fetchSubcategories(context) {
      Axios(httpConfig.subcategories.getAll)
         .then(response => {
            context.commit('POPULATE_SUBCATEGORIES', response.data.subcategories);
            // context.commit('POPULATE_CATEGORIES', response.data.categories);
         })
   },
   createSubcategory(context, postData) {
      httpConfig.subcategories.create.data = postData;

      return Axios(httpConfig.subcategories.create)
         .then((response) => {
            const {success, data, message} = response.data;
            if (success === true) {
               context.commit('ADD_SUBCATEGORY', data)
            } else {
               // this.form.errorMsg = serverResponseData.message;
            }
         })
   },
   deleteSubcategory(context, subcatId) {
      const { subcategories: {delete: {url}} } = httpConfig;
      const deleteUrl = url.replace('{subcat_id}', subcatId);

      return Axios.delete(deleteUrl)
      .then(({data}) => {
         if(data.success === true) {
            context.commit('DELETE_SUBCATEGORY', subcatId);
         }
      })
   }
}