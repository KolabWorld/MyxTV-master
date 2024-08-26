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
                    <h3 class="box-title">Invoice : #INV/{{$invoice->id}}  <span style="margin-left:10px">Invoice Total : {{ $invoice->currency }} {{$invoice->invoice_total}}</span></h3>
                    <div class="box-tools">
                        <a href='/admin/invoice/{{$invoice->id}}/view' class="btn btn-primary btn-sm close_popup">
                            <span class="glyphicon glyphicon-backward"></span> {{{trans('admin/admin.back') }}}
                        </a>
                    </div>
                </div>
                @if($invoice->payment_status=="unpaid")
                {!! Form::model($invoice, ['method' => isset($invoice) && $invoice->id ? 'put' : 'post','files' => true]) !!}
                    <input type="hidden" name="invoice_id" value="{{$invoice->id}}">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group required {{{ $errors->has('channel_order_id') ? 'has-error' : '' }}}">
                                    <label for="message">
                                        <strong> Cheque No. OR NEFT number
                                            <span class="mendatory" style="color:red"> *</span>
                                        </strong>
                                    </label>
                                    <input type="text" class="form-control" id="input-channel_order_id" name="channel_order_id" required="true">
                                    {!! $errors->first('channel_order_id', '<label class="control-label"  for="channel_order_id">:message</label>')!!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group required {{{ $errors->has('created_at') ? 'has-error' : '' }}}">
                                    <label for="message">
                                        <strong> Transaction Date
                                            <span class="mendatory" style="color:red"> *</span>
                                        </strong>
                                    </label>
                                    <input type="date" class="form-control" id="input-created_at" name="created_at" required="true">
                                    {!! $errors->first('created_at', '<label class="control-label"  for="created_at">:message</label>')!!}
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
                @else
                <p>Invoice has been paid succefully. Please click on back.</p>
                @endif
            </div>
		</div>
	</div>
</section>
@endsection