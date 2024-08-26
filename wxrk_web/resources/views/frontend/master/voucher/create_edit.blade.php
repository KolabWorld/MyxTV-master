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
                    <h3 class="box-title"> @if (isset($voucher) && $voucher->id) Edit @else Create @endif Voucher</h3>
                    <div class="box-tools">
                        <button class="btn btn-primary btn-sm close_popup">
                            <span class="glyphicon glyphicon-backward"></span> {{{trans('admin/admin.back') }}}
                        </button>
                    </div>
                </div><!-- /.box-header -->
                <!-- form start -->
                 {!! Form::model($voucher, ['method' => isset($voucher) && $voucher->id ? 'put' : 'post']) !!}
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group {{{ $errors->has('code') ? 'has-error' : '' }}}">
                                    {!! Form::label('code', 'Code') !!}
                                    {!! Form::text('code', 
                                        isset($voucher) && $voucher->code ? $voucher->code : old('code'), 
                                        ['class' => 'form-control',
                                        'id' => 'code']) 
                                    !!}
                                    {!! $errors->first('code', '<label class="control-label"  for="code">:message</label>')!!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {{{ $errors->has('discount_type') ? 'has-error' : '' }}}">
                                    {!! Form::label('discount_type', 'Discount Type') !!}
                                    <select name="discount_type" class="form-control selectpicker" data-live-search="true" id="discount_type">
                                        <option value="">-- Select Discount Type --</option>
                                        <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>Fixed</option>
                                        <option value="percentage" {{ old('discount_type') == 'percentage' ? 'selected' : '' }}>Percentage</option>
                                    </select>
                                    {!! $errors->first('discount_type', '<label class="control-label"  for="discount_type">:message</label>')!!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group date {{{ $errors->has('valid_from') ? 'has-error' : '' }}}">
                                    {!! Form::label('valid_from', 'Valid From') !!}
                                    {!! Form::text('valid_from', 
                                        isset($voucher) && $voucher->valid_from ? $voucher->valid_from : old('valid_from'), 
                                        ['class' => 'form-control datepicker',
                                        'id' => 'valid_from']) 
                                    !!}
                                    {!! $errors->first('valid_from', '<label class="control-label"  for="valid_from">:message</label>')!!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group date {{{ $errors->has('valid_to') ? 'has-error' : '' }}}">
                                    {!! Form::label('valid_to', 'Valid To') !!}
                                    {!! Form::text('valid_to', 
                                        isset($voucher) && $voucher->valid_to ? $voucher->valid_to : old('valid_to'), 
                                        ['class' => 'form-control datepicker',
                                        'id' => 'valid_to']) 
                                    !!}
                                    {!! $errors->first('valid_to', '<label class="control-label"  for="valid_to">:message</label>')!!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group {{{ $errors->has('value') ? 'has-error' : '' }}}">
                                    {!! Form::label('value', 'Value') !!}
                                    {!! Form::text('value', 
                                        isset($voucher) && $voucher->value ? $voucher->value : old('value'), 
                                        ['class' => 'form-control',
                                        'id' => 'value']) 
                                    !!}
                                    {!! $errors->first('value', '<label class="control-label"  for="value">:message</label>')!!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {{{ $errors->has('max_uses') ? 'has-error' : '' }}}">
                                    {!! Form::label('max_uses', 'Max Uses') !!}
                                    {!! Form::text('max_uses', 
                                        isset($voucher) && $voucher->max_uses ? $voucher->max_uses : old('max_uses'), 
                                        ['class' => 'form-control',
                                        'id' => 'max_uses']) 
                                    !!}
                                    {!! $errors->first('max_uses', '<label class="control-label"  for="max_uses">:message</label>')!!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="reset" class="btn btn-warning close_popup">
                            <span class="glyphicon glyphicon-ban-circle"></span> {{trans("admin/modal.cancel") }}
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <span class="glyphicon glyphicon-ok-circle"></span>
                            @if (isset($voucher) && $voucher->id)
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript">
        $(function() {
            $( ".datepicker" ).datepicker({
                changeMonth: true,
                changeYear: true,
                maxDate: "+12y",
                dateFormat: 'dd-mm-yy'
            });
                
        });    
    </script>
@stop