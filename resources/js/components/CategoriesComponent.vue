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
                           v-slot="{ errors, classes }">
                           <input type="text" 
                              class="input"
                              :class="{ 'is-danger': name && errors.length}" 
                              name="name"
                              v-model="name">                           
                           <span class="has-text-danger" v-show="name && name.length">{{ errors[0] }}</span>
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
                           v-slot="{ errors }">
                           <input type="text" 
                              class="input"
                              :class="{'is-danger': categoryCode && errors.length}"
                              id="category_code" name="category_code"
                              v-model="categoryCode">
                           <span class="has-text-danger" v-show="categoryCode && categoryCode.length">{{ errors[0] }}</span>
                        </validation-provider>
                        
                     </div>
                  </div>
               </div>
            </div>

            <div class="field is-horizontal">
               <div class="field-label">
               </div>
               <div class="field-body">
                  <div class="field">
                     <div class="control">
                        <button class="button is-link" 
                           type="submit" 
                           :disabled="!observerSlotProp.valid || observerSlotProp.pristine">Create
                        </button>
                     </div>
                  </div>
               </div>									
            </div>
         </form>
      </ValidationObserver>      
   </div>
</template>


<script>
   import { ValidationObserver, ValidationProvider, extend } from 'vee-validate';

   // Vue.use(VeeValidate);
   import { required, email, max, alpha_dash } from 'vee-validate/dist/rules';
   extend('required', required);
   extend('email', email);
   extend('max', max);
   extend('alpha_dash', alpha_dash);

   const httpConfig = {
      create: {
         method: 'post',
         url: '/categories'
      } 
   }
   export default {
      components: { ValidationObserver, ValidationProvider },
      data() {
         return {
            name: null,
            categoryCode: null,
            form: {
               message: null
            }
         }
      },
      computed: {
         postData: function() {
            return {
               name: this.name,
               category_code: this.categoryCode,
               _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            }
         }
      },
      methods: {
         createCategory: function() {
            console.log(this.postData);
            var vm = this;
            axios[httpConfig.create.method](httpConfig.create.url, this.postData)
               .then(function(response) {
                  let data = response.data;
                  if(data.success) {
                     vm.$emit('category-added',data.data);
                     vm.name = vm.categoryCode = null;
                  }
                  console.log(response);
               });
         }
      }
   }
</script>