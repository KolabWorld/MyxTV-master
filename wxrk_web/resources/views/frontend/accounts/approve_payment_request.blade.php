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
                    <h3 class="box-title"> Approve Payment Request</h3>
                    <div class="box-tools">
                        <button class="btn btn-primary btn-sm close_popup">
                        <span class="glyphicon glyphicon-backward"></span> {{{trans('admin/admin.back') }}}
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                {!! Form::model($paymentRequest, ['method' => 'post']) !!}

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
                            {!! Form::label('account_id', 'Send From Account') !!}
                            <select id="account_id" name="account_id" class="form-control select" required="true">
                                <option>--select account--</option>
                                @foreach($accounts as $account)
                                    <option value="{{$account->id}}">{{$account->name}} ({{$account->amount}})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('amount', 'Amount') !!}
                            {!! Form::text('amount', 
                            $paymentRequest->amount, 
                            ['class' => 'form-control',
                            'disabled' => true,
                            'id' => 'amount']) 
                            !!}
                        </div>
                    </div>
                    
                     <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('remark', 'Remark') !!}
                            <input type="text" value="{{$paymentRequest->remark}}" id="remark" class="form-control" name="remark"  autocomplete="off" />
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
                    Save
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

