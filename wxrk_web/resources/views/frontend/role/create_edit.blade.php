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

<section class="content" >
    <div class="row"  id="app">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header">
                    <div class="box-tools">
                        <a class="btn btn-primary btn-sm close_popup" href="/admin/roles">
                        <span class="glyphicon glyphicon-backward"></span>Back
                      </a>
                    </div>
                </div><!-- /.box-header -->

                <!-- form start -->
                {!! Form::model($role, ['method' => isset($role) && $role->id ? 'put' : 'post']) !!}

                    @if (count($errors) > 0)
                    <div class="alert alert-danger alert-dismissible fade in">
                        There were some problems adding roles.<br />
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="box-body">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <legend>Role</legend>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group {{{ $errors->has('name') ? 'has-error' : '' }}}">
                                            {!! Form::label('name', 'Name') !!}
                                            {!! Form::text('name',
                                                isset($role) && $role->name ? $role->name : old('name'),
                                                ['class' => 'form-control',
                                                'id' => 'name'])
                                            !!}

                                            {!! $errors->first('name', '<label class="control-label" for="name">:message</label>')!!}

                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group {{{ $errors->has('alias') ? 'has-error' : '' }}}">
                                            {!! Form::label('alias', 'Alias') !!}
                                            {!! Form::text('alias',
                                                isset($role) && $role->alias ? $role->alias : old('alias'),
                                                ['class' => 'form-control',
                                                'id' => 'alias'])
                                            !!}

                                            {!! $errors->first('alias', '<label class="control-label"  for="alias">:message</label>')!!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <legend>Permissions</legend>
                                <div class="row" style="margin-left: 7px;">
                                    @foreach($permissions as $key => $permission)
                                    <div class="col-md-3">
                                        <div class="checkbox">
                                            <input type="checkbox" id="type_{{$key}}" v-model="permission['{{$key}}']">
                                            <label for="type_{{$key}}"><strong style="font-weight: 800;text-transform: capitalize;">{{$key}}</strong></label>
                                        </div>
                                        @foreach($permission as $typeId => $type)
                                        <div class="checkbox">
                                            <input type="checkbox" id="permission_{{$typeId}}" name="permission[{{$typeId}}]" value="true" :checked="permission['{{$key}}'] @if(in_array($typeId, $rolePermissions)) || true @endif">
                                            <label for="permission_{{$typeId}}">
                                                {{$type}}
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div><!-- /.box-body -->

                    <div class="box-footer">
                        <button type="reset" class="btn btn-warning close_popup">
                            <span class="glyphicon glyphicon-ban-circle"></span> {{trans("admin/modal.cancel") }}
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <span class="glyphicon glyphicon-ok-circle"></span>
                            @if (isset($user->id))
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

@endsection

@section('styles')
    <link href="/assets/plugins/bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.css" rel="stylesheet">

@endsection

@section('scripts')
	@parent
	<script src="{{ asset('assets/js/vue.min.js') }}"></script>
	<script src="{{ asset('assets/js/axios.min.js') }}"></script>

	<script>
		axios.defaults.headers.common['X-CSRF-TOKEN'] = window.Laravel.csrfToken;
	    axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
	    var app = new Vue({
	        el: '#app',
	        data: {
	        	permission : []
	        },
	        methods: {
	        }
	    })
	</script>
@stop
