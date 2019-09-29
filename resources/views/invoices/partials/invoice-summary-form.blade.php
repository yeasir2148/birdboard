      <div class="alert alert-success" v-if="form.successMsg && form.successMsg.length">{{form.successMsg}}</div>
      <div class="alert alert-danger" v-if="form.errorMsg && form.errorMsg.length">{{form.errorMsg}}</div>
      
      <div class="form">
         <validation-observer v-slot="observerSlotProp" @submit.prevent="createInvoiceSummary">
            <form id="createInvoiceForm">
               <!-- Invoice No -->
               <div class="field is-horizontal">
                  <div class="field-label is-normal">
                     <label for="invoice_no" class="label">Invoice No</label>
                  </div>
                  <div class="field-body">
                     <div class="field">
                        <div class="control">
                           <validation-provider
                              name="Invoice-Number"
                              rules="required"
                              v-slot="{ errors, classes }">
                              <input
                                 type="text"
                                 class="input"
                                 :class="{ 'is-danger': errors.length}"
                                 id="invoice_no"
                                 name="invoice_no"
                                 v-model="form.invoiceNo">
                              <span
                                 class="has-text-danger" v-show="errors.length">
                                 @{{ errors[0] }}
                              </span>
                           </validation-provider>
                        </div>
                     </div>
                  </div>
               </div>
               
               <!--Store -->
               <div class="field is-horizontal">
                  <div class="field-label is-normal">
                     <label for="unit_id" class="label">Store</label>
                  </div>
                  <div class="field-body">
                     <div class="field">
                        <div class="control">
                           <validation-provider
                              name="Store"
                              rules="required|numeric"
                              v-slot="{ errors }">
                              <div class="select">
                                 <select
                                    :class="{'is-danger': errors.length}"
                                    id="store_id"
                                    name="store_id"
                                    v-model="form.storeId">
                                       <option value="" disabled selected>Select Store</option>
                                       <option v-for="store in stores" :key="store.id" :value="store.id">
                                          @{{ store.store_name }}
                                       </option>
                                 </select>
                                 <span class="has-text-danger" v-show="errors.length">
                                    @{{ errors[0] }}
                                 </span>
                              </div>
                           </validation-provider>
                        </div>
                     </div>
                  </div>
               </div>
               <br>
               <!-- Invoice Date -->
               <div class="field is-horizontal">
                  <div class="field-label is-normal">
                     <label for="invoice_date" class="label">Invoice Date</label>
                  </div>
                  <div class="field-body">
                     <div class="field">
                        <div class="control">
                           <validation-provider
                              name="Invoice date"
                              rules="required"
                              v-slot="{ errors }">
                              <input
                                 type="text"
                                 class="input"
                                 :class="{'is-danger': errors.length}"
                                 id="invoice_date"
                                 name="invoice_date"
                                 v-model="form.invoiceDate">
                              <span
                                 class="has-text-danger" v-show="errors.length">
                                    @{{ errors[0] }}
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
         </validation-observer>
      </div>