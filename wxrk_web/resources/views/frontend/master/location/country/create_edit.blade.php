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
                    <h3 class="box-title"> @if (isset($country) && $country->id) Edit @else Create @endif Country</h3>
                    <div class="box-tools">
                        <a class="btn btn-primary btn-sm close_popup" href="/master/location/countries">
                            <span class="glyphicon glyphicon-backward"></span> {{{trans('admin/admin.back') }}}
                        </a>
                    </div>
                </div><!-- /.box-header -->
                <!-- form start -->
                 {!! Form::model($country, ['method' => isset($country) && $country->id ? 'put' : 'post']) !!}
                    <div class="box-body">
                        <div class="col-md-6">
                            <div class="form-group {{{ $errors->has('name') ? 'has-error' : '' }}}">
                                {!! Form::label('name', 'Country Name') !!}
                                {!! Form::text('name', 
                                    isset($country) && $country->name ? $country->name : old('name'), 
                                    ['class' => 'form-control',
                                    'id' => 'name']) 
                                !!}
                                {!! $errors->first('name', '<label class="control-label"  for="name">:message</label>')!!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group {{{ $errors->has('code') ? 'has-error' : '' }}}">
                                        {!! Form::label('code', 'Country Code') !!}
                                        {!! Form::text('code', 
                                            isset($country) && $country->code ? $country->code : old('code'), 
                                            ['class' => 'form-control',
                                            'id' => 'code']) 
                                        !!}
                                        {!! $errors->first('name', '<label class="control-label"  for="name">:message</label>')!!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('dial_code', 'Dial Code') !!}
                                        {!! Form::text('dial_code', 
                                            isset($country) && $country->dial_code ? $country->dial_code : old('dial_code'), 
                                            ['class' => 'form-control',
                                            'id' => 'dial_code']) 
                                        !!}
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
                            @if (isset($country) && $country->id)
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
@stop 
@section('scripts')
<script type="text/javascript">
    $(function() {
        
    });
</script>
@stop
