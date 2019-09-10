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
							<div class="alert alert-success" v-if="form.successMsg && form.successMsg.length">@{{form.successMsg}}</div>
							<div class="alert alert-danger" v-if="form.errorMsg && form.errorMsg.length">@{{form.errorMsg}}</div>
						</div>
					</div>
					<div class="columns">
						<div class="column">
							<categories @category-added="newCategoryAdded"></categories>
						</div>
					</div>

					<div class="columns">
						<div class="column has-text-centered">
							<h4 class="title is-4">All Categories</h4>
						</div>
					</div>

					<div class="columns">
						<div class="column">
							<table class="table is-bordered is-hoverable">
								<thead>
									<tr>
										<th class="has-text-centered">Name</th>
										<th class="has-text-centered">Action</th>
									</tr>
								</thead>

								<tbody>
									@foreach($categories as $category)
									<tr>
										<td class="has-text-centered">{{ $category->name }}</td>
										<td class="has-text-centered"><span class="btn btn-primary">Edit</span></td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>

				</div>
				<div class="tab-pane fade" id="subcategory_content" role="tabpanel" aria-labelledby="profile-tab">Profile Content
				</div>
				<div class="tab-pane fade" id="food_type_content" role="tabpanel" aria-labelledby="contact-tab">Contact content
				</div>
			</div>
		</div>
	</div>
	
</div>


@stop
