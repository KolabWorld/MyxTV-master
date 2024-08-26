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
                    <h3 class="box-title"> @if (isset($serverWelcomeEmail) && $serverWelcomeEmail->id) Edit @else Create @endif</h3>
                    <div class="box-tools">
                        <button class="btn btn-primary btn-sm close_popup">
                            <span class="glyphicon glyphicon-backward"></span> {{{trans('admin/admin.back') }}}
                        </button>
                    </div>
                </div><!-- /.box-header -->
                <!-- form start -->
                {!! Form::model($serverWelcomeEmail, ['method' => isset($serverWelcomeEmail) && $serverWelcomeEmail->id ? 'put' : 'post']) !!}
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group {{{ $errors->has('name') ? 'has-error' : '' }}}">
                                    {!! Form::label('name', 'Name') !!}
                                    {!! Form::text('name', 
                                        isset($serverWelcomeEmail) && $serverWelcomeEmail->name ? $serverWelcomeEmail->name : old('name'), 
                                        ['class' => 'form-control',
                                        'id' => 'name']) 
                                    !!}
                                    {!! $errors->first('name', '<label class="control-label"  for="name">:message</label>')!!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {{{ $errors->has('category_name') ? 'has-error' : '' }}}">
                                    {!! Form::label('category_name', 'Category') !!}
                                    <select class="form-control select2" name="category_name">
                                        @foreach($messageCategories as $val)
                                            <option value="{{$val}}"  @if(isset($serverWelcomeEmail) && ($serverWelcomeEmail->category_name == $val) || (old('category_name') == $val)) selected @endif>{{$val}}</option>
                                        @endforeach
                                    </select>
                                    {!! $errors->first('category_name', '<label class="control-label"  for="category_name">:message</label>')!!}
                                </div>
                            </div>
                        </div>
						<div class="row">
						    <div class="col-md-6">
                                <div class="form-group {{{ $errors->has('name') ? 'has-error' : '' }}}">
                                    {!! Form::label('name', 'From') !!}
                                    {!! Form::text('fromname', 
                                        isset($serverWelcomeEmail) && $serverWelcomeEmail->fromname ? $serverWelcomeEmail->fromname : old('fromname'), 
                                        ['class' => 'form-control',
                                        'id' => 'fromname']) 
                                    !!}
                                    {!! $errors->first('fromname', '<label class="control-label"  for="fromname">:fromname</label>')!!}
                                </div>
                            </div>
							<div class="col-md-6">
                                <div class="form-group {{{ $errors->has('name') ? 'has-error' : '' }}}">
                                    {!! Form::label('name', 'From Email') !!}
                                    {!! Form::text('fromemail', 
                                        isset($serverWelcomeEmail) && $serverWelcomeEmail->fromemail ? $serverWelcomeEmail->fromemail : old('fromemail'), 
                                        ['class' => 'form-control',
                                        'id' => 'fromemail']) 
                                    !!}
                                    {!! $errors->first('fromemail', '<label class="control-label"  for="fromemail">:fromemail</label>')!!}
                                </div>
                            </div>							
                        </div>
						 <div class="row">
						 	<div class="col-md-6">
                                <div class="form-group {{{ $errors->has('name') ? 'has-error' : '' }}}">
                                    {!! Form::label('name', 'Subject') !!}
                                    {!! Form::text('subject', 
                                        isset($serverWelcomeEmail) && $serverWelcomeEmail->subject ? $serverWelcomeEmail->subject : old('subject'), 
                                        ['class' => 'form-control',
                                        'id' => 'subject']) 
                                    !!}
                                    {!! $errors->first('subject', '<label class="control-label"  for="subject">:subject</label>')!!}
                                </div>
                            </div>
						    <div class="col-md-6">
                                <div class="form-group {{{ $errors->has('name') ? 'has-error' : '' }}}">
                                    {!! Form::label('name', 'Copy To') !!}
                                    {!! Form::text('copyto', 
                                        isset($serverWelcomeEmail) && $serverWelcomeEmail->copyto ? $serverWelcomeEmail->copyto : old('copyto'), 
                                        ['class' => 'form-control',
                                        'id' => 'copyto']) 
                                    !!}
                                    {!! $errors->first('copyto', '<label class="control-label"  for="subject">:copyto</label>')!!}
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
                                        {{isset($serverWelcomeEmail) && $serverWelcomeEmail->description ? $serverWelcomeEmail->description : old('description')}} 
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
                            @if (isset($serverWelcomeEmail) && $serverWelcomeEmail->id)
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
                }
            });
        });
    </script>
    
@stop
