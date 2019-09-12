<template>
   <div>
      <ValidationObserver v-slot="observerSlotProp" @submit.prevent="createCategory">
         <form method="post" action="/categories">
            <div class="field is-horizontal">
               <div class="field-label is-normal">
                  <label for="category_name" class="label">Category Name</label>
               </div>
               <div class="field-body">
                  <div class="field">
                     <div class="control">
                        <validation-provider
                           name="category-name"
                           rules="required|max:30|alpha_dash"
                           v-slot="{ errors, classes }"
                        >
                           <input
                              type="text"
                              class="input"
                              :class="{ 'is-danger': form.name && errors.length}"
                              name="name"
                              v-model="form.name"
                           >
                           <span
                              class="has-text-danger"
                              v-show="form.name && form.name.length"
                           >{{ errors[0] }}</span>
                        </validation-provider>
                     </div>
                  </div>
               </div>
            </div>

            <div class="field is-horizontal">
               <div class="field-label is-normal">
                  <label for="category_code" class="label">Category Code</label>
               </div>
               <div class="field-body">
                  <div class="field">
                     <div class="control">
                        <validation-provider
                           name="cateory-code"
                           rules="required|max:30|alpha_dash"
                           v-slot="{ errors }"
                        >
                           <input
                              type="text"
                              class="input"
                              :class="{'is-danger': form.categoryCode && errors.length}"
                              id="category_code"
                              name="category_code"
                              v-model="form.categoryCode"
                           >
                           <span
                              class="has-text-danger"
                              v-show="form.categoryCode && form.categoryCode.length"
                           >{{ errors[0] }}</span>
                        </validation-provider>
                     </div>
                  </div>
               </div>
            </div>

            <div class="field is-horizontal">
               <div class="field-label"></div>
               <div class="field-body">
                  <div class="field">
                     <div class="control">
                        <button
                           class="button is-link"
                           type="submit"
                           :disabled="!observerSlotProp.valid || observerSlotProp.pristine"
                        >Create</button>
                     </div>
                  </div>
               </div>
            </div>
         </form>
      </ValidationObserver>

      <div class="columns">
         <div class="column has-text-centered">
            <h4 class="title is-4">All Categories</h4>
         </div>
      </div>

      <div class="columns">
         <div class="column">
            <table class="table is-bordered is-hoverable">
               <thead>
                  <tr>
                     <th class="has-text-centered">Name</th>
                     <th class="has-text-centered">Category code</th>
                     <th class="has-text-centered">Action</th>
                  </tr>
               </thead>

               <tbody>
                  <tr v-for="category in categories" :key="category.id">
                     <td class="has-text-centered">{{ category.name }}</td>
                     <td class="has-text-centered">{{ category.category_code }}</td>
                     <td class="has-text-centered">
                        <button class="btn btn-primary" @click="deleteCategory(category.id)">Delete</button>
                     </td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
   </div>
</template>


<script>
import { ValidationObserver, ValidationProvider, extend } from "vee-validate";
import { required, email, max, alpha_dash } from "vee-validate/dist/rules";
extend("required", required);
extend("email", email);
extend("max", max);
extend("alpha_dash", alpha_dash);

const httpConfig = {
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
      url: "/categories/{category_id}",
      params: {
         data: {
           _token: document.querySelector('meta[name="csrf-token"]').getAttribute("content")
         }
      }         
   }
};
export default {
   components: { ValidationObserver, ValidationProvider },
   data() {
      return {
         categories:[],
         form: {
            name: null,
            categoryCode: null
         },
         serverResponse: {}
      };
   },

   mounted: function() {
      axios(httpConfig.get)
      .then(({ data }) => {
         if(data.length) {
            this.categories = data;
         }
      });
   },

   computed: {
      postData: function() {
         return {
            name: this.form.name,
            category_code: this.form.categoryCode.toLowerCase(),
            _token: document.querySelector('meta[name="csrf-token"]').getAttribute("content")
         };
      }
   },
   methods: {
      createCategory: function() {
         httpConfig.create.data = this.postData;
         var vm = this;
         axios(httpConfig.create).then(function(response) {
            let data = response.data;
            vm.$emit("category-added", data);
         });

         this.resetForm();
      },

      deleteCategory: function(categoryId) {
         axios.delete(httpConfig.delete.url.replace('{category_id}', categoryId), httpConfig.delete.params)
         .then( response => {
            this.serverResponse = response;
            console.log(this.serverResponse);
            if(response.data.success === true) {
               this.categories = this.categories.filter(category => {
                  return category.id !== categoryId;
               });
            }
            this.$emit('category-deleted', this.serverResponse);
         });
      },

      resetForm: function() {
         for (var key in this.form) {
            this.form[key] = null;
         }
      }
   }
};
</script>