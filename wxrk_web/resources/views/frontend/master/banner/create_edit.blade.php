@extends('frontend.app')

{{-- Web site Title --}}
@section('title') :: @parent @stop


@section('content')

    @include('frontend.partials.nav', [
        'title' => 'Banner',
        'description' => 'Add',
    ])

    <section class="content mb-3">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="row align-items-center position-top-sticky">
                        <div class="col-5 d-none d-sm-block">
                            <a href="javascript:history.back()" class="btn btn-outline-secondary">Go Back</a>
                        </div>
                        <div class="col-7 text-sm-right">
                            <a href="equipment-master.html" class="btn btn-success mr-2">Publish</a>
                            <a href="equipment-master.html" class="btn btn-danger">Cancel</a>
                        </div>
                    </div>


                    <div class="dashbed-border-bottom mt-2 mb-3"></div>




                    <div class="row">
                        <div class="col-md-8">
                            <div class="card formCard">
                                <div class="card-body">
                                    <div class="head-title form-head mb-4">
                                        <h2>Add/Edit Banner</h2>
                                        <h5>Details</h5>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group innerappform">
                                                        <label>Banner Type</label>
                                                        <select class="form-control">
                                                            <option>Select</option>
                                                            <option>Category</option>
                                                            <option>Section</option>
                                                        </select>
                                                    </div>
                                                </div>


                                                <div class="col-md-6">
                                                    <div class="form-group innerappform">
                                                        <label>Banner Text</label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter Banner Text" />
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group innerappform">
                                                        <label>Banner Button Text</label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter Banner Button Text" />
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group innerappform">
                                                        <label>Banner Button link</label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter Banner web link" />
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group innerappform uploadformbox">
                                                        <label>Banner image</label>
                                                        <input type="text" class="form-control" disabled=""
                                                            placeholder="(JPG, Png, Gif only)">
                                                        <div class="upload-btn-wrapper up-loposition">
                                                            <button class="uploadBtn">Upload</button>
                                                            <input type="file">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-4">
                                                            <div class="uploaded-doc">
                                                                <img src="/assets/admin/images/logo.png">
                                                                <a href="#"><img src="/assets/admin/images/close.svg"></a>
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
                                        <input class="filled-in" name="group1" type="radio" id="active"
                                            checked="">
                                        <label for="active">ACTIVE</label>
                                    </div>
                                    <div class="activechkbox mb-0">
                                        <input class="filled-in" name="group1" type="radio" id="inactive">
                                        <label for="inactive">INACTIVE</label>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>




                </div>

            </div>


        </div>
    </section>

@endsection

@section('scripts')
    @parent

    </script>
@endsection
