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
                    <h3 class="box-title"> @if (isset($task) && $task->id) Edit @else Create @endif task</h3>
                    <div class="box-tools">
                        <button class="btn btn-primary btn-sm close_popup">
                        <span class="glyphicon glyphicon-backward"></span> {{{trans('admin/admin.back') }}}
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                {!! Form::model($task, ['method' => isset($task) && $task->id ? 'put' : 'post','files' => true]) !!}

                @if (count($errors) > 0)
                <div class="alert alert-danger alert-dismissible fade in">
                    There were some problems adding task.<br />
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                    
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('title', 'Title') !!}
                                {!! Form::text('title', 
                                isset($task) && $task->title ? $task->title : old('title'), 
                                ['class' => 'form-control',
                                'id' => 'title']) 
                                !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('priority', 'Priority') !!}
                                <select id="priority" name="priority" class="form-control select" >
                                    <option>--select priority--</option>
                                    <option value="normal" {{{ ((isset($task) && $task->priority == 'normal')? ' selected="selected"' : '') }}}>Normal</option>
                                    <option value="high" {{{ ((isset($task) && $task->priority == 'high')? ' selected="selected"' : '') }}}>High</option>
                                    <option value="low" {{{ ((isset($task) && $task->priority == 'low')? ' selected="selected"' : '') }}}>Low</option>
                                    
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('contact_name', 'Contact Name') !!}
                                {!! Form::text('contact_name', 
                                isset($task) && $task->contact_name ? $task->contact_name : old('contact_name'), 
                                ['class' => 'form-control',
                                'id' => 'contact_name']) 
                                !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('contact_number', 'Contact Number') !!}
                                {!! Form::text('contact_number', 
                                isset($task) && $task->contact_number ? $task->contact_number : old('contact_number'), 
                                ['class' => 'form-control',
                                'id' => 'contact_number']) 
                                !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('assigned_to', 'Assigned To') !!}
                                <select id="assigned_to" name="assigned_to" class="form-control select2">
                                    <option>--select user--</option>
                                    @foreach($users as $user)
                                        <option @if(isset($task->assigned_to) && $task->assigned_to == $user->id) selected @endif value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="clear" style="clear:both;"></div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('contact_address', 'Contact Address') !!}
                                {!! Form::textarea('contact_address', 
                                isset($task) && $task->contact_address ? $task->contact_address : old('contact_address'), 
                                ['class' => 'form-control',
                                'rows' => '5',
                                'id' => 'contact_address']) 
                                !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('description', 'Description') !!}
                                {!! Form::textarea('description', 
                                isset($task) && $task->description ? $task->description : old('description'), 
                                ['class' => 'form-control',
                                'rows' => '5',
                                'id' => 'description']) 
                                !!}
                            </div>
                        </div>
                    </div>
                    <legend>Attachments</legend>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <input type="file" name="image[]" class="btn btn-primary" id="image" onchange="preview_image();" multiple/>
                                    <span class="help-block">choose Multiple files</span>
                                    <div id="image_preview" class="row"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="reset" class="btn btn-warning close_popup">
                    <span class="glyphicon glyphicon-ban-circle"></span> {{trans("admin/modal.cancel") }}
                    </button>
                    <button type="submit" class="btn btn-primary">
                    <span class="glyphicon glyphicon-ok-circle"></span>
                    @if (isset($task) && $task->id)
                    {{ trans("admin/modal.edit") }}
                    @else
                    {{trans("admin/modal.create") }}
                    @endif
                    </button>
                </div>
                {!! Form::close() !!}

                @if($task->id)
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <legend>Attachments</legend>
                            <div class="row">
                                @foreach($taskFiles as $key => $val)
                                    <div class="col-sm-4 col-md-4">
                                        <a href="/admin/task/{{$val->task_id}}/delete-file/{{$val->id}}" class="btn btn-danger btn-sm">
                                            <span class="glyphicon glyphicon-trash"></span>
                                        </a>
                                        <a href="/uploads/task-files/{{$val->file}}" target="_blank">
                                         {{$val->file_name}}
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
                <br><br>
            </div>
            <!-- /.box -->
        </div>
        <!--/.col (left) -->
    </div>
    <!-- /.row -->
</section>

@section('styles')
   
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {

            
        });
    </script>
    <script type="text/javascript">
        function preview_image() 
        {
            var total_file=document.getElementById("image").files.length;
            console.log(total_file);
            console.log(document.getElementById("image").files);
            for(var i=0;i<total_file;i++)
            {
                $('#image_preview').append("<div class='col-sm-3 col-md-3'><img src='"+URL.createObjectURL(event.target.files[i])+"' style='height:250px;width:100%'></div>");
            }
        }
    </script>
@endsection