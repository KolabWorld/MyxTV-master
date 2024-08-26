@extends('frontend.web-app')
{{-- Web site Title --}}
@section('title') MyxTV :: @parent @stop
@section('content')
<section  class="ptb-100 bg-image overflow-hidden"  image-overlay="8"></section>
    <section>
     <div class="container-fluid">
        <div class="row align-items-center mb-1">
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <h2 class="mt-4 text-center">
                    {{ $static->name }}
                </h2>
                <div class="container">
                    <div class="row">
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-8">
                            <div class="mt-4 text-left">{!! $static->description !!}</div>
                        </div>
                        <div class="col-sm-2">
                        </div>
                    </div>
                <div class="container">
            </div>
        </div>
      </div>
    </section>

@stop

@section('scripts')
@stop

@section('styles')
    <style type="text/css"></style>
@endsection
