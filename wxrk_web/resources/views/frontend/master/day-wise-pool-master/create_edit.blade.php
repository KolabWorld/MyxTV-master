@extends('frontend.app')

{{-- Web site Title --}}
@section('title') :: @parent @stop

@section('content')

    @include('frontend.partials.nav', [
        'title' => 'Day Wise Pool Master',
        'description' => 'Add/Edit',
    ])

    <section class="content mb-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row align-items-center position-top-sticky">
                        <div class="col-sm-5 d-none d-sm-block">
                            <a href="/day-wise-pool-master" class="btn btn-outline-secondary">Go Back</a>
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
                            <a href="/day-wise-pool-master" class="btn btn-danger">Cancel</a>
                        </div>
                    </div>
                    <div class="dashbed-border-bottom mt-2 mb-3"></div>
                    <form method="post" action="{{ $action }}" role="post-data" redirect="/day-wise-pool-master"
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
                                                                <h2>Day Wise Pool Master</h2>
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
                                                                    <label>Pool Date</label>
                                                                    <input type="date" class="form-control" name="pool_date" value="{{ $record->pool_date }}"
                                                                        placeholder="Enter Pool Date" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>$MyX Pool Balance</label>
                                                                    <input type="text" class="form-control" name="pool_balance" value="{{ $record->pool_balance }}"
                                                                        placeholder="Enter $MyX Pool Balance" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>Daily Limit</label>
                                                                    <input type="text" class="form-control" name="daily_limit" value="{{ $record->daily_limit }}"
                                                                        placeholder="Enter Daily Limit" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>Total User</label>
                                                                    <input type="text" class="form-control" name="total_user" value="{{ $record->total_user }}"
                                                                        placeholder="Enter Total User" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>$MyX Distribution Limit</label>
                                                                    <input type="text" class="form-control" name="wxrk_dist_limit" value="{{ $record->wxrk_dist_limit }}"
                                                                        placeholder="Enter $MyX Distribution Limit" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>$MyX per User per Day</label>
                                                                    <input type="text" class="form-control" name="wxrk_per_user_per_day" value="{{ $record->wxrk_per_user_per_day }}"
                                                                        placeholder="Enter $MyX per User per Day" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>$MyX per Minute</label>
                                                                    <input type="text" class="form-control" name="wxrk_per_min" value="{{ $record->wxrk_per_min }}"
                                                                        placeholder="Enter $MyX per Minute" />
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
                                            {{ $record->status ? ($record->status == 'active' ? 'checked' : '') : 'checked' }}>
                                            <label for="active">ACTIVE</label>
                                        </div>
                                        {{-- @if($record && $record->id)
                                        <div class="activechkbox">
                                            <input class="filled-in" name="status" type="radio" id="inactive" value="inactive"
                                            {{ $record->status == 'inactive' ? 'checked' : '' }}>
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
