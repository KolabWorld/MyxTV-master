@extends('admin.app')
{{-- Web site Title --}}
@section('title') Invoice #{{$invoice->invoice_number}} :: @parent @stop
@section('content')
@if (isset($status))
<div class="pad margin no-print">
	<div class="alert alert-{{$status['code']}} alert-dismissible fade in" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
		<h4><i class="icon fa fa-ban"></i> {{ $status['header'] }}</h4>
		<ul>
			@foreach ($status['messages'] as $m)
				<li>{{$m}}</li>
			@endforeach
		</ul>
	</div>
</div>
@endif
<section class="content-header">
	<h1>
		Invoices
	</h1>
	<ol class="breadcrumb">
		<li>
			<a href="#">
				<i class="fa fa-dashboard"></i> Home
			</a>
		</li>
		<li class="active">Dashboard</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-sm-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title pull-left">Invoice Info</h3>
					<a href="/admin/invoice/{{$invoice->id}}/pdf" class="btn btn-info pull-right" target="_blank">
						<i class="fa fa-download"></i> Download Invoice
					</a>
					<a href="/admin/invoice/{{$invoice->id}}/send-mail" class="btn btn-info pull-right">
						<i class="fa fa-envelope"></i> Send Email
					</a>
					<a href="{{ url()->previous() }}" class="btn btn-info pull-right">
						<i class="fa fa-arrow-left"></i> Back
					</a>
				</div>
				<style>
					.commonspan{
						padding: 9px 12px !important;
						font-size: 12px;
						text-transform: capitalize;
						border: 0px;
						border-radius: 0px;
					}
				</style>
				<div class="box-body">
					<div class="row">
						<div class="col-xs-12 col-sm-6">
							<div class="form-group row">
								<label for="inputEmail3" class="col-sm-4 col-form-label">Date</label>
								<div class="col-sm-6">
									<span class="span-text">{{ date('d-M-Y', strtotime($invoice->created_at)) }}</span>
								</div>
							</div>
							<div class="form-group row">
								<label for="inputEmail3" class="col-sm-4 col-form-label">Invoice #</label>
								<div class="col-sm-6">
									<span class="span-text">{{ $invoice->invoice_number ?? ''}}</span>
								</div>
							</div>
							<div class="form-group row">
								<label for="inputEmail3" class="col-sm-4 col-form-label">Client</label>
								<div class="col-sm-6">
							
									<span class="span-text">
										<a href="/admin/users/{{ $invoice->user_id }}/view">
											{{ isset($invoice->customer['billing_address']['name'])?$invoice->customer['billing_address']['name']:"" }}
										</a>@if(isset($invoice->customer['company_name']))<br><i style="font-size: 11px;font-weight: 600;">{{ $invoice->customer['company_name'] }}</i>@endif<br>
										{{ isset($invoice->customer['billing_address']['address'])?$invoice->customer['billing_address']['address']:''}}<br/>
										{{ isset($invoice->customer['billing_address']['city'])?$invoice->customer['billing_address']['city']:""}}, {{ isset($invoice->customer['billing_address']['state'])?$invoice->customer['billing_address']['state']:""}}<br/>
										{{ isset($invoice->customer['billing_address']['country'])?$invoice->customer['billing_address']['country']:""}}
									</span>
								</div>
							</div>
							<div class="form-group row">
								<label for="inputEmail3" class="col-sm-4 col-form-label">Status</label>
								<div class="col-sm-6">
									<span class="span-text">
										@if($invoice->status == 'approved')
											<span class="label label-info commonspan">
												{{ $invoice->status}}
											</span>
										@elseif($invoice->status == 'processing')
											<span class="label label-warning commonspan">
												{{ $invoice->status}}
											</span>
										@elseif($invoice->status == 'completed')
											<span class="label label-success commonspan">
												{{ $invoice->status}}
											</span>
										@else
											<span class="label label-danger commonspan">
												{{ $invoice->status}}
											</span>
										@endif
									</span>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<label for="inputEmail3" class="col-sm-4 col-form-label">
										Change Payment Status
									</label>
									<div class="col-sm-5">
										<select class="form-control" name="payment_status" onchange="changePaymentStatus(this.value)" 
										style=" width: 115px;font-size: 12px;padding: 0px 4px;text-transform: capitalize;">
											<option value="">Select Payment Status</option>
											@foreach($paymentStatus as $status)
												<option value="{{$status}}" {{ (($invoice->payment_status == $status)?'selected':'') }}>{{$status}}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="row" style="margin-top:2%;">
									<label for="inputEmail3" class="col-sm-4 col-form-label">
										Change Status
									</label>
									<div class="col-sm-5">
										<select class="form-control" name="status" onchange="changeStatus(this.value)" style=" width: 115px;font-size: 12px;padding: 0px 4px;text-transform: capitalize;">
											<option value="">Select Status</option>
											@foreach($invoiceStatus as $status)
												<option value="{{$status}}" {{ (($invoice->status == $status)?'selected':'') }}>{{$status}}</option>
											@endforeach
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-6">
							<div class="form-group row">
								<label for="inputEmail3" class="col-sm-4 col-form-label">Invoice Type</label>
								<div class="col-sm-6">
									<span class="span-text">{{$invoice->invoice_type}}
									</span>
									@if($invoice->invoiceable)

										@if($invoice->invoice_type == 'new_order')
											<a href="/admin/order/{{$invoice->invoiceable_id}}/view" >View Order</a>
										@elseif($invoice->invoice_type == 'service_upgrade')
											<a href="/admin/service-upgrade-request/{{$invoice->invoiceable_id}}/view" >View Request</a>
										@elseif($invoice->invoice_type == 'renew_service')
											<a href="/admin/users/{{$invoice->user_id}}/view/services?service_id={{$invoice->invoiceable_id}}" >View Service</a>
										@elseif($invoice->invoice_type == 'wallet')
											<a href="/admin/users/{{$invoice->id}}/view/user-wallets">View Wallet</a>
										@endif

									@endif
								</div>
							</div>

							<div class="form-group row">
								<label for="inputEmail3" class="col-sm-4 col-form-label">Payment Method</label>
								<div class="col-sm-6">
									<span class="span-text">{{$invoice->payment_method}}</span>
								</div>
							</div>
							

							<div class="form-group row">
								<label for="inputEmail3" class="col-sm-4 col-form-label">Payment Status</label>
								<div class="col-sm-8">
									<span class="span-text">
										<span class="label label-info commonspan">
											{{$invoice->payment_status}}
										</span>
									</span>

									@if($invoice->payment_status !== 'paid')
										@if($invoice->invoice_type !== 'wallet')
										<a href="/admin/invoice/{{$invoice->id}}/checkout" class="btn btn-info btn-sm cboxElement iframe commonspan">Pay By wallet</a>
										@endif
										<a href="/admin/invoice/{{$invoice->id}}/mark-paid" class="commonspan btn btn-success btn-sm cboxElement iframemarkpaid">Mark Paid</a>
										<a href="/admin/invoice/{{$invoice->id}}/add-discount" class="commonspan btn btn-success btn-sm cboxElement iframe">Add Discount</a>
									@endif
								</div>
							</div>
							<div class="form-group row">
								<label for="inputEmail3" class="col-sm-4 col-form-label">Amount</label>
								<div class="col-sm-6">
									<span class="span-text">{{ $invoice->currency }} {{$invoice->invoice_total ?? 0.00 }}</span>
								</div>
							</div>
							@if($invoice->voucher_amount > 0)
							<div class="form-group row">
								<label for="inputEmail3" class="col-sm-4 col-form-label">Voucher Code</label>
								<div class="col-sm-6">
									<span class="span-text">{{$invoice->voucher_code ?? ''}}</span>
								</div>
							</div>
							@endif

							<div class="form-group row">
								<label for="inputEmail3" class="col-sm-4 col-form-label">Due Date</label>
								<div class="col-sm-6">
									<span class="span-text">{{$invoice->due_date ?? ''}}</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Order Items</h3>
					<!-- <div class="box-tools">
						<a class="btn btn-info btn-sm" href="#">
						<i class="fa fa-plus"></i> &nbsp; Add Note
						</a>
					</div> -->
				</div>
				<div class="card-body p-0">
					<div class="table-responsive">
						<table class="table">
							<thead>
								<tr>
									<!--<th>SAC</th>-->
									<th>item</th>
									<th>Unit Price</th>
									<th>Quantity</th>
									<th>Tax</th>
									<th>Total Amount</th>
								</tr>
							</thead>
							<tbody>
								@foreach($invoice->items as $item)
								<tr>
								<!--	<td>{{ $item->item_code }}</td>-->
									<td> {!! $item->item !!} </td>
									<td>{{$invoice->currency }} {{$item->unit_price}}</td>
									<td>{{ $item->quantity }}</td>
									<td>
										@if($item->is_taxable)
											@if($item->tax_value_1 > 0)
												{{$item->tax_1 }} @ {{$item->tax_perc_1 }}% : {{$invoice->currency }} {{$item->tax_value_1}}
											@endif
											@if($item->tax_value_2 > 0)
												<br/>
												{{$item->tax_2 }} @ {{$item->tax_perc_2 }}% : {{$invoice->currency }} {{$item->tax_value_2}}
											@endif
										@else
											{{$invoice->currency }} 0.00
										@endif
									</td>
									<td>
										{{$invoice->currency }} {{$item->total_amount}}
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<div class="row">
						<div class="col-sm-7 hidden-xs"></div>
						<div class="col-sm-5 col-xs-12">
							<div class="table-responsive">
								<table class="table">
									<tbody>
										<tr>
											<th style="width:50%">Sub Total:</th>
											<td>{{$invoice->currency }} {{number_format(($invoice->sub_total),2)}}</td>
										</tr>
										@if($invoice->total_tax > 0)
										<tr>
											<th style="width:50%">Total Tax:</th>
											<td>{{$invoice->currency }} {{number_format(($invoice->total_tax),2)}}</td>
										</tr>
										@endif
										<tr>
											<th style="width:50%">Total Amount:</th>
											<td>{{$invoice->currency }} {{number_format(($invoice->total_amount),2)}}</td>
										</tr>
										@if($invoice->voucher_amount > 0)
										<tr>
											<th style="width:50%">Voucher {{$invoice->voucher_code}}:</th>
											<td>{{$invoice->currency }} {{number_format(($invoice->voucher_amount),2)}}</td>
										</tr>
										@endif
										<tr>
											<th style="width:50%">Invoice Total:</th>
											<td>{{$invoice->currency }} {{number_format(($invoice->invoice_total),2)}}</td>
										</tr>
										@if($invoice->amount_recieved > 0)
										<tr>
											<th style="width:50%">Amount Recieved:</th>
											<td>{{$invoice->currency }} {{number_format(($invoice->amount_recieved),2)}}</td>
										</tr>
										@endif

										<tr>
											<th style="width:50%">Amount Due:</th>
											<td>{{$invoice->currency }} {{number_format(($invoice->amount_pending),2)}}</td>
										</tr>

									</tbody>
								</table>
							</div>
						</div>
					</div>

					<div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Payment Transactions</h3>
                                    <!-- <div class="box-tools">
                                        <a class="btn btn-info btn-sm" href="#">
                                        <i class="fa fa-plus"></i> &nbsp; Add Note
                                        </a>
                                    </div> -->
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Payment Channel</th>
                                                    <th>transaction Id</th>
                                                    <th>Amount</th>
													<th>Date</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($invoice->paymentTransactions as $payment)
                                                <tr>
                                                    <td>{{ $payment->paymentChannel->name }}</td>
                                                    <td>{{ $payment->channel_order_id }}</td>
                                                    <td>{{ $payment->amount }}</td>
													<td>{{ $payment->updated_at }}</td>
                                                    <td>{{ $payment->status }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
					</div>
					<div class="row">
						<div class="col-md-12">
							@include('admin.partials.comment',
								array(
									'url' => '/admin/invoice/'.$invoice->id.'/comment',
									'comments' => $invoice->load('comments')->comments
								)
							)
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- <div class="col-sm-12">
			<div class=" text-center mb-4">
				@if($invoice->status == 'approved')
				<a href="/admin/order/{{$invoice->id}}/status/{{$invoice->status}}" class="btn bg-olive margin"> Accept Order
				</a>
				@elseif($invoice->status == 'processing')
				<a href="/admin/order/{{$invoice->id}}/status/{{$invoice->status}}" class="btn btn-default"> Mark Completed
				</a>
				@elseif(($invoice->status != 'completed') && ($invoice->status != 'cancelled'))
				<a href="/admin/order/{{$invoice->id}}/status/{{$invoice->status}}"  class="btn btn-danger" >
				<i class="fa fa-trash"></i> Cancel Order
				</a>
				@endif
			</div>
		</div> -->
	</div>
</section>
@endsection

{{-- Scripts --}}
@section('scripts')
@parent

<script>
	var oTable;

    function changePaymentStatus(th) {
        swal({
            title: "Are you sure to change payment status?",
            type: "warning",
            buttons: ['CANCEL', 'OK']
        }).then(function(isConfirm) {
            if(isConfirm){
                var data = '';
                console.log(th);
                var invoiceId = {{$invoice->id}};
                // swal('Deleted');
                $.ajax({
                    url: '/admin/invoice/'+invoiceId+'/change-payment-status?payment_status='+th,
                    type: 'GET',
                    data: data,
                    success:function(data) {
                        swal('Payment Status Changed');
                        window.location.reload();
                    }
                });
            }
        });
    }

    function changeStatus(th) {
        swal({
            title: "Are you sure to change status?",
            type: "warning",
            buttons: ['CANCEL', 'OK']
        }).then(function(isConfirm) {
            if(isConfirm){
                var data = '';
                console.log(th);
                var invoiceId = {{$invoice->id}};
                // swal('Deleted');
                $.ajax({
                    url: '/admin/invoice/'+invoiceId+'/change-status?status='+th,
                    type: 'GET',
                    data: data,
                    success:function(data) {
                        swal('Status Changed');
                        window.location.reload();
                    }
                });
            }
        });
    }

	$(".iframe").colorbox({
		iframe: true,
		width: "50%",
		height: "50%",
		onClosed: function () {
			window.location.reload();
		}
	});
	$(".iframemarkpaid").colorbox({
		iframe: true,
		width: "50%",
		height: "70%",
		onClosed: function () {
			window.location.reload();
		}
	});

</script>
@endsection
