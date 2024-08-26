@extends('pdf/app')

{{-- Web site Title --}}
@section('title') Samsung Engineering :: @parent @stop

@section('content')
    <style>
        .page-break {
            page-break-after: always;
        }
    </style>
    <div class="row">
        @foreach ($qrs as $key => $qr)
        <div class="col-md-12" style="padding: 170px 10px; text-align:center;">
            {!! preg_replace('<<\?xml.*\?>>','',$qr->toHtml()) !!}
            <br>
            <h2>{{ $records[$key]['company_name'] }}</h2> 
            <h2>{{ $records[$key]['qr_code_number'] }} / {{ date('d-m-Y',strtotime($records[$key]['created_at'])) }}</h2> 
        </div>
        @if (!$loop->last)
            <div class="page-break"></div>
        @endif
        @endforeach
    </div>
@endsection
