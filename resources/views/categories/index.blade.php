@extends('layouts.app')

@section('content')
<div class="container" v-cloak>
	<div class="columns">
		<div class="column is-three-fifths">
			<ul class="nav nav-tabs" id="inventories_tablist" role="tablist">
            <li class="nav-item">
               <a class="nav-link active" id="category_tab" data-toggle="tab" href="#category_content" role="tab"
                  aria-controls="home" aria-selected="true">Category</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" id="subcategory_tab" data-toggle="tab" href="#subcategory_content" role="tab"
                  aria-controls="profile" aria-selected="false">Sub-category</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" id="items_tab" data-toggle="tab" href="#food_type_content" role="tab"
                  aria-controls="contact" aria-selected="false">Items</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" id="stores_tab" data-toggle="tab" href="#stores_content" role="tab"
                  aria-controls="contact" aria-selected="false">Stores</a>
            </li>
			</ul>
			<div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="category_content" role="tabpanel"
               aria-labelledby="category_tab">
               <div class="columns">
                  <div class="column">

                  </div>
               </div>
               <div class="columns">
                  <div class="column">
                     <categories>
                     </categories>
                  </div>
               </div>
            </div>
            <div class="tab-pane fade" id="subcategory_content" role="tabpanel" aria-labelledby="subcategory_tab">
               <div class="columns">
                  <div class="column">
                  </div>
               </div>
               <div class="columns">
                  <div class="column">
                     <subcategories>
                     </subcategories>
                  </div>
               </div>
            </div>
            <div class="tab-pane fade" id="food_type_content" role="tabpanel" aria-labelledby="items_tab">
               <div class="columns">
                  <div class="column">
                  </div>
               </div>
               <div class="columns">
                  <div class="column">
                     <Items>
                     </Items>
                  </div>
               </div>
            </div>
            <div class="tab-pane fade" id="stores_content" role="tabpanel" aria-labelledby="stores_tab">
               <div class="columns">
                  <div class="column">
                  </div>
               </div>
               <div class="columns">
                  <div class="column">
                     <Stores>
                     </Stores>
                  </div>
               </div>
            </div>
			</div>
      </div>
      
      <!-- <div class="column is-two-fifths">
         
      </div> -->
	</div>
</div>


@stop
