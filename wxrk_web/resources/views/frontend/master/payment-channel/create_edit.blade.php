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
                    <h3 class="box-title"> @if (isset($paymentChannel) && $paymentChannel->id) Edit @else Create @endif Payment Channel</h3>
                    <div class="box-tools">
                        <button class="btn btn-primary btn-sm close_popup">
                            <span class="glyphicon glyphicon-backward"></span> {{{trans('admin/admin.back') }}}
                        </button>
                    </div>
                </div><!-- /.box-header -->
                <!-- form start -->
                 {!! Form::model($paymentChannel, ['method' => isset($paymentChannel) && $paymentChannel->id ? 'put' : 'post']) !!}
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group {{{ $errors->has('name') ? 'has-error' : '' }}}">
                                    {!! Form::label('name', 'Name') !!}
                                    {!! Form::text('name', 
                                        isset($paymentChannel) && $paymentChannel->name ? $paymentChannel->name : old('name'), 
                                        ['class' => 'form-control',
                                        'id' => 'name']) 
                                    !!}
                                    {!! $errors->first('name', '<label class="control-label"  for="name">:message</label>')!!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {{{ $errors->has('alias') ? 'has-error' : '' }}}">
                                    {!! Form::label('alias', 'Alias') !!}
                                    {!! Form::text('alias', 
                                        isset($paymentChannel) && $paymentChannel->alias ? $paymentChannel->alias : old('alias'), 
                                        ['class' => 'form-control',
                                        'id' => 'alias']) 
                                    !!}
                                    {!! $errors->first('alias', '<label class="control-label"  for="alias">:message</label>')!!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group {{{ $errors->has('access_id') ? 'has-error' : '' }}}">
                                    {!! Form::label('access_id', 'Access ID') !!}
                                    {!! Form::text('access_id', 
                                        isset($paymentChannel) && $paymentChannel->access_id ? $paymentChannel->access_id : old('access_id'), 
                                        ['class' => 'form-control',
                                        'id' => 'access_id']) 
                                    !!}
                                    {!! $errors->first('access_id', '<label class="control-label"  for="access_id">:message</label>')!!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {{{ $errors->has('access_code') ? 'has-error' : '' }}}">
                                    {!! Form::label('access_code', 'Access Code') !!}
                                    {!! Form::text('access_code', 
                                        isset($paymentChannel) && $paymentChannel->access_code ? $paymentChannel->access_code : old('access_code'), 
                                        ['class' => 'form-control',
                                        'id' => 'access_code']) 
                                    !!}
                                    {!! $errors->first('access_code', '<label class="control-label"  for="access_code">:message</label>')!!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group {{{ $errors->has('access_secret') ? 'has-error' : '' }}}">
                                    {!! Form::label('access_secret', 'Access Secret') !!}
                                    {!! Form::text('access_secret', 
                                        isset($paymentChannel) && $paymentChannel->access_secret ? $paymentChannel->access_secret : old('access_secret'), 
                                        ['class' => 'form-control',
                                        'id' => 'access_secret']) 
                                    !!}
                                    {!! $errors->first('access_secret', '<label class="control-label"  for="access_secret">:message</label>')!!}
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
                            @if (isset($paymentChannel) && $paymentChannel->id)
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

@section('styles')
@stop

@section('scripts')
@stop
