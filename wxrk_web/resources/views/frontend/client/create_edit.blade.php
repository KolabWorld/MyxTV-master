@extends('admin.app') 

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
                    <h3 class="box-title"> @if (isset($client) && $client->id) Edit @else Create @endif Client</h3>
                    <div class="box-tools">
                        <a href="/admin/clients" class="btn btn-primary btn-sm">
                        <span class="glyphicon glyphicon-backward"></span> {{{trans('admin/admin.back') }}}
                        </a>
                    </div>
                </div><!-- /.box-header -->
                <!-- form start -->
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
                    <div class="box-body">
                        <div class="panel panel-default">
                            <div class="panel-body">
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
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6">
                                 <div class="panel panel-default">
                                    <div class="panel-body">
                                        <legend>Billing Address</legend>
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
                                            {!! Form::select('state_id', $states, isset($client) && $client->state_id ? $client->state_id : old('state_id'), ['class' => 'form-control']) !!}
                                        </div>
                                        <div class="form-group" style="float: right;width: 27%">
                                            
                                            {!! Form::label('zip', 'Zip Code') !!}
                                            {!! Form::text('zip', 
                                                isset($client) && $client->zip ? $client->zip : old('zip'), 
                                                ['class' => 'form-control',
                                                'id' => 'zip']) 
                                            !!}
                                        </div>

                                        <div class="form-group">

                                            {!! Form::label('country', 'Country') !!}
                                            {!! Form::select('country', $countries, isset($client) && $client->country ? $client->country : old('country'), ['class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                               <div class="panel panel-default">
                                    <div class="panel-body">
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
                            @if (isset($client->id))
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
@if(isset($client) && $client->id)
 <section class="content-header">
        <!--<h1>Users <small>Platform Users</small></h1>-->
        <h1>Client Address</h1>
        <h3>
            <div class="pull-left">
                <div class="pull-right">
                    <a href="/admin/client/{{$client->id}}/address/create" class="btn btn-sm  btn-primary iframe"><span class="glyphicon glyphicon-plus-sign"></span> Add Client Address</a>
                </div>
            </div>
        </h3>
        <br>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <table id="table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Alias Name</th>
                                    <th>Address Name</th>
                                    <th>Address</th>
                                    <th>City</th>
                                    <th>State</th>
                                    <th>Active</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div><!-- /.box-body -->
                </div>
            </div>
        </div>
    </section>  
    @endif

@endsection 

{{-- Scripts --}}
@section('scripts')
    @parent
<script type="text/javascript">
        var oTable;
        $(document).ready(function () {

            @if(isset($client) && $client->id)
            oTable = $('#table').DataTable({
                "order" : [[1, "desc"]],
                "sDom": "<'row'<'col-md-2'l><'col-md-7'a><'col-md-2'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
                //"sPaginationType": "bootstrap",
                "processing": true,
                "serverSide": true,
                "ajax": "/admin/client/{{$client->id}}/address/",
                "fnDrawCallback": function (oSettings) {
                    $(".iframe").colorbox({
                        iframe: true,
                        width: "80%",
                        height: "80%",
                        onClosed: function () {
                            window.location.reload();
                        }
                    });
                }
            });
            @endif
        });
    </script>
@endsection

