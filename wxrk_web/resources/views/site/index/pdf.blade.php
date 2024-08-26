@extends('invoice/app-pdf')

{{-- Web site Title --}}
@section('title') Aimsbuildmart Invoice :: @parent @stop

@section('content')
    <div class="container">
        @include($partialView, array(
                'invoice' => $invoice,
                'items' => $items,
                'stamp' => public_path('/assets/invoice/img/quoto-sign.jpg'),
                'logo' => public_path('/assets/invoice/img/Logo.png'),
                'line' => public_path('/assets/invoice/img/Line.png'),
                'amountInWords' => $amountInWords
            ))
    </div>
@endsection