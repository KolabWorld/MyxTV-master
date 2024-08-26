@extends('admin/app')
{{-- Web site Title --}}
@section('title') Sliders :: @parent @stop
@section('content')

	<div class="content-header">
		<div class="container-fluid mt-3">
			<div class="row mb-2">
				<div class="col-sm-12 col-md-12 col-12">
					<div class="tophead">
						<div class="allTitle">
							<a class="d-block d-lg-none" data-widget="pushmenu" href="#" role="button">
								<img src="/assets/admin/img/menu-left-alt.svg" width="18px" />
							</a>
							<h2>
								{{ $heading }} ({{ $sliderData->total() }})</h2>
							<div class="subTitle">Image / Video & Content</div>
						</div>
						<div class="headpanel">
							<div class="setting">
								<a href="#">
									<img src="/assets/admin/img/settings.svg" />
								</a>
							</div>
							<div class="notify">
								<a href="#">
									<img src="/assets/admin/img/notify.svg" />
								</a>
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
							<div class="col-sm-5 col-md-5">
								<div class="filterarea">
									{{-- <div class="sel_all">
										<input class="filled-in" name="group1" type="checkbox" id="news">
										<label for="news" class="text-dark">Select All</label>
									</div> --}}
									<div class="sortlink">
										<a href="#" class="text-dark">
											<img src="/assets/admin/img/filter.svg" /> Sort & Filter
										</a>
									</div>
								</div>
							</div>
							<div class="col-sm-7 col-md-7 textM-right">
								<a href="/admin/home" class="btn btn-auto btn-outline-dark mb-0">Back</a>
								<a class="btn btn-md btn-dark btn-auto mb-0" href="/admin/sliders/create?type={{$type}}">Add New {{ $heading }}</a>
								<div class="searchTb">
									<form action="" method="GET">
										<div class="input-group custom-search">
											<div class="input-group-prepend">
												<span class="input-group-text"><i class="fa fa-search"></i></span>
											</div>
											<input type="text" class="form-control" value="{{ Request::get('search') }}" name="search" placeholder="Search by title" aria-label="title" aria-describedby="basic-addon1">
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>

					<div class="table-responsive">
						<table class="table table-color table-bordered admintable border-0" cellspacing="0" cellpadding="0">
						@foreach ($sliderData as $key => $slider)
							<tr>
								{{-- <td>
									<input class="filled-in" name="group1" type="checkbox" id="news1">
									<label for="news1"></label>
								</td> --}}
								<td>
									<div class="tb_status {{ $slider->status =='active' ? 'dark':'light' }}">{{ $slider->status }}</div>
								</td>
								<td>
									<strong>{{ $slider->type }}</strong>Type
								</td>
								<td>
									<strong>{{ $slider->title }}</strong>Title
								</td>
								<td>
									<strong>{{ $slider->attachment_type }}</strong>Attachment Type
								</td>
								<td>
									@if($slider->attachment_type == 'video')
										<a href="{{$slider->attachment}}" target="new">
											<video muted width="40px" height="40px"  style="object-fit:cover; border: 0.5px solid #7070705a" autoplay="1">
												<source src="{{$slider->attachment}}">
											</video>
										</a>  
									@else
										<a href="{{$slider->attachment}}" target="new">
											<div class="img-wh40 float-left mr-2"><img src="{{$slider->attachment}}" class="mr-2" style="border: 0.5px solid #7070705a;"></div>
										</a> 
									@endif
								</td>
								<td>
								<strong>{{ $slider->is_auto_play ? 'Yes' : 'No' }}</strong>Auto Play
								</td>
								<td>
									<div class="dropdown">
										<a class="admintabledrop btn btn-sm btn-outline-dark" data-toggle="dropdown" href="#" aria-expanded="true">
											More
										</a>
										<div class="dropdown-menu dropdown-menu-md tableaction dropdown-menu-right" style="left: inherit; right: 0px;">
											<ul>
												<li>
													<a href="{{ url('admin/sliders/'.$slider->id.'/edit') }}">View & Edit</a>
												</li>
												<li>
													<a href="#" data-url="/admin/sliders/{{ $slider->id }}" data-request="remove" data-redirect="/admin/sliders?type={{$type}}" >Delete</a>
												</li>
											</ul>
										</div>
									</div>
								</td>
								 
								<!-- <td>
									<a href="{{ url('admin/sliders/'.$slider->id) }}" class="btn btn-sm btn-outline-dark">View Details</a>
								</td> -->
							</tr>
							@endforeach
						 
						</table>
					</div>
					{{ $sliderData->appends(request()->except('page'))->links('admin.layouts.pagination') }}
				</section>

			</div>

		</div>
	</section>

@stop

@section('scripts')
<script src="{{ asset('js/custom-script.js') }}"></script>
<script src="{{ asset('js/sweetalert.js') }}"></script>
<script type="text/javascript"></script>
@stop

@section('styles')
<style type="text/css">
 
</style>
@endsection
