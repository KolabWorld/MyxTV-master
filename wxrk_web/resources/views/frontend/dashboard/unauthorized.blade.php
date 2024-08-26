@extends('admin/app')

{{-- Web site Title --}}
@section('title') Unauthorized access :: @parent @stop

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
  <ol class="breadcrumb">
    <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">401 error</li>
  </ol>
</section>

<section class="content">
    <div class="row">
       

  <div class="error-page">
    <h2 class="headline text-red">401</h2>

    <div class="error-content">
      <h3><i class="fa fa-warning text-red"></i> Oops! Unauthorized access.</h3>

      <p>
        Please contact to site administrator.
      </p>

    </div>
  </div>

    </div>
    
</section>
@stop 
