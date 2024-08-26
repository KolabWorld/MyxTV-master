@extends('frontend.app')

{{-- Web site Title --}}
@section('title') :: @parent @stop

@section('content')

    @include('frontend.partials.nav', [
        'title' => 'Advertisements',
        'description' => $banners->total() . ' Records',
    ])

    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">

                    <div class="row align-items-center">
                        <div class="col-4 d-none d-sm-block">
                            <a href="javascript:history.back()" class="btn btn-outline-secondary">Go Back</a>
                        </div>
                        <div class="col-12 col-md-8 text-sm-right">
                            <a href="/banner/create" class="btn btn-secondary btn-filter mr-2">
                                <i class="far fa-plus-square mr-1"></i> Add New
                            </a>
                            <a href="#filter" data-toggle="modal" class="btn btn-primary btn-filter mr-2">
                                <i class="fas fa-filter mr-1"></i> Filter
                            </a>
                            {{--  <a href="#" class="btn btn-success btn-filter"><i class="far fa-file-excel mr-1"></i>
                                Export to Excel</a>  --}}
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
                                                    <th>Advertisement Name</th>
                                                    <th>Attachment</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($banners as $banner)
                                                    <tr>
                                                        <td>
                                                            <span class="badge 
                                                            @if($banner->status == 'active')
                                                                badge-success
                                                            @elseif($banner->status == 'blacklist')
                                                                badge-warning
                                                            @else
                                                                badge-danger
                                                            @endif
                                                            ">
                                                                {{ ucWords($banner->status) }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            {{ $banner->name }}
                                                        </td>
                                                        <td>
                                                            <a href="{{$banner->image}}" target="new">
                                                                <div class="img-wh40 float-left mr-2">
                                                                    <img src="{{$banner->image}}" height="40px"  width="40px" class="mr-2" style="border: 0.5px solid #7070705a; display : {{ ($banner->attachment_type == 'image') ? 'block' : 'none' }}">
                                                                    <video width="100%" height="40px"  width="40px" muted style="display : {{ ($banner->attachment_type == 'video') ? 'block' : 'none' }}">
                                                                        <source src="{{ @$banner->image }}">
                                                                    </video>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <a href="/banner/{{ $banner->id }}/edit">
                                                                <i class="fas fa-pencil-alt"></i>
                                                            </a>
                                                            <a href="#" data-url="/banner/{{ $banner->id }}/delete"
                                                                data-request="remove" data-redirect="/banners">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    {{ $banners->links('frontend.layouts.pagination') }}

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('modals')
    @parent
    <div class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="loginpopupTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-slideout" role="document">
            <div class="modal-content bg-white">
                <form>
                    <div class="modal-header d-block pt-5 px-3 px-sm-5 border-0">
                        <div class="pt-3">
                            <button type="button" class="close search-btn addaddressbtn p-0" data-dismiss="modal"
                                aria-label="Close">
                                <img src="/assets/admin/images/close.png" width="40px" />
                            </button>
                            <div class="head-title">
                                <h2>Filter</h2>
                                <h5>Change and Apply the Filter</h5>
                            </div>
                            <div class="dashbed-border-bottom mt-3"></div>
                        </div>
                    </div>
                    <div class="modal-body pt-3 pb-5 px-3 px-sm-5">
                        <div class="form-group innerappform">
                            <label>Status</label>
                            <select class="form-control" name="status">
                                <option value="">Select</option>
                                <option value="active" @if(Request::get('status') == 'active') selected @endif>Active</option>
                                <option value="inactive" @if(Request::get('status') == 'inactive') selected @endif>Inactive</option>
                                {{-- <option value="blacklist" @if(Request::get('status') == 'blacklist') selected @endif>Blacklist</option> --}}
                            </select>
                        </div>
                        <div class="row">
                            {{-- <div class="col-md-6">
                                <div class="form-group innerappform innerappform">
                                    <label>Banner Type</label>
                                    <input type="text" name="type" value="{{ Request::get('type') }}" class="form-control" />
                                </div>
                            </div> --}}
                            <div class="col-md-6">
                                <div class="form-group innerappform innerappform">
                                    <label>Advertisement Name</label>
                                    <input type="text" name="name" value="{{ Request::get('name') }}" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3 px-5">Apply Filter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent

@endsection
