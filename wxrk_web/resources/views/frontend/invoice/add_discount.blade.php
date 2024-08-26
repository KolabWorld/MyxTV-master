@extends('admin.layouts.modal') 

@section('content')
@if (isset($status))
<div class="pad margin no-print">
    <div class="alert alert-{{$status['code']}} alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        <h4>
            <i class="icon fa fa-ban"></i> {{ $status['header'] }}
        </h4>
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
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <!-- general form elements -->
            <div class="box box-primary" style="padding:5%">
                <div class="box-header">
                    <h3 class="box-title"> Add Discount</h3>
                    <div class="box-tools">
                        <a href='/admin/invoice/{{$invoice->id}}/view' class="btn btn-primary btn-sm close_popup">
                            <span class="glyphicon glyphicon-backward"></span> {{{trans('admin/admin.back') }}}
                        </a>
                    </div>
                </div>
                {!! Form::model($invoice, ['method' => isset($invoice) && $invoice->id ? 'put' : 'post','files' => true]) !!}
                    <input type="hidden" name="invoice_id" value="{{$invoice->id}}">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group required {{{ $errors->has('voucher_amount') ? 'has-error' : '' }}}">
                                    <label for="message">
                                        <strong>Discount Amount
                                            <span class="mendatory" style="color:red"> *</span>
                                        </strong>
                                    </label>
                                    <input type="text" class="form-control" id="input-voucher_amount" name="voucher_amount" required="true">
                                    {!! $errors->first('voucher_amount', '<label class="control-label"  for="voucher_amount">:message</label>')!!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <a href="/admin/invoice/{{$invoice->id}}/view" type="reset" class="btn btn-warning close_popup">
                            <span class="glyphicon glyphicon-ban-circle"></span> {{trans("admin/modal.cancel") }}
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <span class="glyphicon glyphicon-ok-circle"></span>
                            Submit
                        </button>
                    </div>
                {!! Form::close() !!}
            </div>
		</div>
	</div>
</section>
@endsection