@extends('frontend.app')

{{-- Web site Title --}}
@section('title') :: @parent @stop


@section('content')

    @include('frontend.partials.nav', [
        'title' => 'Profile',
        'description' => 'Edit',
    ])

    <section class="content mb-3">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="row align-items-center position-top-sticky">
                        <div class="col-sm-5 d-none d-sm-block">
                            <a href="/vendors" class="btn btn-outline-secondary">Go Back</a>
                        </div>
                        <div class="col-sm-7 text-sm-right">
                            <button type="button" data-request="ajax-submit" data-target="[role=post-data]" id="save"
                                class="btn btn-success mr-2">
                                @if ($vendor && $vendor->id)
                                    Update
                                @else
                                    Submit
                                @endif
                            </button>
                            <a href="/vendors" class="btn btn-danger">Cancel</a>
                        </div>
                    </div>

                    <div class="dashbed-border-bottom mt-2 mb-3"></div>

                    <form method="post" action="{{ $action }}" redirect="" role="post-data"
                        enctype="multipart/form-data">
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
                                                                <h2>Profile Details</h2>
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
                                                    <div class="col-md-10">
                                                        <input type="hidden" name="id" value="{{ $vendor->id }}">

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>Email ID</label>
                                                                    <input type="text" class="form-control"
                                                                        name="email" value="{{ $vendor->email }}"
                                                                        placeholder="Enter Email ID"  readonly/>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>Mobile No</label>
                                                                    <input type="text" class="form-control"
                                                                        name="mobile" value="{{ $vendor->mobile }}"
                                                                        placeholder="Enter Mobile No" readonly/>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>Alternate Contact No</label>
                                                                    <input type="text" class="form-control"
                                                                        name="alternate_contact_number"
                                                                        value="{{ $vendor->alternate_contact_number }}"
                                                                        placeholder="Enter Alternate Contact No" />
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>Alternate Email ID</label>
                                                                    <input type="text" class="form-control"
                                                                        name="alternate_email"
                                                                        value="{{ $vendor->alternate_email }}"
                                                                        placeholder="Enter Alternate Email ID" />
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>Contact person name</label>
                                                                    <input type="text" class="form-control"
                                                                        name="contact_person_name"
                                                                        value="{{ $vendor->contact_person_name }}"
                                                                        placeholder="Enter Contact person name" />
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform uploadformbox">
                                                                    <label>Company Logo</label>
                                                                    <input type="text" class="form-control"
                                                                        disabled="" placeholder="(JPG, JPEG, PNG only)">
                                                                    <div class="upload-btn-wrapper up-loposition">
                                                                        <button class="uploadBtn">Upload</button>
                                                                        <input type="file" name="logo"
                                                                            onchange="renderImage(this,'preview_logo')">
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-2">
                                                                    <div class="col-4">
                                                                        <div class="uploaded-doc">
                                                                            <img src="{{ $vendor->logo ?: '/assets/admin/images/logo.png' }}"
                                                                                id="preview_logo">
                                                                            {{--  <a href="#"><img src="/assets/admin/images/close.svg"></a>  --}}
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
                                </div>
                            </div>

                            <div class="col-md-4">

                                <div class="card dashcard">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h2>Change Password</h2>
                                                <h3>Change your password here</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group innerappform">
                                                    <label>New Password</label>
                                                    <input type="password" class="form-control" name="new_password"
                                                    id="materialLoginFormInputPassword"  value="" placeholder="Enter New Password" />
                                                        <a href="#" id="materialLoginFormShowPassword"
                                                        onclick="showPassword('materialLoginForm')">
                                                        <i class="fas fa-eye showeye"></i>
                                                    </a>
                                                    <a href="#" id="materialLoginFormHidePassword"
                                                        onclick="hidePassword('materialLoginForm')" style="display : none;">
                                                        <i class="fas fa-eye-slash showeye"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group innerappform">
                                                    <label>Confirm Password</label>
                                                    <input type="password" class="form-control" name="confirm_password"
                                                        value="" placeholder="Enter New Password Again" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if ($vendor && $vendor->id && $vendor->hasRole('vendor'))
                                    @php
                                        $currentPlan = $vendor->subscriptionPlan;
                                        $currentAdminPlan = $vendor->adminSubscriptionPlan;
                                    @endphp
                                    <div class="card dashcard">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <h2>Current Plan</h2>
                                                    <h3>Your current plan details</h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <h6>
                                                            <strong>Plan Type : </strong>
                                                            {{ $currentPlan->plan_type }}
                                                        </h6>
                                                    </div>
                                                    <div class="form-group">
                                                        <h6>
                                                            <strong>Plan Name : </strong>
                                                            {{ $currentPlan->name }}
                                                        </h6>
                                                    </div>
                                                    <div class="form-group">
                                                        <h6>
                                                            <strong>Allowed Offers in a Month : </strong>
                                                            {{ $currentPlan->offers_in_a_month }}
                                                        </h6>
                                                    </div>
                                                    <div class="form-group">
                                                        <h6>
                                                            <strong>Premium days in a Month : </strong>
                                                            {{ $currentPlan->premium_days }}
                                                        </h6>
                                                    </div>
                                                    <div class="form-group">
                                                        <h6>
                                                            <strong>Plan expires at : </strong>
                                                            {{ $currentAdminPlan->plan_expires_at }}
                                                        </h6>
                                                    </div>
                                                    <div class="form-group mt-4">
                                                        <a href="/subscription-plan-upgrade"
                                                            class="btn btn-primary w-100">Upgrade Your Plan</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
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

    <script>
        $('select[name=country_id]').change(function() {
            getStates(this.value, '');
        });

        $('select[name=state_id]').change(function() {
            getCities(this.value, '');
        });

        $(document).ready(function() {
            @if (@$vendor->address->state_id && @$vendor->address->country_id)
                getStates({{ @$vendor->address->country_id }}, {{ @$vendor->address->state_id }});
            @endif

            @if (@$vendor->address->state_id && @$vendor->address->city_id)
                getCities({{ @$vendor->address->state_id }}, {{ @$vendor->address->city_id }});
            @endif
        });

        function getCities(state_id, cityId) {
            data = {
                'state_id': state_id,
                '_token': '{{ csrf_token() }}'
            }
            $.ajax({
                url: '/ajax/cities',
                type: 'POST',
                data: data,
                success: function(data) {
                    var selectbox = '';
                    if (data) {
                        selectbox += '<option value="">Select</option>';
                        $.each(data, function(i, item) {
                            var selected = '';
                            if (cityId != '' && cityId == i) {
                                selected = 'selected';
                            }
                            selectbox += '<option value="' + i + '" ' + selected + '>' + item +
                                '</option>';
                        });

                    }
                    $('select[name=city_id]').html(selectbox);
                }
            });
        }

        function getStates(country_id, stateId) {
            data = {
                'country_id': country_id,
                '_token': '{{ csrf_token() }}'
            }
            $.ajax({
                url: '/ajax/states',
                type: 'POST',
                data: data,
                success: function(data) {
                    var selectbox = '';
                    if (data) {
                        selectbox += '<option value="">Select</option>';
                        $.each(data, function(i, item) {
                            var selected = '';
                            if (stateId != '' && stateId == i) {
                                selected = 'selected';
                            }
                            selectbox += '<option value="' + i + '" ' + selected + '>' + item +
                                '</option>';
                        });

                    }
                    $('select[name=state_id]').html(selectbox);
                    $('select[name=city_id]').html('<option value="">Select</option>');
                }
            });
        }
    </script>
    <script>
        function showPassword(tabModule) {
            $('#' + tabModule + 'InputPassword').attr('type', 'text');
            $('#' + tabModule + 'ShowPassword').hide();
            $('#' + tabModule + 'HidePassword').show();
        }

        function hidePassword(tabModule) {
            $('#' + tabModule + 'InputPassword').attr('type', 'password');
            $('#' + tabModule + 'ShowPassword').show();
            $('#' + tabModule + 'HidePassword').hide();
        }
    </script>

@endsection
