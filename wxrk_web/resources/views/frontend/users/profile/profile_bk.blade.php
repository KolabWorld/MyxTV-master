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
					<div class="active tab-pane" id="tab_2">
						<div class="box box-primary">
							<!-- form start -->
							<form role="form" action="/admin/users/update" method="post">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<input type="hidden" name="id" value="{{$user->id}}">
								<input type="hidden" name="user_type" value="{{$user->user_type}}">
								<div class="box-body">
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label>Name</label>
												<input type="text" class="form-control" placeholder="Name" name="name" value="{{ $user->name ?? ''}}">
											</div>
											<div class="form-group">
												<label>Company Name</label>
												<div class="input-group">
													<input type="text" class="form-control" placeholder="Company Name" name="company_name" value="{{ $user->company_name ?: ''}}"> <span class="input-group-addon">Optional</span>
												</div>
											</div>
											<div class="form-group">
												<label for="exampleInputEmail1">Email address</label>
												<input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email" name="email" value="{{ $user->email ?? ''}}">
											</div>
											<div class="form-group">
												<label style="width:100%;">Password</label>
												<input type="password" style="float:left;width:50%;" class="form-control" placeholder="" name="password" style="width:50%;">
												<a href="/admin/users/{{$user->id}}/reset-password" style="float:left;" class="btn btn-success">Reset & Send Password</a>
												 
											</div>
										<!--	<div class="form-group {{{ $errors->has('security_question_id') ? 'has-error' : '' }}}">
												<label for="country">
													<strong>Security Question</strong>
												</label>
												<select name="security_question_id" class="form-control select2" data-live-search="true" id="security_question_id">
													<option value="">-- Select Question --</option>
													@foreach($securityQuestions as $val)
														<option value="{{$val->id}}" @if(isset($userProfile) && ($userProfile->security_question_id == $val->id) || (old('security_question_id') == $val->id)) selected @endif>{{$val->name}}</option>
													@endforeach
												</select>
												{!! $errors->first('security_question_id', '<label class="control-label"  for="security_question_id">:message</label>')!!}
											</div>
											<div class="form-group {{{ $errors->has('security_answer') ? 'has-error' : '' }}}">
												<label>Security Answer</label>
												<input type="text" class="form-control" value="@if(isset($userProfile)){{$userProfile->security_answer}}@else{{old('security_answer')}}@endif" name="security_answer" placeholder="Security Answer">
												{!! $errors->first('security_answer', '<label class="control-label"  for="security_answer">:message</label>')!!}
											</div>-->
											<div class="form-group" style="width:100%;clear:both;">
												<label>Become A Reseller</label>
												<div class="checkbox">
													<label>
														<input type="checkbox" value="1" name="is_reseller" id="is_reseller" {{ (isset($user) && $user->is_reseller == 1 ) ? 'checked' : ''}}> Become A Reseller
													</label>
												</div>
											</div>
											<div class="form-group" id="reseller_type_div" style="display: {{$user->reseller_type ? 'block' : 'none'}};">
												<label>Reseller Type</label>
												<input type="text" class="form-control" placeholder="" name="reseller_type" value="{{ $user->reseller_type ?? ''}}">
											</div>
											<div class="form-group">
												<label>Tax Exempt</label>
												<div class="checkbox">
													<label>
														<input type="checkbox" name="tax_exempt" value="1" {{ (isset($user) && $user->tax_exempt == 1 ) ? 'checked' : ''}}> Tax Exempt
													</label>
												</div>
											</div>
											<div class="form-group">
												<label for="exampleInputEmail1">Additional Email address (Saperate with , (comma))</label>
												<input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter email" name="alternate_emailids" value="{{ $user->alternate_emailids ?? ''}}">
											</div>
										<!--	<div class="form-group">
												<label>Late Fees</label>
												<div class="checkbox">
													<label>
														<input type="checkbox" value="1" name="is_late_fee" {{ (isset($userProfile) && $userProfile->is_late_fee == 1 ) ? 'checked' : ''}}> Don't Apply Late Fees</label>
												</div>
											</div>
											<div class="form-group">
												<label>Overdue Notices</label>
												<div class="checkbox">
													<label>
														<input type="checkbox" value="1" name="is_overdue_notice" {{ (isset($userProfile) && $userProfile->is_overdue_notice == 1 ) ? 'checked' : ''}}> Don't Send Overdue Emails</label>
												</div>
											</div>
											<div class="form-group">
												<label>
													<strong>Tax Exempt</strong>
												</label>
												<div class="checkbox">
													<label>
														<input type="checkbox" value="1" name="is_tax_exempt" {{ (isset($userProfile) && $userProfile->is_tax_exempt == 1 ) ? 'checked' : ''}}> Don't Apply Tax to Invoices</label>
												</div>
											</div>
											<div class="form-group">
												<label>
													<strong>Separate Invoices</strong>
												</label>
												<div class="checkbox">
													<label>
														<input type="checkbox" value="1" name="is_seperate_invoice" {{ (isset($userProfile) && $userProfile->is_seperate_invoice == 1 ) ? 'checked' : ''}}> Separate Invoices for Services</label>
												</div>
											</div>
											<div class="form-group">
												<label>
													<strong>Disable CC Processing</strong>
												</label>
												<div class="checkbox">
													<label>
														<input type="checkbox" value="1" name="is_cc_processing" {{ (isset($userProfile) && $userProfile->is_cc_processing == 1 ) ? 'checked' : ''}}> Disable Automatic CC Processing</label>
												</div>
											</div>
											<div class="form-group">
												<label>
													<strong>Marketing Emails Opt-out</strong>
												</label>
												<div class="checkbox">
													<label>
														<input type="checkbox" value="1" name="is_marketing_email" {{ (isset($userProfile) && $userProfile->is_marketing_email == 1 ) ? 'checked' : ''}}> Don't send client marketing emails</label>
												</div>
											</div>
											<div class="form-group">
												<label>
													<strong>Status Update</strong>
												</label>
												<div class="checkbox">
													<label>
														<input type="checkbox" value="1" name="is_automatic_status_update" {{ (isset($userProfile) && $userProfile->is_automatic_status_update == 1 ) ? 'checked' : ''}}> Disable Automatic Status Update</label>
												</div>
											</div>
											<div class="form-group">
												<label>
													<strong>Allow Single Sign-On</strong>
												</label>
												<div class="checkbox">
													<label>
														<input type="checkbox" value="1" name="is_single_sign_on" {{ (isset($userProfile) && $userProfile->is_single_sign_on == 1 ) ? 'checked' : ''}}>Tick to allow Single Sign-On</label>
												</div>
											</div>
											<div class="form-group">
												<label>
													<strong>Register as a Partner</strong>
												</label>
												<div class="checkbox">
													<label>
														<input type="checkbox" value="1" name="register_as_a_partner" {{ (isset($userProfile) && $userProfile->register_as_a_partner == 1 ) ? 'checked' : ''}}> Check it for Register as a Partner</label>
												</div>
											</div>
											<div class="form-group">
												<label>
													<strong>Two-Factor Authentication</strong>
												</label>
												<div class="checkbox">
													<label>
														<input type="checkbox" name="is_two_factor_authentication" value="1" {{ (isset($user->is_two_factor_authentication) && $user->two_step_verification == 1 ) ? 'checked' : ''}}> Enabled - Uncheck to disable
													</label>
												</div>
											</div>-->
										</div>
										<div class="col-sm-6">
											<div class="form-group {{{ $errors->has('line_1') ? 'has-error' : '' }}}">
												<label for="state">
													<strong>Address 1
														<!-- <span class="mendatory" style="color:red"> *</span> -->
													</strong>
												</label>
												<input type="text" class="form-control" id="line_1" name="line_1" value="@if(isset($user->address)){{$user->address->line_1}}@else{{old('line_1')}}@endif" placeholder="Enter Address 1">
			                                	{!! $errors->first('line_1', '<label class="control-label"  for="line_1">:message</label>')!!}
											</div>
											<div class="form-group {{{ $errors->has('landmark') ? 'has-error' : '' }}}">
												<label for="landmark">
													<strong>Address 2</strong>
												</label>
												<div class="input-group">
													<input type="text" class="form-control" placeholder="Address line 2" name="line_2" value="@if(isset($user->address)){{$user->address->landmark}}@else{{old('landmark')}}@endif"> <span class="input-group-addon">Optional</span>
												</div>
			                                	{!! $errors->first('landmark', '<label class="control-label"  for="landmark">:message</label>')!!}
											</div>
											<div class="form-group {{{ $errors->has('country_id') ? 'has-error' : '' }}}">
												<label for="country">
													<strong>Country
														<!-- <span class="mendatory" style="color:red"> *</span> -->
													</strong>
												</label>
												<select name="country_id" class="form-control select2" data-live-search="true" onchange="getStates(this,'states')" id="country_id">
													<option value="">-- Select Country --</option>
													@foreach($countries as $val)
														<option value="{{$val->id}}" @if(isset($user->address) && ($user->address->country_id == $val->id) || (old('country_id') == $val->id)) selected @endif>{{$val->name}}</option>
													@endforeach
												</select>
												{!! $errors->first('country_id', '<label class="control-label"  for="country_id">:message</label>')!!}
											</div>
											<div class="form-group {{{ $errors->has('state_id') ? 'has-error' : '' }}}" id="states">
												<label for="state">
													<strong>State
														<!-- <span class="mendatory" style="color:red"> *</span> -->
													</strong>
												</label>
												<select name="blank_state" class="form-control select2" data-live-search="true" id="blank_state">
													<option value="">-- Select State --</option>
												</select>
												{!! $errors->first('state_id', '<label class="control-label"  for="state_id">:message</label>')!!}
											</div>
											<div class="form-group {{{ $errors->has('city_id') ? 'has-error' : '' }}}" id="cities">
												<label for="state">
													<strong>City
														<!-- <span class="mendatory" style="color:red"> *</span> -->
													</strong>
												</label>
												<select name="blank_city" class="form-control select2" data-live-search="true" id="blank_city">
													<option value="">-- Select City --</option>
												</select>
												{!! $errors->first('city_id', '<label class="control-label"  for="city_id">:message</label>')!!}
											</div>
											<div class="form-group">
												<label for="postal_code">
													<strong>Postal Code</strong>
												</label>
												<input type="text" name="postal_code" id="postal_code" value="@if(isset($user->address)){{$user->address->postal_code}}@else{{old('postal_code')}}@endif" placeholder="Enter GSTIN No." class="form-control">
												{!! $errors->first('postal_code', '<label class="control-label"  for="postal_code">:message</label>')!!}
											</div>
											<div class="form-group">
												<label for="area">
													<strong>GSTIN</strong>
												</label>
												<input type="text" name="gst_number" id="gst_number" value="@if(isset($user->address)){{$user->address->gst_number}}@else{{old('gst_number')}}@endif" placeholder="Enter GSTIN No." class="form-control">
												{!! $errors->first('gst_number', '<label class="control-label"  for="gst_number">:message</label>')!!}
											</div>
											<div class="form-group">
												<label>Phone Number</label>
												<input type="text" class="form-control" placeholder="" name="mobile" value="{{ $user->mobile ?? ''}}">
											</div>
											<!--
											<div class="form-group {{{ $errors->has('payment_channel_id') ? 'has-error' : '' }}}">
												<label for="country">
													<strong>Payment Method</strong>
												</label>
												<select name="payment_channel_id" class="form-control select2" data-live-search="true" id="payment_channel_id">
													<option value="">-- Select Payment Method --</option>
													@foreach($paymentChannels as $val)
														<option value="{{$val->id}}" @if(isset($userProfile) && ($userProfile->payment_channel_id == $val->id) || (old('payment_channel_id') == $val->id)) selected @endif>{{$val->name}}</option>
													@endforeach
												</select>
												{!! $errors->first('payment_channel_id', '<label class="control-label"  for="payment_channel_id">:message</label>')!!}
											</div>
											<div class="form-group {{{ $errors->has('language_id') ? 'has-error' : '' }}}">
												<label for="country">
													<strong>Language</strong>
												</label>
												<select name="language_id" class="form-control select2" data-live-search="true" id="language_id">
													<option value="">-- Select Language --</option>
													@foreach($languages as $val)
														<option value="{{$val->id}}" @if(isset($userProfile) && ($userProfile->language_id == $val->id) || (old('language_id') == $val->id)) selected @endif>{{$val->name}}</option>
													@endforeach
												</select>
												{!! $errors->first('language_id', '<label class="control-label"  for="language_id">:message</label>')!!}
											</div>
											<div class="form-group {{{ $errors->has('currency_id') ? 'has-error' : '' }}}">
												<label for="country">
													<strong>Currency</strong>
												</label>
												<select name="currency_id" class="form-control select2" data-live-search="true" id="currency_id">
													<option value="">-- Select Currency --</option>
													@foreach($currencies as $val)
														<option value="{{$val->id}}" @if(isset($user) && ($user->currency_id == $val->id) || (old('currency_id') == $val->id)) selected @endif>{{$val->name}}</option>
													@endforeach
												</select>
												{!! $errors->first('currency_id', '<label class="control-label"  for="currency_id">:message</label>')!!}
											</div>
											<div class="form-group {{{ $errors->has('client_group_id') ? 'has-error' : '' }}}">
												<label for="country">
													<strong>Client Group</strong>
												</label>
												<select name="client_group_id" class="form-control select2" data-live-search="true" id="client_group_id">
													<option value="">-- Select Client Group --</option>
													@foreach($languages as $val)
														<option value="{{$val->id}}" @if(isset($userProfile) && ($userProfile->client_group_id == $val->id) || (old('client_group_id') == $val->id)) selected @endif>{{$val->name}}</option>
													@endforeach
												</select>
												{!! $errors->first('client_group_id', '<label class="control-label"  for="client_group_id">:message</label>')!!}
											</div>-->
											<div class="form-group {{{ $errors->has('status') ? 'has-error' : '' }}}">
												<label for="status">
													<strong>Status</strong>
												</label>
												<select name="status" class="form-control select2" data-live-search="true" id="status">
													<option value="">-- Select Status --</option>
													@foreach($userStatus as $val)
														<option value="{{$val}}" @if(isset($user) && ($user->status == $val) || (old('status') == $val)) selected @endif>{{$val}}</option>
													@endforeach
												</select>
												{!! $errors->first('status', '<label class="control-label"  for="status">:message</label>')!!}
											</div>
											<div class="form-group {{{ $errors->has('currency_id') ? 'has-error' : '' }}}">
												<label for="country">
													<strong>Currency</strong>
												</label>
												<select name="currency_id" class="form-control select2" data-live-search="true" id="currency_id">
													<option value="">-- Select Currency --</option>
													@foreach($currencies as $val)
														<option value="{{$val->id}}" @if(isset($user) && ($user->currency_id == $val->id) || (old('currency_id') == $val->id)) selected @endif>{{$val->name}}</option>
													@endforeach
												</select>
												{!! $errors->first('currency_id', '<label class="control-label"  for="currency_id">:message</label>')!!}
											</div>
										</div>
										<div class="col-sm-12">
											<div class="form-group">
												<label>Admin Notes</label>
												<textarea class="form-control" rows="3" name="admin_note" placeholder="Enter ...">@if(isset($userProfile)){{$userProfile->admin_note}}@else{{old('admin_note')}}@endif</textarea>
											</div>
										</div>
									</div>
								</div>
								<!-- /.box-body -->
								<div class="box-footer text-center">
									<button type="submit" class="btn btn-success">Save Changes</button>
									<button type="submit" class="btn btn-danger">Cancel Changes</button>
								</div>
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
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
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
@stop

@section('scripts')
	@parent
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
	<script type="text/javascript">
        $('#status').select2();
        $('#country_id').select2();
        $('#language_id').select2();
        $('#currency_id').select2();
        $('#client_group_id').select2();
        $('#payment_channel_id').select2();
        $('#security_question_id').select2();

        function getStates(th) {
            var countryId = $('#country_id').val();
            var stateId = "";

            @if(isset($user->address->state_id) && $user->address->state_id)
                stateId = '{{$user->address->state_id}}';
            @endif

            console.log(stateId);
            var data = {
                country_id : countryId,
                '_token' : '{{{csrf_token()}}}'
            }
            $.ajax({
                url: '/admin/master/location/country/'+countryId+'/states' ,
                type: 'GET',
                data: data,
                success:function(data) {
                    var selectbox = '';
                    if(data)
                    {
                        selectbox = '<label for="state"><strong>State</strong></label>';
                        selectbox += '<select name="state_id" class="form-control select2" data-live-search="true" onchange="getCities(this)" id="state_id">';
                        selectbox += '<option  value="">-- Select State --</option>';
                        $.each(data, function (i, item) {
                            if(i == stateId) {
                                selectbox += '<option value="'+i+'" selected="selected">'+item+'</option>';
                            }
                            else {
                                selectbox += '<option value="'+i+'">'+item+'</option>';
                            }
                        });
                        selectbox += '</select>';
                    }
                    $('#blank_state').css('display','none');
                    $('#states').css('display','block');
                    $('#states').html(selectbox);
                    $('#state_id').select2();
                    if(stateId) {
                        getCities();
                    }
                }
            });
        }

        function getCities(th) {
            var stateId = $('#state_id').val();
            var cityId = "";

            @if(isset($user->address->city_id) && $user->address->city_id)
                cityId = '{{$user->address->city_id}}';
            @endif

            var data = {
                state_id : stateId,
                '_token' : '{{{csrf_token()}}}'
            }
            $.ajax({
                url: '/ajax/cities' ,
                type: 'POST',
                data: data,
                success:function(data) {
                    var selectbox = '';
                    if(data)
                    {
                        selectbox = '<label for="state"><strong>City</strong></label>';
                        selectbox += '<select name="city_id" class="form-control select2" data-live-search="true" id="city_id">';
                        selectbox += '<option value="">-- Select City --</option>';
                        $.each(data, function (i, item) {
                            if(i == cityId) {
                                selectbox += '<option value="'+i+'" selected="selected">'+item+'</option>';
                            }
                            else {
                                selectbox += '<option value="'+i+'">'+item+'</option>';
                            }
                        });
                        selectbox += '</select></div>';
                    }
                    $('#blank_city').css('display','none');
                    $('#cities').html(selectbox);
                    $('#cities').css('display','block');
                    $('#city_id').select2();
                }
            });
        }

        $(document).ready(function(){
            if($('#country_id').val()) {
                getStates();
            }
        });
    </script>
    <script type="text/javascript">
    	$(document).ready(function(){
    		var ckbox = $('#is_reseller');
            $('input').on('click',function () {
		        if (ckbox.is(':checked')) {
		            $('#reseller_type_div').css('display','block');
		        } else {
		            $('#reseller_type_div').css('display','none');
		        }
		    });
		});
    </script>

@stop
