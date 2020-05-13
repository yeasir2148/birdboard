<template>
   <div>
      <div class="alert alert-success" v-if="form.successMsg && form.successMsg.length">{{form.successMsg}}</div>
      <div class="alert alert-danger" v-if="form.errorMsg && form.errorMsg.length">{{form.errorMsg}}</div>
      <div class="form" v-if="isAuthenticated">
         <ValidationObserver v-slot="observerSlotProp" @submit.prevent="addStore(postData)">
            <form id="createStoreForm">
               <div class="field is-horizontal">
                  <div class="field-label is-normal">
                     <label for="store_name" class="label">Store Name <sup>*</sup></label>
                  </div>
                  <div class="field-body">
                     <div class="field" @focusout="showStoreSuggestion = false" @keyup="filterStores">
                        <div class="control">
                           <validation-provider
                              name="store-name"
                              rules="required|max:100|alpha_space_dash"
                              v-slot="{ errors, classes }">
                              <input
                                 type="text"
                                 class="input"
                                 :class="{ 'is-danger': form.storeName && errors.length}"
                                 name="store_name"
                                 id="store_name"
                                 v-model="form.storeName"
                                 autocomplete="off"
                              >
                              <div class="field-suggest" v-if="showStoreSuggestion">
                                 <ul>
                                    <li>Available stores....</li>
                                    <li 
                                       v-for="store of filteredStores"
                                       :key="store.id"
                                       class="store-suggestion"
                                    >
                                       {{store.store_name}}
                                    </li>
                                 </ul>
                              </div>
                              <span
                                 class="has-text-danger"
                                 v-show="form.storeName && form.storeName.length"
                              >{{ errors[0] }}</span>
                           </validation-provider>
                        </div>
                     </div>
                  </div> 
               </div>

               <!--<div class="field is-horizontal" v-if="false">
                  <div class="field-label is-normal">
                     <label for="store_code" class="label">Store Code</label>
                  </div>
                  <div class="field-body">
                     <div class="field">
                        <div class="control">
                           <validation-provider
                              name="store-code"
                              rules="required|max:50|alpha_dash"
                              v-slot="{ errors }"
                           >
                              <input
                                 type="text"
                                 class="input"
                                 :class="{'is-danger': form.storeCode && errors.length}"
                                 id="store_code"
                                 name="store_code"
                                 v-model="form.storeCode"
                              >
                              <span
                                 class="has-text-danger"
                                 v-show="form.storeCode && form.storeCode.length"
                              >{{ errors[0] }}</span>
                           </validation-provider>
                        </div>
                     </div>
                  </div>
               </div>-->
                              
               <div class="field is-horizontal">
                  <div class="field-label is-normal">
                     <label for="address" class="label">Address</label>
                  </div>
                  <div class="field-body">
                     <div class="field">
                        <div class="control">
                           <validation-provider
                              name="store-address"
                              rules="max:150"
                              v-slot="{ errors, classes }">
                              <textarea rows="3" cols="50"
                                 class="textarea"
                                 :class="{ 'is-danger': form.address && errors.length}"
                                 name="address"
                                 id="address"
                                 v-model="form.address">
                              </textarea>
                              <span class="has-text-danger" v-show="form.address && form.address.length">
                                 {{ errors[0] }}
                              </span>
                           </validation-provider>
                        </div>
                     </div>
                  </div> 
               </div>

               <div class="field is-horizontal">
                  <div class="field-label is-normal">
                     <label for="suburb" class="label">Suburb *</label>
                  </div>
                  <div class="field-body">
                     <div class="field">
                        <div class="control">
                           <validation-provider
                              name="store-suburb"
                              rules="required|max:20"
                              v-slot="{ errors, classes }">
                              <input
                                 class="input"
                                 :class="{ 'is-danger': form.suburb && errors.length}"
                                 name="suburb"
                                 id="suburb"
                                 v-model="form.suburb">
                              </input>
                              <span class="has-text-danger" v-show="form.suburb && form.suburb.length">
                                 {{ errors[0] }}
                              </span>
                           </validation-provider>
                        </div>
                     </div>
                  </div> 
               </div>

               <div class="field is-horizontal">
                  <div class="field-label is-normal">
                     <label for="abn" class="label">ABN</label>
                  </div>
                  <div class="field-body">
                     <div class="field">
                        <div class="control">
                           <validation-provider
                              name="store-abn"
                              rules="max:15"
                              v-slot="{ errors, classes }">
                              <input
                                 type="text"
                                 class="input"
                                 :class="{ 'is-danger': form.storeName && errors.length}"
                                 name="abn"
                                 id="abn"
                                 v-model="form.abn"
                                 autocomplete="off">
                              <span
                                 class="has-text-danger"
                                 v-show="form.abn && form.abn.length">
                                 {{ errors[0] }}
                              </span>
                           </validation-provider>
                        </div>
                     </div>
                  </div> 
               </div>

               <div class="field is-horizontal">
                  <div class="field-label is-normal">
                     <label for="phone" class="label">Phone</label>
                  </div>
                  <div class="field-body">
                     <div class="field">
                        <div class="control">
                           <validation-provider
                              name="store-phone"
                              rules="max:15"
                              v-slot="{ errors, classes }">
                              <input
                                 type="text"
                                 class="input"
                                 :class="{ 'is-danger': form.phone && errors.length}"
                                 name="phone"
                                 id="phone"
                                 v-model="form.phone"
                                 autocomplete="off">
                              <span
                                 class="has-text-danger"
                                 v-show="form.phone && form.phone.length">
                                 {{ errors[0] }}
                              </span>
                           </validation-provider>
                        </div>
                     </div>
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
      </div>

      <br>

      <div class="columns is-vcentered">
         <div class="column has-text-centered">
            <h4 class="title is-4">Stores</h4>
         </div>
         <Fetch class="column is-2 has-text-centered" objectToFetch="stores"></Fetch>

      </div>

      <div class="columns">
         <div class="column">
            <table class="table is-bordered is-hoverable custom-color">
               <thead>
                  <tr>
                     <th class="has-text-centered green">Store Name</th>
                     <th class="has-text-centered green">Store code</th>
                     <th class="has-text-centered green">ABN</th>
                     <th class="has-text-centered green">Phone</th>
                     <th class="has-text-centered green">Suburb</th>
                     <th class="has-text-centered green" v-if="isAuthenticated">Action</th>
                  </tr>
               </thead>

               <tbody>
                  <tr v-for="store in stores" :key="store.id">
                     <td class="has-text-centered">{{ store.store_name }}</td>
                     <td class="has-text-centered">{{ store.store_code }}</td>
                     <td class="has-text-centered">{{ store.abn }}</td>
                     <td class="has-text-centered">{{ store.phone }}</td>
                     <td class="has-text-centered">{{ store.suburb }}</td>
                     <td class="has-text-centered" v-if="isAuthenticated">
                        <button class="fas fa-trash-alt" @click="confirmDelete(store.id)"></button>
                     </td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
      <div class="columns">
         <confirm-delete
            :entityId="storeIdToDelete"
            entityType="store"
            v-if="showDeleteModal"
            @deleted="afterDeleteStore"
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
   import _ from 'lodash';
   import { mapState, mapActions } from 'vuex';
   import Fetch from "@js/components/Fetch.vue";
   import { commonMethods } from "@js/mixins/commonMethodMixin.js";

   extend("required", required);
   extend("max", max);

   export default {
      mixins: [ commonMethods ],
      components: { ValidationObserver, ValidationProvider, ConfirmDelete, Fetch },
      data() {
         return {
            form: {
               status: 'pending',
               storeName: null,
               storeCode: null,
               address: null,
               suburb: null,
               abn: null,
               phone: null,
               successMsg: null,
               errorMsg: null,
               storeSuggestion: null
            },
            storeIdToDelete: null,
            showDeleteModal: false,
            filteredStores: null,
            
         };
      },

      mounted: function() {
         this.fetchStores();
      },

      computed: {
         ...mapState({
            categories: state => state.categoryStore.categories,
            subcategories: state => state.subcategoryStore.subcategories,
            items: state => state.itemStore.items,
            stores: state => state.shopStore.stores,
            isAuthenticated: state => state.auth.isLoggedIn
         }),
         formStatus: function() {
            return this.form.status == 'pending' && this.form.storeName && this.filteredStores.length;
         },
         postData: function() {
            return {
               store_name: this.form.storeName,
               address: this.form.address,
               suburb: this.form.suburb,
               abn: this.form.abn,
               phone: this.form.phone,
            };
         },
         removeModal: function() {
            return '#remove_store_modal';
         },
         showStoreSuggestion: {
            get() {
               return this.form.storeSuggestion && this.form.status == 'pending' 
                  && this.filteredStores.length > 0;
            },
            set(newValue) {
               this.form.storeSuggestion = newValue;
            }            
         }
      },
      watch: {
         stores: function(newValue) {
            this.filteredStores = newValue;
         },
         'form.storeName': function(newVal, oldVal) {

         }
      },
      methods: {
         ...mapActions('shopStore', ['fetchStores','createStore']),
         filterStores: _.debounce(function() {
            this.showStoreSuggestion = true;
            this.filteredStores = this.stores.filter(store => {
               return store.store_name.toLowerCase().includes(this.form.storeName.toLowerCase());
            });
         }, 500),
         addStore: function(postData) {
            this.createStore(postData)
            .then(() => {
               this.$toasted.show('Store added successfully');
               setTimeout(() => this.resetForm(), 1000);
            })
            .catch(errorResponse => {
               this.$toasted.show(errorResponse.message);
            });
         },
         confirmDelete: function(storeId) {
            this.storeIdToDelete = storeId;
            this.showDeleteModal = true;

            this.$nextTick(() => {
               $(this.removeModal).modal({
                  backdrop: 'static'
               });
            });
         },
         afterDeleteStore: function() {
            this.$toasted.show('Store deleted');

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

<style lang="scss">
   .fas.icon {
      line-height: inherit;
      cursor: pointer;
      &:hover {
         background-color: #EDE7E6;
      }
   }
   .field-suggest {
      position: absolute;
      background-color: white;
      z-index: 9999;
      border: 1px solid lightgrey;
      padding: 5px;
      width: 200px;
      border-radius: 5px;
   }
   li.store-suggestion {
      cursor: pointer;
      &:hover {
         background: #FFF8DD;
      }
   }
</style>
