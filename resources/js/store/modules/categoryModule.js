import { httpConfig } from "@js/utils/httpClient";
import Axios from "axios";
import * as CustomExceptions from "@js/Exceptions";

export const namespaced = true;

export const state = {
   categories: [],
}

export const mutations = {
   POPULATE_CATEGORIES(state, categories) {
      state.categories = categories;
   },
   ADD_CATEGORY(state, category) {
      state.categories.push(category);
   },
   DELETE_CATEGORY(state, categoryId) {
      let catIndex = state.categories.findIndex((category) => category.id == categoryId);
      if(catIndex >= 0) {
         state.categories.splice(catIndex, 1);
      }         
   },
}

export const actions = {
   fetchCategories(context) {
      Axios(httpConfig.categories.get)
         .then(response => {
            context.commit('POPULATE_CATEGORIES', response.data)
         })
   },
   createCategory(context, postData) {
      httpConfig.categories.create.data = postData;

      return Axios(httpConfig.categories.create)
      .then((response) => {
         const {success, data, message} = response.data;
         if (success === true) {
            context.commit('ADD_CATEGORY', data)
         } else {
            // this.form.errorMsg = serverResponseData.message;
         }
      })
   },
   deleteCategory(context, subcatId) {
      const { categories: {delete: {url}} } = httpConfig;
      const deleteUrl = url.replace('{category_id}', subcatId);

      return Axios.delete(deleteUrl)
      .then(({data}) => {
         if(data.success === true) {
            context.commit('DELETE_CATEGORY', subcatId);
         }
      })
   },
}