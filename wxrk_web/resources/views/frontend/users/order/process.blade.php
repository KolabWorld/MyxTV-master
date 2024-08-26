@extends('admin.app')
@section('content')
@include('admin.users.partials.flash')

<section class="content-header">
    <h1 class="pull-left">
    <b>Place Order for <span style="color: #4a7cad;">{{  $user->name }}</span></b>
    </h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12" style="padding-left:0px;">
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <div class="tab-content">
                    <div class="active tab-pane" id="tab_3" style="border-top: 3px solid #3c8dbc;">
                        <div class="box box-primary">
                            <div class="box-body">
                              
                                @if($userCart)
                                <div class=" justify-content-center margin_30">
                                    <div class="col-xl-12 col-lg-12"> 
                                  <strong style="font-weight:bold;">Order Date: </strong> {{ (isset($userCart->created_at) && $userCart->created_at!="")?$userCart->created_at:date('Y-m-d') }} 
                                 <!-- {{ (isset($created_at) && $created_at!="")?$created_at:date('Y-m-d') }}-->
                                        <table class="table cart-list">
                                            <thead>
                                                <tr>
                                                    <th ><strong  style="font-weight:bold;">Description</strong></th>
                                                    <th style="text-align: right !important;"><strong  style="font-weight:bold;">Price</strong></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($userCart->items as $item)
                                                    <tr>
                                                        <td >
                                                            <strong>
                                                                <em>-</em> {{$item->productService->name}}
                                                            </strong> ({{$item->host_name}})<br>
                                                            @foreach($item->productService->attributes as $attribute)
                                                            &nbsp;<span style="font-size:11px;">» {{$attribute->name}}</span><br>
                                                            @endforeach
                                                        </td>
                                                        <td style="text-align: right !important;">
                                                            <strong> <span >{{$userCart->currency->alias}} {{$item->unit_price}}</span></strong>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" style="padding:0px 0px 0px 20px;font-size:12px;">
                                                            <b>Configurable Options
                                                        </td>
                                                    </tr>
                                                    @if($item->configOptions)
                                                        @foreach($item->configOptions as $option)
                                                            <tr>
                                                                <td style="padding:0px 0px 0px 20px;font-size:11px;">
                                                                    <strong>{{$option->configGroupService->name}}:</strong> {{$option->configServiceOption->name}} <br/>
                                                                    {{$option->quantity}} x {{$option->unit_price}}
                                                                </td>
                                                                <td style="font-size:11px;padding:0px 0px 0px 0x;style="text-align: right !important;"">
                                                                    <strong> {{$userCart->currency->alias}} {{$option->total_amount}}</strong>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif

                                                    @if($item->tax_1)
                                                    <tr>
                                                        <td>
                                                            <b>{{$item->tax_1}}</b>
                                                        </td>
                                                        <td style="text-align: right !important;">
                                                            <b>{{$userCart->currency->alias}} {{$item->tax_value_1}} ({{$item->tax_perc_1}}%)</b>
                                                        </td>
                                                    </tr>
                                                    @endif
                                                    @if($item->tax_2)
                                                    <tr>
                                                        <td>
                                                            <b>{{$item->tax_2}}</b>
                                                        </td>
                                                        <td>
                                                            <b>{{$userCart->currency->alias}} {{$item->tax_value_2}} ({{$item->tax_perc_2}}%)</b>
                                                        </td>
                                                    </tr>
                                                    @endif
                                                    <tr><td colspan="2" style="padding: 0px; background-color: #f3f3f3;">&nbsp;</td></tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="row add_top_30 justify-content-space-between  cart_actions">
                                            <div class="col-xs-12 col-sm-6">
                                                <div class="apply-coupon">
                                                    <!--<form action="/add-voucher" method="post">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <div class="form-group form-inline">
                                                            <input type="text" name="voucher_code" value="{{ $userCart->voucher_code }}" placeholder="Promo code" class="form-control">
                                                            <button type="submit" class="btn_1 outline">Apply Coupon</button>
                                                        </div>
                                                        <div class="form-group">
                                                        {!! $errors->first('voucher_code', '<label class="control-label" for="voucher_code" style="color:red">:message</label>')!!}
                                                        </div>
                                                        @if(isset($voucherModel) && $voucherModel)
                                                        <div class="form-group">
                                                            <label class="control-label" for="voucher_code" style="color:green">Voucher Applied Successfully! {{$voucherModel->discount_type}} {{$voucherModel->value}}</label>
                                                        </div>
                                                        @endif
                                                    </form>-->
                                                </div>
                                            </div>
                                          
                                        </div>
                                        <hr>
                                        <div class="box_cart">
                                            <div class="">
                                                <div class="row justify-content-end">
                                                    <div class="col-xs-12 text-right">
                                                        <ul>
                                                            <li>
                                                                <span  style="font-weight:bold;">Subtotal: </span> {{$userCart->currency->alias}} {{number_format(($userCart->total_taxable_amount),2)}}
                                                            </li>
                                                            @if($userCart->total_tax >0)
                                                            <li>
                                                                <span  style="font-weight:bold;">Tax: </span> {{$userCart->currency->alias}} {{number_format(($userCart->total_tax),2)}}
                                                            </li>
                                                            @endif
                                                            <li>
                                                                <span style="font-weight:bold;">Discount: </span> {{$userCart->currency->alias}} {{number_format(($userCart->voucher_amount),2)}}
                                                            </li>
                                                            <li>
                                                                <span  style="font-weight:bold;">Total Recurring: </span> {{$userCart->currency->alias}} {{number_format(($userCart->invoice_total),2)}} {{$userCart->mode}}
                                                            </li>
                                                        </ul>
                                                        <form method="POST" action="/admin/users/{{$user->id}}/checkout-order">
                                                        <input type="hidden" name="cart" value="{{json_encode($userCart)}}" >
                                                        @csrf

                                                        <button type="submit" class="btn btn-primary" style="margin-top:20px;">
                                                            <span class="glyphicon glyphicon-ok-circle"></span>
                                                                Place Order
                                                        </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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