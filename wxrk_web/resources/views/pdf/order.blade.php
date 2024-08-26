@extends('pdf/app')

{{-- Web site Title --}}
@section('title') Miditech Invoice :: @parent @stop

@section('content')
@if($order->payment_status == 'paid')
<style>
	.container {
		background-image: url("/frontend/images/invoice-paid.jpeg");
		background-repeat: no-repeat;
		background-position: 400px 180px;
		background-size: 300px 100px;
	}
</style>
@else
<style>
	.container {
		background-image: url("/frontend/images/unpaid.jpg");
		background-repeat: no-repeat;
		background-position: 400px 180px;
		background-size: 300px 100px;
	}
</style>
@endif	
    <div class="container">
        @include('includes.order', array(
            'invoice' => $order,
            'stamp' => $stamp,
            'logo' => $logo,
            'line' => $line
        ))
    </div>
@endsection