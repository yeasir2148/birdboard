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
                  <div class="column is-two-fifths">
                     <div>
                        @auth
                        <invoice-summary-form :stores="stores" @new-invoice-added="invoices.push($event)"></invoice-summary-form>
                        @endauth

                        <br>
                        <br>

                        <invoice-summary-list :invoices="invoices" :items="items" :stores="stores" :units="units"
                           @invoice-summary-deleted="invoiceSummaryDeleted">
                        @auth
                           <template v-slot:delete-btn="{ invoice, confirmDelete }">
                              <button class="btn btn-danger" @click="confirmDelete(invoice.id)">Delete</button>
                           </template>
                        @endauth
                        </invoice-summary-list>
                     </div>
                  </div>
                  <div class="column is-one-fifth">
                     <!-- This is left empty -->
                  </div>

                  <div class="column is-two-fifths">
                     <invoice-detail-list>
                     @auth
                        <template v-slot:delete-btn="{ invoiceDetail, confirmDelete }">
                           <button class="btn btn-danger" @click="confirmDelete(invoiceDetail.id)">Delete</button>
                        </template>
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
                        <invoice-detail-form :items="items" :stores="stores" 
                           :invoices="invoices"
                           :units="units"
                        >
                        </invoice-detail-form>
                        @endauth

                        <br>
                        <br>

                        <invoice-detail-list>
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
