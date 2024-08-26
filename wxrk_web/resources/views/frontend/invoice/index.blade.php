@extends('admin.app')

{{-- Web site Title --}}
@section('title') Invoices :: @parent @stop


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

    <section class="content-header">
        <!--<h1>Users <small>Platform Users</small></h1>-->
        @if($type == 'billable')
            <h1>Billalbe Items</h1>
        @else
            @if($invoiceStatus == 'success')
                <h1>Active Invoices</h1>
            @elseif($invoiceStatus == 'pending')
                <h1>Pending Invoices</h1>
            @elseif($invoiceStatus == 'complete')
                <h1>Approved Invoices</h1>
            @elseif($invoiceStatus == 'cancelled')
                <h1>Cancelled Invoices</h1>
            @elseif($invoiceStatus == 'initiated')
                <h1>Initiated Invoices</h1>    
            @endif
        @endif    
        <ol class="breadcrumb">
            <li>
                <a href="/admin">
                    <i class="fa fa-dashboard"></i> Home
                </a>
            </li>
            <li class="active">
                @if($type == 'billable')
                    Billalbe Items
                @else
                    @if($invoiceStatus == 'success')
                        <h3>Active Invoices</h3>
                    @elseif($invoiceStatus == 'pending')
                        <h3>Pending Invoices</h3>
                    @elseif($invoiceStatus == 'complete')
                        <h3>Approved Invoices</h3>
                    @elseif($invoiceStatus == 'cancelled')
                        <h3>Cancelled Invoices</h3>
                    @elseif($invoiceStatus == 'initiated')
                        <h3>Initiated Invoices</h3>    
                    @endif
                @endif 
            </li>
        </ol>
        <script>
        function redirectto(url,p1){
            window.location.href='/admin/invoices?type={{app('request')->input('type')}}&invoice_type='+p1;
        }
        </script>
        <div  style="float:right;">Invoice Type: 
               <select name="payment_status" class="form-control input-sm" style="width:unset;display:inline;" onchange="redirectto('{{Request::getRequestUri()}}',this.value);"> 
                    <option value="">--</option>
                    <option value="renew_service" {{ app('request')->input('invoice_type')=='renew_service'?'selected':'' }}>Service Renewal Invoice</option>
                    <option value="new_order" {{ app('request')->input('invoice_type')=='new_order'?'selected':'' }}>New Order</option>
                    <option value="renew_domain_service" {{ app('request')->input('invoice_type')=='renew_domain_service'?'selected':'' }}>Domain Renewel</option>
                    <option value="service_upgrade" {{ app('request')->input('invoice_type')=='service_upgrade'?'selected':'' }}>Service Upgrade</option>
                    <option value="wallet" {{ app('request')->input('invoice_type')=='wallet'?'selected':'' }}>Wallet</option>
                    <option value="custom_invoice" {{ app('request')->input('invoice_type')=='custom_invoice'?'selected':'' }}>Custom Invoice</option>
                    <select><div>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12 col-md-3">
                <a href="/admin/invoice/create" class="btn btn-primary btn-sm">Create Invoice</a>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-12">
                <div class="box">
                    <div class="box-body">
                        <table id="table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Invoice #</th>
                                    <th>Type</th>
                                    <th>Client Name</th>
                                    <th>Invoice Date</th>
                                    <th>Due Date</th>
                                    <th>Total Amount</th>
                                    <th>Payment Status</th>
                                    <th>Status</th>
                                    <th>Details</th>
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
@endsection

{{-- Scripts --}}
@section('scripts')
    @parent
    <script type="text/javascript">
        var oTable;
        $(document).ready(function () {
            oTable = $('#table').DataTable({
                "order" : [[3, "desc"]],
                "sDom": "<'row'<'col-md-2'l><'col-md-7'a><'col-md-2'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
                //"sPaginationType": "bootstrap",
                "processing": true,
                "serverSide": true,
                	"pageLength": 50,
                "ajax": "/admin/invoices/data?type={{$type}}&status={{$invoiceStatus}}&invoice_type={{$invoice_type}}",
                "columns": [
                    { data: 'invoice_number', name: 'invoice_number' },
                    { data: 'invoice_type', name: 'invoice_type' },
                    { data: 'customer_name', name: 'customer_name' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'due_date', name: 'due_date' },
                    { data: 'invoice_total', name: 'invoice_total' },
                    { data: 'payment_status', name: 'payment_status' },
                    { data: 'status', name: 'status' },
                    { data: 'custom_value', name: 'custom_value' },
                    { data: 'actions', name: 'actions',"width": "8%" }
                ],
                "fnDrawCallback": function (oSettings) {
                    $(".iframe").colorbox({
                        iframe: true,
                        width: "40%",
                        height: "50%",
                        onClosed: function () {
                            window.location.reload();
                        }
                    });
                }
            });
        });
    </script>
@endsection
