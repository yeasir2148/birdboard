<div class="tab-pane fade show active" id="category_content" role="tabpanel"
   aria-labelledby="category_tab">
   <div class="columns">
      <div class="column">

      </div>
   </div>
   <div class="columns">
      <div class="column">
         <categories :categories="categories" @new-category-added="categories.push($event)"
            @category-deleted="categoryDeleted">
            {{ 'hiiiiii' . Auth::check() }}
            @if(Auth::check())
            <ValidationObserver v-slot="observerSlotProp" @submit.prevent="createCategory">
         <form method="post" action="/categories" id="createCategoryForm">
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
                           name="category-code"
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
            @endif
         </categories>
      </div>
   </div>
</div>