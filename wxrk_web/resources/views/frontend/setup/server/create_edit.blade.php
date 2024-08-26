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
                    <h3 class="box-title"> @if (isset($server) && $server->id) Edit @else Create @endif Server</h3>
                    <div class="box-tools">
                        <button class="btn btn-primary btn-sm close_popup">
                            <span class="glyphicon glyphicon-backward"></span> {{{trans('admin/admin.back') }}}
                        </button>
                    </div>
                </div><!-- /.box-header -->
                <!-- form start -->
                 {!! Form::model($server, ['method' => isset($server) && $server->id ? 'put' : 'post']) !!}
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group {{{ $errors->has('server_group_id') ? 'has-error' : '' }}}">
                                    {!! Form::label('server_group_id', 'Server Group') !!}
                                    <select class="form-control select2" data-live-search="true" name="server_group_id" id="server_group_id">
                                        <option value="">-- Select Server Group --</option>
                                        @foreach($serverGroups as $val)
                                            <option value="{{$val->id}}" @if(($server && ($server->server_group_id == $val->id)) || (old('server_group_id') == $val->id)) selected @endif>
                                                {{$val->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                    {!! $errors->first('server_group_id', '<label class="control-label"  for="server_group_id">:message</label>')!!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {{{ $errors->has('name') ? 'has-error' : '' }}}">
                                    {!! Form::label('name', 'Name') !!}
                                    {!! Form::text('name', 
                                        isset($server) && $server->name ? $server->name : old('name'), 
                                        ['class' => 'form-control',
                                        'id' => 'name']) 
                                    !!}
                                    {!! $errors->first('name', '<label class="control-label"  for="name">:message</label>')!!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {{{ $errors->has('ip_address') ? 'has-error' : '' }}}">
                                    {!! Form::label('ip_address', 'IP Address') !!}
                                    {!! Form::text('ip_address', 
                                        isset($server) && $server->ip_address ? $server->ip_address : old('ip_address'), 
                                        ['class' => 'form-control',
                                        'id' => 'ip_address']) 
                                    !!}
                                    {!! $errors->first('ip_address', '<label class="control-label"  for="ip_address">:message</label>')!!}
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
                                        {{isset($server) && $server->description ? $server->description : old('description')}} 
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
                            @if (isset($server) && $server->id)
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
            //Add text editor
            $("#description-textarea").wysihtml5();
    
        });
    </script>
    
@stop
