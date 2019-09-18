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
					<a class="nav-link" id="food_type_tab" data-toggle="tab" href="#food_type_content" role="tab"
							aria-controls="contact" aria-selected="false">Contact</a>
				</li>
			</ul>
			<div class="tab-content" id="myTabContent">
				<div class="tab-pane fade show active" id="category_content" role="tabpanel" aria-labelledby="home-tab">
					<div class="columns">
						<div class="column">

						</div>
					</div>
					<div class="columns">
						<div class="column">
							<categories></categories>
						</div>
					</div>
				</div>
				<div class="tab-pane fade" id="subcategory_content" role="tabpanel" aria-labelledby="profile-tab">
               <div class="columns">
						<div class="column">
							<div class="alert alert-success" v-if="form.successMsg && form.successMsg.length">@{{form.successMsg}}</div>
							<div class="alert alert-danger" v-if="form.errorMsg && form.errorMsg.length">@{{form.errorMsg}}</div>
						</div>
					</div>
					<div class="columns">
						<div class="column">
							<subcategories></subcategories>
						</div>
					</div>
				</div>
				<div class="tab-pane fade" id="food_type_content" role="tabpanel" aria-labelledby="contact-tab">Contact content
				</div>
			</div>
		</div>
	</div>
	
</div>


@stop
