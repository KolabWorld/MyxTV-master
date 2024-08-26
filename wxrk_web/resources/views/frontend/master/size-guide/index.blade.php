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
                            <h2>Size guides ({{ $productSizeGuides->total() }})</h2>
                            <div class="subTitle">Manage & upload size guides</div>
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
                                <a href="{{ url('admin/size-guides/create') }}" class="btn btn-md btn-dark btn-auto mb-0">Create New Size Guide</a>
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
                            @foreach ($productSizeGuides as $key => $productSizeGuide)
                            <tr>
                                {{-- <td>
                                    <input class="filled-in checklist" name="checklist[{{$productSizeGuide->id}}]" type="checkbox" id="check{{$key}}">
                                    <label for="check{{$key}}"></label>
                                </td> --}}
                                
                                {{-- <td>
                                    <a href="{{ $productSizeGuide->size_image ? $productSizeGuide->size_image :'#' }}" target="_blank">
                                        <img style="height: 80px; width: 80px;" src="{{ $productSizeGuide->size_image }}" alt="NA">
                                    </a>
                                </td>  --}}
                                <td>
                                    <div class="tb_status {{ $productSizeGuide->status =='active' ? 'dark':'light' }}">{{ $productSizeGuide->status }}</div>
                                </td>
                                <td><strong>{{ $productSizeGuide->title }}</strong>Title</td>
                                <td><strong>{{ $productSizeGuide->created_at }}</strong>Created On</td>
                                <td>
                                    <a href="{{ url('admin/size-guides/'.$productSizeGuide->id.'/edit') }}" class="btn btn-sm btn-outline-dark">Edit</a>
                                    <a href="#" data-url="/admin/size-guides/{{ $productSizeGuide->id }}" data-request="remove" data-redirect="/admin/size-guides" class="btn btn-sm btn-outline-dark">Remove</a>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                    {{ $productSizeGuides->appends(request()->except('page'))->links('admin.layouts.pagination') }}
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
                                        <label for="status">Status</label>
                                        <select class="form-control" id="status" name="status">
                                            <option value="">Select Status</option>
                                            @foreach ($status as $value)
                                                <option value="{{ $value }}" {{ Request::get('status') == $value ? 'selected':'' }}>{{ ucfirst($value) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6 mt-4">
                                    <button class="btn btn-outline-dark btn-rounded btn-block my-4 z-depth-0 waves-effect waves-light" type="submit">Filter</button>
                                </div>
                                <div class="col-sm-6 mt-4">
                                    <a href="{{ url('admin/size-guides') }}" class="btn btn-dark btn-rounded btn-block my-4 z-depth-0 waves-effect waves-light">Clear</a>
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