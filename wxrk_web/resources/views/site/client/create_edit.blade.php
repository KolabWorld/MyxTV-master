@extends('invoice/app')

{{-- Web site Title --}}
@section('title') Create Edit Client :: @parent @stop

@section('content')
    <div id="main-area">

        {!! Form::model($client, ['method' => isset($client) && $client->id ? 'put' : 'post']) !!}

            @if (count($errors) > 0)
            <div class="alert alert-danger alert-dismissible fade in">
                There were some problems adding client.<br />
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if (isset($status))
            <div class="alert alert-{{$status['code']}} alert-dismissible fade in">
                <!-- <h3>{{$status['header']}}</h3><br /> -->
                <ul>
                    @foreach ($status['messages'] as $msg)
                        <li>{{ $msg }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div id="headerbar">
                <h1>Client Form</h1>
                <div class="pull-right btn-group">
                    <button name="btn_submit" class="btn btn-success btn-sm" value="1">
                        <i class="fa fa-check"></i> Save </button>
                    <button id="btn-cancel" name="btn_cancel" class="btn btn-danger btn-sm" value="1">
                        <i class="fa fa-times"></i> Cancel </button>
                </div>
            </div>

            <div id="content">
                <fieldset>
                    <legend>Personal Information</legend>
                    <div class="row">
                        <div class=" col-sm-6 ">
                            {!! Form::label('name', 'Client Name') !!}
                            {!! Form::text('name', 
                                isset($client) && $client->name ? $client->name : old('name'), 
                                ['class' => 'form-control',
                                'id' => 'name']) 
                            !!}
                        </div>
                        <div class="col-sm-6">
                            {!! Form::label('alias', 'Client Alias') !!}
                            {!! Form::text('alias', 
                                isset($client) && $client->alias ? $client->alias : old('alias'), 
                                ['class' => 'form-control',
                                'id' => 'alias']) 
                            !!}
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <legend>Billing Address</legend>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <fieldset>
                                <legend>Address</legend>

                                <div class="form-group">
                                    {!! Form::label('address_1', 'Street Address') !!}
                                    {!! Form::text('address_1', 
                                        isset($client) && $client->address_1 ? $client->address_1 : old('address_1'), 
                                        ['class' => 'form-control',
                                        'id' => 'address_1']) 
                                    !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('address_2', 'Street Address 2') !!}
                                    {!! Form::text('address_2', 
                                        isset($client) && $client->address_2 ? $client->address_2 : old('address_2'), 
                                        ['class' => 'form-control',
                                        'id' => 'address_2']) 
                                    !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('city', 'City') !!}
                                    {!! Form::text('city', 
                                        isset($client) && $client->city ? $client->city : old('city'), 
                                        ['class' => 'form-control',
                                        'id' => 'city']) 
                                    !!}
                                </div>

                                <div class="form-group" style="float: left;width: 70%">
                                    {!! Form::label('state', 'State') !!}
                                    {!! Form::text('state', 
                                        isset($client) && $client->state ? $client->state : old('state'), 
                                        ['class' => 'form-control',
                                        'id' => 'state']) 
                                    !!}
                                </div>
                                <div class="form-group" style="float: right;width: 27%">
                                    {!! Form::label('state_code', 'State Code') !!}
                                    {!! Form::text('state_code', 
                                        isset($client) && $client->state_code ? $client->state_code : old('state_code'), 
                                        ['class' => 'form-control',
                                        'id' => 'state_code']) 
                                    !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('zip', 'Zip Code') !!}
                                    {!! Form::text('zip', 
                                        isset($client) && $client->zip ? $client->zip : old('zip'), 
                                        ['class' => 'form-control',
                                        'id' => 'zip']) 
                                    !!}
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

                                            {!! Form::label('phone', 'Phone Number') !!}
                                            {!! Form::text('phone', 
                                                isset($client) && $client->phone ? $client->phone : old('phone'), 
                                                ['class' => 'form-control',
                                                'id' => 'phone']) 
                                            !!}

                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group">
                                            {!! Form::label('mobile', 'Mobile Number') !!}
                                            {!! Form::text('mobile', 
                                                isset($client) && $client->mobile ? $client->mobile : old('mobile'), 
                                                ['class' => 'form-control',
                                                'id' => 'mobile']) 
                                            !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group  {{ $errors->has('email') ? 'has-error' : '' }}"">
                                    {!! Form::label('email', 'Email Address') !!}
                                    {!! Form::text('email', 
                                        isset($client) && $client->email ? $client->email : old('email'), 
                                        ['class' => 'form-control',
                                        'id' => 'email']) 
                                    !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('pan', 'PAN No.') !!}
                                    {!! Form::text('pan', 
                                        isset($client) && $client->pan ? $client->pan : old('pan'), 
                                        ['class' => 'form-control',
                                        'id' => 'pan']) 
                                    !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('gstin', 'GST No.') !!}
                                    {!! Form::text('gstin', 
                                        isset($client) && $client->gstin ? $client->gstin : old('gstin'), 
                                        ['class' => 'form-control',
                                        'id' => 'gstin']) 
                                    !!}
                                </div>

                            </fieldset>
                        </div>
                    </div>
                </fieldset>
                <span class="input-group-addon">
              
                    <input id="sameShipAddress" value="1" type="checkbox">
                : Same as Billing Address
                </span>
                <fieldset>
                    <legend>Shipping Address</legend>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <fieldset>
                                <legend>Address</legend>
                                <div class="form-group">
                                    {!! Form::label('ship_address_name', 'Client Name') !!}
                                    {!! Form::text('ship_address_name', 
                                        isset($client) && $client->ship_address_name ? $client->ship_address_name : old('ship_address_name'), 
                                        ['class' => 'form-control',
                                        'id' => 'ship_address_name']) 
                                    !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('ship_address_1', 'Street Address') !!}
                                    {!! Form::text('ship_address_1', 
                                        isset($client) && $client->ship_address_1 ? $client->ship_address_1 : old('ship_address_1'), 
                                        ['class' => 'form-control',
                                        'id' => 'ship_address_1']) 
                                    !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('ship_address_2', 'Street Address 2') !!}
                                    {!! Form::text('ship_address_2', 
                                        isset($client) && $client->ship_address_2 ? $client->ship_address_2 : old('ship_address_2'), 
                                        ['class' => 'form-control',
                                        'id' => 'ship_address_2']) 
                                    !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('ship_city', 'City') !!}
                                    {!! Form::text('ship_city', 
                                        isset($client) && $client->ship_city ? $client->ship_city : old('ship_city'), 
                                        ['class' => 'form-control',
                                        'id' => 'ship_city']) 
                                    !!}
                                </div>

                                <div class="form-group" style="float: left;width: 70%">
                                    {!! Form::label('ship_state', 'State') !!}
                                    {!! Form::text('ship_state', 
                                        isset($client) && $client->ship_state ? $client->ship_state : old('ship_state'), 
                                        ['class' => 'form-control',
                                        'id' => 'ship_state']) 
                                    !!}
                                </div>
                                <div class="form-group" style="float: right;width: 27%">
                                    {!! Form::label('ship_state_code', 'State Code') !!}
                                    {!! Form::text('ship_state_code', 
                                        isset($client) && $client->ship_state_code ? $client->ship_state_code : old('ship_state_code'), 
                                        ['class' => 'form-control',
                                        'id' => 'ship_state_code']) 
                                    !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('ship_zip', 'Zip Code') !!}
                                    {!! Form::text('ship_zip', 
                                        isset($client) && $client->ship_zip ? $client->ship_zip : old('ship_zip'), 
                                        ['class' => 'form-control',
                                        'id' => 'ship_zip']) 
                                    !!}
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
                                    {!! Form::label('ship_phone', 'Phone No.') !!}
                                    {!! Form::text('ship_phone', 
                                        isset($client) && $client->ship_phone ? $client->ship_phone : old('ship_phone'), 
                                        ['class' => 'form-control',
                                        'id' => 'ship_phone']) 
                                    !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('ship_mobile', 'Mobile No.') !!}
                                    {!! Form::text('ship_mobile', 
                                        isset($client) && $client->ship_mobile ? $client->ship_mobile : old('ship_mobile'), 
                                        ['class' => 'form-control',
                                        'id' => 'ship_mobile']) 
                                    !!}
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </fieldset>
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
