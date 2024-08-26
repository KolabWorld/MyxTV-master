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
                    <h3 class="box-title"> @if (isset($income) && $income->id) Edit @else Create @endif income</h3>
                    <div class="box-tools">
                        <button class="btn btn-primary btn-sm close_popup">
                        <span class="glyphicon glyphicon-backward"></span> {{{trans('admin/admin.back') }}}
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                {!! Form::model($income, ['method' => isset($income) && $income->id ? 'put' : 'post']) !!}

                @if (count($errors) > 0)
                <div class="alert alert-danger alert-dismissible fade in">
                    There were some problems adding income.<br />
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
                            isset($income) && $income->date ? $income->date : old('date'), 
                            ['class' => 'form-control datepicker',
                            'id' => 'date']) 
                            !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('amount', 'Amount') !!}
                            {!! Form::text('amount', 
                            isset($income) && $income->amount ? $income->amount : old('amount'), 
                            ['class' => 'form-control',
                            'id' => 'amount']) 
                            !!}
                        </div>
                    </div>
                     <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('reference', 'Amount From') !!}
                            {!! Form::text('reference', 
                            isset($income) && $income->reference ? $income->reference : old('reference'), 
                            ['class' => 'form-control',
                            'id' => 'reference']) 
                            !!}
                        </div>
                    </div>
                     <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('reference_no', 'Reference No') !!}
                            {!! Form::text('reference_no', 
                            isset($income) && $income->reference_no ? $income->reference_no : old('reference_no'), 
                            ['class' => 'form-control',
                            'id' => 'reference_no']) 
                            !!}
                        </div>
                    </div>
                     <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('description', 'Description') !!}
                            {!! Form::text('description', 
                            isset($income) && $income->description ? $income->description : old('description'), 
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
                    @if (isset($income) && $income->id)
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

