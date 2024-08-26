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
                    <div class="box-tools">
                        <button class="btn btn-primary btn-sm close_popup">
                        <span class="glyphicon glyphicon-backward"></span> {{{trans('admin/admin.back') }}}
                        </button>
                    </div>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" method="post"  autocomplete="off">
                    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                    <div class="box-body">

                        <div class="form-group {{{ $errors->has('name') ? 'has-error' : '' }}}">
                            <label for="name">Key Name</label>
                            <input type="text" class="form-control" tabindex="1" placeholder="Key Name" name="key_name" id="name" value="{{{ Input::old('name', isset($variable) ? str_replace('_', ' ', $variable->key_name) : null) }}}">
                            {!! $errors->first('name', '<label class="control-label" for="name">:message</label>')!!}
                        </div>
                        
                        <div class="form-group ">
                            <label for="confirm">Active</label>
                            <select class="form-control" name="active" id="active" tabindex>
                                <option value="1" {{{ ((isset($variable) && $variable->active == 1)? ' selected="selected"' : '') }}}>{{{ trans('admin/users.yes') }}}</option>
                                <option value="0" {{{ ((isset($variable) && $variable->active == 0) ? ' selected="selected"' : '') }}}>{{{ trans('admin/users.no') }}}</option>
                            </select>
                        </div>
                    </div><!-- /.box-body -->
                    
                    <div class="box-footer">
                        <button type="reset" class="btn btn-default">
                            <span class="glyphicon glyphicon-remove-circle"></span> {{trans("admin/modal.reset") }}
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <span class="glyphicon glyphicon-ok-circle"></span>
                            @if (isset($variable))
                                {{ trans("admin/modal.edit") }}
                            @else
                                {{trans("admin/modal.create") }}
                            @endif
                        </button>
                    </div>
                </form>
                <br><br>
            </div><!-- /.box -->
        </div><!--/.col (left) -->
    </div>   <!-- /.row -->
</section>
@stop 