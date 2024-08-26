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
                                <div class="row">
                                    <div class="col-sm-5">
                                        <!-- form start -->
                                        <form role="form">
                                            <div class="input-group input-group-sm">
                                                <select class="form-control select2" data-live-search="true" name="product_service_id" id="service_id">
                                                    <option value="">Select Service</option>
                                                    @foreach($productServices as $service)
                                                    <option value="{{$service->id}}" @if($productService && $productService->id == $service->id)
                                                        selected="selected"
                                                        @endif
                                                        >
                                                        {{$service->name}}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <span class="input-group-btn">
                                                    <button type="submit" class="btn btn-info btn-flat">Go!</button>
                                                </span>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                @if($productService)
                                <form action="/admin/user-service/{{$userService->id}}/upgrade" method="post">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="product_service_id" value="{{ $productService->id }}">
                                    <div class="row">
                                        <style>
                                            .indiv {
                                                background-color: #f1f1f1;
                                            }

                                            .indiv h2 {
                                                font-size: 19px;
                                                border: 1px solid #e0d6d6 !important;
                                                padding: 3px;
                                                font-weight: bold;
                                            }

                                            .indiv h3 {
                                                font-size: 14px;
                                                padding: 3px;
                                                font-weight: 700;
                                            }

                                            .indiv h4 {
                                                font-size: 14px;
                                                font-weight: 700;
                                            }

                                            .list_ok {
                                                padding-left: 13px;
                                                list-style: inside;
                                            }
                                        </style>
                                        <div class="col-md-6 ">
                                            <div class=" indiv">
                                                <div class="page_header">
                                                    <h2>Current Plan</h2>
                                                </div>
                                                <div class="box_account">
                                                    <div class="form_container">
                                                        <h3>
                                                            - {{$userService->product_service_name}}
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
                                        </div>
                                        <div class="col-md-6 ">
                                            <div class=" indiv">
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
                                                <div class="box_account">
                                                    <h2>Configurable Options</h2>
                                                    <p>
                                                        This product/service has some options which you can choose from below to customise your order.
                                                    </p>
                                                    <div class="form_container">
                                                        @foreach($configServices as $service)
                                                        <div class="server-info justify-content-space-between">
                                                            <span>{{$service->name}}</span>
                                                            <input type="hidden" name="config_group_service_id" value="{{$service->id}}">
                                                            <div class="d-flex">
                                                                <div class="form-group">
                                                                    @if($service->option_type == 'dropdown')
                                                                    <select class="form-control cus_ctr" name="serviceOptions[{{$service->id}}]">
                                                                        <?php
                                                                        $flg = "None";
                                                                        if ($service->name == "Microsoft Office") {
                                                                            $flg = "No";
                                                                            echo '<option value="">No</option>';
                                                                        } else if ($service->name != "Operating System") { ?>
                                                                            <option value=""><?php echo $flg; ?> 0.00 /
                                                                            <?php if ($mode == 'monthly') {
                                                                                    echo "mo";
                                                                                } else if ($mode == 'quarterly') {
                                                                                    echo "quarterly";
                                                                                } else if ($mode == 'half-yearly') {
                                                                                    echo "half yearly";
                                                                                } else if ($mode == 'yearly') {
                                                                                    echo "yearly";
                                                                                } ?>
                                                                            </option>
                                                                        <?php } ?>
                                                                        @foreach($service->options as $option)
                                                                        <option value="{{$option->id}}">
                                                                            {{$option->name}}
                                                                            @if($option->price)
                                                                            @if($mode == 'monthly')
                                                                            {{$option->price->monthly_price}} /mo
                                                                            @endif
                                                                            @if($mode == 'quarterly')
                                                                            {{$option->price->quarterly_price}} /quarterly
                                                                            @endif
                                                                            @if($mode == 'half-yearly')
                                                                            {{$option->price->half_yearly_price}} /half yearly
                                                                            @endif
                                                                            @if($mode == 'yearly')
                                                                            {{$option->price->yearly_price}} /yearly
                                                                            @endif
                                                                            @endif
                                                                        </option>
                                                                        @endforeach
                                                                    </select>
                                                                    @endif
                                                                    @if($service->option_type == 'quantity')
                                                                    <input type="number" name="serviceOptions[{{$service->id}}]">
                                                                    @foreach($service->options as $option)
                                                                    {{$option->name}}
                                                                    @if($option->price)
                                                                    @if($mode == 'monthly')
                                                                    {{$option->price->monthly_price}} /mo
                                                                    @endif
                                                                    @if($mode == 'quarterly')
                                                                    {{$option->price->quarterly_price}} /quarterly
                                                                    @endif
                                                                    @if($mode == 'half-yearly')
                                                                    {{$option->price->half_yearly_price}} /half yearly
                                                                    @endif
                                                                    @if($mode == 'yearly')
                                                                    {{$option->price->yearly_price}} /yearly
                                                                    @endif
                                                                    @endif
                                                                    @endforeach
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input class="btn btn-success" type="submit" value="Proceed">
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
	@parent
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
	<script type="text/javascript">
        $(document).ready(function(){
			$( ".select2" ).select2();
		});
	</script>
@endsection 

@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

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

        .link-btn li {
            background-color: #3a638b;
            color: #fff;
            padding: 2px 15px;
            border-radius: 5px;
        }

        .link-btn li a.no {
            color: #ff9191;
        }

        .link-btn li a.yes {
            color: #c5ff97;
        }

        .cus_col {
            float: left;
            width: 100%;
            margin-top: 20px;
            display: flex;
        }

        .cus_col h4 {
            margin-bottom: 0;
        }

        .box-body .form-group .checkbox {
            margin-top: 0;
        }
    </style>
@endsection