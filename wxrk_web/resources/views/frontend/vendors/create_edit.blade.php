@extends('frontend.app')

{{-- Web site Title --}}
@section('title') :: @parent @stop


@section('content')

    @include('frontend.partials.nav', [
        'title' => 'Vendor',
        'description' => 'Add',
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

                    <form method="post" action="{{ $action }}" redirect="@if($user->hasRole('admin')) /vendors @endif" role="post-data"
                        enctype="multipart/form-data">
                        @if ($vendor && $vendor->id)
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
                                                        <div class="form-group innerappform">
                                                            <label>Company name</label>
                                                            <input type="text" class="form-control" name="company_name"
                                                                value="{{ $vendor->company_name }}"
                                                                placeholder="Enter Company name" />
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>Email ID</label>
                                                                    <input type="text" class="form-control"
                                                                        name="email" value="{{ $vendor->email }}"
                                                                        placeholder="Enter Email ID" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>Mobile No</label>
                                                                    <input type="text" class="form-control"
                                                                        name="mobile" value="{{ $vendor->mobile }}"
                                                                        placeholder="Enter Mobile No" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>Company Website</label>
                                                                    <input type="text" class="form-control"
                                                                        name="company_website"
                                                                        value="{{ $vendor->company_website }}"
                                                                        placeholder="Enter Company Website" />
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
                                                                    <label>Business Category</label>
                                                                    <select class="form-control"
                                                                        name="business_category_id">
                                                                        <option value="">Select</option>
                                                                        @foreach ($businessCategories as $category)
                                                                            <option value="{{ $category->id }}"
                                                                                @if ($category->id == $vendor->business_category_id) selected @endif>
                                                                                {{ $category->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>Country</label>
                                                                    <select class="form-control" name="country_id">
                                                                        <option value="">Select</option>
                                                                        @foreach ($countries as $country)
                                                                            <option value="{{ $country->id }}"
                                                                                @if ($country->id == @$vendor->address->country_id) selected @endif>
                                                                                {{ $country->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>State</label>
                                                                    <select class="form-control" name="state_id">
                                                                        <option value="">Select</option>
                                                                        <option value="{{ @$vendor->address->state_id }}" selected>
                                                                            {{ @$vendor->address->state ? @$vendor->address->state->name : '' }}
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>City</label>
                                                                    <select class="form-control" name="city_id">
                                                                        <option value="">Select</option>
                                                                        <option value="{{ @$vendor->address->city_id }}" selected>
                                                                            {{ @$vendor->address->city ? @$vendor->address->city->name : '' }}
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>Zip Code</label>
                                                                    <input type="text" class="form-control"
                                                                        name="postal_code"
                                                                        value="{{ @$vendor->address->postal_code }}"
                                                                        placeholder="Enter Zip Code" />
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <div class="form-group innerappform">
                                                                    <label>Address</label>
                                                                    <input type="text" class="form-control"
                                                                        name="address"
                                                                        value="{{ @$vendor->address->landmark }}"
                                                                        placeholder="Enter Address" />
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform uploadformbox">
                                                                    <label>Company Logo</label>
                                                                    <input type="text" class="form-control"
                                                                        disabled=""
                                                                        placeholder="(JPG, JPEG, PNG only)">
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

                            @if ($vendor && $vendor->id)
                                <div class="col-md-4">
                                    <div class="card dashcard">
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
                                                    {{ $vendor->status ? ($vendor->status == 'active' ? 'checked' : '') : 'checked' }}>
                                                <label for="active">ACTIVE</label>
                                            </div>
                                            @if ($user->hasRole('admin'))
                                                <div class="activechkbox">
                                                    <input class="filled-in" name="status" type="radio"
                                                        id="inactive" value="inactive"
                                                        {{ $vendor->status == 'inactive' ? 'checked' : '' }}>
                                                    <label for="inactive">INACTIVE</label>
                                                </div>
                                                {{-- <div class="activechkbox mb-0">
                                                    <input class="filled-in" name="status" type="radio"
                                                        id="pending" value="pending"
                                                        {{ $vendor->status == 'pending' ? 'checked' : '' }}>
                                                    <label for="pending">Pending</label>
                                                </div> --}}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
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
                async: false,
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

@endsection
