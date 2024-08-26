@extends('invoice/app')

{{-- Web site Title --}}
@section('title') Create Edit Client :: @parent @stop

@section('content')
    <div id="main-area">

        {!! Form::open(['url' => '', 'method' => isset($client) ? 'put' : 'post']) !!}
            {{Form::token()}}
            <div id="headerbar">
                <h1>Client Form</h1>
                <div class="pull-right btn-group">
                    <button name="btn_submit" class="btn btn-success btn-sm" value="1">
                        <i class="fa fa-check"></i> Save            </button>
                    <button id="btn-cancel" name="btn_cancel" class="btn btn-danger btn-sm" value="1">
                        <i class="fa fa-times"></i> Cancel            </button>
                </div>
            </div>

            <div id="content">
                <input class="hidden" name="is_update" value="0" type="hidden">

                <fieldset>
                    <legend>Personal Information</legend>
                    <div class="row">
                        <div class=" col-sm-6 ">
                            <label>Client Name</label>
                            <div class="form-group  {{ $errors->has('name') ? 'has-error' : '' }}"">
                                <input id="name" name="name" class="form-control" required="" placeholder="Client Name" value="{{isset($client) ? $client->name : old('name')}}" type="text">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label>Client Alias</label>
                            <input id="alias" name="alias" class="form-control" placeholder="Other Name for Company use" value="{{isset($client) ? $client->alias : old('name')}}" type="text">
                        </div>
                    </div>
                </fieldset>

                <div class="row">
                    <div class="col-sm-12">
                        <fieldset>

                            <legend>Billing Address</legend>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6">
                                    <fieldset>
                                        <legend>Address</legend>

                                        <div class="form-group">
                                            <label>Street Address: </label>

                                            <div class="controls">
                                                <input name="address_1" id="address_1" class="form-control" required="" value="{{isset($client) ? $client->address_1 : old('name')}}" type="text">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Street Address 2: </label>

                                            <div class="controls">
                                                <input name="address_2" id="address_2" class="form-control" value="{{isset($client) ? $client->address_2 : old('name')}}" type="text">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>City: </label>

                                            <div class="controls">
                                                <input required="" name="city" id="city" class="form-control" value="{{isset($client) ? $client->city : old('name')}}" type="text">
                                            </div>
                                        </div>

                                        <div class="form-group" style="float: left;width: 70%">
                                            <label>State: </label>

                                            <div class="controls">
                                                <input required="" name="state" id="state" class="form-control" value="{{isset($client) ? $client->state : old('name')}}" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group" style="float: right;width: 27%">
                                            <label>State Code: </label>

                                            <div class="controls">
                                                <input required="" name="state_code" id="state_code" class="form-control" value="{{isset($client) ? $client->state_code : old('name')}}" type="text">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Zip Code: </label>

                                            <div class="controls">
                                                <input name="zip" id="zip" class="form-control" value="{{isset($client) ? $client->zip : old('name')}}" type="text">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Country: </label>

                                            <div class="controls">
                                                <select name="country" id="country" class="form-control" value="{{isset($client) ? $client->country : old('name')}}">
                                                    <option></option>
                                                    <option value="AU">Australia</option>
                                                    <option value="HU">Hungary</option>
                                                    <option value="IS">Iceland</option>
                                                    <option value="IN" selected="selected">India</option>
                                                    <option value="ID">Indonesia</option>
                                                </select>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>

                                <div class="col-xs-12 col-sm-6">
                                    <fieldset>

                                        <legend>Contact Information</legend>

                                        <div class="row">
                                            <div class="col-xs-12 col-sm-6">
                                                <div class="form-group">

                                                    <label>Phone Number: </label>

                                                    <div class="controls">
                                                        <input required="" name="phone" id="phone" class="form-control" value="{{isset($client) ? $client->phone : old('name')}}" type="text">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-6">
                                                <div class="form-group">
                                                    <label>Mobile Number: </label>

                                                    <div class="controls">
                                                        <input name="mobile" id="mobile" class="form-control" value="{{isset($client) ? $client->mobile : old('name')}}" type="text">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group  {{ $errors->has('email') ? 'has-error' : '' }}"">
                                            <label>Email Address: </label>

                                            <div class="controls">
                                                <input required="" name="email" id="email" class="form-control" value="{{isset($client) ? $client->email : old('name')}}" type="text">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>PAN No.: </label>

                                            <div class="controls">
                                                <input name="pan" id="pan" class="form-control" value="{{isset($client) ? $client->pan : old('name')}}" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>GST No.: </label>

                                            <div class="controls">
                                                <input name="gstin" id="gstin" class="form-control" value="{{isset($client) ? $client->gstin : old('name')}}" type="text">
                                            </div>
                                        </div>

                                    </fieldset>
                                </div>
                            </div></fieldset>
                    </div>
                </div>

                <span class="input-group-addon">
              
                <input id="sameShipAddress" value="1" type="checkbox">
                : Same as Billing Address
              </span>

                <div class="row">
                    <div class="col-sm-12">
                        <fieldset>

                            <legend>Shipping Address</legend>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6">
                                    <fieldset>
                                        <legend>Address</legend>


                                        <div class="form-group">
                                            <label>Client Name: </label>

                                            <div class="controls">
                                                <input name="ship_address_name" id="ship_address_name" class="form-control" required="" value="{{isset($client) ? $client->ship_address_name : old('name')}}" type="text">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Street Address: </label>

                                            <div class="controls">
                                                <input name="ship_address_1" required="" id="ship_address_1" class="form-control" value="{{isset($client) ? $client->ship_address_1 : old('name')}}" type="text">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Street Address 2: </label>

                                            <div class="controls">
                                                <input name="ship_address_2" id="ship_address_2" class="form-control" value="{{isset($client) ? $client->ship_address_2 : old('name')}}" type="text">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>City: </label>

                                            <div class="controls">
                                                <input required="" name="ship_city" id="ship_city" class="form-control" value="{{isset($client) ? $client->ship_city : old('name')}}" type="text">
                                            </div>
                                        </div>

                                        <div class="form-group" style="float: left;width: 70%">
                                            <label>State: </label>

                                            <div class="controls">
                                                <input required="" name="ship_state" id="ship_state" class="form-control" value="{{isset($client) ? $client->ship_state : old('name')}}" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group" style="float: right;width: 27%">
                                            <label>State Code: </label>

                                            <div class="controls">
                                                <input required="" name="ship_state_code" id="ship_state_code" class="form-control" value="{{isset($client) ? $client->ship_state_code : old('name')}}" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Zip Code: </label>

                                            <div class="controls">
                                                <input name="ship_zip" id="ship_zip" class="form-control" value="{{isset($client) ? $client->ship_zip : old('name')}}" type="text">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Country: </label>

                                            <div class="controls">
                                                <select name="ship_country" id="ship_country" class="form-control" value="{{isset($client) ? $client->ship_country : old('ship_country')}}">
                                                    <option></option>

                                                    <option value="AU">Australia</option>
                                                    <option value="HU">Hungary</option>
                                                    <option value="IS">Iceland</option>
                                                    <option value="IN" selected="selected">India</option>
                                                    <option value="ID">Indonesia</option>
                                                </select>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>

                                <div class="col-xs-12 col-sm-6">
                                    <fieldset>

                                        <legend>Contact Information</legend>

                                        <div class="form-group">
                                            <label>Phone Number: </label>

                                            <div class="controls">
                                                <input required="" name="ship_phone" id="ship_phone" class="form-control" value="{{isset($client) ? $client->ship_phone : old('ship_phone')}}" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Mobile Number: </label>

                                            <div class="controls">
                                                <input name="ship_mobile" id="ship_mobile" class="form-control" value="{{isset($client) ? $client->ship_mobile : old('ship_mobile')}}" type="text">
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div></fieldset>
                    </div>
                </div>
                <div>
                </div>
            </div>
            {!! Form::close() !!}
    </div>
@stop

@section('scripts')

    <script defer="" src="http://localhost/temp/invzo/aimsbuildmart/ivm/assets/default/js/plugins.js"></script>
    <script defer="" src="http://localhost/temp/invzo/aimsbuildmart/ivm/assets/default/js/scripts.min.js"></script>
    <script src="http://localhost/temp/invzo/aimsbuildmart/ivm/assets/default/js/libs/bootstrap-datepicker.min.js"></script>

    <script type="text/javascript">
        $(function () {
            $('#name').focus();


            $('#sameShipAddress').change(function() {
                if($(this).is(":checked")) {
                    $('#ship_address_name').val($('#name').val());
                    $('#ship_address_1').val($('#address_1').val());
                    $('#ship_address_2').val($('#address_2').val());
                    $('#ship_city').val($('#city').val());
                    $('#ship_state').val($('#state').val());
                    $('#ship_state_code').val($('#state_code').val());
                    $('#ship_country').val($('#country').val());
                    $('#ship_zip').val($('#zip').val());
                    $('#ship_phone').val($('#phone').val());
                    $('#ship_mobile').val($('#mobile').val());
                    $('#ship_pan').val($('#pan').val());
                    $('#ship_tin').val($('#tin').val());
                    $('#ship_stn').val($('#stn').val());
                    $('#ship_cst').val($('#cst').val());
                    $('#ship_gstin').val($('#gstin').val());
                    // $('#ship_').val($('#address_1').val());

                }
                else {
                    $('#ship_address_name').val('');
                    $('#ship_address_1').val('');
                    $('#ship_address_2').val('');
                    $('#ship_city').val('');
                    $('#ship_state').val('');
                    $('#ship_state_code').val('');
                    $('#ship_country').val('');
                    $('#ship_zip').val('');
                    $('#ship_phone').val('');
                    $('#ship_mobile').val('');
                    $('#ship_pan').val('');
                    $('#ship_tin').val('');
                    $('#ship_stn').val('');
                    $('#ship_cst').val('');
                    $('#ship_gstin').val('');
                }
            });
        });
    </script>
@endsection
