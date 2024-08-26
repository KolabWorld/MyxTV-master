@extends('frontend.app')

{{-- Web site Title --}}
@section('title') :: @parent @stop

@section('content')
    @include('frontend.partials.nav', [
        'title' => 'Event',
        'description' => 'Add/Edit',
    ])
    <section class="content mb-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row align-items-center position-top-sticky">
                        <div class="col-sm-5 d-none d-sm-block">
                            <a href="/events" class="btn btn-outline-secondary">Go Back</a>
                        </div>
                        <div class="col-sm-7 text-sm-right">
                            <button type="button" data-request="ajax-submit" data-target="[role=post-data]" id="save"
                                class="btn btn-success mr-2">
                                @if($event && $event->id)
                                    Update
                                @else
                                    Submit
                                @endif
                            </button>
                            <a href="/events" class="btn btn-danger">Cancel</a>
                        </div>
                    </div>
                    <div class="dashbed-border-bottom mt-2 mb-3"></div>
                    <form method="post" action="{{ $action }}" redirect="/events" role="post-data"
                        enctype="multipart/form-data">
                        @if($event && $event->id)
                            @method('PUT')
                        @endif
                        <div class="row">
                            <div class="col-md-8">
                                <div class="accordion addformaccordian" id="addAccordian">
                                    <div class="card formCard">
                                        <div class="card-header">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link" type="button" data-toggle="collapse"
                                                    data-target="#Equipment">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="head-title form-head">
                                                                <h2>Event</h2>
                                                                <h5>Details</h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="Equipment" class="collapse show" data-parent="#addAccordian">
                                            <div class="card-body pt-2">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>Name</label>
                                                                    <input type="text" class="form-control"
                                                                        name="name" value="{{ $event->name }}"
                                                                        placeholder="Enter Name" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>Event Host</label>
                                                                    <input type="text" class="form-control"
                                                                        name="event_host" value="{{ $event->event_host }}"
                                                                        placeholder="Enter Host Name" />
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group form-label-group innerappform">
                                                                    <label>Select Country</label>
                                                                    <select class="form-control select2" name="countries[]"
                                                                        style="width: 100%;">
                                                                        <option value="">Select</option>
                                                                        @foreach ($countries as $country)
                                                                            <option value="{{ $country->id }}"
                                                                                @if (in_array($country->id, $event->countries->pluck('id')->toArray())) selected @endif>
                                                                                {{ $country->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group form-label-group innerappform">
                                                                    <label>Event Type</label>
                                                                    <select class="form-control" name="event_type_id">
                                                                        <option value="">Select</option>
                                                                        @foreach ($eventTypes as $eventType)
                                                                            <option value="{{ $eventType->id }}"
                                                                                {{ @$event->event_type_id == $eventType->id ? 'selected' : '' }}>
                                                                                {{ $eventType->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>Venue</label>
                                                                    <input type="text" class="form-control"
                                                                        name="venue" value="{{ $event->venue }}"
                                                                        placeholder="Enter Venue" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group innerappform">
                                                                    <label>Description</label>
                                                                    <textarea class="form-control h-100" name="description" placeholder="Enter Event Description">{{ $event->description }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label>Highlights</label>
                                                                <div class="form-group innerappform">
                                                                    <textarea class="form-control h-100" name="highlights" placeholder="Enter Highlights">{{ $event->highlights }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>Start Date Time</label>
                                                                    <input type="datetime-local" class="form-control"
                                                                        name="start_date_time"
                                                                        value="{{ $event->start_date_time ? date('Y-m-d\TH:i', strtotime($event->start_date_time)) : '' }}"
                                                                        placeholder="Enter Start Date Time" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>End Date Time</label>
                                                                    <input type="datetime-local" class="form-control"
                                                                        name="end_date_time"
                                                                        value="{{ $event->end_date_time ? date('Y-m-d\TH:i', strtotime($event->end_date_time)) : '' }}"
                                                                        placeholder="Enter End Date Time" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>Offer By(Company Name)</label>
                                                                    <input type="text" class="form-control"
                                                                        name="company_name"
                                                                        value="{{ $event->company_name }}"
                                                                        placeholder="Enter Company Name" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform uploadformbox">
                                                                    <label>Company Logo</label>
                                                                    <input type="text" class="form-control"
                                                                        disabled="" placeholder="(JPG, png only)">
                                                                    <div class="upload-btn-wrapper up-loposition">
                                                                        <button class="uploadBtn">Upload</button>
                                                                        <input type="file" accept="image/*" name="company_logo"
                                                                            onchange="renderImage(this,'preview_company_logo')">
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-2">
                                                                    <div class="col-4">
                                                                        <div class="uploaded-doc">
                                                                            <img src="{{ $event->company_logo ?: '/assets/admin/images/logo.png' }}"
                                                                                id="preview_company_logo">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group innerappform">
                                                                    <label>About the company</label>
                                                                    <textarea class="form-control h-100" name="about_the_company" placeholder="About the company">{{ $event->about_the_company }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group innerappform uploadformbox">
                                                                    <label>Sponsers</label>
                                                                    <input type="text" class="form-control"
                                                                        disabled="" placeholder="(JPG, Png only)">
                                                                    <div class="upload-btn-wrapper up-loposition">
                                                                        <button class="uploadBtn">Upload</button>
                                                                        <input type="file" accept="image/*" name="sponsers[]" multiple
                                                                            id="sponser">
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-2" id="appendSponsers">
                                                                    {{-- append sponsers --}}
                                                                    @if ($event && $event->sponsers && count($event->sponsers) > 0)
                                                                        @foreach ($event->sponsers as $sponser)
                                                                            <div class="col-md-3">
                                                                                <img src="{{ $sponser->full_url ? $sponser->full_url : '/assets/admin/img/collect-big.jpg' }}"
                                                                                    class="border w-100"
                                                                                    style="width:60px;height:80px;">
                                                                                <a href="#" class="delImageNew mr-1"
                                                                                    data-url="/delete-media/{{ isset($sponser->id) ? $sponser->id : '' }}"
                                                                                    data-request="remove"
                                                                                    data-redirect="/event/{{ $event->id }}/edit">
                                                                                    <img src="/assets/frontend/img/closered.svg"
                                                                                        width="25" />
                                                                                </a>
                                                                            </div>
                                                                        @endforeach
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform uploadformbox">
                                                                    <label>Thumbnail Image</label>git
                                                                    <input type="text" class="form-control"
                                                                        disabled="" placeholder="(JPG, Png only)">
                                                                    <div class="upload-btn-wrapper up-loposition">
                                                                        <button class="uploadBtn">Upload</button>
                                                                        <input type="file" accept="image/*" name="thumbnail_image"
                                                                            onchange="renderImage(this,'preview_thumbnail_image')">
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-2">
                                                                    <div class="col-4">
                                                                        <div class="uploaded-doc">
                                                                            <img src="{{ $event->thumbnail_image ?: '/assets/admin/images/logo.png' }}"
                                                                                id="preview_thumbnail_image">
                                                                        </div>
                                                                        <a href="#" class="delImageNew mr-1" data-request="remove">
                                                                            <img src="/assets/frontend/img/closered.svg"
                                                                                width="25" />
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform uploadformbox">
                                                                    <label>Banners</label>
                                                                    <input type="text" class="form-control"
                                                                        disabled="" placeholder="(JPG, Png only)">
                                                                    <div class="upload-btn-wrapper up-loposition">
                                                                        <button class="uploadBtn">Upload</button>
                                                                        <input type="file" accept="image/*" name="banners[]" multiple
                                                                            id="banner">
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-2" id="appendBanners">
                                                                    {{-- append banners --}}
                                                                    @if ($event && $event->banners && count($event->banners) > 0)
                                                                        @foreach ($event->banners as $banner)
                                                                            <div class="col-md-3">
                                                                                <img src="{{ $banner->full_url ? $banner->full_url : '/assets/admin/img/collect-big.jpg' }}"
                                                                                    class="border w-100"
                                                                                    style="width:60px;height:80px;">
                                                                                <a href="#" class="delImageNew mr-1"
                                                                                    data-url="/delete-media/{{ isset($banner->id) ? $banner->id : '' }}"
                                                                                    data-request="remove"
                                                                                    data-redirect="/event/{{ $event->id }}/edit">
                                                                                    <img src="/assets/frontend/img/closered.svg"
                                                                                        width="25" />
                                                                                </a>
                                                                            </div>
                                                                        @endforeach
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($event && $event->id)
                                        <div class="card formCard">
                                            <div class="card-header">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link collapsed" type="button"
                                                        data-toggle="collapse" data-target="#EquipmentDocuments">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="head-title form-head">
                                                                    <h2>Event Participation Customers</h2>
                                                                    <h5>Details</h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="EquipmentDocuments" class="collapse" data-parent="#addAccordian">
                                                <div class="card-body pt-2">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <table class="table datatbalennew">
                                                                <thead>
                                                                    <tr>
                                                                        <th>S.No</th>
                                                                        <th>Name</th>
                                                                        <th>Email</th>
                                                                        <th>Mobile</th>
                                                                        <th>Country</th>
                                                                        <th>Enroll. Date and Time</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @if (!empty($event->userMapping))
                                                                        @foreach ($event->userMapping as $key => $val)
                                                                            <tr>
                                                                                <td>
                                                                                    {{ $loop->iteration }}
                                                                                </td>
                                                                                <td>
                                                                                    <strong>
                                                                                        {{ @$val->user->name }}
                                                                                    </strong>
                                                                                </td>
                                                                                <td>
                                                                                    {{ @$val->user->email }}
                                                                                </td>
                                                                                <td>
                                                                                    {{ @$val->user->mobile }}
                                                                                </td>
                                                                                <td>
                                                                                    {{ @$val->user->country ? $val->user->country->name : '' }}
                                                                                </td>
                                                                                <td>
                                                                                    {{ $val->created_at ? date('Y-m-d H:i:s', strtotime($val->created_at)) : '' }}
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    @endif
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card dashcard rightapppanel">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h2>Status</h2>
                                                <h3>Select and update the status</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="activechkbox">
                                            <input class="filled-in" name="status" type="radio" id="active"
                                                value="active"
                                                {{ $event->status ? ($event->status == 'active' ? 'checked' : '') : 'checked' }}>
                                            <label for="active">ACTIVE</label>
                                        </div>
                                        @if ($event && $event->id)
                                            <div class="activechkbox">
                                                <input class="filled-in" name="status" type="radio" id="inactive"
                                                    value="inactive" {{ $event->status == 'inactive' ? 'checked' : '' }}>
                                                <label for="inactive">INACTIVE</label>
                                            </div>
                                            {{-- <div class="activechkbox mb-0">
                                                <input class="filled-in" name="status" type="radio" id="blacklist"
                                                    value="blacklist"
                                                    {{ $event->status == 'blacklist' ? 'checked' : '' }}>
                                                <label for="black">BLACKLIST</label>
                                            </div> --}}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('style')
    <link rel="stylesheet" href="/assets/frontend/ckeditor/samples/toolbarconfigurator/lib/codemirror/neo.css">
@endsection

@section('scripts')
    @parent
    <script src="/assets/frontend/ckeditor/ckeditor.js"></script>
    <script src="/assets/frontend/ckeditor/samples/js/sample.js"></script>
    <script type="text/javascript">
        CKEDITOR.replace('highlights');
        CKEDITOR.add
    </script>
    <script>
        initSample();
    </script>
    <script>
        var lengthFIle = 0;
        var maxAllowedImages = 4;
        $("#banner").on("change", function(e) {
            var files = e.target.files,
                filesLength = files.length;
            lengthFIle++;
            if (filesLength > maxAllowedImages || lengthFIle > maxAllowedImages) {
                Swal.fire(
                    'Warning!',
                    'You can upload maximum ' + maxAllowedImages + ' banners',
                    'warning'
                );
                return false;
            }else {
                for (var i = 0; i < filesLength; i++) {
                    var f = files[i]
                    var fileReader = new FileReader();

                    fileReader.onload = (function(e) {
                        var file = e.target;
                        let append = '<div class="col-md-3">' +
                            '<img src="' + e.target.result +
                            '" class="border w-100"  style="width:60px;height:80px;">' +
                            '<a data-request="remove-image" href="#" class="delImageNew mr-1"><img src="/assets/frontend/img/closered.svg" width="25" /></a>' +
                            '</div>';
                        $('#appendBanners').append(append);
                    });
                    fileReader.readAsDataURL(f);
                }
            }
        });

        $("#sponser").on("change", function(e) {
            var files = e.target.files,
                filesLength = files.length;
            lengthFIle++;
            if (filesLength > 10 || lengthFIle > 10) {
                Swal.fire(
                    'Warning!',
                    'You can upload maximum 10 sponsers',
                    'warning'
                );
                return false;
            } else {
                for (var i = 0; i < filesLength; i++) {
                    var f = files[i]
                    var fileReader = new FileReader();

                    fileReader.onload = (function(e) {
                        var file = e.target;
                        let append = '<div class="col-md-2">' +
                            '<img src="' + e.target.result +
                            '" class="border w-100"  style="width:60px;height:80px;">' +
                            '<a data-request="remove-image" href="#" class="delImageNew mr-1"><img src="/assets/frontend/img/closered.svg" width="25" /></a>' +
                            '</div>';
                        $('#appendSponsers').append(append);
                    });
                    fileReader.readAsDataURL(f);
                }
            }
        });

        $(document).on('click', '[data-request="remove-image"]', function() {
            var $this = $(this);
            $this.closest('div').remove();
        });

        $(document).on('click', '[data-request="ajax-submit"]', function() {
            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }
        });
    </script>
@endsection
