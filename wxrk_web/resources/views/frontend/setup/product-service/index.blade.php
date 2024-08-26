@extends('admin.app')

{{-- Web site Title --}}
@section('title') Product Services :: @parent @stop


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
        <h1>Product Services</h1>
        <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Product Services</li>
        </ol>
        <h3>
            <div class="pull-left" style="width:100%;">
                <div class="pull-right" style="float:left !important;">
                    <a href="{{ URL::to('admin/setup/product-service/create/') }}" class="btn btn-sm  btn-primary">
                        <span class="glyphicon glyphicon-plus-sign"></span> Add Product Service
                    </a>
                </div>
                <div class="pull-right" style="float:right !important;width: 20%;">
                  <select onchange="forrmsearch();" name="status" id="status" class="form-control select2" style="float:right;height: 21px;padding: 2px 12px;font-size: 11px;width: 50%;">
                    <option value="">Status</option>
                    <option value="0" {{ app('request')->input('status')=="0"?'selected':'' }}>Active</option>
                    <option value="1" {{ app('request')->input('status')?'selected':'' }}>In-Active</option>
                  </select>

                </div>
            </div>
        </h3>
        <script>
            function forrmsearch(){
              var status = $("#status").val();
              //alert(status);
              window.location.href="/admin/setup/product-services/?status="+status;
            }
        </script>
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
                                    <th>Product Name</th>
                                    <th>Type</th>
                                    <!--<th>Pay Type</th>
                                    <th>Stock</th>
                                    <th>Auto Setup</th>-->
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($serverGroups as $serverGroup)
                                    <tr style="background:#eee !important;">
                                        <td colspan="3" style="text-align: left !important;">
                                            <strong>
                                               <i class="fa fa-snowflake-o"></i> GroupName : {{$serverGroup->name}}
                                            </strong>
                                        </td>
                                        <td>
                                          <!--  <a href="/admin/setup/server-group/{{$serverGroup->id}}/edit" class="btn btn-info btn-xs">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a href="/admin/setup/server-group/{{$serverGroup->id}}/delete" class="btn btn-danger btn-xs">
                                                <i class="fa fa-trash"></i>
                                            </a>-->
                                        </td>
                                    </tr>
                                    @foreach($serverGroup->productServices as $productService)
                                        <tr style="{{ ($productService->is_hidden || $productService->is_retired)?'background:#f1a5a5 !important;':'background:#fff !important;' }}">
                                            <td>
                                                {{$productService->name}}
                                            </td>
                                            <td>
                                                {{$productService->productType->name}}
                                            </td>
                                            <!--<td>
                                                Recurring
                                            </td>
                                            <td>
                                                @if($productService->stock)
                                                    {{$productService->stock}}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                Off
                                            </td>-->
                                            <td>
                                                {{ ($productService->is_hidden || $productService->is_retired)?'In-Active':'Active' }}
                                            </td>
                                            <td>
                                                <a href="/admin/setup/product-service/{{$productService->id}}/edit" class="btn btn-info btn-xs">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a href="/admin/setup/product-service/{{$productService->id}}/delete" class="btn btn-danger btn-xs">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
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

@endsection
