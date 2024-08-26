@extends('frontend.app-blank')

{{-- Web site Title --}}
@section('title') :: @parent @stop

@section('content')

    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12" style="margin-top:5%;">
                    <div class="row align-items-center">
                        <div class="col-12 d-none d-sm-block" style="text-align: center;">
                            <a href="#" class="btn btn-outline-secondary">Twitch Videos</a>
                        </div>
                    </div>
                    <div class="dashbed-border-bottom mt-2 mb-3"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                @foreach($data as $row)
                                    @foreach ($row['videos']->data() as $key => $fR)
                                        <div class="col-md-3">
                                            <a href="/app-video/{{isset($fR->id) ? $fR->id : 'NA'}}" target="new">
                                                <div class="img-wh40 float-left mr-2">
                                                    <img src="{{isset($fR->thumbnail_url) ? thumbnailUrl($fR->thumbnail_url) : 'NA'}}" height="200px" class="mr-2" >
                                                    <label>{{isset($fR->user_name) ? $fR->user_name : ''}} : {{isset($fR->title) ? $fR->title : 'NA'}}</label>
                                                </div>
                                            </a>
                                            {{--  <iframe
                                                src="{{$fR->url}}?&parent=https://localhost:8000/"
                                                height="400"
                                                width="400"
                                                allowfullscreen>
                                            </iframe>  --}}
                                            
                                            {{--  <video width="200px" height="200px" muted >
                                                <source src="{{ $fR->url }}">
                                            </video>  --}}
                                            {{--  {{ $banners->links('frontend.layouts.pagination') }}  --}}
                                        </div>
                                    @endforeach
                                @endforeach
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
                                <option value="blacklist" @if(Request::get('status') == 'blacklist') selected @endif>Blacklist</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group innerappform innerappform">
                                    <label>Banner Type</label>
                                    <input type="text" name="type" value="{{ Request::get('type') }}" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group innerappform innerappform">
                                    <label>Name</label>
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
