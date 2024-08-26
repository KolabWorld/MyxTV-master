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
					<div class="active tab-pane " id="tab_4">
						<div class="box box-primary">
							<!-- form start -->
							<form role="form">
								<div class="box-body">
									<div class="row">
										<!-- <div class="col-sm-12 text-right">
											<button type="submit" class="btn btn-success">Add Time Billing Entries</button>
											<button type="submit" class="btn btn-success">Add Billable Item</button>
										</div> -->
									</div>
									<hr>
									<div>
										<!-- <ul class="list-inline">
											<li>Uninvoiced Items -</li>
											<li><strong>Rs. 0.00 (0)</strong>
											</li>
										</ul> -->
									</div>
									<hr>
									<div class="row">
										<div class="col-sm-12">
											<table id="table" class="table table-striped" width="100%" border="0" cellspacing="1" cellpadding="3">
												<thead>
													<tr>
														<th>S.No.</th>
						                                <th>Customer</th>
						                                <th>Domain</th>
														<th>Registrar</th>
														<th>Registration Date</th>
														<th>Expiry</th>
														<th>Next Due date</th>
														<th>Amount</th>
														<th>Recurring Amount</th>
														<th>Status</th>
						                                <!-- <th>Action</th> -->
													</tr>
												</thead>
												<tbody>
											        @foreach($domainslist as $key => $domainslistval)
														<tr>
															<td>{{ ($key + 1) }}</td>
										                    <td>
										                        <strong>
										                            {{$domainslistval->name}}
										                        </strong>
										                    </td>
										                    <td style="text-align: left;">
															{{$domainslistval->domain}}
															</td>
															<td>
				                                                {{$domainslistval->registrar}}
															</td>
															<td>
				                                                {{$domainslistval->registrationdate}}
															</td>
															<td>
				                                                {{$domainslistval->expirydate}}
				                                            </td>
															<td>
				                                                {{$domainslistval->nextduedate}}
				                                            </td>
															<td>
				                                                {{$domainslistval->firstpaymentamount}}
				                                            </td>
															<td>
				                                                {{$domainslistval->recurringamount}}
				                                            </td>
															<td>															
															@if($domainslistval->status=="Cancelled")
																<a class="btn btn-danger btn-xs" style="text-transform: capitalize;">Cancelled</a>
															@elseif($domainslistval->status=="Active")
																<a class="btn btn-success btn-xs" style="text-transform: capitalize;">Active</a>
															@else
																<a class="btn btn-warning btn-xs" style="text-transform: capitalize;">{{ $domainslistval->status }}</a>
															@endif
				                                            </td>
										                     
														</tr>
													@endforeach
										        </tbody>
											</table>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-12">
											<!-- <ul class="list-inline">
												<li>With Selected:</li>
												<li>
													<button type="button" class="btn btn-success">Invoice Selected Items</button>
												</li>
												<li>
													<button type="button" class="btn btn-danger">Invoice Selected Items</button>
												</li>
											</ul> -->
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
                "fnDrawCallback": function (oSettings) {

                }
            });
        });
    </script>
@endsection
