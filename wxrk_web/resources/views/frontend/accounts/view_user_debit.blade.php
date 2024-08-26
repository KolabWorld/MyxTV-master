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
                    <h3 class="box-title">{{$debit->date}} 
                        @if($debit->status=='1')
                            <small class="label pull-right bg-green-active">Approved</small>
                        @elseif ($debit->status=='2')
                            <small class="label pull-right bg-red">Rejected</small>
                        @else
                            <small class="label pull-right bg-yellow">Pending</small>
                        @endif
                    </h3>
                    <div class="box-tools">
                        <button class="btn btn-primary btn-sm close_popup">
                        <span class="glyphicon glyphicon-backward"></span> {{{trans('admin/admin.back') }}}
                        </button>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Amount</label>
                            <span>{{$debit->amount}}</span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Created At</label>
                            {{ date('M d, Y h:i A', strtotime($debit->created_at)) }}
                            <span></span>
                        </div>
                    </div>
                    @if($debit->ebill)
                     <div class="col-md-6">
                        <a href="/storage/{{$debit->ebill}}" target="_blank">Full View</a> <br/>
                        <img src="/storage/{{$debit->ebill}}" style="height: 150px">
                    </div>
                    @endif
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!--/.col (left) -->
    </div>   <!-- /.row -->
</section>
@stop 