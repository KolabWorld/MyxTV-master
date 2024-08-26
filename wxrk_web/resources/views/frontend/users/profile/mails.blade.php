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
												<strong>Number Of Mails :</strong> ({{count($mails)}})
											</div>
											<div class="col-sm-6"></div>
											<div class="col-sm-3" style="text-align: right;">
												<strong>
													{{$user->name}}
												</strong>
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
																<th>Subject</th>
								                                <th>Category</th>
								                                <th>Status</th>
								                                <th style="width:30%">Description</th>
								                                <th>Attachment</th>
								                                <th>Send Date</th>
															</tr>
														</thead>
														<tbody>
															@if(!empty($mails))
													        	@foreach($mails as $mail)
																	<tr>
																		<td>
																			{{$mail->subject}}
																		</td>
																		<td>
																			{{$mail->category}}
																		</td>
																		<td>
																			@if($mail->status == 'success')
																				<a class="btn btn-success btn-sm">
																					{{$mail->status}}
																				</a>
																			@elseif($mail->status == 'failed')
																				<a class="btn btn-danger btn-sm">
																					{{$mail->status}}
																				</a>
																			@else
																				<a class="btn btn-warning btn-sm">
																					{{$mail->status}}
																				</a>
																			@endif
																		</td>
																		<td style="width:30%">
																			@foreach(json_decode($mail->mail_body, true) as $key => $content)
																			<b>{{$key}}:</b>  {!! $content !!} <br/>
																			@endforeach
																		</td>
																		<td>
																			{!! $mail->attachment !!}
																		</td>
																		<td>
																			{{date('M d, Y H:i:s', strtotime($mail->created_at))}}
																		</td>
																	</tr>
																@endforeach
															@else
																<tr>
																	<td colspan="5" class="textcenter">
																		There are currently no mail.
																	</td>
																</tr>
															@endif
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
                "order" : [[5, "desc"]],
                "sDom": "<'row'<'col-md-2'l><'col-md-7'a><'col-md-2'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
                //"sPaginationType": "bootstrap",
                "processing": true,
                "fnDrawCallback": function (oSettings) {

                }
            });
        });
    </script>
@endsection
