@extends('admin.app')

@section('content')


@include('admin.users.partials.flash')

<section class="content-header">
        <!--<h1>Users <small>Platform Users</small></h1>-->
                    <h1>Transaction List</h1>

        <ol class="breadcrumb">
            <li>
                <a href="/admin">
                    <i class="fa fa-dashboard"></i> Home
                </a>
            </li>
            <li class="active">
                                    Transaction List

            </li>
        </ol>
    </section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<!-- Custom Tabs -->
			<div class="nav-tabs-custom">

				<div class="tab-content">
					<div class="active tab-pane" id="tab_6">
						<div class="box box-primary">
							<!-- form start -->
							<form role="form">
								<div class="box-body">

									<div class="row">
										<div class="col-sm-12">
											<div class="">
												<div class="container">
													<div class="col-md-6 pull-left" >
														<h1 style="font-size: 24px; background: #c4f97f; padding: 10px; margin: 0px;height: 51px;
    width: 344px;">
													<?php
														if(isset($totalCurrencyWise[0]->total))
																echo "<span style='float:left'>".$totalCurrencyWise[0]->total." ".$totalCurrencyWise[0]->currency.'</span>';
																if(isset($totalCurrencyWise[1]->total))
																		echo "<span style='float:right'>".$totalCurrencyWise[1]->total." ".$totalCurrencyWise[1]->currency.'</span>';
													 ?></h1>
												 </div>
												  <div class="col-md-6 pull-right" style="margin-right: -37px;">
														<div class="col-md-4 pull-right"><button type="submit" class="btn btn-info btn-flat">Go!</button>
</div><div class="col-md-8 pull-right">
												    <div class="input-group input-daterange">

<input type="date" class="form-control date-range-filter" name="from_date" value="{{ app('request')->input('from_date') }}">
												      <div class="input-group-addon">to</div>

												      <input type="date" name="to_date" id="to_date" class="form-control date-range-filter  date-range-filter" value="{{ app('request')->input('to_date') }}" >
												    </div> </div>
												  </div>
												</div>
												<!-- /.box-header -->
												<div class="box-body">
													<table id="table" class=" table table-striped" width="100%" border="0" cellspacing="1" cellpadding="3">
														<thead>
															<tr>
																<th>Txn ID.</th>
																<th>Date</th>
																<th>Name</th>
																<th>Email</th>
																<th>Transaction No</th>
																<th>Payment Method</th>
																<th>Amount</th>
																<th>Status</th>
															</tr>
														</thead>
														<tbody>
													        @foreach($transactions as $key => $transaction)
																<tr>
																	<td><a href="/admin/invoice/{{$transaction->payable_id}}/view" target="_blank">TRXN{{$transaction->id}}</a></td>
																	<td>
																		{{date('M d, Y h:i A',strtotime($transaction->created_at))}}
																	</td>
																	<td><a href="/admin/users/{{$transaction->user_id}}/view" target="_blank">{{$transaction->payee_name}}</a></td>
																	<td>{{$transaction->payee_email}}</td>
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
												                    <td>{{$transaction->amount}} {{$transaction->currency}}</td>
																	<td>
						                                                @if($transaction->status == 'paid')
						                                                	<a class='btn btn-success btn-xs' style='border-radius: 4px 10px;text-transform: capitalize;'>Paid</a>
						                                                @else
						                                                	<a class='btn btn-danger btn-xs' style='border-radius: 4px 10px;text-transform: capitalize;'>Unpaid</a>
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
								"pageLength": 50,
                "fnDrawCallback": function (oSettings) {

                }
            });
        });
    </script>
@endsection
