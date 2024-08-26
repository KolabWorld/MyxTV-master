

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
                    <h3 class="box-title"> @if (isset($account) && $account->id) Edit @else Create @endif account</h3>
                    <div class="box-tools">
                        <button class="btn btn-primary btn-sm close_popup">
                        <span class="glyphicon glyphicon-backward"></span> {{{trans('admin/admin.back') }}}
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                {!! Form::model($account, ['method' => isset($account) && $account->id ? 'put' : 'post']) !!}

                @if (count($errors) > 0)
                <div class="alert alert-danger alert-dismissible fade in">
                    There were some problems adding account.<br />
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                    
                <div class="box-body">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('name', 'Name') !!}
                            {!! Form::text('name', 
                            isset($account) && $account->name ? $account->name : old('name'), 
                            ['class' => 'form-control',
                            'id' => 'name']) 
                            !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('description', 'Description') !!}
                            {!! Form::text('description', 
                            isset($account) && $account->description ? $account->description : old('description'), 
                            ['class' => 'form-control',
                            'id' => 'description']) 
                            !!}
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
                    @if (isset($account) && $account->id)
                    {{ trans("admin/modal.edit") }}
                    @else
                    {{trans("admin/modal.create") }}
                    @endif
                    </button>
                </div>
                {!! Form::close() !!}
                <br><br>
            </div>
            <!-- /.box -->
        </div>
        <!--/.col (left) -->
    </div>
    <!-- /.row -->
</section>
@stop 
@section('scripts')
<script type="text/javascript">
    $(function() {
        
    });
</script>
@stop