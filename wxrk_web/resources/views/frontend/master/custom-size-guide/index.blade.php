@extends('admin/app')
{{-- Web site Title --}}
@section('title') Categories :: @parent @stop
@section('content')
     <div class="content-header">
        <div class="container-fluid mt-3">
            <div class="row mb-2">
                <div class="col-sm-12 col-md-12 col-12">
                    <div class="tophead">
                        <div class="allTitle">
                            <a class="d-block d-lg-none" data-widget="pushmenu" href="#" role="button"><img src="/assets/admin/img/menu-left-alt.svg" width="18px" /></a>
                            <h2>Custom Sizing Videos ({{ $productCustomSizes->total() }})</h2>
                            <div class="subTitle">Manage & upload videos</div>
                        </div>
                        <div class="headpanel">
                            <div class="setting">
                                <a href="account-setting.html"><img src="/assets/admin/img/settings.svg" /></a>
                            </div>
                            <div class="notify">
                                <a href="#"><img src="/assets/admin/img/notify.svg" /></a>
                            </div>
                            <div class="adlogo d-inline-block"><img src="/assets/frontend/img/logo/logo-black.png" /></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <section class="content mb-5">
        <div class="container-fluid">

            <div class="row">
                <section class="col-lg-12 connectedSortable">
                    <div class="tableHead">
                        <div class="row">
                            <div class="col-sm-12 col-md-4">
                                <div class="filterarea">
                                    {{-- <div class="sel_all">
                                        <input class="filled-in" name="group1" type="checkbox" id="checkedAll">
                                        <label for="checkedAll" class="text-dark">Select All</label>
                                    </div> --}}
                                    <div class="sortlink">
                                        <a href="#" data-toggle="modal" data-target="#filterModal" class="text-dark"><img src="/assets/admin/img/filter.svg" /> Sort & Filter</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-8 textM-right pl-0"> 
                                <a href="javascript:history.back()" class="btn btn-md btn-outline-dark btn-auto mb-0">Back</a>
                                <a href="{{ url('admin/custom-size-guides/create') }}" class="btn btn-md btn-dark btn-auto mb-0">Upload New Video</a>
                                <div class="searchTb">
                                    <form action="" method="GET">
                                        <div class="input-group custom-search">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-search"></i></span>
                                            </div>
                                            <input type="text" class="form-control" value="{{ Request::get('search') }}" name="search" placeholder="Search by title" aria-label="title" aria-describedby="basic-addon1">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                        <div class="table-responsive">
                        <table class="table table-color table-bordered admintable border-0" cellspacing="0" cellpadding="0">
                            @foreach ($productCustomSizes as $key => $productCustomSize)
                            <tr>
                                {{-- <td>
                                    <input class="filled-in checklist" name="checklist[{{$productCustomSize->id}}]" type="checkbox" id="check{{$key}}">
                                    <label for="check{{$key}}"></label>
                                </td> --}}
                                
                                {{-- <td>
                                    <a href="{{ $productCustomSize->attachment_url ? $productCustomSize->attachment_url :'#' }}" target="_blank">
                                        <video muted style="height: 80px; width: 80px; object-fit: cover; display:{{ isset($productCustomSize->media[0]) && $productCustomSize->media[0]->mime_type =='video/mp4' ? '' :'none;'}}" controls>
                                            <source src="{{ $productCustomSize->attachment_url ? $productCustomSize->attachment_url :'' }}">
                                        </video>
                                        <img style="height: 80px; width: 80px; display:{{ isset($productCustomSize->media[0]) && $productCustomSize->media[0]->mime_type !='video/mp4' ? '' :'none;'}}" src="{{ $productCustomSize->attachment_url ? $productCustomSize->attachment_url :'/assets/admin/img/image.svg' }}"/>
                                    </a>
                                </td>  --}}

                                <td>
                                    <div class="tb_status {{ $productCustomSize->status =='active' ? 'dark':'light' }}">{{ $productCustomSize->status }}</div>
                                </td>
                      
                                <td><strong>{{ $productCustomSize->title }}</strong>Title</td>
                                <td><strong>{{ $productCustomSize->created_at }}</strong>Created On</td>
                                <td>
                                    <a href="{{ url('admin/custom-size-guides/'.$productCustomSize->id.'/edit') }}" class="btn btn-sm btn-outline-dark">Edit</a>
                                    <a href="#" data-url="/admin/custom-size-guides/{{ $productCustomSize->id }}" data-request="remove" data-redirect="/admin/custom-size-guides" class="btn btn-sm btn-outline-dark">Remove</a>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                    {{ $productCustomSizes->appends(request()->except('page'))->links('admin.layouts.pagination') }}
                </section>
            </div>
        </div>
    </section>
    {{-- Filter Modal --}}
    <div class="modal fade rightModal" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="edittext" aria-hidden="true">
        <div class="modal-dialog modal-dialog-slideout" role="document">
            <div class="modal-content">
                <form class="needs-validation" novalidate action="" method="GET">
                    <div class="modal-header pt-5 pl-5 pr-5 border-0">
                        <div class="popTitle">
                           Filter
                        </div>
                        <div class="float-right">
                            <button type="button" class="closebtn" data-dismiss="modal" aria-label="Close">Close <img src="/assets/admin/img/close-line.svg" /></button>
                        </div>
                    </div>
                    <div class="modal-body pt-3 pr-5 pl-5">
                        <div class="cancelAppmnt">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="md-form">
                                            <input type="text" placeholder="Search by title" name="search" value="{{ Request::get('search') }}" class="form-control">
                                        <label for="stitle">Size guide title</label>
                                    </div>
                                    </div>
                                </div>

                                <div class="col-sm-6 mt-4">
                                    <button class="btn btn-outline-dark btn-rounded btn-block my-4 z-depth-0 waves-effect waves-light" type="submit">Filter</button>
                                </div> 
                                <div class="col-sm-6 mt-4">
                                    <a href="{{ url('admin/custom-size-guides') }}" class="btn btn-dark btn-rounded btn-block my-4 z-depth-0 waves-effect waves-light">Clear</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('scripts')
<script src="{{ asset('js/custom-script.js') }}"></script>
<script src="{{ asset('js/sweetalert.js') }}"></script>
<script type="text/javascript"></script>
@stop

@section('styles')
<style type="text/css">
 
</style>
@endsection