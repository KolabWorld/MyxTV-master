@extends('admin.app')
<!-- Main Container  -->
@section('content')
@include('admin.partials.header',['title'=>'Portfolios','description'=>'Manage & update'])

<section class="content mb-5">
	<div class="container-fluid">
		<div class="row">
			<section class="col-lg-12 connectedSortable">
				<div class="tableHead">
					<div class="row">
						<div class="col-sm-5 col-md-5">
							&nbsp;
						</div>
						<div class="col-sm-7 col-md-7 textM-right">
							<button onclick="javascript:history.back()" class="btn btn-md mb-0 btn-auto btn-outline-dark">Back</button>
							<a class="btn btn-md mb-0 btn-auto btn-dark" href="{{ url('admin/designer/'.$designer->id.'/portfolios/create') }}">Add New Portfolio</a>
							<div class="searchTb">
								<form accept="" method="GET">
									<div class="input-group custom-search">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="fa fa-search"></i></span>
										</div>
										<input type="text" class="form-control" name="search" placeholder="Search" aria-label="Search" value="{{ Request::get('search') }}" aria-describedby="basic-addon1">
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
									
						<div class="table-responsive">
							<table class="table table-color table-bordered admintable border-0 mb-2" cellspacing="0" cellpadding="0">
								<tbody>
								<tr>
									<td class="bg-white pl-0">
										<div>
											<h3 class="f-18 playfair mb-1">Featured Image</h3>
											<h3 class="f-12 theme-Ltext playfair">Header & dashboard</h3>
											 
										</div>
									</td>
										
									<td class="pl-5">
										@if($featuredImage)
										<div class="tb_status {{$featuredImage->status=='active'?'dark':'light'}}">{{ucfirst($featuredImage->status)}}</div>
										@else
										<div class="tb_status light">Inactive<div>
										@endif
									</td>
									<td><strong>Image</strong>Type</td>
									<td>
										@if($featuredImage)
										<div class="img-wh40"><img src="{{$featuredImage->attachment}}" style="border: 0.5px solid #7070705a;"></div>
										@else
										<div class="img-wh40"><img src="/assets/admin/img/image2.svg" style="border: 0.5px solid #7070705a;"></div>
										@endif
									</td>
									<td class="textM-right">
										<a href="{{ url('admin/designer/'.$designer->id.'/featured-portfolios') }}" class="btn btn-sm btn-outline-dark">View Details</a>
									</td>
								</tr>


								<tr>
									<td class="bg-white pl-0">
										<div>
											<h3 class="f-18 playfair mb-1">Featured Video</h3>
											<h3 class="f-12 theme-Ltext playfair">On portfolio page</h3>
											 
										</div>
									</td>
										
									<td class="pl-5">
										@if($featuredVideo)
											<div class="tb_status {{$featuredVideo->status=='active'?'dark':'light'}}">{{ucfirst($featuredVideo->status)}}</div>
										@else
											<div class="tb_status light">Inactive<div>
										@endif
									</td>
									<td><strong>Video</strong>Type</td>
									<td>
										@if($featuredVideo)
										<video width="40px" height="40px" autoplay=0 muted style="object-fit: cover; border: 0.5px solid #7070705a;">
											<source src="{{$featuredVideo->attachment}}">
										</video>
										@else
										<div class="img-wh40"><img src="/assets/admin/img/image2.svg" style="border: 0.5px solid #7070705a;"></div>
										@endif
									</td>
									<td class="textM-right">
										<a href="{{ url('admin/designer/'.$designer->id.'/featured-portfolios') }}" class="btn btn-sm btn-outline-dark">View Details</a>
									</td>
								</tr>
							
							</tbody>
						</table>
						</div>
					
					</div>
				</div>

				<div class="mb-4">
					<div class="border-top"></div>
				</div>


				<div class="table-responsive">
					<table class="table table-color table-bordered admintable border-0" cellspacing="0" cellpadding="0">

						@foreach($portfolios as $portfolio)
						<tr>
							<td>
								<input class="filled-in" name="group1" type="checkbox" id="news1">
								<label for="news1"></label>
							</td>
							<td>
								<div class="tb_status {{$portfolio->status=='active'?'dark':'light'}}">{{ucfirst($portfolio->status)}}</div>
							</td>
							<td><strong>{{ucfirst($portfolio->title)}}</strong>Portfolio</td>
							<td><strong>{{ucfirst($portfolio->attachment_type)}}</strong>Type</td>
							<td>
								@if($portfolio->attachment_type == 'video')
								<video width="40px" height="40px" autoplay=1 muted style="object-fit: cover; border: 0.5px solid #7070705a;">
									<source src="{{$portfolio->attachment}}">
								</video>
								@else
								<div class="img-wh40"><img src="{{$portfolio->attachment}}" style="border: 0.5px solid #7070705a;"></div>
								@endif

							</td>
							<td>&nbsp;</td>
							<!--<td><strong class="f-13"><i class="fa fa-exclamation-circle f-16 text-danger"></i> Duplicate Image / Portfolio Exists</strong></td>-->
							<td class="textM-right">
								<a href="{{ url('admin/designer/'.$designer->id.'/portfolios/'.$portfolio->id.'/edit') }}" class="btn btn-sm btn-outline-dark">View Details</a>
							</td>
						</tr>
						@endforeach
					</table>
				</div>

				{{ $portfolios->appends(request()->except('page'))->links('admin.layouts.pagination') }}

			</section>

		</div>

	</div>
</section>

@endsection