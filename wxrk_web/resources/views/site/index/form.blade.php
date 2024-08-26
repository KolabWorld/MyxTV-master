@extends('invoice/app')
{{-- Web site Title --}}
@section('title') Invoice Form :: @parent @stop

@section('content')
<div id="headerbar">
    <div class="pull-right btn-group">
        <a href="/data-upload/template" class="btn btn-sm btn-default">
            <i class="fa fa-download fa-margin"></i>
            Download Template
        </a>
        <a href="/invoice/{{$invoice->id}}/pdf" class="btn btn-sm btn-default">
        <i class="fa fa-print fa-margin"></i>
        Download PDF</a>
        <a class="btn btn-sm btn-default" href="/invoice/{{$invoice->id}}/delete">
            <i class="fa fa-trash-o no-margin"></i> Delete Invoice
        </a>
        <a class="btn_add_row btn btn-sm btn-default">
        <i class="fa fa-plus"></i> Add new row</a>
        <a href="#" class="btn btn-sm btn-success ajax-loader" id="btn_save_invoice">
        <i class="fa fa-check"></i> Save</a>
    </div>
    <div class="invoice-labels pull-right">
    </div>
</div>
<div id="content">
    <table style="display: none">
        <tbody id="new_row" style="display: none;" class="ui-sortable-handle">
            <tr>
                <td rowspan="2" class="td-icon"><i class="fa fa-arrows cursor-move"></i></td>
                <td class="td-text">
                    <input name="id" value="0" type="hidden">
                    <div class="input-group">
                        <span class="input-group-addon">Item</span>
                        <input name="name" class="input-sm form-control" value="" type="text">
                    </div>
                </td>
                <td class="td-amount td-quantity">
                    <div class="input-group">
                        <span class="input-group-addon">HSN/SAC Code</span>
                        <select name="tax_id" class="form-control item_tax_select">
                            @foreach($gstRates as $value)
                            <option value="{{$value->id}}">{{$value->title}}/{{$value->code}}({{$value->rate}}%)</option>
                            @endforeach
                        </select>
                    </div>
                </td>
                <td class="td-amount td-quantity">
                    <div class="input-group">
                        <span class="input-group-addon">Quantity</span>
                        <input name="quantity" class="input-sm form-control amount" value="" type="text">
                    </div>
                </td>
                <td class="td-amount">
                    <div class="input-group">
                        <span class="input-group-addon">Unit Price</span>
                        <input name="unit_price" class="input-sm form-control amount" value="" type="text">
                    </div>
                </td>
                <td class="td-icon text-right td-vert-middle">
                </td>
            </tr>
            <tr>
                <td class="td-textarea">
                    <div class="input-group">
                        <span class="input-group-addon">Description</span>
                        <textarea name="description" class="input-sm form-control"></textarea>
                    </div>
                </td>
                <td class="td-amount">
                    <div class="input-group">
                        <span class="input-group-addon">Unit</span>
                        <input name="unit" class="form-control input-sm" value="" type="text">
                    </div>
                </td>
                <td colspan="2" class="td-amount td-vert-middle">
                </td>
            </tr>
        </tbody>
    </table>


    @if (isset($status))
    <div class="alert alert-{{$status['code']}} alert-dismissible fade in">
        <!-- <h3>{{$status['header']}}</h3><br /> -->
        <ul>
            @foreach ($status['messages'] as $msg)
                <li>{{ $msg }}</li>
            @endforeach
        </ul>
    </div>
    @endif

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

        <div class="invoice">
            {!! Form::open(
                [
                    'method' => 'put', 
                    'id' => "invoice_form",
                    'class' =>"form"
                ]) 
            !!}
            <div class="cf row">
                <div class="col-xs-12 col-md-3">
                    <h2>Invoice #<br/>
                         {!! Form::text('uid', isset($invoice) && $invoice->uid ? $invoice->uid : old('uid'), ['class' => 'form-control', 'id' => 'uid']) !!}
                    </h2>

                </div>
                <div class="col-xs-12 col-md-4">
                      <div class="details-box">
                        <div class="invoice-properties">
                            <div class="form-group">
                                {!! Form::label('client_id', 'Client') !!}
                                {!! Form::select('client_id', $clients, isset($client) && $client->id ? $client->id : old('client_id'), ['class' => 'form-control select2', 'id' => 'client_id']) !!}
                            </div>
                        </div>
                        <div class="invoice-properties">
                            <div class="form-group">
                                {!! Form::label('address_id', 'Ship Address') !!}
                                {!! Form::select('address_id', $addresses, isset($address) && $address->id ? $address->id : old('address_id'), ['class' => 'form-control select2', 'id' => 'address_id']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-5">
                    <div class="details-box">
                        <div class="invoice-properties has-feedback">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Status </label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="0" @if($invoice->status == 0)selected="selected"@endif>
                                            Draft                                            
                                        </option>
                                        <option value="1" @if($invoice->status == 1)selected="selected"@endif>
                                            Sent                                            
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label>Created At</label>
                                    <input name="invoice_date_created" disabled="disabled" id="invoice_date_created" class="form-control" value="{{date('d-M-Y', strtotime($invoice->created_at))}}">
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('po_number', 'PO Number') !!}
                                        {!! Form::text('po_number', isset($invoice) && $invoice->po_number ? $invoice->po_number : old('po_number'), ['class' => 'form-control', 'id' => 'po_number']) !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                       {!! Form::label('eway_bill', 'E-Way Bill') !!}
                                        {!! Form::text('eway_bill', isset($invoice) && $invoice->eway_bill ? $invoice->eway_bill : old('eway_bill'), ['class' => 'form-control', 'id' => 'eway_bill']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        {!! Form::close() !!}

        <div class="cf row">
            <div class="col-xs-12 col-md-4 pull-right">
                <div class="details-box">
                    {!! Form::open(
                        [
                            'method' => 'post', 
                            'id' => "invoice_form_excel",
                            'class' =>"form",
                            'url' => '/invoice/'.$invoice->id.'/upload-excel',
                            'files' => 'true',
                            'enctype'=>'multipart/form-data'
                        ]) 
                    !!}
                        <span class="pull-left">
                            {!! Form::label('file', 'Upload File') !!}
                            <input type="file" name="file" />
                        </span>
                        <span class="pull-left" style="margin-top: 20px;">
                            <button class="btn btn-info btn-sm">Upload File</button>
                        </span>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

        {!! Form::open(
            [
                'method' => 'put', 
                'id' => "invoice_form",
                'class' =>"form"
            ]) 
        !!}

        <div class="table-responsive">
            <table id="item_table" class="items table table-condensed table-bordered ui-sortable">
                <thead style="display: none">
                    <tr>
                        <th></th>
                        <th>Item</th>
                        <th>Description</th>
                        <th></th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Total Amount</th>
                    </tr>
                </thead>
                @foreach($items as $item)
                 <tbody class="item">
                    <tr>
                        <td rowspan="2" class="td-icon"><i class="fa fa-arrows cursor-move"></i></td>
                        <td class="td-text">
                            <input type="hidden" name="id" value="{{$item->id}}">

                            <div class="input-group">
                                <span class="input-group-addon">Item</span>
                                <input type="text" name="name" class="input-sm form-control" value="{{$item->name}}">
                            </div>
                        </td>
                        <td class="td-amount">
                            <div class="input-group">
                                <span class="input-group-addon">HSN/SAC Code</span>
                                <select name="tax_id" class="input-sm form-control select2">
                                    @foreach($gstRates as $value)
                                    <option value="{{$value->id}}" @if($item->tax_id == $value->id) selected="selected" @endif>{{$value->title}}/{{$value->code}}({{$value->rate}}%)</option>
                                    @endforeach
                                </select>
                            </div>
                        </td>
                        <td class="td-amount td-quantity">
                            <div class="input-group">
                                <span class="input-group-addon">Quantity</span>
                                <input type="text" name="quantity" class="input-sm form-control amount" value="{{$item->quantity}}">
                            </div>
                        </td>
                        <td class="td-amount">
                            <div class="input-group">
                                <span class="input-group-addon">Unit Price</span>
                                <input type="text" name="unit_price" class="input-sm form-control amount" value="{{$item->unit_price}}">
                            </div>
                        </td>
                       
                        <td class="td-icon text-right td-vert-middle">
                            <a href="/invoice/{{$invoice->id}}/item/{{$item->id}}/delete" title="Delete">
                                <i class="fa fa-trash-o text-danger"></i>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td class="td-textarea">
                            <div class="input-group">
                                <span class="input-group-addon">Description</span>
                                <textarea name="description"
                                          class="input-sm form-control">{{$item->description}}</textarea>
                            </div>
                        </td>
                         <td class="td-amount">
                            <div class="input-group">
                                <span class="input-group-addon">Unit</span>
                                <input type="text" name="unit" class="input-sm form-control amount" value="{{$item->unit}}">
                            </div>
                        </td>
                        <td colspan="2" class="td-amount td-vert-middle">
                          
                        </td>
                       
                        <td class="td-amount td-vert-middle">
                            @if($item->sgst > 0)
                            <span>SGST: @currency($item->sgst)
                            </span><br/>
                            @endif
                            @if($item->cgst > 0)
                             <span>CGST: @currency($item->cgst)
                            </span><br/>
                            @endif
                            @if($item->igst > 0)
                             <span>IGST: @currency($item->igst)
                            </span><br/>
                            @endif
                            <span>Item Total: @currency($item->total)
                            </span>
                        </td>
                    </tr>
                    </tbody>
                @endforeach
            </table>
        </div>

        <div class="row">
            <div class="col-xs-12 col-md-4">
                <div class="btn-group">
                    <a class="btn_add_row btn btn-sm btn-default">
                    <i class="fa fa-plus"></i> Add new row </a>
                </div>
                <br><br>
            </div>
            <div class="col-xs-12 col-md-6 col-md-offset-2 col-lg-4 col-lg-offset-4">
                <table class="table table-condensed text-right">
                    <tbody>
                        <tr>
                            <td style="width: 40%;">Item Amounts</td>
                            <td style="width: 60%;" class="amount">@currency($invoice->amount)</td>
                        </tr>
                        @if($invoice->tax > 0)
                        <tr>
                            <td style="width: 40%;">Item Taxes</td>
                            <td style="width: 60%;" class="amount">@currency($invoice->tax)</td>
                        </tr>
                        @endif
                        <tr>
                            <td>Transportation Charge</td>
                            <td class="clearfix">
                                <div class="input-group input-group-sm">
                                    <input id="invoice_transport_charge" name="invoice_transport_charge" class="discount-option form-control input-sm amount" value="{{$invoice->transport}}">
                                    <div class="input-group-addon"><i class="fa fa-inr"></i></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Total</b></td>
                            <td class="amount"><b>@currency($invoice->total)</b></td>
                        </tr>
                    </tbody>
                </table>
                <div class="row">
                    <hr>
                    <span class="col-xs-12"><b><u>Note:</u></b> Invoice must be issued under <b>{{$invoice->state->name}}</b> Taxes</span>
                    <hr>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
        <hr>
    </div>
    
</div>
@endsection
@section('scripts')
<script type="text/javascript">  
    $(function () {

        $('#client_id').change(function(){
            var clientId = $(this).val();
            $.ajax({
                url: "/api/client/"+clientId+"/address", 
                method: "GET",
                success: function (response) {
                    var options = '<option>--select address--</option>';
                    $.each(response.data, function(key,val){
                        options += "<option value='"+val.id+"'>"+val.alias+"("+val.address_name+")</option>";
                    })
                    $('#address_id').html(options);
                    $('#address_id').select2();
                }
            }).fail(function (jqXHR, textStatus, error) {
                // Handle error here
                $('#fullpage-loader').hide();
                var msg = jqXHR.responseJSON.errors.message;
                $('.notify > .alert-danger > .alert-msg').html(msg);
                $('.notify > .alert-danger').show();
                setTimeout(function(d){
                    $('.notify > .alert-danger').hide();
                }, 5000);
                return false;
            });
        });
        $('.btn_add_row').click(function () {
            var newDiv = $('#new_row').clone().appendTo('#item_table').removeAttr('id').addClass('item').show();
             $(newDiv).find('.item_tax_select').select2();
        });

        @if($items->count() == 0)
            $('#new_row').clone().appendTo('#item_table').removeAttr('id').addClass('item').show();
        @endif
        $('.item').find('.item_tax_select').select2();

        $('#btn_save_invoice').click(function () {

             if(!$('#address_id').val()) {
                $('#fullpage-loader').css('display', 'none');
                $('.notify > .alert-danger > .alert-msg').html('Please select a client shipping address');
                $('.notify > .alert-danger').show();
                setTimeout(function(d){
                    $('.notify > .alert-danger').hide();
                }, 5000);
                return false;
            }

            if(!$('#client_id').val()) {
                $('#fullpage-loader').hide();
                $('.notify > .alert-danger > .alert-msg').html('Please select a client');
                $('.notify > .alert-danger').show();
                setTimeout(function(d){
                    $('.notify > .alert-danger').hide();
                }, 5000);
                return false;
            }

            var items = [];
            var item_order = 1;
            $('table tbody.item').each(function () {
                var row = {};
                $(this).find('input,select,textarea').each(function () {
                    if ($(this).is(':checkbox')) {
                        row[$(this).attr('name')] = $(this).is(':checked');
                    } else {
                        row[$(this).attr('name')] = $(this).val();
                    }
                });
                row['item_order'] = item_order;
                item_order++;
                items.push(row);
            });
            var invoiceType = $('#invoiceType').val();

            $.ajax({
                url: "/invoice/{{$invoice->id}}/form", 
                method: "POST",
                data: {
                    _token : "{{ csrf_token() }}",
                    invoice_status_id: $('#invoice_status_id').val(),
                    items: JSON.stringify(items),
                    transport_charge : $('#invoice_transport_charge').val(),
                    uid : $('#uid').val(),
                    client_id : $('#client_id').val(),
                    address_id : $('#address_id').val(),
                    po_number : $('#po_number').val(),
                    eway_bill : $('#eway_bill').val(),
                    status : $('#status').val(),
                },
                success: function (response) {
                    // Handle success here
                     if (response.status == '200') {
                        window.location.reload()
                    }
                    else {
                        $('.notify > .alert-danger > .alert-msg').html(msg);
                        $('.notify > .alert-danger').show();
                        setTimeout(function(d){
                            $('.notify > .alert-danger').hide();
                        }, 5000);
                        return false;
                    }
                }
            }).fail(function (jqXHR, textStatus, error) {
                // Handle error here
                $('#fullpage-loader').hide();
                var msg = jqXHR.responseJSON.errors.message;
                $('.notify > .alert-danger > .alert-msg').html(msg);
                $('.notify > .alert-danger').show();
                setTimeout(function(d){
                    $('.notify > .alert-danger').hide();
                }, 5000);
                return false;
            });
        });
    });
</script>
@endsection
