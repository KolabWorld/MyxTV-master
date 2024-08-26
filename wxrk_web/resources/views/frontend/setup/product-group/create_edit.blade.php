@extends('admin.layouts.modal')

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
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title"> @if (isset($serverGroup) && $serverGroup->id) Edit @else Create @endif Product Group</h3>
                    <div class="box-tools">
                        <button class="btn btn-primary btn-sm close_popup">
                            <span class="glyphicon glyphicon-backward"></span> {{{trans('admin/admin.back') }}}
                        </button>
                    </div>
                </div><!-- /.box-header -->
                <!-- form start -->
                 {!! Form::model($serverGroup, ['method' => isset($serverGroup) && $serverGroup->id ? 'put' : 'post', 'files' => true]) !!}
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group {{{ $errors->has('name') ? 'has-error' : '' }}}">
                                    {!! Form::label('name', 'Name') !!}
                                    {!! Form::text('name',
                                        isset($serverGroup) && $serverGroup->name ? $serverGroup->name : old('name'),
                                        ['class' => 'form-control',
                                        'id' => 'name'])
                                    !!}
                                    {!! $errors->first('name', '<label class="control-label"  for="name">:message</label>')!!}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group {{{ $errors->has('product_type_id') ? 'has-error' : '' }}}">
                                    {!! Form::label('product_type_id', 'Product Type') !!}
                                    <select class="form-control select2" id="product_type_id" name="product_type_id" data-live-search="true">
                                        <option>
                                            --Select Product Type--
                                        </option>
                                        @foreach($productTypes as $productType)
                                            <option value="{{$productType->id}}" @if(isset($serverGroup->productType) && (($serverGroup->product_type_id == $productType->id) || (old('product_type_id') == $productType->id))) selected @endif>
                                                {{$productType->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                    {!! $errors->first('product_type_id', '<label class="control-label" for="product_type_id">:message</label>')!!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group {{{ $errors->has('input_img') ? 'has-error' : '' }}}">
                                    {!! Form::label('name', 'Uplaod banner') !!}
                                    <input type="file" name="input_img">
                                    {!! $errors->first('input_img', '<label class="control-label"  for="name">:message</label>')!!}
                                    @if($serverGroup->imgname != "")
                                      <img src="/images/{{ $serverGroup->imgname }}" height="200">
                                    @endif
                                </div>
                            </div>
                            </div>
                    </div><!-- /.box-body -->
                    <div class="panel-body">
                        <legend>Description</legend>
                        <div class="row">
                            <div class="col-sm-12 nopadding">
                                <div class="form-group {{{ $errors->has('description') ? 'has-error' : '' }}}">
                                    <textarea id="description-textarea" name="description" rows="10" cols="80" class="form-control" style="height:300px;">
                                        {{isset($serverGroup) && $serverGroup->description ? stripslashes($serverGroup->description) : stripslashes(old('description'))}}
                                    </textarea>
                                    {!! $errors->first('description', '<label class="control-label"  for="description">:message</label>')!!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="reset" class="btn btn-warning close_popup">
                            <span class="glyphicon glyphicon-ban-circle"></span> {{trans("admin/modal.cancel") }}
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <span class="glyphicon glyphicon-ok-circle"></span>
                            @if (isset($serverGroup) && $serverGroup->id)
                                {{ trans("admin/modal.edit") }}
                            @else
                                {{trans("admin/modal.create") }}
                            @endif
                        </button>
                    </div>
                {!! Form::close() !!}
                <br><br>
            </div><!-- /.box -->
        </div><!--/.col (left) -->
    </div>   <!-- /.row -->
</section>
@stop

@section('styles')
    <link href="/assets/plugins/bootstrap-wysiwyg/style.css" rel="stylesheet" type="text/css" />
@stop

@section('scripts')
<script src='/assets/plugins/bootstrap-wysiwyg/bootstrap-wysiwyg.js'></script>

<script type="text/javascript">
$(function () {
$('#description-textarea').wysihtml5({
toolbar: {
"font-styles": true, // Font styling, e.g. h1, h2, etc.
"emphasis": true, // Italics, bold, etc.
"lists": true, // (Un)ordered lists, e.g. Bullets, Numbers.
"html": true, // Button which allows you to edit the generated HTML.
"link": true, // Button to insert a link.
"image": true, // Button to insert an image.
"color": true, // Button to change color of font
"blockquote": true, // Blockquote
"config.allowedContent" = true,

}
});



  });
</script>

@stop
