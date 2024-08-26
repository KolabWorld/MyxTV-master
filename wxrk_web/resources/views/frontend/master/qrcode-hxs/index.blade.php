@extends('frontend.app')
{{-- Web site Title --}}
@section('title') QR History Codes  :: @parent @stop
@section('content')

@include('frontend.partials.nav',['title'=> 'QR History Codes ' ,'description'=> 'Total  Records '.  $records->total() .''])
<section class="content">
    <div class="container-fluid">  
        <div class="row">
            <div class="col-md-12">
                <div class="row align-items-center"> 
                    <div class="col-8 pl-0 col-md-8 text-right">
                        <a href='/qrcode-hxs/import' class="btn btn-secondary btn-filter mr-2">
                            <i class="far fa-plus-square mr-1"></i> Import
                        </a>
                    </div>
                    <div class="col-md-4">
                        <form method="get">
                            <div class="input-group custom-search custom-search-inner">
                                <input type="text" name="search" class="form-control" placeholder="Search list" value="{{Request::get('search') }}" aria-label="Username" aria-describedby="basic-addon1">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <button type="submit" style="border:0;background:transparent"><img src="/assets/admin/images/search.svg"></button>
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="dashbed-border-bottom mt-2 mb-3"></div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table dashtable">
                                <thead>
                                    <tr>
                                        <th>Action</th>
                                        <th>Sr. No.</th>
                                        <th>Company Name</th>
                                        <th>QR Code Number</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if( $records && count($records) > 0)
                                        @foreach ($records as $key => $record)
                                        <tr>
                                            <td>
                                            <a href="#" data-url="/qrcode-hxs/{{ $record->id }}/delete" data-request="remove" data-redirect="/qrcode-hxs" class="btn btn-sm btn-outline-dark">
                                            <i class="far fa-trash-alt text-danger"></i>
                                            </a>
                                            </td>
                                            <td>
                                                {{$key + 1}}.
                                            </td>
                                            <td>
                                                {{$record->company_name}}
                                            </td>
                                            <td>
                                                {{$record->qr_code_number}}
                                            </td>
                                        </tr>
                                        @endforeach
                                    @else 
                                        <tr>
                                            <td>
                                                No records found !!
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    </div>
    </div>
                                                       
                                                           
                                                   
                               
                           
</section>

@stop

@section('scripts')
<script src="{{ asset('js/custom-script.js') }}"></script>
<script src="{{ asset('js/sweetalert.js') }}"></script>
@stop

@section('styles')
<style type="text/css">
 
</style>
@endsection 