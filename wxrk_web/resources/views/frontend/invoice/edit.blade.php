@extends('admin.app')
{{-- Web site Title --}}
@section('title') Edit Invoice #{{$invoice->invoice_number}} :: @parent @stop
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
		Edit Invoice
	</h1>
	<ol class="breadcrumb">
		<li>
			<a href="/admin">
				<i class="fa fa-dashboard"></i> Home
			</a>
		</li>
		<li>
			<a href="/admin/invoices">
				<i class="fa fa-star"></i> Home
			</a>
		</li>
		<li class="active">Edit Invoice</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-sm-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title pull-left">Invoice Info</h3>
					@if($invoice->items)
						<a href="/admin/invoice/{{$invoice->id}}/submit" class="btn btn-success pull-right">
							<i class="fa fa-download"></i> Save And Submit
						</a>
					@endif	
					<a href="/admin/invoices" class="btn btn-info pull-right">
						<i class="fa fa-arrow-left"></i> Back
					</a>
				</div>
				<?php //echo "<pre>";print_r($invoice);?>
				<form class="form-horizontal">
					<div class="box-body">
						<div class="row">
							<div class="col-xs-12 col-sm-6">
								<div class="form-group row">
									<label for="inputEmail3" class="col-sm-3 col-form-label">Date</label>
									<div class="col-sm-9">
										<span class="span-text">{{ date('d-M-Y', strtotime($invoice->created_at)) }}</span>
									</div>
								</div>
								<div class="form-group row">
									<label for="inputEmail3" class="col-sm-3 col-form-label">Invoice #</label>
									<div class="col-sm-9">
										<span class="span-text">{{ $invoice->invoice_number ?? ''}}</span>
									</div>
								</div>
								<div class="form-group row">
									<label for="inputEmail3" class="col-sm-3 col-form-label">Client</label>
									<div class="col-sm-9">
										<span class="span-text"><a href="/admin/users/{{ $invoice->user_id }}/view">{{$invoice->customer['billing_address']['name']}}</a><br>
										{{ $invoice->customer['billing_address']['address']}}<br/>
										{{ $invoice->customer['billing_address']['city']}}, {{ $invoice->customer['billing_address']['state']}}<br/>
										{{ $invoice->customer['billing_address']['country']}}
										</span>
									</div>
								</div>
							</div>
							<div class="col-xs-12 col-sm-6">
								<div class="form-group row">
									<label for="inputEmail3" class="col-sm-3 col-form-label">Invoice Type</label>
									<div class="col-sm-9">
										<span class="span-text">{{$invoice->invoice_type}}</span>
									</div>
								</div>
								<div class="form-group row">
									<label for="inputEmail3" class="col-sm-3 col-form-label">Amount</label>
									<div class="col-sm-9">
										<span class="span-text">Rs. {{ $invoice->invoice_total ?? 0.00 }}</span>
									</div>
								</div>
								<div class="form-group row">
									<label for="inputEmail3" class="col-sm-3 col-form-label">Status</label>
									<div class="col-sm-9">
										<span class="span-text" style="text-transform: capitalize;font-weight: 800;">{{$invoice->status}}</span>
									</div>
								</div>
								<div class="form-group row">
									<label for="inputEmail3" class="col-sm-3 col-form-label">Due Date</label>
									<div class="col-sm-9">
										<span class="span-text" style="text-transform: capitalize;font-weight: 800;">{{$invoice->due_date}}</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="col-md-12">
			<a href="/admin/invoice/add-item?invoice_id={{$invoice->id}}" class="btn btn-info btn-sm cboxElement iframe">Add Item</a>
		</div>
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Invoice Items</h3>
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
									<th>SAC</th>
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
									<td>{{ $item->item_code }}</td>
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
					<!-- <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Payment Transactions</h3>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Payment Channel</th>
                                                    <th>transaction Id</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($invoice->paymentTransactions as $payment)
                                                <tr>
                                                    <td>{{ $payment->paymentChannel->name }}</td>
                                                    <td>{{ $payment->transection_id }}</td>
                                                    <td>{{ $payment->amount }}</td>
                                                    <td>{{ $payment->status }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
					</div> -->
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
	 $(".iframe").colorbox({
			iframe: true,
			width: "50%",
			height: "80%",
			onClosed: function () {
				window.location.reload();
			}
		});
</script>
@endsection
