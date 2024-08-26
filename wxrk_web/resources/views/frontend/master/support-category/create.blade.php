@extends('frontend.app')

{{-- Web site Title --}}
@section('title') :: @parent @stop


@section('content')

    @include('frontend.partials.nav', [
        'title' => 'Support Category',
        'description' => 'Add',
    ])

    <section class="content mb-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row align-items-center position-top-sticky">
                        <div class="col-sm-5 d-none d-sm-block">
                            <a href="/support-categories" class="btn btn-outline-secondary">Go Back</a>
                        </div>
                        <div class="col-sm-7 text-sm-right">
                            <button type="button" data-request="ajax-submit" data-target="[role=post-data]" id="save"
                                class="btn btn-success mr-2">
                                @if($supportCategory && $supportCategory->id)
                                Update
                                @else
                                Submit
                                @endif
                            </button>
                            <a href="/support-categories" class="btn btn-danger">Cancel</a>
                        </div>
                    </div>
                    <div class="dashbed-border-bottom mt-2 mb-3"></div>
                    <form method="post" action="{{ $action }}" redirect="/support-categories" role="post-data"
                        enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card formCard">
                                    <div class="card-body">
                                        <div class="head-title form-head mb-4">
                                            <h2>Support</h2>
                                            <h5>Category</h5>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group innerappform">
                                                            <label>Name</label>
                                                            <input type="text" name="name"
                                                                value="{{ old('name', $supportCategory->name) }}"
                                                                class="form-control" placeholder="Enter Category" />
                                                        </div>
                                                        @error('name')
                                                            <label class="label">
                                                                <strong class="text-danger"> {{ $message }}</strong>
                                                            </label>
                                                        @enderror
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
                                                {{ !(isset($supportCategory) && $supportCategory->id)
                                                    ? 'checked'
                                                    : (old('name', $supportCategory->status == 'active')
                                                        ? 'checked'
                                                        : '') }}>
                                            <label for="active">ACTIVE</label>
                                        </div>
                                        <div class="activechkbox mb-0">
                                            <input class="filled-in" name="status" type="radio" id="inactive"
                                                value="inactive"
                                                {{ old('name', $supportCategory->status == 'inactive') ? 'checked' : '' }}>
                                            <label for="inactive">INACTIVE</label>
                                        </div>
                                    </div>
                                    @error('status')
                                        <label class="label">
                                            <strong class="text-danger"> {{ $message }}</strong>
                                        </label>
                                    @enderror
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
