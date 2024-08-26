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
						<h2>Products ({{ $products->total() }})</h2>
						<div class="subTitle">Manage products, categories & attributes</div>
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
								  	<form action="{{ url('admin/products-exports?').Request::getQueryString() }}" id="exportForm" method="GET">
									  <a data-toggle="modal" data-target="#filterModal" class="text-dark"><img src="/assets/admin/img/filter.svg" /> Sort & Filter</a>
									  <input type="hidden" name="filter_ids" id="filterIds">
                                        <a  href="javascript:void(0);" class="text-dark" onclick="exportdata();"><img src="/assets/designer/img/export.svg"  /> Export Products</a>
									</form>
								  </div>
							  </div>
						  </div>
						  <div class="col-sm-12 pl-0 col-md-8 textM-right">
								{{-- <a href="{{ url('admin/custom-size-guides') }}" class="btn btn-md btn-dark btn-auto mb-0 waves-effect waves-light">Custom Sizing Videos</a> --}}
								<a href="{{ url('admin/size-guides') }}" class="btn btn-md btn-dark btn-auto mb-0 waves-effect waves-light">Size Guides</a>
								<a href="{{ url('admin/categories') }}" class="btn btn-md btn-dark btn-auto mb-0 waves-effect waves-light">Categories</a>
								<a href="{{ url('admin/product-attributes') }}" class="btn btn-md btn-dark btn-auto mb-0 waves-effect waves-light">Attributes</a>
								@if(isset($designerId) && ($designerId))
							  		<a class="btn btn-md btn-dark btn-auto mb-0" href="/admin/products/create?designer_id={{$designerId}}">Add New Product</a>
								@else 
									<a class="btn btn-md btn-dark btn-auto mb-0" href="{{ url('admin/products/create') }}">Add New Product</a>
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
						@foreach ($products as $key => $product)
						  <tr>
							  {{-- <td>
								<input class="filled-in checklist" name="checklist[]" type="checkbox" id="check{{$key}}" value="{{$product->id}}">
								<label for="check{{$key}}"></label>
							  </td> --}}
							  <td>
								  <div class="tb_status {{ $product->status =='active' ? 'dark':'light' }}">{{ $product->status }}</div>
							  </td>
							  <td><strong>{{ $product->code }}</strong>Product code</td>
							  <td><strong>{{ $product->title }}</strong>Item</td>
							  <td>
								  <strong>
									@if(count($product->categories)>0)
										@foreach ($product->categories as $key => $category)
											{{ $key == 0 ?'':',' }}{{ $category->name }}
										@endforeach
									@endif
								  </strong>Categories
								</td>
							  <td><strong>
								  @if(count($product->subCategories)>0)
								  @foreach ($product->subCategories as $key => $sub)
									  {{ $key == 0 ?'':',' }}{{ $sub->name }}
								  @endforeach
								  @endif
								</strong>Sub Categories
							  </td>
							  <td><strong>{{ $product->avg_lead_time }}</strong>Lead Time</td>
							  <td><strong>{{ isset($product->varients[0]) ? 'Rs. '.$product->varients[0]->actual_cost :'#NA' }}</strong>Amount</td>
							  <td>
									<div class="dropdown">
										<a class="admintabledrop btn btn-sm btn-outline-dark waves-effect waves-light" data-toggle="dropdown" href="#" aria-expanded="true">
											More
										</a>
										<div class="dropdown-menu dropdown-menu-md tableaction dropdown-menu-right" style="right: 0px; position: absolute; left: 0px; transform: translate3d(-127px, 35px, 0px); top: 0px; will-change: transform;" x-placement="bottom-end">
											<ul>
												<li><a href="{{ url('admin/products/'.$product->id) }}">View Details</a></li>
												<li><a href="{{ url('admin/products/'.$product->id.'/edit') }}">Edit</a></li>
												<li><a href="#" data-url="/admin/products/{{ $product->id }}" data-request="remove" data-redirect="/admin/products">Delete</a></li>
											</ul>
										</div>
									</div>
								</td>
						  </tr>
						@endforeach
					  </table>
				  </div>
				  {{ $products->appends(request()->except('page'))->links('admin.layouts.pagination') }}
			  </section>
		  </div>
	  </div>

				 <!--  <div class="table-responsive">
					  <table class="table table-color table-bordered admintable border-0" cellspacing="0" cellpadding="0">
						@foreach ($products as $key => $product)
						  <tr>
							  <td>
								  <input class="filled-in" name="group1" type="checkbox" id="news1">
								  <label for="news1"></label>
							  </td>
							  <td>
								  <div class="tb_status {{ $product->status =='active' ? 'dark':'light' }}">{{ $product->status }}</div>
							  </td>
							  <td><strong>{{ $product->code }}</strong>Product code</td>
							  <td><strong>{{ $product->title }}</strong>Item</td>
							  <td>
								  <strong>
									@if(count($product->categories)>0)
										@foreach ($product->categories as $key => $category)
											{{ $key == 0 ?'':',' }}{{ $category->name }}
										@endforeach
									@endif
								  </strong>Categories
								</td>
							  <td><strong>
								  @if(count($product->subCategories)>0)
								  @foreach ($product->subCategories as $key => $sub)
									  {{ $key == 0 ?'':',' }}{{ $sub->name }}
								  @endforeach
								  @endif
								</strong>Sub Categories
							  </td>
							  <td>
								  <strong>{{ $product->avg_lead_time }}</strong>Lead Time</td>
							  <td>
								  <strong>$ {{(int)$product->min_cost}} - $ {{(int)$product->max_cost}}</strong>Amount</td>
							  <td>
									<div class="dropdown">
										<a class="admintabledrop btn btn-sm btn-outline-dark waves-effect waves-light" data-toggle="dropdown" href="#" aria-expanded="true">
											More
										</a>
										<div class="dropdown-menu dropdown-menu-md tableaction dropdown-menu-right" style="right: 0px; position: absolute; left: 0px; transform: translate3d(-127px, 35px, 0px); top: 0px; will-change: transform;" x-placement="bottom-end">
											<ul>
												<li><a href="{{ url('admin/products/'.$product->id) }}">View Details</a></li>
												<li><a href="{{ url('admin/products/'.$product->id.'/edit') }}">Edit</a></li>
												<li><a href="#" data-url="/admin/products/{{ $product->id }}" data-request="remove" data-redirect="/admin/products">Delete</a></li>
											</ul>
										</div>
									</div>
								</td>
						  </tr>
						@endforeach
					  </table>
				  </div>
				  {{ $products->appends(request()->except('page'))->links('admin.layouts.pagination') }}
			  </section>
		  </div>
	  </div> -->

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
	window.location.href='/admin/products'
});
</script>
@stop

@section('styles')
<style type="text/css">
 
</style>
@endsection