@extends('pdf/app')

{{-- Web site Title --}}
@section('title') Aimsbuildmart Quotation :: @parent @stop

@section('content')
    <div class="container">
        @include('includes.quota', array(
            'quotation' => $quotation,
            'stamp' => $stamp,
            'logo' => $logo,
            'line' => $line
        ))
    </div>
@endsection