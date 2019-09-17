<template>
   <div>
      <ValidationObserver v-slot="observerSlotProp" @submit.prevent="createCategory">
         <form method="post" action="/subcategories" id="createSubCategoryForm">
            <div class="field is-horizontal">
               <div class="field-label is-normal">
                  <label for="subcategory_name" class="label">Subcategory Name</label>
               </div>
               <div class="field-body">
                  <div class="field">
                     <div class="control">
                        <validation-provider
                           name="category-name"
                           rules="required|max:30|alpha_dash"
                           v-slot="{ errors, classes }">
                           <input
                              type="text"
                              class="input"
                              :class="{ 'is-danger': form.subCategoryName && errors.length}"
                              name="name"
                              v-model="form.subcategoryName">
                           <span
                              class="has-text-danger"
                              v-show="form.subCategoryName && form.subCategoryName.length">
                              {{ errors[0] }}
                           </span>
                        </validation-provider>
                     </div>
                  </div>
               </div>
            </div>

            <div class="field is-horizontal">
               <div class="field-label is-normal">
                  <label for="subcategory_code" class="label">Subcategory Code</label>
               </div>
               <div class="field-body">
                  <div class="field">
                     <div class="control">
                        <validation-provider
                           name="category-code"
                           rules="required|max:30|alpha_dash"
                           v-slot="{ errors }">
                           <input
                              type="text"
                              class="input"
                              :class="{'is-danger': form.subcategoryCode && errors.length}"
                              id="category_code"
                              name="category_code"
                              v-model="form.subcategoryCode">
                           <span
                              class="has-text-danger"
                              v-show="form.subcategoryCode && form.subcategoryCode.length">
                                 {{ errors[0] }}
                           </span>
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
                           :disabled="!observerSlotProp.valid || observerSlotProp.pristine">
                              Create
                        </button>
                     </div>
                  </div>
               </div>
            </div>
         </form>
      </ValidationObserver>

      <div class="columns">
         <div class="column has-text-centered">
            <h4 class="title is-4">All Sub</h4>
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
                  <!-- <tr v-for="category in categories" :key="category.id">
                     <td class="has-text-centered">{{ category.name }}</td>
                     <td class="has-text-centered">{{ category.category_code }}</td>
                     <td class="has-text-centered">
                        <button class="btn btn-primary" @click="deleteCategory(category.id)">Delete</button>
                     </td>
                  </tr> -->
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
               categories: [],
               subCategories:[],
               form: {
                  subcategoryName: null,
                  subcategoryCode: null
               },
               serverResponseData: {}
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
               // _token: document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            };
         }
      },
      methods: {
         createCategory: function() {
            httpConfig.create.data = this.postData;
            var vm = this;

            axios(httpConfig.create)
               .then((response) => {
                  this.serverResponseData = response.data;
                  if(this.serverResponseData.success === true) {
                     this.categories.push(this.serverResponseData.data);
                  }
               })
               .catch(errorResponse => {
                  this.serverResponseData = {
                     success: false,
                     msg: errorResponse.message
                  };
               })
               .finally(() => {
                  this.$emit("category-added", this.serverResponseData);
                  this.resetForm();
               });         
         },

         deleteCategory: function(categoryId) {
            axios.delete(httpConfig.delete.url.replace('{category_id}', categoryId), httpConfig.delete.params)
            .then( response => {
               this.serverResponseData = response.data;

               if(response.data.success === true) {
                  this.categories = this.categories.filter(category => {
                     return category.id !== categoryId;
                  });
               }
            })
            .catch(errorResponse => {
               this.serverResponseData = {
                  success: false,
                  msg: errorResponse.message
               };
            })
            .finally(() => {
               this.$emit('category-deleted', this.serverResponseData);
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