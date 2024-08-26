@extends('admin.app')

{{-- Web site Title --}}
@section('title') Welcome Email :: @parent @stop


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
        <h1>Welcome Emails</h1>
        <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Welcome Emails</li>
        </ol>
        <h3>
            <div class="pull-left">
                <div class="pull-right">
                    <a href="{{ URL::to('admin/master/server-welcome-email/create/') }}" class="btn btn-sm  btn-primary iframe cboxElement">
                        <span class="glyphicon glyphicon-plus-sign"></span> Add Welcome Email
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
                                    <th>Status</th>
                                    <th>Template Name</th>
									<th>Category Name</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($welcomeEmailCategories as $welcomeEmail)
                                    <tr style="background:#fff !important;">
                                        <td>
                                            @if($welcomeEmail->deleted_at)
                                                <span class="glyphicon glyphicon-remove"></span>
                                            @else
                                                <span class="glyphicon glyphicon-ok"></span>
                                            @endif
                                        </td>
                                        <td>
                                            {{$welcomeEmail->name}}
                                        </td>
                                        <td>
                                            {{$welcomeEmail->category_name}}
                                        </td>
                                        <td>
                                            {{ date('M d, Y h:i A', strtotime($welcomeEmail->created_at)) }}
                                        </td>
                                        <td>
                                            <a href="/admin/master/server-welcome-email/{{$welcomeEmail->id}}/edit" class="btn btn-info btn-xs iframe">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a href="/admin/master/server-welcome-email/{{$welcomeEmail->id}}/delete" class="btn btn-danger btn-xs iframe">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
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
        $(".iframe").colorbox({
            iframe: true,
            width: "80%",
            height: "80%",
            onClosed: function () {
                window.location.reload();
            }
        });
        var oTable;
        $(document).ready(function () {
            oTable = $('#table').DataTable({
                "order" : false,
                "sDom": "<'row'<'col-md-2'l><'col-md-7'a><'col-md-2'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
                //"sPaginationType": "bootstrap",
                "processing": true,
                "fnDrawCallback": function (oSettings) {
                    
                }
            });
        });
    </script>
@endsection
