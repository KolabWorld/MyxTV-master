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
                        <h2>{{ $customer->name }}</h2>
                        <div class="subTitle">Details</div>
                    </div>
                    <div class="headpanel">
                        <div class="setting">
                            <a href="account-setting.html"><img src="/assets/admin/img/settings.svg" /></a>
                        </div>									
                        <div class="notify">
                            <a href="#"><img src="/assets/admin/img/notify.svg" /></a>
                        </div>
                        {{-- <div class="setting">
                            <a href="login.html"><img src="/assets/admin/img/logout.png" width="23" style="opacity: 0.8" /></a>
                        </div> --}}
                        <div class="adlogo d-inline-block"><img src="/assets/admin/img/logo.svg" /></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-12">
                <div class="backbtnPanel">
                    <div><a href="javascript:history.back()" class="btn btn-sm btn-auto btn-outline-dark">Back</a></div>
                    <div><a href="/admin/customer/{{ $customer->id }}/sales-trend" class="btn btn-sm btn-dark btn-auto">View Customer Trend</a></div>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="content mb-5">
    <div class="container-fluid">
        <div class="row">
            <section class="col-lg-8 connectedSortable">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="myordersData">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="mb-4">
                                        <div class="border-top"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="ordeRow1 f-15 playfair">
                                        <div>Customer Id# CU000{{ $customer->id }}
                                            <br>Joined on: {{ dateFormat($customer->created_at) }}
                                        </div>
                                        <div class="mt-auto textM-right">
                                            Email Id# {{ $customer->email }}<br/>
                                            Contact# {{ $customer->mobile }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row pt-4">
                                <div class="col-6 col-sm-6 col-md-3 col-lg-3">
                                    <h6 class="playfair">Shipping details</h6>
                                    <div class="theme-Ltext normal-line-height">
                                        @if($customer->shippingAddress)
                                        {{ $customer->shippingAddress ? $customer->shippingAddress->name :'-' }} <br/>
                                        {{ $customer->shippingAddress ? $customer->shippingAddress->line_1:'-' }}<br/>
                                        {{ $customer->shippingAddress ? $customer->shippingAddress->postal_code:'' }}, {{ $customer->shippingAddress ? $customer->shippingAddress->city:'' }}<br/>
                                        <strong class="font-weight-Mbolder">{{ isset($customer->shippingAddress->country) ? $customer->shippingAddress->country->name:'-' }}</strong>
                                        @endif
                                    </div>
                                </div> 
                                <div class="col-6 col-sm-6 col-md-3 col-lg-3">
                                    <h6 class="playfair">Billing details</h6>
                                    <div class="theme-Ltext normal-line-height">
                                    @if($customer->billingAddress)
                                        {{ $customer->billingAddress ? $customer->billingAddress->name :'-' }} <br/>
                                        {{ $customer->billingAddress ? $customer->billingAddress->line_1:'-' }}<br/>
                                        {{ $customer->billingAddress ? $customer->billingAddress->postal_code:'' }}, {{ $customer->billingAddress ? $customer->billingAddress->city:'' }}<br/>
                                        <strong class="font-weight-Mbolder">{{ isset($customer->billingAddress->country) ? $customer->billingAddress->country->name:'-' }}</strong>
                                    @endif
                                    </div>
                                </div>
                                {{-- <div class="col-12 col-sm-6 col-md-6 textM-right">
                                    <h6 class="playfair">Credit card details</h6>
                                    <div class="theme-Ltext normal-line-height">Card type: Visa <br>Card number: xxxx-5882</div>
                                </div> --}}
                            </div>
                            <div class="mt-2 mb-2">
                                &nbsp;
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="col-lg-4 connectedSortable">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Status</h3>
                        <p>{{ ucfirst($customer->status)}}</p>
                    </div>
                    {{--<div class="card-body">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <h3 class="card-title">{{ ucfirst($customer->status)}}</h3>
                             <select class="form-control" aria-readonly="true">
                                <option value="active">Active</option>
                                @foreach ($status as $value)
                                <option value="{{ $value }}" {{ $value == $customer->status ? 'selected':'' }}> {{ ucfirst($value) }}</option>
                                @endforeach 
                            </select>
                        </div>
                    </div>--}}
                </div>
            </section>
        </div>

        {{-- <div class="row">
            <div class="col-lg-12">
                <h5 class="playfair f-15 mb-0 text-uppercase">Saved Measurement</h5>
                <div class="border-top my-3"></div> 
                <div class="table-responsive">
                    <table class="table table-color table-bordered admintable border-0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td><strong>56</strong>Att (In.)</td>
                            <td><strong>56</strong>Att (In.)</td>
                            <td><strong>56</strong>Att (In.)</td>
                            <td><strong>56</strong>Att (In.)</td>
                            <td><strong>56</strong>Att (In.)</td>
                            <td><strong>56</strong>Att (In.)</td>
                            <td><strong>56</strong>Att (In.)</td>
                            <td><strong>56</strong>Att (In.)</td>
                            <td><strong>02 Feb 2021</strong>Saved on</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div> --}}

        <div class="row mt-3">
            <div class="col-lg-12">
                <div class="tableHead mb-0">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="playfair f-15 mb-0 text-uppercase">Item Ordered</h5>
                        </div>

                        <div class="col-md-6 textM-right">
                            <div class="filterarea mt-0">
                                <div class="sortlink">
                                    <form action="/admin/order-exports?{{ Request::getQueryString() }}" id="exportForm" method="GET">
                                        <a href="javascript:void(0);" data-toggle="modal" data-target="#filterModal" class="text-dark"><img src="/assets/admin/img/filter.svg"/> Sort & Filter</a>
                                        <input type="hidden" name="filter_ids" id="filterIds">
                                        <input type="hidden" name="user_id" value="{{$customer->id}}">
                                        <a  href="javascript:void(0);" class="text-dark" onclick="exportdata();"><img src="/assets/designer/img/export.svg"  /> Export Orders</a>
                                      </form>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="border-top mb-3 mt-2"></div> 
                
                <div class="table-responsive">
                    <table class="table table-color table-bordered admintable border-0" cellspacing="0" cellpadding="0">
                        @foreach ($orderItems as $item)
                        <tr>
                            <td>
                                <div class="tb_status {{ $item->status=='new'?'mlight':'dark' }}"> {{ $item->status }}</div>
                            </td>
                            <td><strong>CU000{{ $item->order->user_id }}</strong>Customer ID#</td>
                            <td><strong>{{ $item->order->user_name }}</strong>Customer</td>
                            <td><strong>{{ $item->designer ? $item->designer['name'] : '-' }}</strong>Designer</td>
                            <td><strong>{{ date('jS M Y',strtotime($item->created_at))}}</strong>Order Date</td>
                            <td><strong>$ {{round($item->total_amount)}}</strong>Amount</td>
                            <td class="textM-right">
                                <a href="/admin/order/{{$item->item_number}}" class="btn btn-sm btn-outline-dark">View Details</a>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                {{ $orderItems->appends(request()->except('page'))->links('admin.layouts.pagination') }}
            </div>


        </div>

        {{-- <div class="row">
            <div class="col-lg-12">
                <div class="tableHead mb-0">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="playfair f-15 mb-0 text-uppercase">DISCOUNTS USED</h5>
                            <div class="border-top my-3"></div>
                        </div>
                    </div>
                </div> 
                <div class="table-responsive">
                    <table class="table table-color table-bordered admintable border-0" cellspacing="0" cellpadding="0">

                        <tr>
                            <td>
                                <div class="tb_status dark">Active</div>
                            </td>
                            <td><strong>Welcome20</strong>Discount Code</td>
                            <td><strong>Flat 20% Off for New Customer</strong>Summary</td>
                            <td><strong>Designer's Name</strong>Designer</td>
                            <td><strong>02 Feb 2021</strong>Used On</td>
                            <td><strong>$ 99</strong>Discount Worth</td>
                            <td><strong>$ 1500</strong>Total Spent</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="tb_status dark">Active</div>
                            </td>
                            <td><strong>Welcome20</strong>Discount Code</td>
                            <td><strong>Flat 20% Off for New Customer</strong>Summary</td>
                            <td><strong>Designer's Name</strong>Designer</td>
                            <td><strong>02 Feb 2021</strong>Used On</td>
                            <td><strong>$ 99</strong>Discount Worth</td>
                            <td><strong>$ 1500</strong>Total Spent</td>
                        </tr>
                    </table>
                </div>
            </div>


        </div> --}}

        <div class="row mt-3">
            <div class="col-lg-12">
                <div class="tableHead mb-0">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="playfair f-15 mb-0 text-uppercase">Appointments</h5>
                            <div class="border-top my-3"></div> 
                        </div>
                    </div>
                </div> 
                <div class="table-responsive">
                    <table class="table table-color table-bordered admintable border-0" cellspacing="0" cellpadding="0">
                        @foreach ($appointments as $appointment)
                        <tr>
                            <td>
                                <div class="tb_status {{$appointment->status=='scheduled'?'dark':'mlight'}}">{{$appointment->status}}</div>
                            </td>
                            <td><strong>{{ $appointment->booking_id }}</strong>Appointment ID#</td>
                            <td><strong>{{ $appointment->user ? $appointment->user->name :'-' }}</strong>Customer</td>
                            <td><strong>{{ $appointment->designer ? $appointment->designer->name : '-' }}</strong>Designer</td>
                            <td><strong>{{ date('d-M-Y', strtotime($appointment->appointment_date))}}</strong>Date</td>
                            <td><strong>{{ date('h:i a', strtotime($appointment->start_time))}}</strong>Time</td>
                            <td class="textM-right">
                                <a href="/admin/appointment/{{$appointment->booking_id}}" class="btn btn-sm btn-outline-dark">View Details</a>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>

    </div>
</section>
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
                                <div class="from-group">
                                    <label class="active" for="stitle">Status</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="">Select Status</option>
                                        @foreach ($order_status as $value)
                                            <option value="{{ $value }}" {{ Request::get('status') == $value ? 'selected':'' }}>{{ ucfirst($value) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6 mt-4">
                                <button class="btn btn-outline-dark btn-rounded btn-block my-4 z-depth-0 waves-effect waves-light" type="submit">Filter</button>
                            </div>
                            <div class="col-sm-6 mt-4">
                                <a href="/admin/customers/{{$customer->id}}" class="btn btn-dark btn-rounded btn-block my-4 z-depth-0 waves-effect waves-light" type="button">Reset</a>
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
// script
</script>
@stop

@section('styles')
<style type="text/css">
 
</style>
@endsection