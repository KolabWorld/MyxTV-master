@extends('invoice/app')

{{-- Web site Title --}}
@section('title') Unauthorized access :: @parent @stop

@section('content')
	<style type="text/css">
		.text-red {
			color:red;
		}
		.error-page {
			text-align: center;
			margin-top: 10%
		}
	</style>

	<div id="content">
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

		<div class="error-page">
			<div class="code">
				<h1 class="headline text-red">401</h1>
			</div>
			<div class="error-content">
				<h3><i class="fa fa-warning text-red"></i> Oops! Unauthorized access.</h3>

				<p>
					Please contact to site administrator.
				</p>
			</div>
		</div>
	</div>
@stop 
