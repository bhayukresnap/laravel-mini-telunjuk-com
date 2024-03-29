@extends('dashboard.layout.template')

@section('breadcrumb')
<div class="col-12 align-self-center">
	<ol class="breadcrumb">
		{{ Breadcrumbs::render('editcategorieslevel2', $category) }}
	</ol>
</div>
@endsection

@section('body')
<form class="row" id="update" action="{{route('updatecategorieslevel2',$category->id)}}">
	@csrf
	<div class="col-12 text-right">
		<div class="form-group">
			<button type="submit" class="btn btn-primary">Save</button>
		</div>
	</div>
	<div class="col-sm-8">
		<div class="card">
			<div class="card-header card-default">
				Update {{$category->category_name}}
			</div>
			<div class="card-body row">
				<div class="col-6">
					<img id="previewFeaturedImage" src="{{$category->thumbnail->original}}" class="img-fluid mb-2">
					<div class="input-group">
						<span class="input-group-btn">
							<a data-input="originalPath" data-preview="previewFeaturedImage" data-thumbs="thumbnailPath" class="btn btn-primary form-control thumbnail_image">
								<i class="fa fa-picture-o">&nbsp;</i> Choose
							</a>
						</span>
						<input autocomplete="off" id="originalPath" class="form-control" required type="text" name="original" readonly="readonly" value="{{$category->thumbnail->original}}">
					</div>
				</div>
				<div class="col-6">
					<div class="form-group">
						<label>Category Level 1</label>
						<select class="form-control" name="categoryLvl1">
							<option disabled selected>--Select--</option>
							@foreach($category_level_1 as $level1)
								<option value="{{$level1->id}}">{{$level1->category_name}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label>Category name</label>
						<input type="text" name="category_name" class="form-control" required value="{{$category->category_name}}">
					</div>
					<div class="form-group">
						<label>Alt img</label>
						<input type="text" name="alt" class="form-control" required value="{{$category->thumbnail->alt}}">
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-4" id="updateMeta"></div>
</form>
@endsection

@section('script')
<script type="text/javascript">
	updateMeta('#updateMeta','{{$category->meta->path_url}}','{{$category->meta->meta_title}}','{{$category->meta->meta_description}}','{{$category->meta->meta_keyword}}','{{$category->meta->canonical}}','{{$category->meta->json_ld}}','{{$category->meta->noindex}}');
	$('select option[value="{{$category->categoryLvl1}}"]').prop('selected','true');
</script>
@endsection