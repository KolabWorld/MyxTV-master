@extends('admin.layouts.modal') 

@section('content')

@if (isset($status))
<div class="pad margin no-print">
    <div class="alert alert-{{$status['code']}} alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4><i class="icon fa fa-ban"></i> {{ $status['header'] }}</h4>
        <ul>
            @foreach ($status['messages'] as $m)
                <li>{{$m}}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif

<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title"> @if (isset($address) && $address->id) Edit @else Create @endif address Address</h3>
                    <div class="box-tools">
                        <button class="btn btn-primary btn-sm close_popup">
                        <span class="glyphicon glyphicon-backward"></span> {{{trans('admin/admin.back') }}}
                        </button>
                    </div>
                </div><!-- /.box-header -->
                <!-- form start -->
                {!! Form::model($address, ['method' => isset($address) && $address->id ? 'put' : 'post']) !!}

                    @if (count($errors) > 0)
                    <div class="alert alert-danger alert-dismissible fade in">
                        There were some problems adding address.<br />
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="box-body">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <legend>Personal Information</legend>
                                <div class="row">
                                    <div class="col-sm-6">
                                        {!! Form::label('alias', 'Address Alias') !!}
                                        {!! Form::text('alias', 
                                            isset($address) && $address->alias ? $address->alias : old('alias'), 
                                            ['class' => 'form-control',
                                            'id' => 'alias']) 
                                        !!}
                                    </div> 
                                    <div class=" col-sm-6 ">
                                        {!! Form::label('name', 'address Name') !!}
                                        {!! Form::text('address_name', 
                                            isset($address) && $address->address_name ? $address->address_name : old('address_name'), 
                                            ['class' => 'form-control',
                                            'id' => 'address_name']) 
                                        !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                         <div class="panel panel-default">
                            <div class="panel-body">
                                <legend>Billing Address</legend>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group">
                                            {!! Form::label('address_1', 'Street Address') !!}
                                            {!! Form::text('address_1', 
                                                isset($address) && $address->address_1 ? $address->address_1 : old('address_1'), 
                                                ['class' => 'form-control',
                                                'id' => 'address_1']) 
                                            !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">

                                        <div class="form-group">
                                            {!! Form::label('address_2', 'Street Address 2') !!}
                                            {!! Form::text('address_2', 
                                                isset($address) && $address->address_2 ? $address->address_2 : old('address_2'), 
                                                ['class' => 'form-control',
                                                'id' => 'address_2']) 
                                            !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group"  style="float: left;width: 70%">
                                            {!! Form::label('city', 'City') !!}
                                            {!! Form::text('city', 
                                                isset($address) && $address->city ? $address->city : old('city'), 
                                                ['class' => 'form-control',
                                                'id' => 'city']) 
                                            !!}
                                        </div>
                                        <div class="form-group" style="float: right;width: 27%">
                                            
                                            {!! Form::label('zip', 'Zip Code') !!}
                                            {!! Form::text('zip', 
                                                isset($address) && $address->zip ? $address->zip : old('zip'), 
                                                ['class' => 'form-control',
                                                'id' => 'zip']) 
                                            !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">

                                        <div class="form-group" style="float: left;width: 50%">

                                           {!! Form::label('state', 'State') !!}
                                            {!! Form::select('state_id', $states, isset($address) && $address->state_id ? $address->state_id : old('state_id'), ['class' => 'form-control']) !!}

                                        </div>
                                        <div class="form-group" style="float: right;width: 50%">
                                            
                                           {!! Form::label('country', 'Country') !!}
                                            {!! Form::select('country', $countries, isset($address) && $address->country ? $address->country : old('country'), ['class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group">

                                            {!! Form::label('phone', 'Phone Number') !!}
                                            {!! Form::text('phone', 
                                                isset($address) && $address->phone ? $address->phone : old('phone'), 
                                                ['class' => 'form-control',
                                                'id' => 'phone']) 
                                            !!}

                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group">
                                            {!! Form::label('mobile', 'Mobile Number') !!}
                                            {!! Form::text('mobile', 
                                                isset($address) && $address->mobile ? $address->mobile : old('mobile'), 
                                                ['class' => 'form-control',
                                                'id' => 'mobile']) 
                                            !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                    
                    <div class="box-footer">
                        <button type="reset" class="btn btn-warning close_popup">
                            <span class="glyphicon glyphicon-ban-circle"></span> {{trans("admin/modal.cancel") }}
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <span class="glyphicon glyphicon-ok-circle"></span>
                            @if (isset($address->id))
                                {{ trans("admin/modal.edit") }}
                            @else
                                {{trans("admin/modal.create") }}
                            @endif
                        </button>
                    </div>
                {!! Form::close() !!}
                <br><br>
            </div><!-- /.box -->
        </div><!--/.col (left) -->
    </div>   <!-- /.row -->
</section>
@endsection 