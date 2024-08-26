@extends('admin.app')
@section('content')
@include('admin.users.partials.flash')

<section class="content-header">
    <h1 class="pull-left">
        <b>Place Order for <span style="color: #4a7cad;">{{  $user->name }}</span></b>
    </h1>
</section>
 
<section class="content" style="padding:0px;">
    <div class="row">
        <div class="col-md-12">
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <div class="tab-content">
                    <div class="active tab-pane" id="tab_3" style="border-top: 3px solid #3c8dbc;">
                        <div class="box box-primary">
                            <div class="box-body">
                                <div class="row">
                                    <form role="form">
                                            
                                        <div class="col-sm-3">
                                            <select class="form-control select2" style="float: left;" data-live-search="true" name="product_service_id" id="service_id">
                                                <option value="">Select Service</option>
                                                @foreach($productServices as $service)
                                                <option value="{{$service->id}}" @if($productService && $productService->id == $service->id)
                                                    selected="selected"
                                                    @endif
                                                    >
                                                    {{$service->name}} - {{ $service->is_hidden==1?'In-Active':'Active' }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-2">
                                            <select name="mode" class="form-control cus_ctr" >
                                                <option value="monthly" {{($mode == 'monthly') ? 'selected' : '' }}>
                                                    Monthly
                                                </option>
                                                <option value="quarterly" {{($mode == 'quarterly') ? 'selected' : '' }}>
                                                    Quarterly
                                                </option>
                                                <option value="half-yearly" {{($mode == 'half-yearly') ? 'selected' : '' }}>
                                                    Semi-Annually
                                                </option>
                                                <option value="yearly" {{($mode == 'yearly') ? 'selected' : '' }}>
                                                    Annually
                                                </option>
                                            </select>
                                        </div>

                                        <div class="col-sm-2">
                                            <span class="input-group-btn">
                                                <button type="submit" class="btn btn-info btn-flat" style="color: #000;
    background-color: #bebebe;
    border-color: #9d9d9d;">Go!</button>
                                            </span>
                                        </form>
                                    </div>
                                </div>
                                    
                                @if($productService)
                                <form  method="post">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="product_service_id" value="{{ $productService->id }}">
                                    <div class="row" style="margin-top: 9px;">
                                        <div class="col-md-3 ">
                                        <div class="form-group required {{{ $errors->has('created_at') ? 'has-error' : '' }}}">
                                            <label for="message">
                                                <strong style="font-weight:bold;">Order Date
                                                    
                                                </strong>
                                            </label>
                                            <input type="date" class="form-control" id="input-due_date" name="created_at" required >
                                            {!! $errors->first('created_at', '<label class="control-label"  for="created_at">:message</label>')!!}
                                        </div>
                                        </div>
                                        <div class="col-md-3 ">
                                        <div class="form-group required {{{ $errors->has('created_at') ? 'has-error' : '' }}}">
                                            <label for="message">
                                                <strong style="font-weight:bold;">Exclude Tax
                                                    
                                                </strong>
                                            </label><br/>
                                            <input type="checkbox" name="exclude_tax" value="1" style="padding: 6px 12px;">
                                        </div>
                                        </div>
                                        </div>
                                    <div class="row">
                                        <div class="col-md-6 ">
                                            <div class=" indiv">
                                                <div class="page_header">
                                                    <h2 style="font-size:20px; color: #000;">Product Details:</h2>
                                                </div>
                                            
                                                <div class="box_account">
                                                    <div class="form_container">
                                                        <h3 style="font-size:18px;">
                                                            <strong> {{$productService->name}}</strong>
                                                            @php 
                                                            $unitPrice = 0;
                                                            if($mode == 'monthly')
                                                                $unitPrice = $price->monthly_price;
                                                            elseif($mode == 'quarterly')
                                                                $unitPrice = $price->quarterly_price;
                                                            elseif($mode == 'half-yearly')
                                                                $unitPrice = $price->half_yearly_price;
                                                            elseif($mode == 'yearly')
                                                                $unitPrice = $price->yearly_price;

                                                            @endphp

                                                            {{$currencyAlias}} <input type="text" style="display: initial; width: 14%;" class="form-control" name="price" value="{{$unitPrice}}"> {{$mode}}

                                                        </h3> 
                                                        <ul class="list_ok" style="margin-left: 45px;"> 
                                                            @foreach($productService->attributes as $val)
                                                            <li>{{$val->name}}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                    <!-- /form_container -->
                                                </div>
                                                <div class="box_account">
                                                    <h2 style="font-size:18px; color: #000;">Configurable Options:</h2>
                                                    <p>
                                                        This product/service has some options which you can choose from below to customise your order.
                                                    </p>
                                                   
                                                    <div class="form_container row">
                                                        @foreach($configServices as $service)
                                                        @php
                                                            $optionPrice = 0;
                                                        @endphp
                                                        <div class="col-md-8">
                                                            <span>{{$service->name}}</span>
                                                            <input type="hidden" name="config_group_service_id" value="{{$service->id}}">
                                                            <div class="">
                                                                <div class="form-group">
                                                                    @if($service->option_type == 'dropdown')
                                                                  
                                                                    <select class="form-control cus_ctr" name="serviceOptions[{{$service->id}}]" onchange="setOptionPrice(this, {{$service->id}})">
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

                                                                        @php
                                                                            $opOptionPrice = 0;
                                                                            if($option->price) {
                                                                                if($mode == 'monthly') {
                                                                                    $opOptionPrice = $option->price->monthly_price;
                                                                                }
                                                                                if($mode == 'quarterly') {
                                                                                    $opOptionPrice = $option->price->quarterly_price;
                                                                                }
                                                                                if($mode == 'half-yearly') {
                                                                                    $opOptionPrice = $option->price->half_yearly_price;
                                                                                }
                                                                                if($mode == 'yearly') {
                                                                                    $opOptionPrice = $option->price->yearly_price;
                                                                                }
                                                                            }

                                                                        @endphp
                                                                        <option value="{{$option->id}}" priceattr="{{$opOptionPrice}}">
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

                                                                            @php
                                                                                if($mode == 'monthly') {
                                                                                    $optionPrice = $option->price->monthly_price;
                                                                                }
                                                                                if($mode == 'quarterly') {
                                                                                    $optionPrice = $option->price->quarterly_price;
                                                                                }
                                                                                if($mode == 'half-yearly') {
                                                                                    $optionPrice = $option->price->half_yearly_price;
                                                                                }
                                                                                if($mode == 'yearly') {
                                                                                    $optionPrice = $option->price->yearly_price;
                                                                                }

                                                                            @endphp
                                                                        @endif
                                                                        @break
                                                                        {{$optionPrice}}

                                                                    @endforeach

                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <span>Custom Price {{$optionPrice}}</span>
                                                            <input type="text" name="serviceOptionsPrice[{{$service->id}}]" id="serviceOptionsPrice_{{$service->id}}" value="{{$optionPrice}}">
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

        function setOptionPrice(th, id) {
            var price = $(th).find('option:selected').attr('priceattr');
            $('#serviceOptionsPrice_'+id).val(price)
        }
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
        .nav-tabs-custom {
            margin-bottom: 20px;
            background: #fff;
            box-shadow: 0 0px 0px rgb(0 0 0 / 0%); 
            border-radius: 3px;
        }
        .box {
            position: relative;
            border-radius: 3px;
            background: #e7e7e7;
            border-top: 3px solid #1a4d80;
            border: 1px solid #ccc;
            padding-left: 6px;
            margin-bottom: 20px;
            width: 100%;
            /* box-shadow: 0 1px 1px rgb(0 0 0 / 10%); */
            margin-top: 5px;
            background-color: :#CCC;
            border: 3px 1px 1px 1px solid;
        }
    </style>
@endsection