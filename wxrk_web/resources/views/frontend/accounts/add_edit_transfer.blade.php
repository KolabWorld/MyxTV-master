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
                    <h3 class="box-title"> @if (isset($expense) && $expense->id) Edit @else Create @endif expense</h3>
                    <div class="box-tools">
                        <button class="btn btn-primary btn-sm close_popup">
                        <span class="glyphicon glyphicon-backward"></span> {{{trans('admin/admin.back') }}}
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                {!! Form::model($expense, ['method' => isset($expense) && $expense->id ? 'put' : 'post']) !!}

                @if (count($errors) > 0)
                <div class="alert alert-danger alert-dismissible fade in">
                    There were some problems adding expense.<br />
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
                            {!! Form::label('date', 'Date') !!}
                            {!! Form::text('date', 
                            isset($expense) && $expense->date ? $expense->date : old('date'), 
                            ['class' => 'form-control datepicker',
                            'id' => 'date']) 
                            !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('amount', 'Amount') !!}
                            {!! Form::text('amount', 
                            isset($expense) && $expense->amount ? $expense->amount : old('amount'), 
                            ['class' => 'form-control',
                            'id' => 'amount']) 
                            !!}
                        </div>
                    </div>
                     <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('channel_uid', 'Send To') !!}
                            <select id="channel_uid" name="channel_uid" class="form-control select" @if(isset($expense->channel_uid)) disabled @endif>
                                <option>--select user--</option>
                                @foreach($users as $user)
                                    <option @if(isset($expense->channel_uid) && $expense->channel_uid == $user->id) selected @endif value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                     <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('reference', 'Reference') !!}
                            {!! Form::text('reference', 
                            isset($expense) && $expense->reference ? $expense->reference : old('reference'), 
                            ['class' => 'form-control',
                            'id' => 'reference']) 
                            !!}
                        </div>
                    </div>
                     <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('description', 'Description') !!}
                            {!! Form::text('description', 
                            isset($expense) && $expense->description ? $expense->description : old('description'), 
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
                    @if (isset($expense) && $expense->id)
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

@section('styles')
    <link href="/assets/plugins/bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.css" rel="stylesheet">

@endsection

@section('scripts')

 <script type='text/javascript' src='/assets/plugins/ez-schedule-manager/js/moment.locales.min.js?ver=4.3.5'></script>
<script src="/assets/plugins/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript">
        var oTable;
        $(document).ready(function () {

            var dateOptions = {
                format: 'YYYY-MM-DD',
                sideBySide: false,
                defaultDate : 'now'
            };

            $('.datepicker').datetimepicker(dateOptions);
        });
    </script>
@endsection

