@extends('dashboard.layout.template')

@section('breadcrumb')
<div class="col-12 align-self-center">
	<ol class="breadcrumb">
		{{ Breadcrumbs::render('editblog', $blog) }}
	</ol>
</div>
@endsection

@section('body')
<form class="row" id="update" action="{{route('updateblog', $blog->id)}}">
	@csrf
	<div class="col-12 text-right">
		<div class="form-group">
			<button type="submit" class="btn btn-primary">Save</button>
		</div>
	</div>
	<div class="col-sm-8">
		<div class="card">
			<div class="card-header card-default">
				Create blog
			</div>
			<div class="card-body row">
				<div class="col-7">
					<div class="form-group">
						<label>Title</label>
						<input type="text" name="title" class="form-control" required value="{{$blog->title}}">
					</div>
				</div>
				<div class="col-5">
					<div class="form-group">
						<label>Publish date</label>
						<div class="input-group m-b">
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
							<input type="text" name="published_at" required value="{{$blog->published_at}}" />
						</div>
					</div>
				</div>
				<div class="col-12">
					<div class="form-group">
						<label>Body</label>
						<textarea type="text" class="summernote" >{{$blog->meta->body_html}}</textarea>
						<input type="hidden" name="body_html" value="{{$blog->meta->body_html}}">
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-4">
		<div class="card">
			<div class="card-body">
				<img id="previewFeaturedImage" src="{{$blog->thumbnail->original}}" class="img-fluid mb-2">
				<div class="input-group">
					<span class="input-group-btn">
						<a data-input="originalPath" data-preview="previewFeaturedImage" data-thumbs="thumbnailPath" class="btn btn-primary form-control thumbnail_image">
							<i class="fa fa-picture-o">&nbsp;</i> Choose
						</a>
					</span>
					<input autocomplete="off" id="originalPath" class="form-control" required type="text" name="original" readonly="readonly" value="{{$blog->thumbnail->original}}">
				</div>
				<br>
				<div class="form-group">
					<label>Alt img</label>
					<input type="text" name="alt" class="form-control" required value="{{$blog->thumbnail->alt}}">
				</div>
				{{-- <div class="form-group">
					<label>Category</label>
					<select name="category" class="form-control" required>
						<option disabled selected>--Select--</option>
						@foreach($categories as $category)
							<option value="{{$category->id}}">{{$category->category_name}}</option>
						@endforeach
					</select>
				</div> --}}
				<div class="form-group">
					<label>Tag</label>
					<select id="selectTag" name="tag[]" class="form-control" multiple="multiple">
						@foreach($tags as $tag)
						<option value="{{$tag->id}}">{{$tag->tagname}}</option>
						@endforeach
					</select>
				</div>
			</div>
		</div>
		<div id="updateMeta"></div>
	</div>
</form>
@endsection

@section('script')
	

<script type="text/javascript">
	updateMeta('#updateMeta','{{$blog->meta->path_url}}','{{$blog->meta->meta_title}}','{{$blog->meta->meta_description}}','{{$blog->meta->meta_keyword}}','{{$blog->meta->canonical}}','{{$blog->meta->json_ld}}','{{$blog->meta->noindex}}');
	const tagtemp = [];
	@foreach($blog->tags as $blogTag)
		tagtemp.push({{$blogTag->id}})
	@endforeach
	$('#selectTag').val(tagtemp);
	$('#selectTag').multiselect({
        	columns  : 1,
		    search   : true,
		    selectAll: true,
		    texts    : {
		        placeholder: '--Select--',
		    }
        });
	$('.summernote').summernote({
		height:'400px',
		callbacks: {
		    onKeyup: function(e) {
		      $('input[name="body_html"]').val($(this).summernote('code'));
		    }
		  }
	});
	$('input[name="published_at"]').daterangepicker({
		singleDatePicker: true,
		showDropdowns: true,
		timePicker: true,
		timePicker24Hour:true,
		locale: {
		    format: 'YYYY/MM/DD HH:mm:ss'
		  },
	});
</script>
@endsection