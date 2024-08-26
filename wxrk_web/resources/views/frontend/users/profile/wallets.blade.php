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
											<div class="col-sm-3">
												<strong>Wallet Amount :</strong> {{$user->currency ? $user->currency->alias : ''}} {{$wallet ? $wallet->amount : 0.00}}
											</div>
											<div class="col-sm-3">
												<a href="/admin/users/{{$user->id}}/view/wallet/add-amount" class="btn btn-info btn-sm iframe cboxElement">Add Amount</a>
											</div>
										</div>
									</div>
									<hr>
									<div class="row">
										<div class="col-sm-12">
											<div class="box box-warning direct-chat direct-chat-warning">
												<!-- /.box-header -->
												<div class="box-body">
													<table id="table" class=" table table-striped" width="100%" border="0" cellspacing="1" cellpadding="3">
														<thead>
															<tr>
																<th>Amount</th>
								                                <th>Closing Balance</th>
								                                <th>Transaction Number</th>
								                                <th width="30%">Remark</th>
								                                <th>Transaction Time</th>
															</tr>
														</thead>
														<tbody>
															@foreach($transactions as $transaction)
																<tr>
																	<td>
																		{{$transaction->currency}} {{$transaction->amount}}
																	</td>
																	<td>
																		{{$transaction->currency}} {{$transaction->closing_balance}}
																	</td>
																	<td>
																		{{$transaction->transaction_no}}
																	</td>

																	<td>
																		{{$transaction->remark}}
																	</td>

																	<td>
																		{{date('M d, Y H:i:s', strtotime($transaction->created_at))}}
																	</td>
																</tr>
															@endforeach
												        </tbody>
													</table>
												</div>
												<!-- /.box-body -->
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
                "order" : [[4, "desc"]],
                "sDom": "<'row'<'col-md-2'l><'col-md-7'a><'col-md-2'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
                //"sPaginationType": "bootstrap",
                "processing": true,
                "fnDrawCallback": function (oSettings) {
                    $(".iframe").colorbox({
                        iframe: true,
                        width: "40%",
                        height: "60%",
                        onClosed: function () {
                            window.location.reload();
                        }
                    });
                }
            });
        });
    </script>
@endsection
