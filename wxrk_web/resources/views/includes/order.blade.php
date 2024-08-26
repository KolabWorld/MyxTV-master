<style type="text/css">
	@if($invoice->payment_status == 'paid')
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
</style>
<div class="invoice-box">
{{--
	<div class="invoice-ribbon">
		@if($invoice->payment_status == 'paid')
			<div class="ribbon-inner">paid</div>
		@elseif($invoice->payment_status == 'unpaid')
			<div class="ribbon-inner-cancel">unpaid</div>
		@else
			<div class="ribbon-inner-partial">partial</div>
		@endif	
	</div>
--}}
	<table cellpadding="0" cellspacing="0">
		<tr class="top">
			<td colspan="2">
				<table>
					<tr>
						<td class="title">
							<img src="/frontend/images/pdflogo.JPG" class="logo" style="max-width:230px;">
						</td>
						
						<td>
							<span class="headi" style="font-size: 22px;">Invoice: {{ $invoice->order_number }}</span><br>
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
							Company Name<br>
								{{$invoice->customer['billing_address']['name']}}<br>
								{{ $invoice->customer['billing_address']['address']}}<br>
								{{ $invoice->customer['billing_address']['city']}}, {{ $invoice->customer['billing_address']['state']}}<br>
								{{ $invoice->customer['billing_address']['country']}} - {{ $invoice->customer['billing_address']['postal_code']}}<br>
								@if($invoice->customer['billing_address']['gst_number'])
									<br><br>GSTIN: {{ $invoice->customer['billing_address']['gst_number']}}<br> 
								@endif
								
								 
						</td>
						
						<td><p class="lead marginbottom payment-info">Pay To</p>
						<address class="small-text">
                        Supra India Tech Private Limited<br>
SDF K-9, NSEZ, Noida-201305  India<br>
Ph.: +91-0120-4955500<br>
Email ID: Accounts@SupraITS.com
                    </address>
							<p class="lead marginbottom">From : {{$invoice->header['name']}}</p>
							Email:  {{$invoice->header['email']}}<br>
							Tel: {{$invoice->header['mobile']}}<br>
							Invoive No. {{ $invoice->uid }}<br>
							Invoice Date. {{ date('d-M-Y', strtotime($invoice->created_at)) }}<br>
							{{$invoice->header['address_line1']}}<br>
							{{$invoice->header['address_line2']}}<br>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		
		<tr class="heading">
			<td>
				Description
			</td>
			
			<td>
				Total Amount
			</td>
		</tr>
		@foreach($invoice->items as $key => $item)
		
		<tr class="details">
			<td class="small-text">
				<strong>
				<em>-</em> {{$item->productService ? $item->productService->name : ''}}
				</strong> ({{$item->host_name}})<br>
				@if(($item->productService) && ($item->productService->attributes))
					@foreach($item->productService->attributes as $attribute)
					&nbsp;» {{$attribute->name}}<br>
					@endforeach
				@endif	
			</td>
			<td>@numberFormat($item->total_amount)</td>

		</tr>
		@endforeach
		<tr class="heading">
			<td></td>
			
			<td>
			   	Sub Total: @currencyPDF($invoice->total_taxable_amount)
			</td>
		</tr>
		@if($invoice->total_discount)
		<tr class="heading">
			<td></td>
			
			<td>
				Discount : @currencyPDF($invoice->total_discount)
			</td>
		</tr>
		@endif
		<tr class="heading">
			<td></td>
			
			<td>
		  		Total Tax : @currencyPDF($invoice->total_tax)
		   	</td>
		</tr>
		<tr class="heading">
			<td></td>
			
			<td>
		  		Total INR : @currencyPDF($invoice->invoice_total)
		   	</td>
		</tr>
	</table>
	
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
<div class="footer">
	For Miditech PVT. LTD
	<p>Authorized Signatory</p>
</div>