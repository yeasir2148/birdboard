@extends('layouts.app')

@section('content')
<div class="container">
	<div class="columns">
		<div class="column is-three-fifths">
			<ul class="nav nav-tabs" id="categories_tab" role="tablist">
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
								<categories :categories="categories" @new-category-added="categories.push($event)"
                           @category-deleted="categoryDeleted"
                           :is-logged-in="<?= json_encode(Auth::check()) ?>">
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
								<subcategories :categories="categories" :subcategories="subcategories"
									@new-subcategory-added="subcategories.push($event)"
                           @subcategory-deleted="subcategoryDeleted"
                           :is-logged-in="<?= json_encode(Auth::check()) ?>">
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
									<Items :items="items" :categories="categories" :subcategories="subcategories"
                              @new-item-added="items.push($event)" @item-deleted="itemDeleted"
                              :is-logged-in="<?= json_encode(Auth::check()) ?>">
									</Items>
							</div>
						</div>
					</div>
			</div>
		</div>
	</div>
</div>


@stop
