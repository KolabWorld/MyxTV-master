@extends('frontend.app')

{{-- Web site Title --}}
@section('title') :: @parent @stop

@section('content')
    @include('frontend.partials.nav', [
        'title' => 'Order',
        'description' => 'Detail',
    ])

    <section class="content mb-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row align-items-center position-top-sticky">
                        <div class="col-sm-5 d-none d-sm-block">
                            <a href="/orders" class="btn btn-outline-secondary">Go Back</a>
                        </div>
                    </div>
                    <div class="dashbed-border-bottom mt-2 mb-3"></div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="accordion addformaccordian" id="leftAccordian">
                                <div class="card formCard">
                                    <div class="card-header">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link" type="button" data-toggle="collapse"
                                                data-target="#Equipment">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="head-title form-head">
                                                            <h2>Order Details</h2>
                                                            <h5>Details</h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </button>
                                        </h5>
                                    </div>
                                    <div id="Equipment" class="collapse" data-parent="#leftAccordian">
                                        <div class="card-body pt-2">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <p>
                                                            <b>Order Number : </b>
                                                            {{$order->order_number}}
                                                        </p>
                                                    </div>
                                                    <div class="form-group">
                                                        <p>
                                                            <b>Offer Name : </b>
                                                            {{$order->offer_name}}
                                                        </p>
                                                    </div>
                                                    <div class="form-group">
                                                        <p>
                                                            <b>Offer Price : </b>
                                                            {{$order->offer_price}}
                                                        </p>
                                                    </div>
                                                    <div class="form-group">
                                                        <p>
                                                            <b>Offer Promo Code : </b>
                                                            {{$order->offer_promo_code}}
                                                        </p>
                                                    </div> 
                                                    <div class="form-group">
                                                        <p>
                                                            <b>Promo Code Redemption Status : </b>
                                                            {{$order->promo_code_redemption_status}}
                                                        </p>
                                                    </div> 
                                                    <div class="form-group">
                                                        <p>
                                                            <b>Promo Code Redemption Date : </b>
                                                            {{date('d m-Y', strtotime($order->promo_code_redemption_date))}}
                                                        </p>
                                                    </div>  
                                                    <div class="form-group">
                                                        <p>
                                                            <b>Offer Type  :  </b>
                                                            {{$order->offer_type}}
                                                        </p>
                                                    </div>
                                                    <div class="form-group">
                                                        <p>
                                                            <b>Offer Category  :  </b>
                                                            {{$order->offer_category}}
                                                        </p>
                                                    </div>
                                                    <div class="form-group">
                                                        <p>
                                                            <b>Offer Premium Category  :  </b>
                                                            {{$order->offer_premium_category}}
                                                        </p>
                                                    </div>
                                                    <div class="form-group">
                                                        <p>
                                                            <b>Time To Redeem  :  </b>
                                                            {{(int)$order->time_to_redeem}} hours
                                                        </p>
                                                    </div>
                                                    <div class="form-group">
                                                        <p>
                                                            <b>Highlights Of Offer  :  </b>
                                                            {!! $order->highlight_of_offer !!}
                                                        </p>
                                                    </div>
                                                    <div class="form-group">
                                                        <p>
                                                            <b>Details Of Offer  :  </b>
                                                            {!! $order->details_of_offer !!}
                                                        </p>
                                                    </div>
                                                    <div class="form-group">
                                                        <p>
                                                            <b>Website Link  :  </b>
                                                            {{ $order->link }}
                                                        </p>
                                                    </div> 
                                                    <div class="form-group">
                                                        <p>
                                                            <b>Status  :  </b>
                                                            {{ $order->status }}
                                                        </p>
                                                    </div>  
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="accordion addformaccordian" id="rightAccordian">
                                <div class="card formCard">
                                    <div class="card-header">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link" type="button" data-toggle="collapse"
                                                data-target="#Equipment1">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="head-title form-head">
                                                            <h2>Customer And Vendor Details</h2>
                                                            <h5>Details</h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </button>
                                        </h5>
                                    </div>
                                    <div id="Equipment1" class="collapse" data-parent="#rightAccordian">
                                        <div class="card-body pt-2">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <p>
                                                            <b>Customer Name : </b>
                                                            {{$order->customer_name}}
                                                        </p>
                                                    </div>
                                                    <div class="form-group">
                                                        <p>
                                                            <b>Customer Mobile : </b>
                                                            {{$order->customer_mobile}}
                                                        </p>
                                                    </div>
                                                    <div class="form-group">
                                                        <p>
                                                            <b>Customer Email : </b>
                                                            {{$order->customer_email}}
                                                        </p>
                                                    </div>
                                                    <div class="form-group">
                                                        <p>
                                                            <b>Customer Country : </b>
                                                            {{$order->customer_country}}
                                                        </p>
                                                    </div> 
                                                    <div class="form-group">
                                                        <p>
                                                            <b>Vendor Name : </b>
                                                            {{$order->admin ? $order->admin->contact_person_name : ''}}
                                                        </p>
                                                    </div> 
                                                    <div class="form-group">
                                                        <p>
                                                            <b>Vendor Mobile : </b>
                                                            {{$order->vendor_mobile}}
                                                        </p>
                                                    </div>  
                                                    <div class="form-group">
                                                        <p>
                                                            <b>Vendor Email  :  </b>
                                                            {{$order->vendor_email}}
                                                        </p>
                                                    </div>
                                                    <div class="form-group">
                                                        <p>
                                                            <b>Vendor Country  :  </b>
                                                            {{ @$order->admin->address->country->name }}
                                                        </p>
                                                    </div>
                                                    <div class="form-group">
                                                        <p>
                                                            <b>Vendor Category  :  </b>
                                                            {{ @$order->admin->businessCategory->name }}
                                                        </p>
                                                    </div>
                                                    <div class="form-group">
                                                        <p>
                                                            <b>Vendor State  :  </b>
                                                            {{ @$order->admin->address->state->name}}
                                                        </p>
                                                    </div>
                                                    <div class="form-group">
                                                        <p>
                                                            <b>Vendor City  :  </b>
                                                            {{ @$order->admin->address->city->name }}
                                                        </p>
                                                    </div>
                                                    <div class="form-group">
                                                        <p>
                                                            <b>Vendor Address  :  </b>
                                                            {{ $order->admin->address->landmark }}
                                                        </p>
                                                    </div>
                                                    <div class="form-group">
                                                        <p>
                                                            <b>Vendor Postal Code  :  </b>
                                                            {{ $order->admin->address->postal_code }}
                                                        </p>
                                                    </div>  
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-md-12">
                            <div class="accordion addformaccordian" id="Accordian">
                                <div class="card formCard">
                                    <div class="card-header">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link" type="button" data-toggle="collapse"
                                                data-target="#Equipment2">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="head-title form-head">
                                                            <h2>Payment Transactions</h2>
                                                            <h5>Details</h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </button>
                                        </h5>
                                    </div>
                                    <div id="Equipment2" class="collapse show" data-parent="#Accordian">
                                        <div class="card-body pt-2">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <table class="table datatbalennew">
                                                        <thead>
                                                            <tr> 
                                                                <th>S.No</th>
                                                                <th>Email</th>
                                                                <th>Mobile</th>
                                                                <th>Amount</th>
                                                                <th>Channel Order Id</th>
                                                                <th>Created At</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if(!empty($order->transactions))
                                                                @foreach($order->transactions as $key => $val)
                                                                    <tr>
                                                                        <td>
                                                                            {{ $loop->iteration }}
                                                                        </td>
                                                                        <td>
                                                                            <strong>
                                                                                {{ @$order->paymenttransaction->payee_email }}
                                                                            </strong>
                                                                        </td>
                                                                        <td>
                                                                            {{ @$order->paymenttransaction->payee_mobile }}
                                                                        </td>
                                                                        <td>
                                                                            {{ @$order->paymenttransaction->amount }}
                                                                        </td>
                                                                        <td>
                                                                            {{ @$order->paymenttransaction->channel_order_id  }}
                                                                        </td>
                                                                        <td>
                                                                            {{ @$order->paymenttransaction->created_at ? date('Y-m-d H:i:s', strtotime($val->created_at)) : '' }}
                                                                        </td> 
                                                                    </tr> 
                                                                @endforeach
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    @parent

@endsection
