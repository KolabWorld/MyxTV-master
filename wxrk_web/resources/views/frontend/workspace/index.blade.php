@extends('admin/app')

{{-- Web site Title --}}
@section('title') My Workspace :: @parent @stop

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

<section class="content-header">
  <h1>
    My Workspace
  </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">

        <div class="small-box bg-red">
            <div class="inner">
              <h3>10</h3>

              <p>Agreement Requests</p>
            </div>
            <div class="icon">
              <i class="fa fa-building"></i>
            </div>
            <a href="{{ URL::to('/admin/workspace/salon_agreements') }}" class="small-box-footer">
              More info <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>

        </div>
        <!-- /.col -->
    </div>
    
</section>
@stop 

@section('styles')
    <link rel="stylesheet" href="/assets/site/css/plugins.css">

    <link href="/assets/plugins/select2/select2.min.css" type="text/css" rel="stylesheet" />
    <link href="/assets/plugins/bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.css" rel="stylesheet">

    <style type="text/css">
        .checkbox{
        margin-top: 1px !important;
        margin-bottom: 1px !important;
    </style>

@endsection

@section('scripts')

<script type='text/javascript' src='/assets/plugins/ez-schedule-manager/js/moment.locales.min.js?ver=4.3.5'></script>
<script src="/assets/plugins/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.js"></script>

 <!-- <script src="/assets/site/js/jquery.datetimepicker.full.min.js"></script> -->
<script type="text/javascript" src="/assets/plugins/select2/select2.full.js"></script>


<script type="text/javascript">

</script>
@stop
