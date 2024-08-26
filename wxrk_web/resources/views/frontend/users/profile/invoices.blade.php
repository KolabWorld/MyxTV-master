@extends('admin.app')

@section('content')


@include('admin.users.partials.flash')

<section class="content-header">
		<h1 class="pull-left">
			#{{ $user->id }} {{ $user->name }}
		</h1>

  	<div class="form-group pull-right search-con">
		  <a href="/admin/users/{{$user->id}}/login" class="btn btn-info">Login as client</a>
	</div>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<!-- Custom Tabs -->
			<div class="nav-tabs-custom">
				@include('admin.users.partials.links')
				<div class="tab-content">
					<!-- /.tab-pane -->
					<div class="active tab-pane " id="tab_5">
						<div class="box box-primary">
							<!-- form start -->
							<form role="form">
								<div class="box-body">
									<div class="row">
										<div class="col-sm-4">
											<h4><b>Send Invoice Mail</b></h4>
											<form role="form" action="/admin/users/{{$user->id}}/user-invoice/send-email" method="post">
						                      	<input type="hidden" name="_token" value="{{ csrf_token() }}">
						                      	<div class="input-group input-group-sm">
						                        	<select  class="form-control select2" data-live-search="true" name="email_type" id="email_type">
						                          		<option value="">New Message</option>
						                          		@foreach($serverWelcomeEmails as $welcomeEmail)
								                          	<option value="{{$welcomeEmail->name}}">
								                          		{{$welcomeEmail->name}}
								                          	</option>
								                        @endforeach
						                        	</select>
						                        	<span class="input-group-btn">
						                          		<button type="submit" class="btn btn-info btn-flat">Go!</button>
						                        	</span>
						                      	</div>
						                    </form>
										</div>
									</div>
									<hr>
									<div class="row">
										<div class="col-sm-12">
											<div class="box box-warning direct-chat direct-chat-warning" style="padding:2%;">
												<!-- /.box-header -->
												<div class="box-body">
													<table id="table" class="table table-striped" width="100%" border="0" cellspacing="1" cellpadding="3">
														<thead>
															<tr>
																<th>Invoice #</th>
																<th>Type</th>
																<th>Invoice Date</th>
																<th>Due Date</th>
																<th>Total Amount</th>
																<th>Payment Status</th>
																<th>Status</th>
																<th>Actions</th>
															</tr>
														</thead>
														<tbody></tbody>
													</table>
													<hr>
													{{--
													<div class="row">
														<div class="col-sm-12">
															<ul class="list-inline" style="margin-left: 10px;">
																<li>With Selected:</li>
																<li>
																	<button type="button" class="btn btn-success">Mark Paid</button>
																</li>
																<li>
																	<button type="button" class="btn btn-default">Mark Unpaid</button>
																</li>
																<li>
																	<button type="button" class="btn btn-default">Mark Cancelled</button>
																</li>
																<li>
																	<button type="button" class="btn btn-default">Duplicate Invoice</button>
																</li>
																<li>
																	<button type="button" class="btn btn-default">Send Reminder</button>
																</li>
																<li>
																	<button type="button" class="btn btn-default">Merge</button>
																</li>
																<li>
																	<button type="button" class="btn btn-default">Mass Pay</button>
																</li>
																<li>
																	<button type="button" class="btn btn-danger">Delete</button>
																</li>
															</ul>
														</div>
													</div>
													<hr>
													<div class="">
														<div class="col-sm-12 form-group">
															<button type="button" class="btn btn-default pull-left">« Previous Page</button>
															<button type="button" class="btn btn-default pull-right">Next Page »</button>
														</div>
													</div>--}}
												</div>
												<!-- /.box-body -->
												<!-- /.box-footer-->
											</div>
										</div>
									</div>
								</div>
								<!-- /.box-body -->
							</form>
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

@section('styles')
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
	.link-btn li{
		background-color: #3a638b;
		color: #fff;
		padding: 2px 15px;
		border-radius: 5px;
	}
	.link-btn li a.no{ color: #ff9191;}
	.link-btn li a.yes{color: #c5ff97;}
	.cus_col {
		float: left;
		width: 100%;
		margin-top: 20px;
		display: flex;
	}
	.cus_col h4{ margin-bottom: 0;}
	.box-body .form-group .checkbox {
		margin-top: 0;
	}

</style>
@endsection

{{-- Scripts --}}
@section('scripts')
    @parent
    <script type="text/javascript">
        var oTable;
        $(document).ready(function () {
            oTable = $('#table').DataTable({
                "order" : [[1, "desc"]],
                "sDom": "<'row'<'col-md-2'l><'col-md-7'a><'col-md-2'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
                //"sPaginationType": "bootstrap",
                "processing": true,
                "serverSide": true,
				"pageLength": 25,
                "ajax": '/admin/invoices/dataclient?user_id={{$user->id}}',
                "columns": [
					
                    { data: 'invoice_number', name: 'invoice_number' },
					{ data: 'invoice_type', name: 'invoice_type' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'due_date', name: 'due_date' },
                    { data: 'invoice_total', name: 'invoice_total' },
                    { data: 'payment_status', name: 'payment_status' },
                    { data: 'status', name: 'status' },
                    { data: 'actions', name: 'actions',"width": "8%" }
                ],
                "fnDrawCallback": function (oSettings) {
                    $(".iframe").colorbox({
                        iframe: true,
                        width: "80%",
                        height: "80%",
                        onClosed: function () {
                            window.location.reload();
                        }
                    });
                }
            });
        });
    </script>
@endsection
