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
                        <strong>@if (isset($productService) && $productService->id) Edit @else Create @endif Product Service</strong>
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
                            {{--  <legend>Personal Information</legend>  --}}
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="nav-tabs-custom">
                                        <ul class="nav nav-tabs">
                                            <li class="active">
                                                <a href="#tab_1" data-toggle="tab" aria-expanded="false">
                                                    <b>Details</b>
                                                </a>
                                            </li>
                                            @if(isset($productService) && ($productService->id))
                                                <li class="">
                                                    <a href="/admin/setup/product-service/{{$productService->id}}/pricing">
                                                        <b>Pricing</b>
                                                    </a>
                                                </li>
                                                <li class="">
                                                    <a href="/admin/setup/product-service/{{$productService->id}}/attributes">
                                                        <b>Attributes</b>
                                                    </a>
                                                </li>
                                                <li class="">
                                                    <a href="/admin/setup/product-service/{{$productService->id}}/config-options">
                                                        <b>Configurable Options</b>
                                                    </a>
                                                </li>
												 <li class="">
                                                    <a href="/admin/setup/product-service/{{$productService->id}}/seo-details">
                                                        <b>SEO</b>
                                                    </a>
                                                </li>
                                                {{--  <li class="">
                                                    <a href="#tab_5" data-toggle="tab" aria-expanded="true">
                                                        <b>Upgrades</b>
                                                    </a>
                                                </li>
                                                <li class="">
                                                    <a href="#tab_6" data-toggle="tab" aria-expanded="true">
                                                        <b>Free Domain</b>
                                                    </a>
                                                </li>
                                                <li class="">
                                                    <a href="#tab_7" data-toggle="tab" aria-expanded="false">
                                                        <b>Other</b>
                                                    </a>
                                                </li>
                                                <li class="">
                                                    <a href="#tab_8" data-toggle="tab" aria-expanded="true">
                                                        <b>Links</b>
                                                    </a>
                                                </li>  --}}
                                            @endif    
                                            <li class="pull-right">
                                                <a href="#" class="text-muted">
                                                    <i class="fa fa-gear"></i>
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tab_1">
                                                <!-- form start -->
                                                {!! Form::model($productService, ['method' => isset($productService) && $productService->id ? 'put' : 'post']) !!}
                                                    <div class="box-body">
                                                        <div class="panel panel-default">
                                                            <div class="panel-body">
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group {{{ $errors->has('product_type_id') ? 'has-error' : '' }}}">
                                                                            {!! Form::label('product_type_id', 'Product Type') !!}
                                                                            <select class="form-control select2" id="product_type_id" name="product_type_id" data-live-search="true" onchange="getproductGroups()">
                                                                                <option>
                                                                                    --Select Product Type--
                                                                                </option>
                                                                                @foreach($productTypes as $productType)
                                                                                    <option value="{{$productType->id}}" @if(isset($productService->productType) && (($productService->product_type_id == $productType->id) || (old('product_type_id') == $productType->id))) selected @endif>
                                                                                        {{$productType->name}}
                                                                                    </option>
                                                                                @endforeach 
                                                                            </select>
                                                                            {!! $errors->first('product_type_id', '<label class="control-label" for="product_type_id">:message</label>')!!}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6" id="product_groups">
                                                                        <div class="form-group {{{ $errors->has('server_group_id') ? 'has-error' : '' }}}">
                                                                            {!! Form::label('server_group_id', 'Product Group') !!}
                                                                            <select name="server_group_id" class="form-control select2" data-live-search="true" id="blank_state">
                                                                                <option value="">-- Select Product Group --</option>
                                                                                @foreach($serverGroups as $serverGroup)
																				<?php if($serverGroup->product_type_id == $productService->product_type_id){?>
                                                                                    <option value="{{$serverGroup->id}}" @if(isset($serverGroup->id) && (($productService->server_group_id  == $serverGroup->id) || (old('server_group_id') == $serverGroup->id))) selected @endif >
                                                                                        {{$serverGroup->name}}
                                                                                    </option>
																				<?php }?>
                                                                                @endforeach 																				
                                                                            </select>
                                                                            {!! $errors->first('server_group_id', '<label class="control-label" for="server_group_id">:message</label>')!!}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">    
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group {{{ $errors->has('name') ? 'has-error' : '' }}}">
                                                                            {!! Form::label('name', 'Product Name') !!}
                                                                            {!! Form::text('name', 
                                                                                isset($productService) && $productService->name ? $productService->name : old('name'), 
                                                                                ['class' => 'form-control',
                                                                                'id' => 'name',
                                                                                'placeholder' => 'Enter Product Name']) 
                                                                            !!}
                                                                            {!! $errors->first('name', '<label class="control-label"  for="name">:message</label>')!!}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group {{{ $errors->has('welcome_email_id') ? 'has-error' : '' }}}">
                                                                            {!! Form::label('welcome_email_id', 'Welcome Email') !!}
                                                                            <select class="form-control select2" id="welcome_email_id" name="welcome_email_id" data-live-search="true">
                                                                                <option>
                                                                                    --Select Welcome Email--
                                                                                </option>
                                                                                @foreach($welcomeEmails as $welcomeEmail)
                                                                                    <option value="{{$welcomeEmail->id}}" @if(isset($productService->welcomeEmail) && (($productService->welcome_email_id == $welcomeEmail->id) || (old('welcome_email_id') == $welcomeEmail->id))) selected @endif>
                                                                                        {{$welcomeEmail->name}}
                                                                                    </option>
                                                                                @endforeach 
                                                                            </select>
                                                                            {!! $errors->first('welcome_email_id', '<label class="control-label" for="welcome_email_id">:message</label>')!!}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-12 col-md-12">
                                                                        <div class="form-group {{{ $errors->has('domain_required') ? 'has-error' : '' }}}">
                                                                            {!! Form::label('require-domain', 'Require Domain') !!}
                                                                            <div class="checkbox icheck" style="padding-left:2%;">
                                                                                <label>
                                                                                    <input type="checkbox" name="domain_required" value="1" @if($productService->domain_required) checked @endif> Tick to show domain registration options
                                                                                </label>
                                                                                {!! $errors->first('domain_required', '<label class="control-label" for="domain_required">:message</label>')!!}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">    
                                                                    <div class="col-sm-2 col-md-2">
                                                                        <div class="form-group {{{ $errors->has('stock') ? 'has-error' : '' }}}">
                                                                            {!! Form::label('require-domain', 'Stock Control') !!}
                                                                            {!! Form::number('stock', 
                                                                                isset($productService) && $productService->stock ? $productService->stock : old('stock'), 
                                                                                ['class' => 'form-control',
                                                                                'id' => 'stock',
                                                                                'placeholder' => 'Enter Stock']) 
                                                                            !!}
                                                                            {!! $errors->first('stock', '<label class="control-label" for="stock">:message</label>')!!}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-12 col-md-12">
                                                                        <div class="form-group {{{ $errors->has('tax_applicable') ? 'has-error' : '' }}}">
                                                                            {!! Form::label('apply-tax', 'Apply Tax') !!}
                                                                            <div class="checkbox icheck" style="padding-left:2%;">
                                                                                <label>
                                                                                    <input type="checkbox" name="tax_applicable" value="1" {{  ($productService->tax_applicable == 1 ? ' checked' : '') }}> Tick this box to charge tax for this product
                                                                                </label>
                                                                                {!! $errors->first('tax_applicable', '<label class="control-label" for="tax_applicable">:message</label>')!!}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-12 col-md-12">
                                                                        <div class="form-group {{{ $errors->has('is_featured') ? 'has-error' : '' }}}">
                                                                            {!! Form::label('featured', 'Featured') !!}
                                                                            <div class="checkbox icheck" style="padding-left:2%;">
                                                                                <label>
                                                                                    <input type="checkbox" name="is_featured" value="1" {{  ($productService->is_featured == 1 ? ' checked' : '') }}> Display this product more prominently on supported order forms
                                                                                </label>
                                                                                {!! $errors->first('is_featured', '<label class="control-label" for="is_featured">:message</label>')!!}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-12 col-md-12">
                                                                        <div class="form-group {{{ $errors->has('is_hidden') ? 'has-error' : '' }}}">
                                                                            {!! Form::label('hidden', 'Hidden') !!}
                                                                            <div class="checkbox icheck" style="padding-left:2%;">
                                                                                <label>
                                                                                    <input type="checkbox" name="is_hidden" value="1" {{  ($productService->is_hidden == 1 ? ' checked' : '') }}> Tick to hide from order form
                                                                                </label>
                                                                                {!! $errors->first('is_hidden', '<label class="control-label" for="is_hidden">:message</label>')!!}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-12 col-md-12">
                                                                        <div class="form-group {{{ $errors->has('is_retired') ? 'has-error' : '' }}}">
                                                                            {!! Form::label('retired', 'Retired') !!}
                                                                            <div class="checkbox icheck" style="padding-left:2%;">
                                                                                <label>
                                                                                    <input type="checkbox" name="is_retired" value="1" {{  ($productService->is_retired == 1 ? ' checked' : '') }}> Tick to hide from admin area product dropdown menus (does not apply to services already with this product)
                                                                                </label>
                                                                                {!! $errors->first('is_retired', '<label class="control-label" for="is_retired">:message</label>')!!}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-12 col-md-12">
                                                                        <div class="form-group {{{ $errors->has('for_reseller') ? 'has-error' : '' }}}">
                                                                            {!! Form::label('for_reseller', 'For Reseller') !!}
                                                                            <div class="checkbox icheck" style="padding-left:2%;">
                                                                                <label>
                                                                                    <input type="checkbox" name="for_reseller" value="1" {{  ($productService->for_reseller == 1 ? ' checked' : '') }}> Tick to view in reseller panel
                                                                                </label>
                                                                                {!! $errors->first('for_reseller', '<label class="control-label" for="for_reseller">:message</label>')!!}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-12 col-md-12">
                                                                        {!! Form::label('description', 'Description') !!}
                                                                        <div class="form-group {{{ $errors->has('description') ? 'has-error' : '' }}}">
                                                                            <textarea id="description-textarea" name="description" rows="6" cols="80" class="form-control" style="height:200px;">{{isset($productService) && $productService->description ? $productService->description : old('description')}} 
                                                                            </textarea>
                                                                            {!! $errors->first('description', '<label class="control-label"  for="description">:message</label>')!!}
                                                                        </div>
                                                                    </div>
                                                                </div>    
                                                            </div>
                                                        </div>
                                                    </div><!-- /.box-body -->
                                                    
                                                    <div class="box-footer">
                                                        <button type="submit" class="btn btn-primary">
                                                            <span class="glyphicon glyphicon-ok-circle"></span>
                                                            Save Changes
                                                        </button>
                                                        <a type="reset" class="btn btn-warning close_popup" href="/admin/setup/product-services">
                                                            <span class="glyphicon glyphicon-ban-circle"></span> Cancel Changes
                                                        </a>
                                                    </div>
                                                {!! Form::close() !!}
                                            </div>
                                            @if(isset($productService) && ($productService->id))
                                                <!-- /.tab-pane -->
                                                <div class="tab-pane" id="tab_2">
                                                    @include('admin.setup.product-service.partials.tab-product-service-price')
                                                </div>
                                                @include('admin.setup.product-service.partials.tab-attribute')
                                                <div class="tab-pane" id="tab_4">
                                                    @include('admin.setup.product-service.partials.tab-configurable-options')
                                                </div>
                                                <!-- /.tab-pane -->
                                                <div class="tab-pane" id="tab_5">
                                                    
                                                </div>
                                                <!-- /.tab-pane -->
                                                <div class="tab-pane" id="tab_6">
                                                    
                                                </div>
                                                <!-- /.tab-pane -->
                                                <div class="tab-pane" id="tab_7">
                                                    
                                                </div>
                                                <!-- /.tab-pane -->
                                                <div class="tab-pane" id="tab_8">
                                                    
                                                </div>
                                            @endif    
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
    <link href="/assets/plugins/bootstrap-wysiwyg/style.css" rel="stylesheet" type="text/css" />
    <link href="/assets/plugins/select2/select2.css" media="screen" rel="stylesheet" type="text/css">
@endsection

@section('scripts')
    @parent
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src='/assets/plugins/bootstrap-wysiwyg/bootstrap-wysiwyg.js'></script>

    <script type="text/javascript">
        function getproductGroups() {
            var productTypeId = $('#product_type_id').val();
            var serverGroupId = "";

            @if(isset($productService->server_group_id) && $productService->server_group_id)
                serverGroupId = '{{$productService->server_group_id}}';
            @endif

            console.log(serverGroupId);
            var data = {
                product_type_id : productTypeId,
                '_token' : '{{{csrf_token()}}}'
            }
            $.ajax({
                url: '/admin/setup/product/groups' ,
                type: 'POST',
                data: data,
                success:function(data) {
                    var selectbox = '';
                    if(data)
                    {
                        selectbox = '<label for="state"><strong>Product Group<span class="mendatory" style="color:red"> *</span></strong></label>';
                        selectbox += '<select name="server_group_id" class="form-control" data-live-search="true" id="server_group_id">';
                        selectbox += '<option>-- Select Product Group --</option>';
                        $.each(data, function (i, item) {
                            if(i == serverGroupId) {
                                selectbox += '<option value="'+i+'" selected="selected">'+item+'</option>';
                            }
                            else {
                                selectbox += '<option value="'+i+'">'+item+'</option>';
                            }
                        });
                        selectbox += '</select>';
                    }
                    $('#blank_product_group').css('display','none');
                    $('#product_groups').css('display','block');
                    $('#product_groups').html(selectbox);
                }
            });
        }

        $(document).ready(function(){
            if($('#product_type_id').val()) {
                getProductGroups();
            }
        });

    </script>
    <script type="text/javascript">
        $(function () {
            //Add text editor
            $("#description-textarea").wysihtml5();
            $('#server_group_id').select2();
            $('#product_type_id').select2();
            $('#welcome_email_id').select2();
        });
    </script>    
@endsection

