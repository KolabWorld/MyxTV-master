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
					<div class="active tab-pane" id="tab_6">
						<div class="box box-primary">
							<!-- form start -->
							<form role="form">
								<div class="box-body">
									<div class="row">
										<div class="col-sm-12 text-right">
											<!-- <button type="submit" class="btn btn-success">Add New Transaction</button> -->
										</div>
										<div class="profile-margin">
											<hr>
											<div class="col-sm-3">Total In: Rs. {{ $transactions->sum('amount')}}</div>
											<div class="col-sm-3">Total Fees: Rs. 0.00</div>
											<div class="col-sm-3">Total Out: Rs. 0.00</div>
											<div class="col-sm-3"><strong>Balance: Rs. {{ '' }}</strong>
											</div>
										</div>
									</div>
									<hr>
									<div class="row">
										<div class="col-sm-12">
											<div class="box box-warning direct-chat direct-chat-warning">
												{{--
												<div class="box-header with-border">
													<div class="row">
														<div class="col-sm-10">
															<p>874 Records Found, Page 1 of 18</p>
														</div>
														<div class="col-sm-2">
															<div class="input-group input-group-sm">
																<select class="form-control">
																	<option>1</option>
																	<option>2</option>
																</select>
																<span class="input-group-btn">
																	<button type="button" class="btn btn-info btn-flat">Go!</button>
																</span>
															</div>
														</div>
													</div>
												</div>--}}
												<!-- /.box-header -->
												<div class="box-body">
													<table id="table" class=" table table-striped" width="100%" border="0" cellspacing="1" cellpadding="3">
														<thead>
															<tr>
																<th>Date</th>
																<th>Transaction No</th>
																<th>Payment Method</th>
																<th>Amount</th>
																<th>Status</th>
															</tr>
														</thead>
														<tbody>
													        @foreach($transactions as $key => $transaction)
																<tr>
																	<td>
																		{{date('M d, Y h:i A',strtotime($transaction->created_at))}}
																	</td>
																	<td>
												                    	{{$transaction->channel_order_id}}
																	</td>
												                    <td>
												                        <strong>
												                        	@if($transaction->paymentChannel)
												                            	{{$transaction->paymentChannel->name}}
												                            @else
												                            	-
												                            @endif
												                        </strong>
												                    </td>
												                    <td>
												                    	{{$transaction->amount}}
																	</td>
																	<td>
						                                                @if($transaction->status == 'paid' || $transaction->status == 'completed')
						                                                	<a class='btn btn-success btn-xs' style='border-radius: 4px 10px;text-transform: capitalize;'>Paid</a>
						                                                @else
						                                                	<a class='btn btn-danger btn-xs' style='border-radius: 4px 10px;text-transform: capitalize;'>{{$transaction->status}}</a>
						                                                @endif
						                                            </td>
																</tr>
															@endforeach
												        </tbody>
													</table>
													{{--
													<hr>
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
													</div>--}}</div>
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
					<!-- /.tab-pane -->
					<!-- /.tab-pane -->
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
                "order" : [[0, "desc"]],
                "sDom": "<'row'<'col-md-2'l><'col-md-7'a><'col-md-2'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
                //"sPaginationType": "bootstrap",
                "processing": true,
				"pageLength": 25,
                "fnDrawCallback": function (oSettings) {

                }
            });
        });
    </script>
@endsection
