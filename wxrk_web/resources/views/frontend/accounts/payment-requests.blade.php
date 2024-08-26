@extends('admin.app')

{{-- Web site Title --}}
@section('title') Accounts :: @parent @stop


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
        <h1>Accounts</h1>
        <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Accounts</li>
        </ol>
        <br>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <table id="table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <!-- <th>Title</th> -->
                                    <th>Name</th>
                                    <th>Amount</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Remark</th>
                                    <th>Created At</th>
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


@section('styles')
            
<link rel="stylesheet" href="/assets/plugins/timepicker/bootstrap-timepicker.min.css" type='text/css'>
@stop

{{-- Scripts --}}
@section('scripts')
    @parent

    <script src="/assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>

    <script type="text/javascript">

        function rejectRecord(id) {
            bootbox.prompt({ 
                size: "small",
                title: "Cancellation Remark",
                inputType: 'textarea',
                callback: function (result) {
                    if (result) {
                        $.ajax({
                            data : {
                                'remark' : result,
                                '_token' : '{{{csrf_token()}}}'
                            },
                            method: 'POST',
                            url: "/admin/payment-requests/"+id+"/reject",
                            async: false,
                            success: function(json){
                                bootbox.alert({ 
                                    size: "small",
                                    message: "Record rejected.",
                                });
                                oTable.ajax.reload();
                            }
                        });
                    }
                }
            })
        }

        function approveRecord(id) {
            bootbox.confirm({ 
                size: "small",
                message: "Are you sure?", 
                callback: function(result){ 
                    if (result) {
                        $.ajax({
                            url: "/admin/payment-requests/"+id+"/approve",
                            async: false,
                            success: function(json){
                                bootbox.alert({ 
                                    size: "small",
                                    message: "Record approved.",
                                });
                                oTable.ajax.reload();
                            }
                        });
                    }
                }
            })
        }
        var oTable;
        $(document).ready(function () {
            oTable = $('#table').DataTable({
                "order" : [[1, "desc"]],
                "sDom": "<'row'<'col-md-2'l><'col-md-7'a><'col-md-2'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
                //"sPaginationType": "bootstrap",
                "processing": true,
                "serverSide": true,
                "ajax": "{{ URL::to('admin/accounts/payment-requests/data/') }}",
                "columns": [
                    { data: 'name', name: 'name' },
                    { data: 'amount', name: 'amount' },
                    { data: 'description', name: 'description' },
                    { data: 'status', name: 'status' },
                    { data: 'remark', name: 'remark' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'actions', name: 'actions' }
                ],
                "fnDrawCallback": function (oSettings) {
                    $(".iframe").colorbox({
                        iframe: true,
                        width: "80%",
                        height: "80%",
                        onClosed: function () {
                            window.location.reload();
                        }
                    });
                }
            });
        });
    </script>
@endsection
