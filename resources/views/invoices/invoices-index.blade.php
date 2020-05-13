@extends('layouts.app')

@section('content')
<div class="container" v-cloak>
	<div class="columns">
		<div class="column">
			<ul class="nav nav-tabs" id="invoices_tablist" role="tablist">
            <li class="nav-item">
               <a class="nav-link active" id="invoices_tab" data-toggle="tab" href="#invoice_summary_content" role="tab"
               aria-controls="home" aria-selected="true">Summary</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" id="invoice_detail_tab" data-toggle="tab" href="#invoice_detail_content" role="tab"
               aria-controls="home" aria-selected="true">Invoice Detail</a>
            </li>
			</ul>
			<div class="tab-content" id="invoices_page_content">
            <div class="tab-pane fade show active" id="invoice_summary_content" role="tabpanel"
               aria-labelledby="invoices_tab">
               <div class="columns">
                  <div class="column is-three-fifths">
                     <div>
                        @auth
                        <invoice-summary-form></invoice-summary-form>
                        @endauth

                        <br>
                        <br>

                        <invoice-summary-list>
                           @auth
                              <template v-slot:delete-btn="{ invoice, confirmDelete }">
                                 <button class="fas fa-trash-alt" @click="confirmDelete(invoice.id)"></button>
                              </template>
                           @endauth
                        </invoice-summary-list>
                     </div>
                  </div>

                  <div class="column is-two-fifths" :class="{ hidden: selectedInvoice === null}" id="invoice_details_on_summary_page">
                     <invoice-detail-list @invoice-detail-removed="refreshInvoice" :modal_no="1">
                        @auth
                        <template v-slot:delete-btn="{ invoiceDetail, confirmDelete }">
                           <button class="fas fa-trash-alt" @click="confirmDelete(invoiceDetail.id, 1)"></button>
                        </template>
                        
                        <!-- <template v-slot:confirm-delete-modal="{ invoiceDetailIdToDelete, entityType }">
                           <div class="columns">
                              <confirm-delete :entity-id="invoiceDetailIdToDelete" :entity-type="entityType" :modal-no="1">
                                 <template v-slot:body>
                                    Confirm Deletion of invoice item?
                                 </template>
                              </confirm-delete>
                           </div>
                        </template> -->
                        @endauth
                     </invoice-detail-list>                     
                  </div>
               </div>
            </div>

            <div class="tab-pane fade" id="invoice_detail_content" role="tabpanel"
               aria-labelledby="invoice_detail_tab">
               <div class="columns">
                  <div class="column is-two-fifths">
                     <div>                        
                        @auth
                        <invoice-detail-form>
                        </invoice-detail-form>
                        @endauth

                        <br>
                        <br>

                        <invoice-detail-list @invoice-detail-removed="refreshInvoice" :modal_no="2">
                           @auth
                           <template v-slot:delete-btn="{ invoiceDetail, confirmDelete }">
                              <button class="fas fa-trash-alt" @click="confirmDelete(invoiceDetail.id, 2)"></button>
                           </template>
                           <!-- <template v-slot:confirm-delete-modal="{ invoiceDetailIdToDelete, entityType }">
                              <div class="columns">
                                 <confirm-delete :entity-id="invoiceDetailIdToDelete" :entity-type="entityType" :modal-no="2">
                                    <template v-slot:body>
                                       Confirm Deletion of invoice item?
                                    </template>
                                 </confirm-delete>
                              </div>
                           </template>
                           @endauth -->
                        </invoice-detail-list>          
                     </div>
                  </div>
               </div>
            </div>


			</div>
      </div>
	</div>
</div>


@stop
