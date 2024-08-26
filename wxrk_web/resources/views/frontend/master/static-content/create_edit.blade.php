@extends('frontend.app')

{{-- Web site Title --}}
@section('title') :: @parent @stop

@section('content')

    @include('frontend.partials.nav', [
        'title' => 'Static Content',
        'description' => 'Add/Edit',
    ])

    <section class="content mb-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row align-items-center position-top-sticky">
                        <div class="col-sm-5 d-none d-sm-block">
                            <a href="/static-contents" class="btn btn-outline-secondary">Go Back</a>
                        </div>
                        <div class="col-sm-7 text-sm-right">
                            <button type="button" data-request="ajax-submit" data-target="[role=post-data]" id="save"
                                class="btn btn-success mr-2">
                                @if($static && $static->id)
                                    Update
                                @else
                                    Submit
                                @endif
                            </button>
                            <a href="/static-contents" class="btn btn-danger">Cancel</a>
                        </div>
                    </div>
                    <div class="dashbed-border-bottom mt-2 mb-3"></div>
                    <form method="post" action="{{ $action }}" redirect="/static-contents" role="post-data"
                        enctype="multipart/form-data">
                        @if($static && $static->id)
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
                                                                <h2>Static Content</h2>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </button>
                                            </h5>
                                        </div>

                                        <div id="Equipment" class="collapse show" data-parent="#addAccordian">
                                            <div class="card-body pt-2">
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>Name</label>
                                                                    <input type="text" class="form-control" name="name" value="{{ $static->name }}"
                                                                        placeholder="Enter Name" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>
                                                                        Page Type <span style="color:red;">*</span>
                                                                    </label>
                                                                    <select class="form-control" id="page_type" name="page_type" required="">
                                                                        <option value="">Please select</option>
                                                                        @foreach ($pageTypes as $pageType)
                                                                            <option value="{{$pageType}}" {{ ($pageType == @$static->page_type) ? 'selected':'' }}>
                                                                                {{ ucfirst($pageType) }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <div class="form-group innerappform textarea-group">
                                                                    <label for="exampleFormControlTextarea1">
                                                                          Description
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12" style="margin-top:3%;">
                                                                <div class="form-group innerappform textarea-group">
                                                                    <textarea class="form-control" name="description"
                                                                        id="exampleFormControlTextarea1" placeholder="Enter the long description here"
                                                                        rows="3">{{ $static->description ?: old('description') }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                                            <input class="filled-in" name="status" type="radio" id="active" value="active"
                                            {{ $static->status ? ($static->status == 'active' ? 'checked' : '') : 'checked' }}>
                                            <label for="active">ACTIVE</label>
                                        </div>
                                        @if($static && $static->id)
                                        <div class="activechkbox">
                                            <input class="filled-in" name="status" type="radio" id="inactive" value="inactive"
                                            {{ $static->status == 'inactive' ? 'checked' : '' }}>
                                            <label for="inactive">INACTIVE</label>
                                        </div>
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

@section('scripts')
    @parent
    <script src="/assets/admin/ckeditor/ckeditor.js"></script>
    <script src="/assets/admin/ckeditor/samples/js/sample.js"></script>
    <script type="text/javascript"> 
        CKEDITOR.replace( 'description' );
        CKEDITOR.add            
    </script>
    <script type="text/javascript">
        $('#save').on('click', function (e) {
            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }
            $('#final_submit').click();
        });

    </script>
@endsection
