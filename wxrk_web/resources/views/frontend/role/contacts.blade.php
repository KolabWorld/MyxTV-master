@extends('admin.app')

{{-- Web site Title --}}
@section('title') Contacts :: @parent @stop


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
        <h1>Contacts</h1>
        <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/admin/groups"><i class="fa fa-users"></i> Groups</a></li>
            <li class="active">Contacts</li>
        </ol>
        <h3>
            <div class="pull-left">
                <div class="pull-left">
                    <a href="/admin/{{$group_id}}/contact/create" class="btn btn-sm  btn-primary iframe"><span class="glyphicon glyphicon-plus-sign"></span> Add Contact</a>
                </div>
            </div>
        </h3>
        <br>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">

            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add Bulk Contacts</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body clearfix">

                        <form method='post' action="{{ URL::to('admin/'.$group_id.'/contacts/upload') }}" enctype='multipart/form-data'>
                            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                           
                            <div style='float:left'>
                                <input type=file name='file'>
                            </div>
                            <div style='float:left'>
                                <button type=submit class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-upload"></span> Upload</button>
                            </div>
                            <a class="btn btn-info btn-xs" href="/admin/contacts/sample/">
                                <span class="glyphicon glyphicon-download"></span>Download Sample
                            </a>
                        </form>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>


            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <table id="table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile No</th>
                                    <th>Address</th>
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

{{-- Scripts --}}
@section('scripts')
    @parent
<script type="text/javascript">
        var oTable;
        $(document).ready(function () {
            oTable = $('#table').DataTable({
                "order" : [[1, "desc"]],
                "sDom": "<'row'<'col-md-2'l><'col-md-7'a><'col-md-2'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
                //"sPaginationType": "bootstrap",
                "processing": true,
                "serverSide": true,
                "ajax": "{{ URL::to('admin/'.$group_id.'/contacts/data') }}",
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
