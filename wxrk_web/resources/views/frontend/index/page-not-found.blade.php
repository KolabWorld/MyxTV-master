@extends('frontend.app-blank')
{{-- Web site Title --}}
@section('title') Equipment Details :: @parent @stop
@section('content')

@php
$regex = "([^\\s]+(\\.(?i)(jpe?g|png))$)";
@endphp
<div class="content-header scanboxbox-shadow pb-2 mob-contentheader">
    <div class="container-fluid">
        <div class="row align-items-center mb-1">
            <div class="col-2">
                <a href="javascript:history.back()"><img src="/assets/admin/images/popup-close.svg" width="16px" /></a>
            </div>
            <div class="col-8 text-center">
                <img src="/assets/admin/images/logo.png" />
            </div>
        </div>
    </div>
</div>
<br><br>
<h2> This Page doesn't exists.</h2>
</div>
@stop

@section('scripts')
<script>
    $('input').attr('disabled', 'true')
    $('select').attr('disabled', 'true')

</script>
@stop

@section('styles')
<style type="text/css"></style>
@endsection
