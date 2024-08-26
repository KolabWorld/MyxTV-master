@extends('invoice/app')

{{-- Web site Title --}}
@section('title') Client Details :: @parent @stop

@section('scripts')
	<script type="text/javascript">
	$(function () {
		// Display the create invoice modal
		$('#create-invoice').modal('show');

		$('#create-invoice').on('shown', function () {
			$("#client_name").focus();
		});

		$().ready(function () {
			$("[name='client_name']").select2();
			 $("[name='state_id']").select2();
		});

		// Creates the invoice
		$('#invoice_create_confirm').click(function () {
			// Posts the data to validate and create the invoice;
			// will create the new client if necessar
			$.post("http://localhost/temp/invzo/aimsbuildmart/ivm/index.php/invoices/ajax/create", {
					invoice_type : $('#invoice_type').val(),
					client_name: $('#client_name').val(),
					invoice_date_created: $('#invoice_date_created').val(),
					invoice_group_id: $('#invoice_group_id').val(),
					invoice_time_created: '19:25:49',
					user_id: '1'
				},
				function (data) {
					var response = JSON.parse(data);
					
					if (response.success == '1') {
						// The validation was successful and invoice was created
						window.location = "http://localhost/temp/invzo/aimsbuildmart/ivm/index.php/invoices/view/" + response.invoice_id;
					}
					else {
						// The validation was not successful
						$('.control-group').removeClass('has-error');
						for (var key in response.validation_errors) {
							$('#' + key).parent().parent().addClass('has-error');
						}
					}
				});
		});
	});

</script>
@endsection

@section('model')
	<div id="create-invoice" class="modal col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2" role="dialog" aria-labelledby="modal_create_invoice" aria-hidden="true" style="display: none;">
	<form class="modal-content">
		<div class="modal-header">
			<a data-dismiss="modal" class="close"><i class="fa fa-close"></i></a>

			<h3>Create Invoice</h3>
		</div>
		<div class="modal-body">

			<input class="hidden" id="payment_method_id" value="">

			<div class="form-group">
				<label>Invoice State</label>

				<div class="controls">
					<select name="invoice_group_id" id="invoice_group_id" class="form-control">
						<option value=""></option>
							<option value="3">Delhi</option>
							<option value="4">Haryana</option>
							<option value="6">Other/CST</option>
							<option value="5">Uttar Pradesh</option>
							<option value="7">West Bengal</option>
					</select>
				</div>
			</div>

			<div class="form-group">
				<label for="client_name">Client</label>
				<select name="client_name" id="client_name" class="form-control select2-hidden-accessible" tabindex="-1" aria-hidden="true">
					<option value=" ISS Facility Services India Pvt. Ltd." selected=""> ISS Facility Services India Pvt. Ltd.  (HP CG)</option><option value="ALCATEL-LUCENT INDIA LIMITED">ALCATEL-LUCENT INDIA LIMITED  (HR)</option><option value="Bharti Airtel Limited">Bharti Airtel Limited  (HR)</option>                				
				</select>
			</div>

			<div class="form-group has-feedback">
				<label>Invoice Date</label>

				<div class="input-group">
					<input name="invoice_date_created" id="invoice_date_created" class="form-control datepicker" value="04-Jul-2018">
				<span class="input-group-addon">
					<i class="fa fa-calendar fa-fw"></i>
				</span>
				</div>
			</div>

		   <div class="form-group">
				<label for="state_name">Invoice Type</label>
				<select name="invoice_type" id="invoice_type" class="form-control" autofocus="autofocus">
					<option value="7">Default</option>                
				</select>
			</div>
		</div>

		<div class="modal-footer">
			<div class="btn-group">
				<button class="btn btn-danger" type="button" data-dismiss="modal">
					<i class="fa fa-times"></i> Cancel                
				</button>
				<button class="btn btn-success ajax-loader" id="invoice_create_confirm" type="button">
					<i class="fa fa-check"></i> Submit
				</button>
			</div>
		</div>

	</form>

</div>

@stop
@section('content')
	<div id="main-area">

	<div id="modal-placeholder">


</div>

	<script>
	$(function () {
		$('#save_client_note').click(function () {
			$.post('http://localhost/temp/invzo/aimsbuildmart/ivm/index.php/clients/ajax/save_client_note',
				{
					client_id: $('#client_id').val(),
					client_note: $('#client_note').val()
				}, function (data) {
										var response = JSON.parse(data);
					if (response.success == '1') {
						// The validation was successful
						$('.control-group').removeClass('error');
						$('#client_note').val('');

						$('#notes_list').load("http://localhost/temp/invzo/aimsbuildmart/ivm/index.php/clients/ajax/load_client_notes",
							{
								client_id: 69                            });
					}
					else {
						// The validation was not successful
						$('.control-group').removeClass('error');
						for (var key in response.validation_errors) {
							$('#' + key).parent().parent().addClass('error');
						}
					}
				});
		});

	});
</script>

<div id="headerbar">
	<div class="pull-left">
		<h1> ISS Facility Services India Pvt. Ltd.</h1>
	</div>
	<div class="pull-right btn-group">
		<a href="#" class="btn btn-sm btn-default client-create-invoice" data-client-name=" ISS Facility Services India Pvt. Ltd."><i class="fa fa-file-text" "=""></i> Create Invoice</a>
		<a href="http://localhost/temp/invzo/aimsbuildmart/ivm/index.php/clients/form/69" class="btn btn-sm btn-default">
			<i class="fa fa-edit"></i> Edit        </a>

		<a class="btn btn-sm btn-danger" href="http://localhost/temp/invzo/aimsbuildmart/ivm/index.php/clients/delete/69" onclick="return confirm('If you delete this client you will also delete any invoices, quotes and payments related to this client. Are you sure you want to permanently delete this client?');">
			<i class="fa fa-trash-o"></i> Delete        </a>
	</div>

</div>

<ul id="settings-tabs" class="nav nav-tabs nav-tabs-noborder">
	<li class="active"><a data-toggle="tab" href="#clientDetails" aria-expanded="true">Details</a></li>
	<li class=""><a data-toggle="tab" href="#clientInvoices" aria-expanded="false">Invoices &amp; Quotes</a></li>
	<li class=""><a data-toggle="tab" href="#clientPayments" aria-expanded="false">Payments</a></li>
</ul>

<div class="tabbable tabs-below">

	<div class="tab-content">

		<div id="clientDetails" class="tab-pane tab-info active">

			



			<div class="row">
			   <div class="col-xs-12"> 
				   
				   
					<h3> ISS Facility Services India Pvt. Ltd. (HP CG)</h3>
			   </div>
					<div class="col-xs-12 col-sm-6 col-md-6"> 
		<fieldset>
			<legend>Billing Address</legend>
					<p>
						 ISS Facility Services India Pvt. Ltd.<br>                        Ground Floor, Plot No-40 <br>                        Sec-18<br>                        Gurgaon                        HARYANA                        122001 
						(06)                        <br>IN                        <br>P: NA                        <br>M: NA                    </p>
		</fieldset>
					</div>
					 <div class="col-xs-12 col-sm-6 col-md-6">
					
					
					 <fieldset>
			<legend>Shipping Address</legend>
					<p>
					   Hewlett Packard Enterprise India Private Limited<br>                        Building No.2, DLF Cyber Green, DLF Cyber City,<br>                        1st to 4th floor, Tower D&amp;E, Phase III<br>                        Gurgaon                        Haryana                        122002                         (06)                        <br>IN                        <br>P: NA                        <br>M: NA                    </p>
		</fieldset>
					 </div>
			 
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
				</div>
			</div>

			<hr>

			<div class="row">
				<div class="col-xs-12 col-md-6">
					<h4>Contact Information</h4>
					<br>
					<table class="table table-condensed table-striped">
													<tbody><tr>
								<th>Email</th>
								<td>NA</td>
							</tr>
																			<tr>
								<th>Phone</th>
								<td>NA</td>
							</tr>
																			<tr>
								<th>Mobile</th>
								<td>NA</td>
							</tr>
																							</tbody></table>
				</div>

				<div class="col-xs-12 col-md-6">
					<h4>Tax Information</h4>
					<br>
					<table class="table table-condensed table-striped">
													<tbody><tr>
								<th>PAN no.</th>
								<td>AABCI3815M</td>
							</tr>
																			<tr>
								<th>GST no.</th>
								<td>06AABCI3815M1ZJ</td>
							</tr>
											   
					</tbody></table>
				</div>
			  
			</div>

			
			<hr>

			<div>
				<h4>Notes</h4>
				<br>

				<div id="notes_list">
									</div>
				<div class="panel panel-default panel-body">
					<form class="row">
						<div class="col-xs-12 col-md-10">
							<input name="client_id" id="client_id" value="69" type="hidden">
							<textarea id="client_note" class="form-control" rows="1"></textarea>
						</div>
						<div class="col-xs-12 col-md-2 text-center">
							<input id="save_client_note" class="btn btn-default btn-block" value="Add Notes" type="button">
						</div>
					</form>
				</div>
			</div>

		</div>

		<div id="clientInvoices" class="tab-pane table-content">
			<div class="table-responsive">
	<table class="table table-striped">

		<thead>
		<tr>
			<th>Status</th>
			<th>Invoice</th>
			 <th>Invoice Type</th>
			<th>Created</th>
			<th>Client Name</th>

			 <th>State Name</th>
			<th style="text-align: right;">Amount</th>
			<th>Options</th>
		</tr>
		</thead>

		<tbody>
					<tr>
				<td>
					<span class="label draft">
						Draft                    </span>
				</td>

				<td>
					<a href="http://localhost/temp/invzo/aimsbuildmart/ivm/index.php/invoices/view/758" title="Edit">
						HR-131                    </a>
				</td>
				 <td>
					Default                </td>
				<td>
					03-Nov-2017                </td>

				<td>
					<a href="http://localhost/temp/invzo/aimsbuildmart/ivm/index.php/clients/view/69" title="View Client">
						 ISS Facility Services India Pvt. Ltd.                    </a>
				</td>
				<td>
					Haryana                </td>

				<td class="amount ">
					<i class="fa fa-inr"></i>22,320.00                </td>

				<td>
					<div class="options btn-group">
						<a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">
							<i class="fa fa-cog"></i> Options                        </a>
						<ul class="dropdown-menu">
															<li>
									<a href="http://localhost/temp/invzo/aimsbuildmart/ivm/index.php/invoices/view/758">
										<i class="fa fa-edit fa-margin"></i> Edit                                    </a>
								</li>
														<li>
								<a href="http://localhost/temp/invzo/aimsbuildmart/ivm/index.php/invoices/generate_pdf/758" target="_blank">
									<i class="fa fa-print fa-margin"></i> Download PDF                                </a>
							</li>
							
															<li>
									<a href="http://localhost/temp/invzo/aimsbuildmart/ivm/index.php/invoices/delete/758" onclick="return confirm('If you delete this invoice you will not be able to recover it later. Are you sure you want to permanently delete this invoice?');">
										<i class="fa fa-trash-o fa-margin"></i> Delete                                    </a>
								</li>
													</ul>
					</div>
				</td>
			</tr>
					<tr>
				<td>
					<span class="label draft">
						Draft                    </span>
				</td>

				<td>
					<a href="http://localhost/temp/invzo/aimsbuildmart/ivm/index.php/invoices/view/757" title="Edit">
						HR130                    </a>
				</td>
				 <td>
					Default                </td>
				<td>
					02-Nov-2017                </td>

				<td>
					<a href="http://localhost/temp/invzo/aimsbuildmart/ivm/index.php/clients/view/69" title="View Client">
						 ISS Facility Services India Pvt. Ltd.                    </a>
				</td>
				<td>
					Haryana                </td>

				<td class="amount ">
					<i class="fa fa-inr"></i>47,200.00                </td>

				<td>
					<div class="options btn-group">
						<a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">
							<i class="fa fa-cog"></i> Options                        </a>
						<ul class="dropdown-menu">
															<li>
									<a href="http://localhost/temp/invzo/aimsbuildmart/ivm/index.php/invoices/view/757">
										<i class="fa fa-edit fa-margin"></i> Edit                                    </a>
								</li>
														<li>
								<a href="http://localhost/temp/invzo/aimsbuildmart/ivm/index.php/invoices/generate_pdf/757" target="_blank">
									<i class="fa fa-print fa-margin"></i> Download PDF                                </a>
							</li>
							
															<li>
									<a href="http://localhost/temp/invzo/aimsbuildmart/ivm/index.php/invoices/delete/757" onclick="return confirm('If you delete this invoice you will not be able to recover it later. Are you sure you want to permanently delete this invoice?');">
										<i class="fa fa-trash-o fa-margin"></i> Delete                                    </a>
								</li>
													</ul>
					</div>
				</td>
			</tr>
					<tr>
				<td>
					<span class="label draft">
						Draft                    </span>
				</td>

				<td>
					<a href="http://localhost/temp/invzo/aimsbuildmart/ivm/index.php/invoices/view/756" title="Edit">
						HR129                    </a>
				</td>
				 <td>
					Default                </td>
				<td>
					02-Nov-2017                </td>

				<td>
					<a href="http://localhost/temp/invzo/aimsbuildmart/ivm/index.php/clients/view/69" title="View Client">
						 ISS Facility Services India Pvt. Ltd.                    </a>
				</td>
				<td>
					Haryana                </td>

				<td class="amount ">
					<i class="fa fa-inr"></i>10,384.00                </td>

				<td>
					<div class="options btn-group">
						<a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">
							<i class="fa fa-cog"></i> Options                        </a>
						<ul class="dropdown-menu">
															<li>
									<a href="http://localhost/temp/invzo/aimsbuildmart/ivm/index.php/invoices/view/756">
										<i class="fa fa-edit fa-margin"></i> Edit                                    </a>
								</li>
														<li>
								<a href="http://localhost/temp/invzo/aimsbuildmart/ivm/index.php/invoices/generate_pdf/756" target="_blank">
									<i class="fa fa-print fa-margin"></i> Download PDF                                </a>
							</li>
							
															<li>
									<a href="http://localhost/temp/invzo/aimsbuildmart/ivm/index.php/invoices/delete/756" onclick="return confirm('If you delete this invoice you will not be able to recover it later. Are you sure you want to permanently delete this invoice?');">
										<i class="fa fa-trash-o fa-margin"></i> Delete                                    </a>
								</li>
													</ul>
					</div>
				</td>
			</tr>
					<tr>
				<td>
					<span class="label draft">
						Draft                    </span>
				</td>

				<td>
					<a href="http://localhost/temp/invzo/aimsbuildmart/ivm/index.php/invoices/view/755" title="Edit">
						HR125                    </a>
				</td>
				 <td>
					Default                </td>
				<td>
					01-Nov-2017                </td>

				<td>
					<a href="http://localhost/temp/invzo/aimsbuildmart/ivm/index.php/clients/view/69" title="View Client">
						 ISS Facility Services India Pvt. Ltd.                    </a>
				</td>
				<td>
					Haryana                </td>

				<td class="amount ">
					<i class="fa fa-inr"></i>87,084.00                </td>

				<td>
					<div class="options btn-group">
						<a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">
							<i class="fa fa-cog"></i> Options                        </a>
						<ul class="dropdown-menu">
															<li>
									<a href="http://localhost/temp/invzo/aimsbuildmart/ivm/index.php/invoices/view/755">
										<i class="fa fa-edit fa-margin"></i> Edit                                    </a>
								</li>
														<li>
								<a href="http://localhost/temp/invzo/aimsbuildmart/ivm/index.php/invoices/generate_pdf/755" target="_blank">
									<i class="fa fa-print fa-margin"></i> Download PDF                                </a>
							</li>
							
															<li>
									<a href="http://localhost/temp/invzo/aimsbuildmart/ivm/index.php/invoices/delete/755" onclick="return confirm('If you delete this invoice you will not be able to recover it later. Are you sure you want to permanently delete this invoice?');">
										<i class="fa fa-trash-o fa-margin"></i> Delete                                    </a>
								</li>
													</ul>
					</div>
				</td>
			</tr>
					<tr>
				<td>
					<span class="label draft">
						Draft                    </span>
				</td>

				<td>
					<a href="http://localhost/temp/invzo/aimsbuildmart/ivm/index.php/invoices/view/749" title="Edit">
						HR 123                    </a>
				</td>
				 <td>
					Default                </td>
				<td>
					17-Oct-2017                </td>

				<td>
					<a href="http://localhost/temp/invzo/aimsbuildmart/ivm/index.php/clients/view/69" title="View Client">
						 ISS Facility Services India Pvt. Ltd.                    </a>
				</td>
				<td>
					Haryana                </td>

				<td class="amount ">
					<i class="fa fa-inr"></i>5,900.00                </td>

				<td>
					<div class="options btn-group">
						<a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">
							<i class="fa fa-cog"></i> Options                        </a>
						<ul class="dropdown-menu">
															<li>
									<a href="http://localhost/temp/invzo/aimsbuildmart/ivm/index.php/invoices/view/749">
										<i class="fa fa-edit fa-margin"></i> Edit                                    </a>
								</li>
														<li>
								<a href="http://localhost/temp/invzo/aimsbuildmart/ivm/index.php/invoices/generate_pdf/749" target="_blank">
									<i class="fa fa-print fa-margin"></i> Download PDF                                </a>
							</li>
							
															<li>
									<a href="http://localhost/temp/invzo/aimsbuildmart/ivm/index.php/invoices/delete/749" onclick="return confirm('If you delete this invoice you will not be able to recover it later. Are you sure you want to permanently delete this invoice?');">
										<i class="fa fa-trash-o fa-margin"></i> Delete                                    </a>
								</li>
													</ul>
					</div>
				</td>
			</tr>
					<tr>
				<td>
					<span class="label draft">
						Draft                    </span>
				</td>

				<td>
					<a href="http://localhost/temp/invzo/aimsbuildmart/ivm/index.php/invoices/view/747" title="Edit">
						HR120                    </a>
				</td>
				 <td>
					Default                </td>
				<td>
					11-Oct-2017                </td>

				<td>
					<a href="http://localhost/temp/invzo/aimsbuildmart/ivm/index.php/clients/view/69" title="View Client">
						 ISS Facility Services India Pvt. Ltd.                    </a>
				</td>
				<td>
					Haryana                </td>

				<td class="amount ">
					<i class="fa fa-inr"></i>48,380.00                </td>

				<td>
					<div class="options btn-group">
						<a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">
							<i class="fa fa-cog"></i> Options                        </a>
						<ul class="dropdown-menu">
															<li>
									<a href="http://localhost/temp/invzo/aimsbuildmart/ivm/index.php/invoices/view/747">
										<i class="fa fa-edit fa-margin"></i> Edit                                    </a>
								</li>
														<li>
								<a href="http://localhost/temp/invzo/aimsbuildmart/ivm/index.php/invoices/generate_pdf/747" target="_blank">
									<i class="fa fa-print fa-margin"></i> Download PDF                                </a>
							</li>
							
															<li>
									<a href="http://localhost/temp/invzo/aimsbuildmart/ivm/index.php/invoices/delete/747" onclick="return confirm('If you delete this invoice you will not be able to recover it later. Are you sure you want to permanently delete this invoice?');">
										<i class="fa fa-trash-o fa-margin"></i> Delete                                    </a>
								</li>
													</ul>
					</div>
				</td>
			</tr>
				</tbody>

	</table>
</div>        </div>

		<div id="clientPayments" class="tab-pane table-content">
			<div class="table-responsive">
	<table class="table table-striped">

		<thead>
		<tr>
			<th>Payment Date</th>
			<th>Invoice Date</th>
			<th>Invoice</th>
			<th>Client</th>
			<th>Amount</th>
			<th>Payment Method</th>
			<th>Note</th>
			<th>Options</th>
		</tr>
		</thead>

		<tbody>
				</tbody>

	</table>
</div>        </div>
	</div>

</div>
</div>
@stop 

