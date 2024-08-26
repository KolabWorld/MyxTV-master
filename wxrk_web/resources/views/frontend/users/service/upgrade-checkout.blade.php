@extends('admin.app') 
@section('content')
@include('admin.users.partials.flash')

<section class="content-header" style="padding:2%;">
	<h1 class="pull-left">
		<b>Service Upgrade</b>
	</h1>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<!-- Custom Tabs -->
			<div class="nav-tabs-custom">
				<div class="tab-content">
					<div class="active tab-pane" id="tab_3">
						<div class="box box-primary">
							<div class="box-body">
								@if($productService)
								<form action="/admin/user-service/{{$userService->id}}/upgrade-checkout" method="post">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<input type="hidden" name="product_service_id" value="{{ $productService->id }}">
									<input type="hidden" name="user_service_id" value="{{ $userService->id }}">
									<input type="hidden" name="currency_id" value="{{ $currency->id }}">
									<input type="hidden" name="mode" value="{{ $mode }}">
									<input type="hidden" name="productUnitPrice" value="{{ $productUnitPrice }}">
									<div class="row">
										<div class="col-md-6">
                                            <div class="page_header">
                                                <h2>Current Plan Configuration</h2>
                                            </div>
                                            <div class="box_account">
                                                <div class="form_container">
                                                    <h3>
                                                        <strong> - {{$userService->product_service_name}}</strong>
                                                            {{$currencyAlias}} {{$userService->unit_price}} {{$mode}}
                            
                                                    </h3>
                                                    <ul class="list_ok">
                                                        @foreach($userService->product_service_attributes as $val)
                                                            <li>{{$val['name']}}</li>
                                                        @endforeach	
                                                    </ul>
                                                </div>
                                                <!-- /form_container -->
                                            </div>

                                            @if($userService->configOptions)
                                            <div class="box_account">
                                                <div class="form_container">
                                                    <h3>
                                                        Config Options:
                            
                                                    </h3>
                                                    <ul class="list_ok">
                                                        @foreach($userService->configOptions as $val)
                                                            <li><b>{{$val->config_group_service_name}}</b> : {{$val->quantity}} x {{$val->config_service_option_name}}</li>
                                                        @endforeach	
                                                    </ul>
                                                </div>
                                                <!-- /form_container -->
                                            </div>
                                            @endif

                                            <div class="page_header">
                                                <h4>
                                                    <b>Due Date</b> : {{date('d M Y', strtotime($userService->due_date))}}
                                                </h4>
                                                <h4>
                                                    <b>Remaining Days</b> : {{$remainingDays}} Days
                                                </h4>
                                                <h4>
                                                    <b>Adjustable Amount</b> : {{$currencyAlias}} {{$adjustableAmount}}
                                                </h4>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="page_header">
                                                <h2>Upgradable Product Configuration</h2>
                                            </div>
                                            <div class="box_account">
                                                <div class="form_container">
                                                    <h3>
                                                        <strong> - {{$productService->name}}</strong>
                                                        @if($price) 
                                                            @if($mode == 'monthly')
                                                                {{$currencyAlias}} {{$price->monthly_price}} Monthly
                                                            @elseif($mode == 'quarterly')
                                                                {{$currencyAlias}} {{$price->quarterly_price}} Quarterly
                                                            @elseif($mode == 'half-yearly')
                                                                {{$currencyAlias}} {{$price->half_yearly_price}} Semi-Annually
                                                            @elseif($mode == 'yearly')
                                                                {{$currencyAlias}} {{$price->yearly_price}} Annually
                                                            @endif
                                                        @endif
                            
                                                    </h3>
                                                    <ul class="list_ok">
                                                        @foreach($productService->attributes as $val)
                                                            <li>{{$val->name}}</li>
                                                        @endforeach	
                                                    </ul>
                                                </div>
                                                <!-- /form_container -->
                                            </div>
                                            <div class="page_header">
                                                <h4>
                                                    <b>Remaining Days</b> : {{$remainingDays}} Days
                                                </h4>
                                                <h4>
                                                    <b>Product Price</b> : {{$currencyAlias}} {{$newPrice}}
                                                    <input type = "hidden" name="unit_price" value="{{$newPrice}} ">
                                                </h4>
                                            </div>
                                            <div class="box_account">
                                                <h2>Configurable Options</h2>
                                                <p>
                                                    This product/service has some options which you can choose from below to customise your order.
                                                </p>
                                                <div class="form_container">
                                                    <input type="hidden" name="config_options" value="{{json_encode($configOptions)}}" >
                                                    @foreach($configOptions as $val)
                                                        <div class="server-info justify-content-space-between">
                                                            <b>{{$val['config_group_service_name']}}</b> : {{$val['config_service_option_name']}} =>  {{$val['unit_price']}} X {{$val['quantity']}} = {{$val['total_amount']}}
                                                        </div>
                                                    @endforeach	
                                                </div>
                                            </div>
                                            <div class="page_header">
                                                <h4>
                                                    <b>Final Cost</b> : {{$totalPrice}} <br/>
                                                    <b>Payable Cost</b> : {{$payableAmount}} 
                                                    <input type="hidden" name="config_total" value="{{$configTotal}}">
                                                    <input type="hidden" name="sub_total" value="{{$totalPrice}}">
                                                    <input type="hidden" name="total_amount" value="{{$totalPrice}}">
                                                    <input type="hidden" name="amount_recieved" value="{{$adjustableAmount}}">
                                                    <input type="hidden" name="amount_pending" value="{{$payableAmount}}">
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                    <input class="btn btn-success pull-right" type="submit" value="Upgrade">
                                </form>	
								@endif
							</div>
						</div>
					</div>
				</div>
				<!-- /.tab-content -->
			</div>
			<!-- nav-tabs-custom -->
		</div>
		<!-- /.col -->
	</div>
</section>

@stop 
@section('scripts')
@endsection

@section('styles')
<style>
	.search-con {
		min-width: 250px;
	}
	.profile-margin {
		float: left;
		width: 100%;
		padding-left: 15px;
		padding-right: 15px;
	}
	.link-btn {
		margin: 0;
	}
	.link-btn li{
		background-color: #3a638b;
		color: #fff;
		padding: 2px 15px;
		border-radius: 5px;
	}
	.link-btn li a.no{ color: #ff9191;}
	.link-btn li a.yes{color: #c5ff97;}
	.cus_col {
		float: left;
		width: 100%;
		margin-top: 20px;
		display: flex;
	}
	.cus_col h4{ margin-bottom: 0;}
	.box-body .form-group .checkbox {
		margin-top: 0;
	}

</style>
@endsection