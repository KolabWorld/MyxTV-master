@extends('pdf/app')

{{-- Web site Title --}}
@section('title') Miditech Invoice :: @parent @stop

@section('content')
@if($invoice->payment_status == 'paid')
<style>
	.container {
		background-image: url("{{ env('APP_URL') }}/frontend/images/invoice-paid.jpeg");
		background-repeat: no-repeat;
		background-position: 400px 120px;
		background-size: 300px 100px;
	}
</style>
@else
<style>
	.container {
		background-image: url("{{ env('APP_URL') }}/frontend/images/unpaid.jpg");
		background-repeat: no-repeat;
		background-position: 400px 120px;
		background-size: 300px 100px;
	}
</style>
@endif
 @if($invoice->id<10125)
    <div class="container">
        @include('includes.invosupra', array(
            'invoice' => $invoice,
            'stamp' => $stamp,
            'logo' => $logo,
            'line' => $line
        ))
    </div>
	@else
	<div class="container">
        @include('includes.invo', array(
            'invoice' => $invoice,
            'stamp' => $stamp,
            'logo' => $logo,
            'line' => $line
        ))
    </div>
	@endif
@endsection
