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
                        <div class="alert alert-success" v-if="form.successMsg && form.successMsg.length">{{form.successMsg}}</div>
                        <div class="alert alert-danger" v-if="form.errorMsg && form.errorMsg.length">{{form.errorMsg}}</div>
                        
                        @auth
                           <InvoicesComponent></<InvoicesComponent>
                        @endauth
                        <br>
                        
                        <div class="columns">
                           <div class="column has-text-centered">
                              <h4 class="title is-4">Items</h4>
                           </div>
                           <div class="column is-2 has-text-centered">
                              <div class="toolbar has-text-centered">
                                 <span @click="fetchItems" class="icon fas fa-sync"></span>
                              </div>            
                           </div>
                        </div>      

                        <div class="columns">
                           <div class="column">
                              <table class="table is-bordered is-hoverable">
                                 <thead>
                                    <tr>
                                       <th class="has-text-centered">Item Name</th>
                                       <th class="has-text-centered">Item Code</th>
                                       <th class="has-text-centered">Subcategory</th>
                                       <th class="has-text-centered" v-if="isAuthenticated">Action</th>
                                    </tr>
                                 </thead>

                                 <tbody>
                                    <tr v-for="item in items" :key="item.id">
                                       <td class="has-text-centered">{{ item.item_name }}</td>
                                       <td class="has-text-centered">{{ item.item_code }}</td>
                                       <td class="has-text-centered">{{ item.subcategory.subcat_name }}</td>
                                       <td class="has-text-centered" v-if="isAuthenticated">
                                          <button class="btn btn-primary" @click="confirmDelete(item.id)">Delete</button>
                                       </td>
                                    </tr>
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
			</div>
		</div>
	</div>
</div>


@stop
