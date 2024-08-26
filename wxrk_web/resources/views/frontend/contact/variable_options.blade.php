@extends('admin.app') 

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
    <h1>Options in {{str_replace('_', ' ', $variable->key_name)}}</h1>
    <ol class="breadcrumb">
        <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="/config">Variable List</a></li>
        <li class="active">Options</li>
    </ol>
    <br>
</section>
<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                @if (isset($variable))
                <div class="box-header">
                    <ul class="nav nav-tabs">
                        <li><a href="{{ URL::to('admin/config/variable/'.$variable->id.'/edit') }}">Variable Details</a></li>
                        <li class="active"><a href="">Variable List</a></li>
                    </ul>
                </div>
                @endif
                <!-- form start -->
                <div class="box box-solid">
                    <div class="box-header">
                        <h3 class="box-title"></h3>
                        <div class="box-tools">
                            <a href="/admin/config/variable/{{$variable->id}}/option/create" class="btn btn-primary iframe">Add New Option</a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Name</th>
                                    <th>Created By</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th style="width: 40px">Edit</th>
                                </tr>
                                {{-- */$i=1;/* --}}
                                @foreach ($options as $option)
                                <tr>                                            
                                    <td style="width: 10px">{{$i}}</td>
                                    <td>{{str_replace('_', ' ', $option->key_name)}}</td>
                                    <td>{{$option->createdBy->name}}</td>
                                    <td>
                                        @if ($option->active== 1) 
                                        <span class="glyphicon glyphicon-ok"></span> 
                                        @else 
                                        <span class='glyphicon glyphicon-remove'></span> 
                                        @endif

                                    </td>
                                    <td>{{$option->created_at}}</td>
                                    <td style="width: 40px"><a href="/admin/config/variable/{{$option->parent_id}}/option/{{$option->id}}/edit" class="iframe cboxElement"><i class="fa fa-edit"></i></a></td>
                                </tr> 
                                {{-- */$i++;/* --}}
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <br><br>
            </div><!-- /.box -->
        </div><!--/.col (left) -->
    </div>   <!-- /.row -->
</section>
@stop 

@section('scripts')
<script>
    $(".iframe").colorbox({
        iframe: true,
        width: "80%",
        height: "80%",
        onClosed: function () {
            window.location.reload();
        }
    });
</script>
@endsection
