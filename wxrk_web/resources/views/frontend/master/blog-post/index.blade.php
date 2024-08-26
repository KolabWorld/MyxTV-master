@extends('admin/app')
{{-- Web site Title --}}
@section('title') Dashboard :: @parent @stop
@section('content')

  <div class="content-header">
	<div class="container-fluid mt-3">
		<div class="row mb-2">
			<div class="col-sm-12 col-md-12 col-12">
				<div class="tophead">
					<div class="allTitle">
						<a class="d-block d-lg-none" data-widget="pushmenu" href="#" role="button"><img src="/assets/admin/img/menu-left-alt.svg" width="18px" /></a>
						<h2>Blog Posts ({{ $blogPosts->total() }})</h2>
						<div class="subTitle">Manage Blog Posts & Categories</div>
					</div>
					<div class="headpanel">
						<div class="setting"> 
							<a href="#"><img src="/assets/admin/img/settings.svg" /></a>
						</div>
						<div class="notify">
							<a href="#"><img src="/assets/admin/img/notify.svg" /></a>
						</div>
						<!-- <div class="setting">
							<a href="{{ url('admin/admin-logout') }}"><img src="/assets/admin/img/logout.png" width="23" style="opacity: 0.8"></a>
						</div>  -->
						<div class="adlogo d-inline-block">
							<img src="/assets/frontend/img/logo/logo-black.png">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
  </div>

  <section class="content mb-5">
	  <div class="container-fluid">
		  <div class="row">
			  <section class="col-lg-12 connectedSortable">
				  <div class="tableHead">
					  <div class="row">
						  <div class="col-sm-12 col-md-4">
							  <div class="filterarea">
								  {{-- <div class="sel_all">
									<input class="filled-in" name="group1" type="checkbox" id="checkedAll">
									<label for="checkedAll" class="text-dark">Select All</label>
								  </div> --}}
								  <div class="sortlink">
								  	<form action="{{ url('admin/blog-posts-exports?').Request::getQueryString() }}" id="exportForm" method="GET">
									  <a data-toggle="modal" data-target="#filterModal" class="text-dark"><img src="/assets/admin/img/filter.svg" /> Sort & Filter</a>
									  <input type="hidden" name="filter_ids" id="filterIds">
                                        <a  href="javascript:void(0);" class="text-dark" onclick="exportdata();"><img src="/assets/designer/img/export.svg"  /> Export Products</a>
									</form>
								  </div>
							  </div>
						  </div>
						  <div class="col-sm-12 pl-0 col-md-8 textM-right">
								{{-- <a href="{{ url('admin/custom-size-guides') }}" class="btn btn-md btn-dark btn-auto mb-0 waves-effect waves-light">Custom Sizing Videos</a> --}}
								{{-- <a href="{{ url('admin/size-guides') }}" class="btn btn-md btn-dark btn-auto mb-0 waves-effect waves-light">Size Guides</a> --}}
								<a href="{{ url('admin/blog-categories') }}" class="btn btn-md btn-dark btn-auto mb-0 waves-effect waves-light">Categories</a>
								{{-- <a href="{{ url('admin/blogPost-attributes') }}" class="btn btn-md btn-dark btn-auto mb-0 waves-effect waves-light">Attributes</a> --}}
								@if(isset($designerId) && ($designerId))
							  		<a class="btn btn-md btn-dark btn-auto mb-0" href="/admin/blog-posts/create?designer_id={{$designerId}}">Add New Blog Post</a>
								@else 
									<a class="btn btn-md btn-dark btn-auto mb-0" href="{{ url('admin/blog-posts/create') }}">Add New Blog Post</a>
								@endif
							  <div class="searchTb">
								<form action="" method="GET">
								  <div class="input-group custom-search">
									  <div class="input-group-prepend">
										  <span class="input-group-text"><i class="fa fa-search"></i></span>
									  </div>
									  <input type="text" class="form-control" value="{{ Request::get('search') }}" name="search" placeholder="Search by name" aria-label="Username" aria-describedby="basic-addon1">
								  </div>
								</form>
							  </div>
						  </div>
					  </div>
				  </div>


				  <div class="table-responsive">
					  <table class="table table-color table-bordered admintable border-0" cellspacing="0" cellpadding="0">
						@foreach ($blogPosts as $key => $blogPost)
						  <tr>
							  {{-- <td>
								<input class="filled-in checklist" name="checklist[]" type="checkbox" id="check{{$key}}" value="{{$blogPost->id}}">
								<label for="check{{$key}}"></label>
							  </td> --}}
							  <td>
								  <div class="tb_status {{ $blogPost->status =='active' ? 'dark':'light' }}">{{ $blogPost->status }}</div>
							  </td>
							  <td><strong>{{ $blogPost->title }}</strong>Blog Title</td>
							  <td><strong>{{ $blogPost->description }}</strong>Blog Description</td>
							  <td><strong><img src="{{ $blogPost->featured_image }}" alt="featured_image" height="50px" width="50px"><strong></td>
							  <td>
								  <strong>
									{{ $blogPost->getCategory->name }}
								</strong>Categories
								</td>
							  <td>
									<div class="dropdown">
										<a class="admintabledrop btn btn-sm btn-outline-dark waves-effect waves-light" data-toggle="dropdown" href="#" aria-expanded="true">
											More
										</a>
										<div class="dropdown-menu dropdown-menu-md tableaction dropdown-menu-right" style="right: 0px; position: absolute; left: 0px; transform: translate3d(-127px, 35px, 0px); top: 0px; will-change: transform;" x-placement="bottom-end">
											<ul>
												{{-- <li><a href="{{ url('admin/blog-posts/'.$blogPost->id) }}">View Details</a></li> --}}
												<li><a href="{{ url('admin/blog-posts/'.$blogPost->id.'/edit') }}">Edit</a></li>
												<li><a href="#" data-url="/admin/blog-posts/{{ $blogPost->id }}" data-request="remove" data-redirect="/admin/blog-posts">Delete</a></li>
											</ul>
										</div>
									</div>
								</td>
						  </tr>
						@endforeach
					  </table>
				  </div>
				  {{ $blogPosts->appends(request()->except('page'))->links('admin.layouts.pagination') }}
			  </section>
		  </div>
	  </div>
  </section>
{{-- Filter Modal --}}
<div class="modal fade rightModal" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="edittext" aria-hidden="true">
	<div class="modal-dialog modal-dialog-slideout" role="document">
		<div class="modal-content">
			<form class="needs-validation" novalidate action="" method="GET" id="filterForm">
				<div class="modal-header pt-5 pl-5 pr-5 border-0">
					<div class="popTitle">
						Filter
					</div>
					<div class="float-right">
						<button type="button" class="closebtn" data-dismiss="modal" aria-label="Close">Close <img src="/assets/admin/img/close-line.svg" /></button>
					</div>
				</div>
				<div class="modal-body pt-3 pr-5 pl-5">
					<div class="cancelAppmnt">
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
									<label for="status">Status</label>
									<select class="form-control" id="status" name="status">
										<option value="">Select Status</option>
										@foreach ($status as $value)
											<option value="{{ $value }}" {{ Request::get('status') == $value ? 'selected':'' }}>{{ ucfirst($value) }}</option>
										@endforeach
									</select>
								</div>
							</div>

							<div class="col-sm-6 mt-4">
								<button class="btn btn-outline-dark btn-rounded btn-block my-4 z-depth-0 waves-effect waves-light" type="submit">Filter</button>
							</div>
							<div class="col-sm-6 mt-4">
								<button class="btn btn-dark btn-rounded btn-block my-4 z-depth-0 waves-effect waves-light" type="button" id="reset">Reset</button>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

@stop

@section('scripts')
<script src="{{ asset('js/custom-script.js') }}"></script>
<script src="{{ asset('js/sweetalert.js') }}"></script>
<script type="text/javascript">
$("#reset").click(function() {
	window.location.href='/admin/blog-posts'
});
</script>
@stop

@section('styles')
<style type="text/css">
 
</style>
@endsection