@extends('frontend.app')
{{-- Web site Title --}}
@section('title') Equipment Types :: @parent @stop
@section('content')

@include('frontend.partials.nav',['title'=> 'Equipment Types' ,'description'=> 'Total Records '. $records->total() .''])
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="row align-items-center"> 
                    <div class="col-8 pl-0 col-md-8 text-right">
                        <a href="/equipment-types/create" class="btn btn-secondary btn-filter mr-2">
                            <i class="far fa-plus-square mr-1"></i> Add New
                        </a>
                        {{-- <a href="#" class="btn btn-success btn-filter">
                            <i class="far fa-file-excel mr-1"></i> Export to Excel
                        </a> --}}
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
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table dashtable">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Name</th>
                                                <th>Maintenance Cycle</th>
                                                <th>Updated At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($records as $key => $record)
                                                <tr>
                                                    <td>
                                                        @if(($record->status == 'active'))
                                                            <span class="badge badge-success">
                                                                {{ucfirst($record->status)}}
                                                            </span>
                                                        @else 
                                                            <span class="badge badge-warning">
                                                                {{ucfirst($record->status)}}
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <strong>
                                                            {{$record->name}}
                                                        </strong>
                                                    </td> 
                                                    <td>
                                                        {{$record->maintenance_cycle}}
                                                    </td>  
                                                    <td>
                                                        {{$record->updated_at ? date('d/m/Y', strtotime($record->updated_at)) : ''}}
                                                    </td>  
                                                    <td>
                                                        <a href="/equipment-types/{{ $record->id }}/edit" class="btn btn-sm btn-outline-dark">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </a> 
                                                        <!-- <a href="#" data-url="/equipment-types/{{ $record->id }}/delete" data-request="remove" data-redirect="/equipment-types" class="btn btn-sm btn-outline-dark">
                                                            <i class="far fa-trash-alt text-danger"></i>
                                                        </a> -->
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{ $records->appends(request()->except('page'))->links('frontend.layouts.pagination') }}
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