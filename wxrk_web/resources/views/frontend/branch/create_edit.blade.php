

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
                    <h3 class="box-title"> @if (isset($branch) && $branch->id) Edit @else Create @endif branch</h3>
                    <div class="box-tools">
                        <button class="btn btn-primary btn-sm close_popup">
                        <span class="glyphicon glyphicon-backward"></span> {{{trans('admin/admin.back') }}}
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                {!! Form::model($branch, ['method' => isset($branch) && $branch->id ? 'put' : 'post']) !!}

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
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('name', 'Name') !!}
                            {!! Form::text('name', 
                            isset($branch) && $branch->name ? $branch->name : old('name'), 
                            ['class' => 'form-control',
                            'id' => 'name']) 
                            !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('alias', 'Alias') !!}
                            {!! Form::text('alias', 
                            isset($branch) && $branch->alias ? $branch->alias : old('alias'), 
                            ['class' => 'form-control',
                            'id' => 'alias']) 
                            !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('pan_no', 'PAN No') !!}
                            {!! Form::text('pan_no', 
                            isset($branch) && $branch->pan_no ? $branch->pan_no : old('pan_no'), 
                            ['class' => 'form-control',
                            'id' => 'pan_no']) 
                            !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('gstin', 'GSTIN') !!}
                            {!! Form::text('gstin', 
                            isset($branch) && $branch->gstin ? $branch->gstin : old('gstin'), 
                            ['class' => 'form-control',
                            'id' => 'gstin']) 
                            !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('cin_no', 'CIN') !!}
                            {!! Form::text('cin_no', 
                            isset($branch) && $branch->cin_no ? $branch->cin_no : old('cin_no'), 
                            ['class' => 'form-control',
                            'id' => 'cin_no']) 
                            !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('email', 'Email') !!}
                            {!! Form::text('email', 
                            isset($branch) && $branch->email ? $branch->email : old('email'), 
                            ['class' => 'form-control',
                            'id' => 'email']) 
                            !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('phone', 'Phone No') !!}
                            {!! Form::text('phone', 
                            isset($branch) && $branch->phone ? $branch->phone : old('phone'), 
                            ['class' => 'form-control',
                            'id' => 'phone']) 
                            !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('address1', 'Street Address') !!}
                            {!! Form::text('address1', 
                            isset($branch) && $branch->address1 ? $branch->address1 : old('address1'), 
                            ['class' => 'form-control',
                            'id' => 'address1']) 
                            !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('address2', 'Street Address 2') !!}
                            {!! Form::text('address2', 
                            isset($branch) && $branch->address2 ? $branch->address2 : old('address2'), 
                            ['class' => 'form-control',
                            'id' => 'address2']) 
                            !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('city', 'City') !!}
                            {!! Form::text('city', 
                            isset($branch) && $branch->city ? $branch->city : old('city'), 
                            ['class' => 'form-control',
                            'id' => 'city']) 
                            !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" style="float: left;width: 70%">
                            {!! Form::label('state', 'State') !!}
                            {!! Form::select('state_id', $states, isset($branch) && $branch->state_id ? $branch->state_id : old('state_id'), ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group" style="float: right;width: 27%">
                            {!! Form::label('zip', 'Zip Code') !!}
                            {!! Form::text('zip', 
                            isset($branch) && $branch->zip ? $branch->zip : old('zip'), 
                            ['class' => 'form-control',
                            'id' => 'zip']) 
                            !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('country', 'Country') !!}
                            {!! Form::select('country', $countries, isset($branch) && $branch->country ? $branch->country : old('country'), ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('series_invoice', 'Series Invoice') !!}
                            {!! Form::text('series_invoice', 
                            isset($branch) && $branch->series_invoice ? $branch->series_invoice : old('series_invoice'), 
                            ['class' => 'form-control',
                            'id' => 'series_invoice']) 
                            !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('series_quotation', 'Series Quotation') !!}
                            {!! Form::text('series_quotation', 
                            isset($branch) && $branch->series_quotation ? $branch->series_quotation : old('series_quotation'), 
                            ['class' => 'form-control',
                            'id' => 'series_quotation']) 
                            !!}
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="reset" class="btn btn-warning close_popup">
                    <span class="glyphicon glyphicon-ban-circle"></span> {{trans("admin/modal.cancel") }}
                    </button>
                    <button type="submit" class="btn btn-primary">
                    <span class="glyphicon glyphicon-ok-circle"></span>
                    @if (isset($branch) && $branch->id)
                    {{ trans("admin/modal.edit") }}
                    @else
                    {{trans("admin/modal.create") }}
                    @endif
                    </button>
                </div>
                {!! Form::close() !!}
                <br><br>
            </div>
            <!-- /.box -->
        </div>
        <!--/.col (left) -->
    </div>
    <!-- /.row -->
</section>
@stop 
@section('scripts')
<script type="text/javascript">
    $(function() {
        
    });
</script>
@stop