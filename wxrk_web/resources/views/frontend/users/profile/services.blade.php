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
				@if(session('message'))
                        <h4 style="font-style: italic;color:green;background-color: #f0c3c3;padding: 5px;">
                            {{ session('message') }}
                        </h4>
                    @endif   
				<div class="tab-content">
					<div class="active tab-pane" id="tab_3">

						<div class="box box-primary">
							<div class="box-body">
								<div class="row">
									<div class="col-sm-6">
										<!-- form start -->
										<form role="form">
											<div class="input-group input-group-sm">
												<select  class="form-control select2" data-live-search="true" name="service_id" id="service_id">
													<option value="">Select Service</option>
													@foreach($user->services as $service)
														<option value="{{$service->id}}"
														 	@if($userService && $userService->id == $service->id)
															 	selected="selected"
															@endif
															style="<?php echo (($service->status !=='active')?'background-color: #ea9d9d;':'');?>"
														>
															{{$service->product_service_name}} - {{$service->host_name}}  - {{$service->status}}
														</option>
													@endforeach
												</select>
												<span class="input-group-btn">
													<button type="submit" style="margin-top: 28px;" class="btn btn-info btn-flat">Go!</button>
												</span>
											</div>
										</form>
									</div>
									<div class="col-sm-6 text-right">
										@if($userService)
											<a href="/admin/user-service/{{$userService->id}}/sendcurrentinvoice?service_id={{ app('request')->input('service_id') }}" class="btn btn-info">Send Invoice</a>
											<a href="/admin/user-service/{{$userService->id}}/move" class="btn btn-info iframe cboxElement">Move Service</a>
											<a href="/admin/user-service/{{$userService->id}}/upgrade" class="btn btn-success">Upgrade/Downgrade</a>
											<!-- <a href="/admin/user-service/{{$userService->id}}/upgrade" class="btn btn-success">Move Product/Service</a> -->
										@endif
									</div>
								</div>
								<hr>
								@if($userService)
								<form action="/admin/users/{{$userService->user_id}}/view/update-service" method="post">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<input type="hidden" name="user_id" value="{{$userService->user_id}}">
									<input type="hidden" name="id" value="{{$userService->id}}">
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label>Product/Service</label>
												<select class="form-control" name="product_service_id">
													<option value="{{$userService ? $userService->product_service_id : ''}}">
														{{$userService ? $userService->product_service_name." - ".$userService->host_name : ''}}
													</option>
												</select>
											</div>
											<div class="form-group {{{ $errors->has('server_id') ? 'has-error' : '' }}}">
												<label for="server_id">
													<strong>Server*</strong>
												</label>
												<select name="server_id" class="form-control select2" data-live-search="true" id="server_id">
													<option value="">-- Select Server --</option>
													@foreach($serverModules as $val)
														<option value="{{$val->id}}" @if(isset($userService) && ($userService->server_id == $val->id) || (old('server_id') == $val->id)) selected @endif>{{$val->name}}</option>
													@endforeach
												</select>
												{!! $errors->first('server_id', '<label class="control-label"  for="server_id">:message</label>')!!}
											</div>
											<div class="form-group">
												<label>Hostname*</label>
												<input type="text" class="form-control" placeholder="Hostname" name="host_name" id="host_name" value="{{ $userService->host_name ?? ''}}">
											</div>
											<div class="form-group">
												<label>Dedicated IP</label>
												<input type="text" class="form-control" id="dedicated_ip" name="dedicated_ip" value="{{ $userService->dedicated_ip ?? ''}}" placeholder="">
											</div>
											<div class="form-group">
												<label>Username*</label>
												<div class="input-group">
													<input type="text" class="form-control" name="user_name" id="user_name" value="{{ $userService->user_name ?? ''}}" placeholder="">
													<span class="input-group-addon">
														<a href="#">
															<span class="badge bg-green">login to control panel</span>
														</a>
													</span>
												</div>
											</div>
											<div class="form-group">
												<label>Password*</label>
												<input type="text" class="form-control" name="root_password" id="root_password" value="{{ $userService->root_password ?? ''}}" placeholder="">
											</div> 
											<div class="form-group {{{ $errors->has('status') ? 'has-error' : '' }}}">
												<label for="status">
													<strong>Status</strong>
												</label>
												<?php
													$userService->status = $userService->status=='canceled'?'cancelled':$userService->status;
													 
												?>
												<select name="status" class="form-control select2" data-live-search="true" id="status">
													<option value="">-- Select Status --</option>
													@foreach($serviceStatus as $val)
														<option value="{{$val}}" @if(isset($userService) && (strtolower($userService->status) == strtolower($val)) || (old('status') == $val)) selected @endif>{{ucfirst($val)}}</option>
													@endforeach
												</select>
												{!! $errors->first('status', '<label class="control-label"  for="status">:message</label>')!!}
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label>Registration Date</label>
												<div class="input-group">
													<input type="date" class="form-control" value="{{date('Y-m-d', strtotime($userService->created_at))}}" readonly="true">
													<span class="input-group-addon">
														<i class="fa fa-calendar"></i>
													</span>
												</div>
											</div>
											<div class="form-group">
												<label>First Payment Amount {{$userService->currency->alias}}</label>
												<input type="text" class="form-control" name="unit_price" value="{{$userService->unit_price}}">
											</div>
											<div class="form-group">
												<label>Recurring Amount {{$userService->currency->alias}}</label>
												<div class="input-group">
													<input type="text" class="form-control" name="unit_price" value="{{$userService->unit_price}}">
													<span class="input-group-addon">
														<input type="checkbox"> Auto Recalculate on Save
													</span>
												</div>
											</div>
											<div class="form-group">
												<label>Due Date</label>
												<div class="input-group">
													<input type="date" class="form-control" name="due_date" value="{{ $userService->due_date ? date('Y-m-d', strtotime($userService->due_date)) : ''}}">
													<span class="input-group-addon">
														<i class="fa fa-calendar"></i>
													</span>
												</div>
											</div>
											<div class="form-group">
												<label>Next Due Date</label>
												<div class="input-group">
													<input type="date" class="form-control" name="next_due_date" value="{{ $userService->next_due_date ? date('Y-m-d', strtotime($userService->next_due_date)) : ''}}">
													<span class="input-group-addon">
														<i class="fa fa-calendar"></i>
													</span>
												</div>
											</div>
											<div class="form-group">
												<label>Termination Date</label>
												<div class="input-group">
													<input type="date" class="form-control" name="termination_date" value="{{ $userService->termination_date ? date('Y-m-d', strtotime($userService->termination_date)) : ''}}">
													<span class="input-group-addon">
														<i class="fa fa-calendar"></i>
													</span>
												</div>
											</div>
											<div class="form-group">
												<label>Billing Cycle</label>
												<select class="form-control" name="mode">
													 
													<option value="monthly" {{($userService->mode == 'monthly') ? 'selected' : '' }}>
                                                    Monthly
                                                </option>
                                                <option value="quarterly" {{($userService->mode == 'quarterly') ? 'selected' : '' }}>
                                                    Quarterly
                                                </option>
                                                <option value="half-yearly" {{($userService->mode == 'half-yearly') ? 'selected' : '' }}>
                                                    Semi-Annually
                                                </option>
                                                <option value="yearly" {{($userService->mode == 'yearly') ? 'selected' : '' }}>
                                                    Annually
                                                </option>

												</select>
											</div>
											<!-- <div class="form-group">
												<label>Payment Method</label>
												<div class="input-group">
													<input type="text" class="form-control" placeholder="">	<span class="input-group-addon"><a href="#"><span class="badge bg-green">View Invoices</span>
													</a>
													</span>
												</div>
											</div>
											<div class="form-group">
												<label>Promotion Code</label>
												<div class="input-group">
													<select class="form-control">
														<option>option 1</option>
														<option>option 2</option>
														<option>option 3</option>
														<option>option 4</option>
														<option>option 5</option>
													</select>	<span class="input-group-addon">(Change will not affect price)</span>
												</div>
											</div> -->
										</div>
										<div class="col-sm-12">
											<div class="form-group">
												<label>Assigned IPs</label>
												<textarea class="form-control" rows="3" name="assigned_ips" placeholder="Enter ...">{{ $userService->assigned_ips ?? ''}}</textarea>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label>Nameserver 1</label>
												<input type="text" class="form-control" placeholder="Nameserver 1" name="ns1_prefix" value="{{ $userService->ns1_prefix ?? ''}}">
											</div>
											<div class="form-group">
												<label>Nameserver 2</label>
												<input type="text" class="form-control" placeholder="Nameserver 2" name="ns2_prefix" value="{{ $userService->ns2_prefix ?? ''}}">
											</div>

											@foreach($userService->configOptions as $option)
												<div class="form-group">
													<label>{{$option->config_group_service_name}}</label>
													<div class="input-group">
														<input type="text" class="form-control" value="{{$option->config_service_option_name}}" placeholder="" readonly="true">
														<span class="input-group-addon">X QTY: {{$option->quantity}} Rs. {{$option->total_amount}}</span>
													</div>
												</div>
											@endforeach
											<!--<div class="form-group">
												<label>Module Commands</label>
												<br>
												<button type="button" class="btn btn-default" onclick="jQuery('#modalModuleCreate').modal('show');" id="btnCreate">Create</button>
												<button type="button" class="btn btn-default" onclick="jQuery('#modalModuleSuspend').modal('show');" id="btnSuspend">Suspend</button>
												<button type="button" class="btn btn-default" onclick="jQuery('#modalModuleUnsuspend').modal('show');" id="btnUnsuspend">Unsuspend</button>
												<button type="button" class="btn btn-default" onclick="jQuery('#modalModuleTerminate').modal('show');" id="btnTerminate">Terminate</button>
												<button type="button" class="btn btn-default" onclick="jQuery('#modalModuleChangePackage').modal('show');" id="btnChange_Package">Change Package</button>
												<button type="button" class="btn btn-default" onclick="runModuleCommand('custom','restart')" id="btnRestart">Restart</button>
											</div>-->
											<div class="form-group">
												<label></label>
												<br>
											</div>
										</div>
										{{--
										<div class="col-sm-12">
											<div class="form-group">
												<label>Addons</label>
												<br>
												<table class=" table table-striped" width="100%" border="0" cellspacing="1" cellpadding="3">
													<tbody>
														<tr>
															<th>Reg Date</th>
															<th>Name</th>
															<th>Pricing</th>
															<th>Status</th>
															<th>Next Due Date</th>
															<th></th>
															<th></th>
														</tr>
														<tr style="">
															<td>No Records Found</td>
														</tr>
														<tr>
															<td>
																<button type="button" class="btn btn-default"><i class="fa fa-plus"></i> Add New Addon</button>
															</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label>Subscription ID</label>
												<input type="text" class="form-control" placeholder="">
											</div>
											<div class="form-group">
												<label>Override Auto-Suspend</label>
												<div class="input-group">
													<span class="input-group-addon">
														<input type="checkbox"> Do not suspend until
													</span>
													<input type="text" class="form-control">
													<span class="input-group-addon">
														<i class="fa fa-calendar"></i>
													</span>
												</div>
											</div>
											<div class="form-group">
												<label>Auto-Terminate End of Cycle</label>
												<div class="input-group">
													<span class="input-group-addon">
														<input type="checkbox"> Reason
													</span>
													<input type="text" class="form-control">
													<span class="input-group-addon">
														<i class="fa fa-calendar"></i>
													</span>
												</div>
											</div>
										</div>
										<div class="col-sm-12">
											<div class="form-group">
												<label>Admin Notes</label>
												<textarea class="form-control" rows="3" placeholder="Enter ..."></textarea>
											</div>
										</div>
										--}}

										<div class="col-sm-12">
											<div class="form-group">
												<!-- /.box-body -->
												<div class="box-footer text-right">
													<button type="submit" class="btn btn-success">Save Chnages</button>
													<!-- <button type="submit" class="btn btn-danger">Cancel Chnages</button>
													<button type="submit" class="btn btn-danger">Delete</button> -->
												</div>
											</div>
										</div>
									</div>
								</form>
								<div class="row">
									<div class="col-sm-4 col-md-4">
					                    <h4>
					                    	<b>Send Message</b>
					                    </h4>
					                    <form role="form" id="frmemail" action="/admin/users/{{$user->id}}/user-service/{{$userService->id}}/send-email" method="post">
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
					                          		<button type="button" class="btn btn-info btn-flat" onclick="checkdatafilled();">Go!</button>
					                        	</span>
					                      	</div>
					                    </form>
					                </div>
								</div>
								@endif
							</div>
						</div>
					</div>
				</div>
				<script>
					function checkdatafilled(){  
						 if($("#server_id").val()=="" || $("#dedicated_ip").val()=="" || $("#dediroot_passwordcated_ip").val()==""
						  || $("#host_name").val()=="" || $("#user_name").val()==""){
							  alert("Please fill and save all the values in above form before sending eny email.");
							  return false;
						  }
						  $('form#frmemail').submit();

					}
				</script>
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
        $(document).ready(function () {
            $(".iframe").colorbox({
                iframe: true,
                width: "40%",
                height: "50%",
                onClosed: function () {
                    window.location.reload();
                }
            });
        });
    </script>
@endsection
