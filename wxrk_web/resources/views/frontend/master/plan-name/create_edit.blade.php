@extends('frontend.app')

{{-- Web site Title --}}
@section('title') :: @parent @stop

@section('content')

    @include('frontend.partials.nav', [
        'title' => 'Plan-Name',
        'description' => 'Add/Edit',
    ])

    <section class="content mb-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row align-items-center position-top-sticky">
                        <div class="col-sm-5 d-none d-sm-block">
                            <a href="/plan-name" class="btn btn-outline-secondary">Go Back</a>
                        </div>
                        <div class="col-sm-7 text-sm-right">
                            <button type="button" data-request="ajax-submit" data-target="[role=post-data]" id="save"
                                class="btn btn-success mr-2">
                                @if($record && $record->id)
                                    Update
                                @else
                                    Submit
                                @endif
                            </button>
                            <a href="/plan-name" class="btn btn-danger">Cancel</a>
                        </div>
                    </div>
                    <div class="dashbed-border-bottom mt-2 mb-3"></div>
                    <form method="post" action="{{ $action }}" redirect="/plan-name" role="post-data"
                        enctype="multipart/form-data">
                        @if($record && $record->id)
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
                                                                <h2>Plan-Name</h2>
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
                                                                    <label>Plan Type</label>
                                                                    <select class="form-control" name="plan_type_id">
                                                                        <option value="">Please select</option>
                                                                        @foreach ($planTypes as $planType)
                                                                            <option value="{{ $planType->id }}"
                                                                                {{ $planType->id == $record->plan_type_id ? 'selected' : '' }}>
                                                                                {{ $planType->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>Name</label>
                                                                    <input type="text" class="form-control" name="name" value="{{ $record->name }}"
                                                                        placeholder="Enter Name" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>Max Images Allowed</label>
                                                                    <input type="text" class="form-control" name="max_images_allowed" value="{{ $record->max_images_allowed }}"
                                                                        placeholder="Enter Max Images Allowed" />
                                                                </div>
                                                            </div>
                                                            {{-- <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>Max Videos Allowed</label>
                                                                    <input type="text" class="form-control" name="max_videos_allowed" value="{{ $record->max_videos_allowed }}"
                                                                        placeholder="Enter Max Videos Allowed " />
                                                                </div>
                                                            </div> --}}
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
                                            {{ $record->status ? ($record->status == 'active' ? 'checked' : '') : 'checked' }}>
                                            <label for="active">ACTIVE</label>
                                        </div>
                                        @if($record && $record->id)
                                        <div class="activechkbox">
                                            <input class="filled-in" name="status" type="radio" id="inactive" value="inactive"
                                            {{ $record->status == 'inactive' ? 'checked' : '' }}>
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

@endsection
