@extends('admin.app')

{{-- Web site Title --}}
@section('title') Social Link :: @parent @stop


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
        <h1>Social Link</h1>
        <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Social Link</li>
        </ol>
        <h3>
            <div class="pull-left">
                <div class="pull-right">
                    <a href="{{ URL::to('admin/master/social-link/create/') }}" class="btn btn-sm  btn-primary iframe cboxElement">
                        <span class="glyphicon glyphicon-plus-sign"></span> Add Social Link
                    </a>
                </div>
            </div>
        </h3>
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
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Icon</th>
                                    <th>Link</th>
                                    <th>Active</th>
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
                "ajax": "{{ URL::to('admin/master/social-links/data/') }}",
                "columns": [
                    { data: 'name', name: 'name' },
                    { data: 'image', name: 'image' },
                    { data: 'icon', name: 'icon' },
                    { data: 'link', name: 'link' },
                    { data: 'deleted_at', name: 'deleted_at' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'actions', name: 'actions',"width": "5%" }
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
