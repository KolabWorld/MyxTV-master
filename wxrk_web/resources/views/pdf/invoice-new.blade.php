@extends('pdf/app')

{{-- Web site Title --}}
@section('title') Miditech Invoice :: @parent @stop

@section('content')
	@if($invoice->payment_status == 'paid')
	<style>
		.container {
			background-image: url("/frontend/images/invoice-paid.jpeg");
			background-repeat: no-repeat;
			background-position: 400px 180px;
			background-size: 300px 100px;
		}
	</style>
	@else
	<style>
		.container {
			background-image: url("/frontend/images/unpaid.jpg");
			background-repeat: no-repeat;
			background-position: 400px 180px;
			background-size: 300px 100px;
		}
	</style>
	@endif
    <div class="container">
		<div class="invoice-box">
			<table cellpadding="0" cellspacing="0">
				<tr class="top">
					<td colspan="2">
						<table>
							<tr>
								<td class="title">
									<img src="/frontend/images/pdflogo.JPG" class="logo" style="max-width:230px;">
								</td>

								<td class="text-right">
									<span class="headi" style="font-size: 22px;">Invoice: {{ $invoice->invoice_number }}</span><br>
									<span class="headi" style="font-weight:bold;">Invoice Date:</span> {{ date('d-M-Y', strtotime($invoice->created_at)) }}<br/>
									<span class="headi" style="font-weight:bold;">Due Date:</span> {{ date('d-M-Y', strtotime($invoice->created_at)) }}
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr class="top">
					<td colspan="2">
						<hr>
					</td>
				</tr>
				<tr class="information">
					<td colspan="2">
						<table>
							<tr>
								<td class="small-text">
									<p class="lead marginbottom payment-info">Invoiced To</p>
									{!! isset($invoice->customer['company_name']) ? $invoice->customer['company_name'] .'<br>' : ''  !!}
									{{$invoice->customer['billing_address']['name']}}<br>
									{{ $invoice->customer['billing_address']['address']}}<br>
									{{ $invoice->customer['billing_address']['city']}}, {{ $invoice->customer['billing_address']['state']}}<br>
									{{ $invoice->customer['billing_address']['country']}} - {{ $invoice->customer['billing_address']['postal_code']}}<br>
									@if($invoice->customer['billing_address']['gst_number'])
										<br>GSTIN: {{ $invoice->customer['billing_address']['gst_number']}}<br>
									@endif
								</td>

								<td class="text-right"><p class="lead marginbottom payment-info">Pay To</p>
									<address class="small-text">
										Supra India Tech Private Limited<br>
										SDF K-9, NSEZ, Noida-201305  India<br>
										Ph.: +91-0120-4955500<br>
										Email ID: Accounts@SupraITS.com
									</address>
									<!-- <p class="lead marginbottom">From : {{$invoice->header['name']}}</p>
									Email:  {{$invoice->header['email']}}<br>
									Tel: {{$invoice->header['mobile']}}<br>
									Invoive No. {{ $invoice->uid }}<br>
									Invoice Date. {{ date('d-M-Y', strtotime($invoice->created_at)) }}<br>
									{{$invoice->header['address_line1']}}<br>
									{{$invoice->header['address_line2']}}<br> -->
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<table cellpadding="0" cellspacing="0">

				<tr class="heading">
				<!--	<th>SAC</th>-->
					<th>item</th>
					<th>Unit Price</th>
					<th>Quantity</th>
					<th>Tax</th>
					<th>Total Amount</th>
				</tr>
				@foreach($invoice->items as $key => $item)

				<tr class="details">
					<!--<td>{{ $item->item_code }}</td>-->
					<td> {!! $item->item !!} </td>
					<td class="text-right">{{$invoice->currency }} {{$item->unit_price}}</td>
					<td class="text-right">{{ $item->quantity }}</td>
					<td>
						@if($item->is_taxable)
							@if($item->tax_value_1)
								{{$item->tax_1 }} @ {{$item->tax_perc_1 }}% : {{$invoice->currency }} {{$item->tax_value_1}}
							@endif
							@if($item->tax_value_2)
								<br/>
								{{$item->tax_2 }} @ {{$item->tax_perc_2 }}% : {{$invoice->currency }} {{$item->tax_value_2}}
							@endif
						@else
							{{$invoice->currency }} 0.00
						@endif
					</td>
					<td class="text-right">{{$invoice->currency }} {{$item->total_amount}}</td>
				</tr>
				@endforeach
			</table>
			<table cellpadding="0" cellspacing="0">
				<tr>
					<th style="width:80%" class="text-right">Sub Total:</th>
					<td class="text-right">{{$invoice->currency }} {{number_format(($invoice->sub_total),2)}}</td>
				</tr>
				<tr>
					<th style="width:80%" class="text-right">Total Tax:</th>
					<td class="text-right">{{$invoice->currency }} {{number_format(($invoice->total_tax),2)}}</td>
				</tr>
				<tr>
					<th style="width:80%" class="text-right">Total Amount:</th>
					<td class="text-right">{{$invoice->currency }} {{number_format(($invoice->total_amount),2)}}</td>
				</tr>
				@if($invoice->voucher_amount)
				<tr>
					<th style="width:80%" class="text-right">Voucher {{$invoice->voucher_code}}:</th>
					<td class="text-right">{{$invoice->currency }} {{number_format(($invoice->voucher_amount),2)}}</td>
				</tr>
				@endif
				<tr>
					<th style="width:80%" class="text-right">Invoice Total:</th>
					<td class="text-right">{{$invoice->currency }} {{number_format(($invoice->invoice_total),2)}}</td>
				</tr>
				@if($invoice->amount_recieved)
				<tr>
					<th style="width:80%" class="text-right">Amount Recieved:</th>
					<td class="text-right">{{$invoice->currency }} {{number_format(($invoice->amount_recieved),2)}}</td>
				</tr>
				@endif

				<tr>
					<th style="width:80%" class="text-right">Amount Due:</th>
					<td class="text-right">{{$invoice->currency }} {{number_format(($invoice->amount_pending),2)}}</td>
				</tr>
			</table>
			@if(count($invoice->paymentTransactions))
				<table cellpadding="0" cellspacing="0" style="margin-top: 5%;">
					<tr class="heading">
						<th>
							Transaction Date
						</th>
						<th>
							Gateway
						</th>
						<th>
							Transaction Id
						</th>
						<th>
							Amount
						</th>
					</tr>
					@foreach($invoice->paymentTransactions as $transaction)
						<tr class="details">
							<td>
								{{date('d M Y', strtotime($transaction->created_at))}}
							</td>
							<td>
								{{$transaction->paymentChannel ? $transaction->paymentChannel->name : '-'}}
							</td>
							<td>
								{{$transaction->transection_id}}
							</td>
							<td>
								{{$invoice->currency}} ($transaction->amount)
							</td>
						</tr>
					@endforeach	
				</table>
			@endif	
			<p>&nbsp;</p><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tg">

		<tr>

			<td width="49%">PAN - AAFCR0562C<br />
			Service Tax Regn. No. - AAFCR0562CSD001<br />
			GST No - 09AAFCR0562C1ZN<br />
			TIN No. - 09355714092C<br />
			CIN Number - U72200DL2010PTC211676<br /></td>
			<td width="2%">&nbsp;</td>
			<td width="12%">&nbsp;</td>
			<td width="37%">&nbsp;</td>

		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>SUPRA INDIA TECH PRIVATE LIMITED<br />
			<br />
			AUTHORISED SIGNATORY</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>

			<tr>

			<td height="141" colspan="4" valign="top"><strong>Terms and Conditions</strong><br />

			<strong>1. Payment options:</strong><br />

			&nbsp;&nbsp;i. Payments can be directly deposited in to HDFC Bank Account, Name: Supra India Tech Private Limited,<br />

			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Account Number: 00032560005623, IFSC Code: HDFC0000003<br />

			&nbsp;&nbsp;ii. Payments can be processed through an online payment gateway system available at www.miditech.co.in<br />

			<strong>2.</strong> No query will be entertained on the Bill unless it is brought to our notice within 10 days from the date of the invoice.<br />

			<strong>3. </strong>Disputes, if any will be settled in New Delhi Court only.<br /></td>

		</tr>

		<tr>
			<td colspan="4" align="center"><br />
			<strong>Regd.Office : </strong>S &ndash; 524, Neelkanth House, 302, 3rd Floor, School Block, Shakarpur, Delhi &ndash; 110 092</td>
		</tr>
		</table>
		</div>
	</div>
@endsection
