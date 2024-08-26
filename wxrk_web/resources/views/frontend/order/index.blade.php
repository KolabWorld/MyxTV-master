@extends('frontend.app')

{{-- Web site Title --}}
@section('title') :: @parent @stop 

@section('content')
    @include('frontend.partials.nav', [
        'title' => 'All Orders',
        'description' => count($orders). ' Records',
    ])
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row align-items-center">
                        {{--  <div class="col-4 d-none d-sm-block">
                             <a href="javascript:history.back()" class="btn btn-outline-secondary">Go Back</a>
                        </div>  --}}
                        <div class="col-12 col-md-8 text-sm-right"> 
                            {{--  <a href="#filter" data-toggle="modal" class="btn btn-primary btn-filter mr-2"><i class="fas fa-filter mr-1"></i> Filter</a>  --}}
                            {{--  <a href="#" class="btn btn-success btn-filter"><i class="far fa-file-excel mr-1"></i> Export to Excel</a>  --}}
                        </div> 
                    </div>
                    <div class="dashbed-border-bottom mt-2 mb-3"></div>
                    <div class="row">
                        <div class="col-md-12"> 
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table dashtable">
                                            <thead>
                                              <tr>
                                                <th></th>
                                                <th>Order ID</th>
                                                <th>Date</th>
                                                <th>Offer Name</th>
                                                <th>Customer Name</th>
                                                <th>Customer Country</th>
                                                <th>Vendor Name</th>
                                                <th>Vendor Country</th> 
                                                <th>Action</th> 
                                              </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($orders as $key => $order)
                                                    <tr>
                                                        <td>
                                                            <span class="badge 
                                                            @if($order->status == 'completed')
                                                                badge-success
                                                            @elseif($order->status == 'canceled')
                                                                badge-danger
                                                            @else
                                                                badge-warning
                                                            @endif
                                                            ">
                                                                {{ ucWords($order->status) }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <strong>
                                                                {{$order->order_number}}
                                                            </strong>
                                                        </td>
                                                        <td>
                                                            {{date('d-m-Y', strtotime($order->created_at))}}
                                                        </td>
                                                        <td>
                                                            {{$order->offer ? $order->offer->offer_name : ''}}
                                                        </td>
                                                        <td>
                                                            {{$order->user ? $order->user->name : ''}}
                                                        </td>
                                                        <td>
                                                            India
                                                        </td>
                                                        <td>
                                                            {{$order->admin ? $order->admin->contact_person_name : ''}}
                                                        </td>
                                                        <td>
                                                            {{ @$order->admin->address->country->name }}
                                                        </td> 
                                                        <td>
                                                            <a href="/order/{{$order->id}}/view">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    {{ $orders->links('frontend.layouts.pagination') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    @parent

@endsection
