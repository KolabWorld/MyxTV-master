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

<section class="content">
    <div class="row" id="app">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">
                        <strong>Product Service Pricing</strong>
                    </h3>
                    <div class="box-tools">
                        <a class="btn btn-primary btn-sm close_popup" href="/admin/setup/product-services/">
                            <span class="glyphicon glyphicon-backward"></span> {{{trans('admin/admin.back') }}}
                        </a>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="nav-tabs-custom">
                                        <ul class="nav nav-tabs">
                                            <li>
                                                <a href="/admin/setup/product-service/{{$productService->id}}/edit" >
                                                    <b>Details</b>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="/admin/setup/product-service/{{$productService->id}}/pricing" >
                                                    <b>Pricing</b>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="/admin/setup/product-service/{{$productService->id}}/attributes" >
                                                    <b>Attributes</b>
                                                </a>
                                            </li>
                                            <li >
                                                 <a href="/admin/setup/product-service/{{$productService->id}}/config-options" >
                                                    <b>Configurable Options</b>
                                                </a>
                                            </li>
											<li class="active">
                                                <a href="#">
                                                    <b>Seo Details</b>
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">

                                            <div class="tab-pane active">
                                               
											   <form action="/admin/setup/product-service/{{$productService->id}}/seo-details" method="post">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="hidden" name="product_service_id" value="{{$productService->id}}">
                                                    <div class="box-body">
													 <div class="row">
														<div class="col-sm-12 col-md-12">
															{!! Form::label('metatitle', 'Meta Title') !!}
															<div class="form-group {{{ $errors->has('metatitle') ? 'has-error' : '' }}}">
																<textarea   name="metatitle" rows="6" cols="80" class="form-control" style="height:50px;">{{isset($productService) && $productService->metatitle ? $productService->metatitle : old('metatitle')}} 
																</textarea>
																{!! $errors->first('metatitle', '<label class="control-label"  for="metatitle">:metatitle</label>')!!}
															</div>
														</div>
													</div>
													 <div class="row">
														<div class="col-sm-12 col-md-12">
															{!! Form::label('metadescription', 'Meta Description') !!}
															<div class="form-group {{{ $errors->has('metadescription') ? 'has-error' : '' }}}">
																<textarea   name="metadescription" rows="6" cols="80" class="form-control" style="height:50px;">{{isset($productService) && $productService->metadescription ? $productService->metadescription : old('metadescription')}} 
																</textarea>
																{!! $errors->first('metadescription', '<label class="control-label"  for="metadescription">:metadescription</label>')!!}
															</div>
														</div>
													</div>   
													 <div class="row">
														<div class="col-sm-12 col-md-12">
															{!! Form::label('metakeywords', 'Meta Keywords') !!}
															<div class="form-group {{{ $errors->has('metakeywords') ? 'has-error' : '' }}}">
																<textarea   name="metakeywords" rows="6" cols="80" class="form-control" style="height:50px;">{{isset($productService) && $productService->metakeywords ? $productService->metakeywords : old('metakeywords')}} 
																</textarea>
																{!! $errors->first('metakeywords', '<label class="control-label"  for="metakeywords">:metakeywords</label>')!!}
															</div>
														</div>
													</div>   
													 <div class="row">
														<div class="col-sm-12 col-md-12">
															{!! Form::label('canonicaltag', 'Canonical Tag') !!}
															<div class="form-group {{{ $errors->has('canonicaltag') ? 'has-error' : '' }}}">
																<textarea   name="canonicaltag" rows="6" cols="80" class="form-control" style="height:50px;">{{isset($productService) && $productService->canonicaltag ? $productService->canonicaltag : old('canonicaltag')}} 
																</textarea>
																{!! $errors->first('canonicaltag', '<label class="control-label"  for="canonicaltag">:canonicaltag</label>')!!}
															</div>
														</div>
													</div>   													
                                                    </div><!-- /.box-body -->
                                                    
                                                    <div class="box-footer">
                                                        <button type="submit" class="btn btn-primary">
                                                            <span class="glyphicon glyphicon-ok-circle"></span>
                                                            Save Changes
                                                        </button>
                                                        <a type="reset" class="btn btn-warning close_popup" href="/admin/setup/product-service/{{$productService->id}}/view">
                                                            <span class="glyphicon glyphicon-ban-circle"></span> Cancel Changes
                                                        </a>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!--/.col (left) -->
    </div>   <!-- /.row -->
</section>
@endsection 

@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <link href="/assets/admin/js/plugins/multi-select/css/multi-select.css" media="screen" rel="stylesheet" type="text/css">
@endsection

@section('scripts')
    @parent
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="/assets/admin/js/plugins/multi-select/js/jquery.multi-select.js" type="text/javascript"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#config_groups').multiSelect();
        });

        function validate() {
            flag = true;
            if (! $( "#config_groups option:selected" ).length) {
                $('#config_groups').closest('.form-group').addClass('has-error');
                $('label[for="config_groups"]').text('At least one configurable option is required.');
                flag = false;
            }
            return flag;
        }
        
    </script>    
@endsection