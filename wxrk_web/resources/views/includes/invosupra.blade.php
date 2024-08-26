@if($invoice->payment_status=='paid')
<style type="text/css">
	.invoice-box {
		position: relative;
		width: 100%;
		height: 29.7cm;
		margin: 0 auto;
		color: #101010;
		background-color: #ffffff;
		font-size: 11px;
		font-family: 'Montserrat', sans-serif;
		background: url('{{ asset("img/invoice-paid.jpg") }}') no-repeat center bottom;
	}
</style>
@else
<style>
	.invoice-box {
		position: relative;
		width: 100%;
		height: 29.7cm;
		margin: 0 auto;
		color: #101010;
		background-color: #ffffff;
		font-size: 11px;
		font-family: 'Montserrat', sans-serif;
		background: url('{{ asset("img/unpiad.jpg") }}') no-repeat center bottom;
	}
</style>
@endif

<div class="invoice-box" style="border-radius:0px !important;padding:0px !important;border:0px !important;margin:0px !important;">

	<table cellpadding="0" cellspacing="0" width="100%" border="0" style="border-radius:0px !important;padding:0px !important;border:0px !important;margin:0px !important;">
		<tr class="top">
			<td colspan="2" style="padding-bottom:20px !important;">
				<table style="border-radius:0px !important;padding:0px !important;border:0px !important;margin:0px !important;">
					<tr>
						<td class="title" style="border-radius:0px !important;padding:0px !important;border:0px !important;margin:0px !important;">
							<img src="{{ env('APP_URL') }}/frontend/images/pdflogo.JPG" class="logo" style="max-width:200px;">
						</td>

						<td style="border-radius:0px !important;padding:30px 0px 0px 0px !important;border:0px !important;margin:0px !important;text-align:right;">
							<address class="small-text">
								<span class="headi" style="font-size: 14px;font-weight:bold;">Invoice: {{ $invoice->invoice_number }}</span><br>
								<span class="headi" style="font-size: 12px;">Invoice Date:</span> {{ date('d-M-Y', strtotime($invoice->created_at)) }}<br />
								<span class="headi" style="font-size: 12px;">Due Date:</span> {{ date('d-M-Y', strtotime($invoice->due_date)) }}
							</address>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr class="top">
			<td colspan="2" style="padding-bottom:20px !important;">
				<p>&nbsp;</p>
			</td>
		</tr>
		<tr class="information">
			<td colspan="2">
				<table>
					<tr>
						<td class="small-text" style="font-size:12px;text-align:left;">
							<p class="lead marginbottom payment-info" style="font-size:12px;font-weight:bold;">Invoiced To<br></p>
							<address class="small-text">{!! isset($invoice->customer['company_name']) ? $invoice->customer['company_name'] .'<br>' : '' !!}
								{{$invoice->customer['billing_address']['name']}}<br>
								{{ $invoice->customer['billing_address']['address']}}<br>
								{{ $invoice->customer['billing_address']['city']}}, {{ $invoice->customer['billing_address']['state']}}<br>
								{{ $invoice->customer['billing_address']['country']}} - {{ $invoice->customer['billing_address']['postal_code']}}<br>
								@if($invoice->customer['billing_address']['gst_number'])
								GSTIN: {{ $invoice->customer['billing_address']['gst_number']}}<br>
								@endif
							</address>
						</td>

						<td style="font-size:12px;text-align:right;">
							<p style="font-size:12px;font-weight:bold;" class="lead marginbottom payment-info">Pay To<br></p>
							<address class="small-text">
							HOSTMIDITECH LLP <br>
                        M-11 Ground Floor<br> 
                        Shastri Nagar Delhi – 52
							</address>
						</td>
					</tr>
				</table>
			</td>
		</tr>

		<tr class="heading">
			<td style="font-size:11px;font-weight:bold;">
				Description
			</td>

			<td style="font-size:11px;font-weight:bold;text-align:right;">
				Total Amount
			</td>
		</tr>

		<?php $itemCounter = 0;
		$old_item_sequence = 0; 
		$tax1 = $tax2 = $taxPerc1 = $taxPerc2 = null
		?>
		@foreach($invoice->items as $key => $item)

		@if($itemCounter != 0 && $item->item_sequence != $old_item_sequence)
		<tr>
			<td colspan="2" style="width:100%;height:1px;border-bottom:1px solid #CCC;"></td>
		</tr>
		<tr>
			<td colspan="2" style="width:100%;height:1px;"></td>
		</tr>
		@endif
		@if($item->item_sequence == $old_item_sequence)
		<tr class="details">
			<td class="small-text" style="padding:0px 10px 0px 20px;height:10px;text-align: left !important">
				<span style="float:Left;font-size:11px !important">
					<address class="small-text"  style="font-size:11px;"><em>-</em> {!! $item->item !!} </address>
				</span>
			</td>
			<td style="padding:0px 10px 0px 20px;height:10px;text-align: right;font-size:11px;"><span style="float:right;">
					<address class="small-text" style="font-size:11px;">{{$invoice->currency}} @numberFormat($item->sub_total)</address>
				</span></td>

		</tr>
		@else
		<tr class="details">
			<td class="small-text" style="text-align: Left;padding:0px 0px 0px 10px;height:10px;float:Left;font-size:12px !important">
				<span style="float:Left;font-size:12px !important">
					<address class="small-text" style="font-size:11px;"> {!! $item->item !!} </address>
				</span>
			</td>
			<td style="text-align: right;font-size:11px !important;"><span style="float:right;">
					<address class="small-text" style="font-size:11px;">{{$invoice->currency}} @numberFormat($item->sub_total)</address>
				</span></td>

		</tr>
		@endif

		@if($item->tax_1)
			@php 
				$tax1 = $item->tax_1;
				$taxPerc1 = $item->tax_perc_1;
			@endphp
		@endif

		@if($item->tax_2)
			@php 
				$tax2 = $item->tax_2;
				$taxPerc2 = $item->tax_perc_2;
			@endphp
		@endif

		<?php $itemCounter++;
		$old_item_sequence = $item->item_sequence; ?>

		@endforeach
		<tr class="heading">
			<td></td>

			<td style="text-align:right;font-size:11px;">
				<address class="small-text" style="font-size:11px;">Sub Total : {{$invoice->currency}} @currencyPDF($invoice->sub_total)</address>
			</td>
		</tr>
		@if($invoice->total_discount)
		<tr class="heading">
			<td></td>

			<td style="text-align:right;font-size:11px;">
				<address class="small-text" style="font-size:11px;">Discount : {{$invoice->currency}} @currencyPDF($invoice->voucher_amount)</address>
			</td>
		</tr>
		@endif

		@if($invoice->total_tax > 0)
		@php 
			$taxValue = $tax2 ? round($invoice->total_tax/2, 2) : $invoice->total_tax;
		@endphp

		<tr class="heading">
			<td></td>

			<td style="text-align:right;font-size:11px;">
				<address class="small-text"> {{$tax1}} ({{$taxPerc1}}%): {{$invoice->currency}} @currencyPDF($taxValue)</address>
			</td>
		</tr>
		@if($tax2)
		<tr class="heading">
			<td></td>

			<td style="text-align:right;font-size:11px;">
				<address class="small-text"> {{$tax2}} ({{$taxPerc2}}%): {{$invoice->currency}} @currencyPDF($taxValue)</address>
			</td>
		</tr>
		@endif
		@endif
		<tr class="heading">
			<td></td>

			<td style="text-align:right;font-size:11px;">
				<address class="small-text"> Total Amount : {{$invoice->currency}} @currencyPDF($invoice->invoice_total)</address>
			</td>
		</tr>
	</table>

	@if($invoice->paymentTransactions && count($invoice->paymentTransactions))
	<table cellpadding="0" cellspacing="0" style="margin-top: 5%;">
		<tr class="heading">
			<th style="font-size:11px;background-color: #f3f1f1 !important;padding:2px;border: 1px solid #ddd !important;">
				Transaction Date
			</th >
			<th  style="font-size:11px;background-color: #f3f1f1 !important;padding:2px;border: 1px solid #ddd !important;">
				Gateway
			</th>
			<th  style="font-size:11px;background-color: #f3f1f1 !important;padding:2px;border: 1px solid #ddd !important;">
				Transaction Id
			</th>
			<th  style="font-size:11px;background-color: #f3f1f1 !important;padding:2px;border: 1px solid #ddd !important;">
				Amount
			</th>
			<th  style="font-size:11px;background-color: #f3f1f1 !important;padding:2px;border: 1px solid #ddd !important;">
				Status
			</th>
		</tr>
		@foreach($invoice->paymentTransactions as $payment)
		<tr class="details">
			<td  style="font-size:11px;"> 
				{{date('d M Y', strtotime($payment->created_at))}}
			</td>
			<td  style="font-size:11px;">
				{{$payment->paymentChannel ? $payment->paymentChannel->name : '-'}}
			</td>
			<td  style="font-size:11px;">
				{{ $payment->channel_order_id }}
			</td>
			<td  style="font-size:11px;">
				{{$invoice->currency}} {{$payment->amount}}
			</td>
			<td  style="font-size:11px;">
				{{$payment->status}}
			</td>
		</tr>
		@endforeach
	</table>
	@endif

	<p>&nbsp;</p>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tg">

		<tr>
			<td width="49%">
				<address class="small-text"  style="font-size:11px;"><b>PAN No. -</b> AAFCR0562C<br />

					<b>Service Tax Reg No. -</b> AAFCR0562CSD001<br />

					<b>GST No. -</b> 09AAFCR0562C1ZN<br />

					<b>TIN No. -</b> 09355714092C<br />

					<b>CIN No. -</b> U72200DL2010PTC211676<br />
				</address>
			</td>

			<td width="2%">&nbsp;</td>

			<td width="12%">&nbsp;</td>

			<td width="37%">&nbsp;</td>

		</tr>

		<tr style="margin-top: 5%;">

			<td>&nbsp;</td>

			<td>&nbsp;</td>

			<td>&nbsp;</td>

			<td>
				<address class="small-text" style="font-size:11px;">HOSTMIDITECH LLP<br />

					<br />

					AUTHORISED SIGNATORY
				</address>
			</td>

		</tr>

		<tr>

			<td>&nbsp;</td>

			<td>&nbsp;</td>

			<td>&nbsp;</td>

			<td>&nbsp;</td>

		</tr>

		<tr>

			<td height="141" colspan="4" valign="top" style="font-size:11px; padding:0px !important;">
				<address class="small-text" style="font-size:11px;padding:0px !important;"><strong  style="font-size:11px;padding:0px !important;">Terms and Conditions</strong>
				<br />
					<strong>1. Payment options:</strong><br />

					&nbsp;&nbsp;i. Payments can be directly deposited in to HDFC Bank Account, Name: Supra India Tech Private Limited,<br />

					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Account Number: 00032560005623, IFSC Code: HDFC0000003<br />

					&nbsp;&nbsp;ii. Payments can be processed through an online payment gateway system available at www.miditech.co.in<br />

					<strong>2.</strong> No query will be entertained on the Bill unless it is brought to our notice within 10 days from the date of the invoice.<br />

					<strong>3. </strong>Disputes, if any will be settled in New Delhi Court only.<br />
				</address>
			</td>

		</tr>

		<tr>

			<td colspan="4" align="center">
				<span class="small-text" style="font-size:11px; padding:0px !important;">
					<strong  style="font-size:11px;padding:0px !important;">Regd.Office : </strong>S &ndash; 524, Neelkanth House, 302, 3rd Floor, School Block, Shakarpur, Delhi &ndash; 110 092
				</span>
			</td>

		</tr>

	</table>
</div>
<div class="footer" style="font-size:11px;">
	For Miditech PVT. LTD
	<p>Authorized Signatory</p>
</div>