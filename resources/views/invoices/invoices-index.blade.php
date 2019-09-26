@extends('layouts.app')

@section('content')
<div class="container">
	<div class="columns">
		<div class="column is-two-fifths">
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
                  <div class="column">
                     <div>
                        @auth
                        <invoice-summary-form :items="items" :stores="stores" :invoices="invoices"></invoice-summary-form>
                        <br>
                        @endauth                      
                        <div class="columns">
                           <div class="column has-text-centered">
                              <h4 class="title is-4">Invoices</h4>
                           </div>
                           <div class="column is-2 has-text-centered">
                              <div class="toolbar has-text-centered">
                                 <span  class="icon fas fa-sync"></span>
                              </div>            
                           </div>
                        </div>                    

                        <div class="columns">
                           <div class="column">
                              <table class="table is-bordered is-hoverable">
                                 <thead>
                                    <tr>
                                       <th class="has-text-centered">Invoice No</th>
                                       <th class="has-text-centered">Value</th>
                                       <th class="has-text-centered">Invoice Date</th>
                                       <th class="has-text-centered">Store Name</th>
                                    </tr>
                                 </thead>

                                 <tbody>
                                    @foreach($data['invoices'] as $invoice)
                                    <tr>
                                       <td class="has-text-centered">{{ $invoice->invoice_no }}</td>
                                       <td class="has-text-centered">{{ $invoice->invoice_no }}</td>
                                       <td class="has-text-centered">{{ $invoice->invoice_no }}</td>
                                       <td class="has-text-centered">{{ $invoice->invoice_no }}</td>
                                    </tr>
                                    @endforeach
                                 </tbody>
                              </table>
                           </div>
                        </div>
                        <div class="columns">
                           Confirm Delete?
                        </div>
                     </div>
                  </div>
               </div>
            </div>

            <div class="tab-pane fade" id="invoice_detail_content" role="tabpanel"
               aria-labelledby="invoice_detail_tab">
               <div class="columns">
                  <div class="column">
                     <div>
                        @auth
                        <invoice-detail-form :items="items" :stores="stores" :invoices="invoices" :units="units"></invoice-detail-form>
                        <br>
                        @endauth                      
                 
                     </div>
                  </div>
               </div>
            </div>

			</div>
		</div>
	</div>
</div>


@stop
