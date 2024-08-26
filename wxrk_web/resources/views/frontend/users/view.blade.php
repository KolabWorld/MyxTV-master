@extends('frontend.app')

{{-- Web site Title --}}
@section('title') :: @parent @stop

@section('content')

    @include('frontend.partials.nav', [
        'title' => 'View Profile',
        'description' => 'View',
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
                            <button type="button" data-request="ajax-submit" data-target="[role=post-data]" id="save" class="btn btn-success mr-2">
                                Update
                            </button>
                            <a href="/users" class="btn btn-danger">Cancel</a>
                        </div>
                    </div>
                    <div class="dashbed-border-bottom mt-2 mb-3"></div>
                    <form action="/user/{{ $user->id }}/edit" method="POST" role="post-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card formCard">
                                    <div class="card-body">
                                        <div class="row justify-content-between">
                                            <div class="col-md-7">
                                                <div class="head-title form-head mb-4">
                                                    <h2>View user details</h2>
                                                    <h5>Logged in user details</h5>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group innerappform">
                                                            <label>Full name</label>
                                                            <input type="text" class="form-control"
                                                                value="{{ $user->name }}" placeholder="Enter Full Name"
                                                                disabled />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group innerappform">
                                                            <label>Date of Joining</label>
                                                            <input type="date" class="form-control"
                                                                value="{{ $user->created_at ? date('Y-m-d', strtotime($user->created_at)) : '' }}"
                                                                disabled />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group innerappform">
                                                            <label>Email address</label>
                                                            <input type="text" class="form-control"
                                                                value="{{ $user->email }}" placeholder="Enter Email address"
                                                                disabled />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group innerappform">
                                                            <label>Phone number</label>
                                                            <input type="text" class="form-control"
                                                                value="{{ $user->mobile }}" placeholder="Enter Phone No."
                                                                disabled />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group innerappform">
                                                            <label>Country</label>
                                                            <select class="form-control" name="country_id">
                                                                <option value="">Select</option>
                                                                @foreach ($countries as $country)
                                                                    <option value="{{ $country->id }}" {{ @$user->country_id == $country->id ? 'selected' : '' }}>
                                                                        {{ $country->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    {{-- <div class="col-md-6">
                                                        <div class="form-group innerappform">
                                                            <label>Date of Birth</label>
                                                            <input type="date" name="date_of_birth" class="form-control"
                                                                value="{{ $user->date_of_birth }}" />
                                                        </div>
                                                    </div> --}}
                                                    <div class="col-md-6">
                                                        <div class="form-group innerappform">
                                                            <label>Total Watch Time</label>
                                                            <input type="text" class="form-control" value="{{ @$user->wallet->watch_time }}"
                                                                disabled />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group innerappform">
                                                            <label>$CX Earned</label>
                                                            <input type="number" class="form-control" value="{{ @$user->wallet->wxrk_earned }}"
                                                                disabled />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group innerappform">
                                                            <label>$CX Spent</label>
                                                            <input type="number" class="form-control" value="{{ @$user->wallet->wxrk_spent }}"
                                                                disabled />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group innerappform">
                                                            <label>$CX Balance</label>
                                                            <input type="number" class="form-control" value="{{ @$user->wallet->wxrk_balance }}"
                                                                disabled />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="head-title form-head mb-4">
                                                    <h2>Profile image</h2>
                                                    <h5>Update your image</h5>
                                                </div>
                                                <div class="d-flex align-items-center">

                                                    <div class="profileuploadded">
                                                        <img src="{{ $user->profile_pic != 'false' ? $user->profile_pic : '/assets/admin/images/avtar.jpg' }}" id="profile_pic">
                                                        {{--  <span class="btncross">
                                                            <img src="/assets/admin/images/closeimg.svg" />
                                                        </span>  --}}
                                                    </div>
                                                    <div class="upload-btn-wrapper upload-popimg ">
                                                        <button class="uploadBtn">
                                                            <p class="f-14 fw-bold text-theme mb-0">Upload profile image</p>
                                                            <p class="fw-medium f-12 text-darkgrey mb-0">Tap to browse</p>
                                                        </button>
                                                        <input type="file" name="profile_pic" onchange="renderImage(this,'profile_pic')" accept="image/jpeg,image/png">
                                                    </div>
                                                </div>
                                                <div class="head-title form-head my-4">
                                                    <h2>Status</h2>
                                                    <h5>Select and update the status</h5>
                                                </div>
                                                <div class="">
                                                    <div class="activechkbox">
                                                        <input class="filled-in" name="status" type="radio" id="active" value="active"
                                                            {{ $user->status == 'active' ? 'checked' : '' }}>
                                                        <label for="active">ACTIVE</label>
                                                    </div>
                                                    <div class="activechkbox">
                                                        <input class="filled-in" name="status" type="radio" id="inactive" value="inactive"
                                                            {{ $user->status == 'inactive' ? 'checked' : '' }}>
                                                        <label for="inactive">INACTIVE</label>
                                                    </div>
                                                    <div class="activechkbox">
                                                        <input class="filled-in" name="status" type="radio"
                                                            id="blacklist" value="blacklist" {{ $user->status == 'blacklist' ? 'checked' : '' }}>
                                                        <label for="blacklist">BLACKLIST</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="accordion addformaccordian" id="addAccordian1">
                                <div class="card formCard">
                                    <div class="card-header">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link" type="button" data-toggle="collapse"
                                                data-target="#Equipment" aria-expanded="false">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="head-title form-head">
                                                            <h2>Day wise Collection</h2>
                                                            <h5>Details</h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </button>
                                        </h5>
                                    </div>
                                    <div id="Equipment" class="collapse show" data-parent="#addAccordian1"
                                        style="">
                                        <div class="card-body pt-0">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="table-responsive" style="max-height: 500px; overflow-y:scroll">
                                                        <table class="table datatbalennew">
                                                            <thead>
                                                                <tr>
                                                                    <th>S.NO</th>
                                                                    <th>Date</th>
                                                                    <th>Watch Time</th>
                                                                    <th>Earned</th>
                                                                    <th>Spent</th>
                                                                    <th>Balance</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($dayWiseCollection as $key => $val)
                                                                    <tr>
                                                                        <td>
                                                                            {{$loop->iteration}}
                                                                        </td>
                                                                        <td>
                                                                            <strong>
                                                                                {{date('d M Y', strtotime($val->created_at))}}
                                                                            </strong>
                                                                        </td>
                                                                        <td>
                                                                            {{$val->watch_time}}
                                                                        </td>
                                                                        <td>
                                                                            {{$val->type == 'earned' ? $val->wxrk_balance : '0.0'}}
                                                                        </td>
                                                                        <td>
                                                                            {{$val->type == 'spent' ? $val->wxrk_balance : '0.0'}}
                                                                        </td>
                                                                        <td>
                                                                            {{$val->wxrk_balance}}
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--  <div class="col-md-6">
                            <div class="accordion addformaccordian" id="addAccordian2">
                                <div class="card formCard">
                                    <div class="card-header">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link" type="button" data-toggle="collapse"
                                                data-target="#EquipmentDocuments2">
                                                <div class="head-title form-head">
                                                    <h2>Daily app Usage statistics [Android]</h2>
                                                    <h5>Details</h5>
                                                </div>
                                            </button>
                                        </h5>
                                    </div>
                                    <div id="EquipmentDocuments2" class="collapse show" data-parent="#addAccordian2">
                                        <div class="card-body pt-0">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="table-responsive" style="max-height: 500px; overflow-y:scroll">
                                                        <table class="table datatbalennew">
                                                            <thead>
                                                                <tr>
                                                                    <th>S.No</th>
                                                                    <th>Date</th>
                                                                    <th>App Name</th>
                                                                    <th>Usage Time</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($androidAppPerformace as $key => $val)
                                                                    <tr>
                                                                        <td>
                                                                            {{$loop->iteration}}
                                                                        </td>
                                                                        <td>
                                                                            <strong>
                                                                                {{date('d M Y', strtotime($val->created_at))}}
                                                                            </strong>
                                                                        </td>
                                                                        <td>
                                                                            {{$val->app_name}}
                                                                        </td>
                                                                        <td>
                                                                            {{$val->total_usage_time}} mins
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="accordion addformaccordian" id="addAccordian3">
                                <div class="card formCard">
                                    <div class="card-header">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link" type="button" data-toggle="collapse"
                                                data-target="#EquipmentDocuments3">
                                                <div class="head-title form-head">
                                                    <h2>Daily app Usage statistics [IOS]</h2>
                                                    <h5>Details</h5>
                                                </div>
                                            </button>
                                        </h5>
                                    </div>
                                    <div id="EquipmentDocuments3" class="collapse show" data-parent="#addAccordian3">
                                        <div class="card-body pt-0">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="table-responsive" style="max-height: 500px; overflow-y:scroll">
                                                        <table class="table datatbalennew">
                                                            <thead>
                                                                <tr>
                                                                    <th>S.No</th>
                                                                    <th>Date</th>
                                                                    <th>App Name</th>
                                                                    <th>Usage Time</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($ios_app_performace as $key => $val)
                                                                    <tr>
                                                                        <td>
                                                                            {{$loop->iteration}}
                                                                        </td>
                                                                        <td>
                                                                            <strong>
                                                                                {{date('d M Y', strtotime($val->created_at))}}
                                                                            </strong>
                                                                        </td>
                                                                        <td>
                                                                            {{$val->app_name}}
                                                                        </td>
                                                                        <td>
                                                                            {{$val->total_usage_time}} mins
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>  --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    @parent
    <script>
        $('#save').click(function(){
            
        })
    </script>
@endsection
