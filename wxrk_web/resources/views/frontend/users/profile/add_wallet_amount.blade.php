@extends('admin.layouts.modal') 

@section('content')

<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title"> Add Wallet Amount</h3>
                    <div class="box-tools">
                        <button class="btn btn-primary btn-sm close_popup">
                            <span class="glyphicon glyphicon-backward"></span> {{{trans('admin/admin.back') }}}
                        </button>
                    </div>
                </div><!-- /.box-header -->
                <!-- form start -->
                {!! Form::model($user, ['method' => isset($user) && $user->id ? 'put' : 'post']) !!}
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group {{{ $errors->has('amount') ? 'has-error' : '' }}}">
                                    {!! Form::label('amount', 'Amount') !!}
                                    {!! Form::text('amount', 
                                        old('amount'),
                                        ['class' => 'form-control',
                                        'id' => 'amount']) 
                                    !!}
                                    {!! $errors->first('amount', '<label class="control-label"  for="amount">:message</label>')!!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {{{ $errors->has('transaction_no') ? 'has-error' : '' }}}">
                                    {!! Form::label('transaction_no', 'Transaction Number') !!}
                                    {!! Form::text('transaction_no', 
                                        old('transaction_no'),
                                        ['class' => 'form-control',
                                        'id' => 'transaction_no']) 
                                    !!}
                                    {!! $errors->first('transaction_no', '<label class="control-label"  for="transaction_no">:message</label>')!!}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group {{{ $errors->has('remark') ? 'has-error' : '' }}}">
                                    {!! Form::label('remark', 'Remark') !!}
                                    {!! Form::text('remark', 
                                        old('remark'),
                                        ['class' => 'form-control',
                                        'id' => 'remark']) 
                                    !!}
                                    {!! $errors->first('remark', '<label class="control-label"  for="remark">:message</label>')!!}
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
                            Add
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
