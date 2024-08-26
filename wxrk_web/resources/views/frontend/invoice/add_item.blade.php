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
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <!-- general form elements -->
            <div class="box box-primary" style="padding:5%">
                <div class="box-header">
                    <h3 class="box-title"> Invoice Item</h3>
                    <div class="box-tools">
                        <a href='/admin/invoice/{{$invoice->id}}/edit' class="btn btn-primary btn-sm close_popup">
                            <span class="glyphicon glyphicon-backward"></span> {{{trans('admin/admin.back') }}}
                        </a>
                    </div>
                </div>
                {!! Form::model($invoiceItem, ['method' => isset($invoiceItem) && $invoiceItem->id ? 'put' : 'post','files' => true]) !!}
                    <input type="hidden" name="invoice_id" value="{{$invoice->id}}">
                    <div class="box-body">
                        <div class="row">
                            <!-- <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group required {{{ $errors->has('product_service_id') ? 'has-error' : '' }}}">
                                    <label for="product_service_id">
                                        <strong>Product Service
                                            <span class="mendatory" style="color:red"> *</span>
                                        </strong>
                                    </label>
                                    <select name="product_service_id" class="form-control selectpicker" data-live-search="true" id="product_service_id" >
                                        <option value="">-- Select Product Service --</option>
                                        @foreach($productServices as $val)
                                            <option value="{{$val->id}}" @if(isset($invoiceItem) && ($invoiceItem->product_service_id == $val->id) || (old('product_service_id') == $val->id)) selected @endif>{{$val->name}}</option>
                                        @endforeach
                                    </select>
                                    {!! $errors->first('product_service_id', '<label class="control-label"  for="product_service_id">:message</label>')!!}
                                </div>
                            </div>   -->
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group required {{{ $errors->has('item') ? 'has-error' : '' }}}">
                                    <label for="message">
                                        <strong>Item
                                            <span class="mendatory" style="color:red"> *</span>
                                        </strong>
                                    </label>
                                    <input type="text" class="form-control" id="input-item" name="item" >
                                    {!! $errors->first('item', '<label class="control-label"  for="item">:message</label>')!!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group required {{{ $errors->has('quantity') ? 'has-error' : '' }}}">
                                    
                                    <input type="hidden" class="form-control" id="input-quantity" name="quantity" value="1" >
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group required {{{ $errors->has('unit_price') ? 'has-error' : '' }}}">
                                    <label for="message">
                                        <strong>Price
                                            <span class="mendatory" style="color:red"> *</span>
                                        </strong>
                                    </label>
                                    <input type="text" class="form-control" id="input-unit_price" name="unit_price" >
                                    {!! $errors->first('unit_price', '<label class="control-label"  for="unit_price">:message</label>')!!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" value="1" name="is_taxable"> Is Taxable</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <a href="/admin/invoice/{{$invoice->id}}/edit" type="reset" class="btn btn-warning close_popup">
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