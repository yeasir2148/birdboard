@extends('layouts.app')

@section('content')
<div class="container">
	<div class="columns">
		<div class="column is-three-fifths">
			<ul class="nav nav-tabs" id="categories_tab" role="tablist">
            <li class="nav-item">
               <a class="nav-link active" id="invoices_tab" data-toggle="tab" href="#invoice_content" role="tab"
                  aria-controls="home" aria-selected="true">Invoice</a>
            </li>
			</ul>
			<div class="tab-content" id="purchase_page_content">
            <div class="tab-pane fade show active" id="invoice_content" role="tabpanel"
               aria-labelledby="invoices_tab">
               <div class="columns">
                  <div class="column">

                  </div>
               </div>
               <div class="columns">
                  <div class="column">
                     <div>
                        @auth
                           <invoice-form :items="items" :units="units" :invoices="invoices"></<invoice-form>
                        @endauth
                        <br>
                        
                        <div class="columns">
                           <div class="column has-text-centered">
                              <h4 class="title is-4">Items</h4>
                           </div>
                           <div class="column is-2 has-text-centered">
                              <div class="toolbar has-text-centered">
                                 <span  class="icon fas fa-sync"></span>
                              </div>            
                           </div>
                        </div>      



                        <div class="columns">
                           Confirm Delete?
                        </div>
                     </div>
                  </div>
               </div>
            </div>
			</div>
		</div>
	</div>
</div>


@stop
