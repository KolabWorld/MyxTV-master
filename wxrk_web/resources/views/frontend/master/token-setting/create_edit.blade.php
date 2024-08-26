@extends('frontend.app')

{{-- Web site Title --}}
@section('title') :: @parent @stop

@section('content')

    @include('frontend.partials.nav', [
        'title' => 'Token-Settings',
        'description' => 'Add/Edit',
    ])

    <section class="content mb-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row align-items-center position-top-sticky">
                        <div class="col-sm-5 d-none d-sm-block">
                            <a href="/token-settings" class="btn btn-outline-secondary">Go Back</a>
                        </div>
                        <div class="col-sm-7 text-sm-right">
                            <button type="button" data-request="ajax-submit" data-target="[role=post-data]" id="save"
                                class="btn btn-success mr-2">
                                @if($tokenSetting && $tokenSetting->id)
                                    Update
                                @else
                                    Submit
                                @endif
                            </button>
                                <a href="/token-settings" class="btn btn btn-danger">Cancel</a>
                        </div>
                        {{-- <div class="col-sm-7 text-sm-right">
                            <a href="/token-settings" class="btn btn btn-danger">Cancel</a>
                        </div> --}}
                    </div>
                    <div class="dashbed-border-bottom mt-2 mb-3"></div>
                    <form method="post" action="{{ $action }}" role="post-data"
                        enctype="multipart/form-data">
                        @csrf
                        @if($tokenSetting && $tokenSetting->id)
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
                                                                <h2>Token-Setting</h2>
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
                                                                    <input type="text" class="form-control" name="name" value="{{ $tokenSetting->name }}"
                                                                        placeholder="Enter Name " />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>Value</label>
                                                                    <input type="text" class="form-control" name="value" value="{{ $tokenSetting->value }}"
                                                                        placeholder="Enter Value"  />
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
                                            {{ $tokenSetting->status ? ($tokenSetting->status == 'active' ? 'checked' : '') : 'checked' }}>
                                            <label for="active">ACTIVE</label>
                                        </div>
                                        {{-- @if($tokenSetting && $tokenSetting->id)
                                        <div class="activechkbox">
                                            <input class="filled-in" name="status" type="radio" id="inactive" value="inactive"
                                            {{ $tokenSetting->status == 'inactive' ? 'checked' : '' }}>
                                            <label for="inactive">INACTIVE</label>
                                        </div>
                                        @endif --}}
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

@endsection
