<template>
   <div>
      <div class="form" v-if="isAuthenticated">
         <ValidationObserver v-slot="observerSlotProp" @submit.prevent="addItem(postData)">
            <form id="createItemForm">
               <div class="field is-horizontal">
                  <div class="field-label is-normal">
                     <label for="item_name" class="label">Item Name <sup>*</sup></label>
                  </div>
                  <div class="field-body">
                     <div class="field" @focusout="showItemNameSuggestion = false">
                        <div class="control">
                           <validation-provider
                              name="Item-Name"
                              rules="required|max:50|alpha_space_dash"
                              v-slot="{ errors, classes }">
                              <input
                                 type="text"
                                 class="input"
                                 :class="{ 'is-danger': form.itemName && errors.length}"
                                 id="item_name"
                                 name="item_name"
                                 autocomplete="off"
                                 v-model="form.itemName">
                              <!--<div class="field-suggest" v-if="showItemNameSuggestion">
                                 <ul>
                                    <li>Available items....</li>
                                    <li v-for="item of filteredItems" :key="item.id">{{item.item_name}}</li>
                                 </ul>
                              </div>-->
                              <span
                                 class="has-text-danger"
                                 v-show="form.itemName && form.itemName.length">
                                 {{ errors[0] }}
                              </span>
                           </validation-provider>
                        </div>
                     </div>
                  </div>
               </div>

               <!--<div class="field is-horizontal" v-if="false">
                  <div class="field-label is-normal">
                     <label for="item_code" class="label">Item Code</label>
                  </div>
                  <div class="field-body">
                     <div class="field">
                        <div class="control">
                           <validation-provider
                              name="Item-Code"
                              rules="required|max:30|alpha_dash"
                              v-slot="{ errors }">
                              <input
                                 type="text"
                                 class="input"
                                 :class="{'is-danger': form.itemCode && errors.length}"
                                 id="item_code"
                                 name="item_code"
                                 v-model="form.itemCode">
                              <span
                                 class="has-text-danger"
                                 v-show="form.itemCode && form.itemCode.length">
                                    {{ errors[0] }}
                              </span>
                           </validation-provider>
                        </div>
                     </div>
                  </div>
               </div>-->

               <div class="field is-horizontal">
                  <div class="field-label is-normal">
                     <label for="subcategory_id" class="label">Subcategory <sup>*</sup></label>
                  </div>
                  <div class="field-body">
                     <div class="field">
                        <div class="control">
                           <validation-provider
                              name="Subcategory"
                              rules="required"
                              v-slot="{ errors }">
                              <div class="select">
                                 <select
                                    :class="{'is-danger': form.subCategoryId && errors.length}"
                                    id="subcategory_id"
                                    name="subcategory_id"
                                    v-model="form.subCategoryId">
                                       <option value="" disabled>Please select subcategory</option>
                                       <option v-for="subcat in subcategories" :key="subcat.id" :value="subcat.id">
                                          {{ subcat.subcat_name + ' - ' + subcat.category.name }}
                                       </option>
                                 </select>
                                 <span class="has-text-danger" v-show="errors.length">
                                    {{ errors[0] }}
                                 </span>
                              </div>
                           </validation-provider>
                        </div>
                     </div>
                  </div>
               </div>
               <br>
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
      </div>

      <br>
      
      <div class="columns is-vcentered">
         <div class="column has-text-centered">
            <h4 class="title is-4">Items</h4>
         </div>
         <Fetch class="column is-2 has-text-centered" objectToFetch="items"></Fetch>
      </div>      

      <div class="columns">
         <div class="column">
            <table class="table is-bordered is-hoverable custom-color">
               <thead>
                  <tr>
                     <th class="has-text-centered green">Item Name</th>
                     <th class="has-text-centered green">Item Code</th>
                     <th class="has-text-centered green">Subcategory</th>
                     <th class="has-text-centered green" v-if="isAuthenticated">Action</th>
                  </tr>
               </thead>

               <tbody>
                  <tr>
                     <td class="has-text-centered">
                        <input class="input" type="text" name="search-item-name" 
                           v-model="search.itemName"
                           data-filter="itemName"
                           placeholder="search item"
                           @keyup="filterItems"
                        />
                     </td>
                     <td class="has-text-centered"></td>
                     <td class="has-text-centered">
                        <input class="input" type="text" name="search-item-subcategory" 
                           v-model="search.subcategoryName" 
                           data-filter="subcategoryId"
                           placeholder="search subcategory"
                           @keyup="filterItems"
                        />                     
                     </td>
                     <td v-if="isAuthenticated" class="has-text-centered"></td>
                  </tr>
                  <tr v-for="item in filteredItems" :key="item.id">
                     <td class="has-text-centered">{{ item.item_name }}</td>
                     <td class="has-text-centered">{{ item.item_code }}</td>
                     <td class="has-text-centered" v-if="item.subcategory">{{ item.subcategory.subcat_name }}</td>
                     <td class="has-text-centered" v-if="isAuthenticated">
                        <button class="fas fa-trash-alt" @click="confirmDelete(item.id)"></button>
                     </td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>

      <div class="columns">
         <confirm-delete
            :entityId="itemIdToDelete"
            entityType="item"
            v-if="showDeleteModal"
            @deleted="afterDeleteItem"
            @delete-modal-closed="afterHideModal()"
         >
            <template v-slot:body>
               Confirm Delete?
            </template>
         </confirm-delete>
      </div>
   </div>
</template>


<script>
   import { ValidationObserver, ValidationProvider, extend } from "vee-validate";
   import ConfirmDelete from './Utility/ConfirmDeleteComponent.vue';
   import { required, max, alpha_dash } from "vee-validate/dist/rules";
   import { alpha_space_dash } from '../__custom_validation_rules.js';
   import { EventBus } from '../__vue_event-bus.js';
   import { setTimeout } from 'timers';
   import _ from 'lodash';
   import { mapState, mapActions } from 'vuex';
   import Fetch from "@js/components/Fetch.vue";
   import { commonMethods } from "@js/mixins/commonMethodMixin.js";
   
   extend("required", required);
   extend("max", max);
   extend("alpha_dash", alpha_dash);

   // this should be key => value object where key is the v-model of search field and value is corresponding table
   // column name of the object(i.e.; Item)
   const allowedFilterMapping = {
      itemName: 'item_name',
      subcategoryName: 'subcategory.subcat_name'
   };

   export default {
      mixins: [ commonMethods ], 
      components: { ValidationObserver, ValidationProvider, ConfirmDelete, Fetch },
      data() {
         return {
            form: {
               status: 'pending',
               itemName: null,
               itemCode: null,
               subCategoryId: null,
               itemNameSuggestion: null,
            },
            search: {
               itemName: null,
               subcategoryName: null
            },
            itemIdToDelete: null,
            showDeleteModal: false,
            filteredItems: null
         };
      },

      mounted: function() {
         this.fetchItems();
      },

      computed: {
         ...mapState({
            categories: state => state.categoryStore.categories,
            subcategories: state => state.subcategoryStore.subcategories,
            items: state => state.itemStore.items,
            isAuthenticated: state => state.auth.isLoggedIn
         }),
         postData: function() {
            return {
               item_name: this.form.itemName,
               subcat_id: this.form.subCategoryId,
            };
         },
         removeModal: function() {
            return '#remove_item_modal';
         },
         showItemNameSuggestion: {
            get() {
               return this.form.itemNameSuggestion && this.form.status == "pending" && this.filteredItems.length;
            },
            set(newValue) {
               this.form.itemNameSuggestion = newValue;
            }
         }
      },

      watch: {
         items(newValue) {
            // If already some text in item name box then filter according to that
            if(this.form.itemName) {
               this.filterItems();
            } else if(this.form.subCategoryId) {         // If already subcategory is selected then filter according to that
               let subcatId = this.form.subCategoryId;
               this.form.subCategoryId = null;
               this.form.subCategoryId = subcatId;
            } else {
               this.filteredItems = newValue;
            }               
         },
      },
      methods: {
         ...mapActions('itemStore', ['fetchItems','createItem']),
         filterItems: _.debounce(function(event) {
            let tmp = this.items;

            for(let field in this.search) {
               if(this.search[field] && this.search.hasOwnProperty(field)) {
                  tmp = tmp.filter(item => {
                     switch(field) {
                        case 'itemName':
                           return item.item_name.toLowerCase().includes(this.search[field].toLowerCase());
                           break;
                        case 'subcategoryName':
                           return item.subcategory.subcat_name.toLowerCase().includes(this.search[field].toLowerCase());
                           break;
                     }                     
                  });
               }
               this.filteredItems = tmp;
            }
         }, 500),
         addItem: function(postData) {
            this.createItem(postData)
            .then(() => {
               this.$toasted.show('Item added successfully');
               setTimeout(() => this.resetForm(), 1000);
            })
            .catch(errorResponse => {
               this.$toasted.show(errorResponse.message);
            });
         },
         filter: function(e) {
            console.log(e.target.attributes);
         },
         confirmDelete: function(itemId) {
            this.itemIdToDelete = itemId;
            this.showDeleteModal = true;
            this.$nextTick(() => {
               $(this.removeModal).modal({
                  backdrop: 'static'
               });
            });
         },
         afterDeleteItem: function() {
            this.$toasted.show('Item deleted');

            $(this.removeModal).modal('hide');            
            this.$nextTick(() => {
               this.showDeleteModal = false;
            });
         },
         resetForm: function() {
            for (var key in this.form) {
               this.form.status = 'pending';
               if(key !== 'status') {
                  this.form[key] = null;
               }               
            }
         }
      }
   };
</script>
