<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>MyxTV</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="/assets/admin/images/favicon.png">

    <link rel="stylesheet" href="/assets/admin/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/admin/css/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
    <link href="/assets/admin/css/material.css" rel="stylesheet">
    <link href="/assets/admin/css/style.css" rel="stylesheet">
    <link href="/assets/admin/css/responsive.css" rel="stylesheet">
</head>

<body class="">
    <div class="wrapper">
        <div class="container mt-4 mt-md-5">
            <div class="row justify-content-center">
                <div class="col-md-12 text-center">
                    <img src="/assets/admin/images/logo.png" class="login-logo" alt="" />
                </div>
                <div class="col-md-12">
                    <div class="login-bg">
                        <div class="row">
                            <div class="col-md-12">
                                <form method="post" action="/vendor/registration/{{$subscriptionPlan->id}}/subscription-plan" redirect="/login" role="post-data"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="subscription_plan_id" value="{{$subscriptionPlan->id}}" />
                                    <div class="card formCard">
                                        <div class="card-header">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link" type="button" data-toggle="collapse"
                                                    data-target="#Equipment">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="head-title form-head">
                                                                <h2>Vendor Registration</h2>
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
                                                        <div class="form-group innerappform">
                                                            <label>Company name</label>
                                                            <input type="text" class="form-control" name="company_name" value=""
                                                                placeholder="Enter Company name" />
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>Email ID</label>
                                                                    <input type="text" class="form-control" name="email" value=""
                                                                        placeholder="Enter Email ID" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>Mobile No</label>
                                                                    <input type="text" class="form-control" name="mobile" value=""
                                                                        placeholder="Enter Mobile No" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>Company Website</label>
                                                                    <input type="text" class="form-control" name="company_website" value=""
                                                                        placeholder="Enter Company Website" />
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>Contact person name</label>
                                                                    <input type="text" class="form-control" name="contact_person_name" value=""
                                                                        placeholder="Enter Contact person name" />
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>Alternate Contact No</label>
                                                                    <input type="text" class="form-control" name="alternate_contact_number" value=""
                                                                        placeholder="Enter Alternate Contact No" />
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>Alternate Email ID</label>
                                                                    <input type="text" class="form-control" name="alternate_email" value=""
                                                                        placeholder="Enter Alternate Email ID" />
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>Business Category</label>
                                                                    <select class="form-control" name="business_category_id">
                                                                        <option value="">Select</option>
                                                                        @foreach ($businessCategories as $category)
                                                                            <option value="{{ $category->id }}">
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
                                                                            <option value="{{ $country->id }}">
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
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>City</label>
                                                                    <select class="form-control" name="city_id">
                                                                        <option value="">Select</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>Zip Code</label>
                                                                    <input type="text" class="form-control" name="postal_code" value=""
                                                                        placeholder="Enter Zip Code" />
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <div class="form-group innerappform">
                                                                    <label>Address</label>
                                                                    <input type="text" class="form-control" name="address" value=""
                                                                        placeholder="Enter Address" />
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform uploadformbox">
                                                                    <label>Company Logo</label>
                                                                    <input type="text" class="form-control"
                                                                        disabled="" placeholder="(JPG, JPEG, PNG only)">
                                                                    <div class="upload-btn-wrapper up-loposition">
                                                                        <button class="uploadBtn">Upload</button>
                                                                        <input type="file" name="logo" onchange="renderImage(this,'preview_logo')">
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-2">
                                                                    <div class="col-4">
                                                                        <div class="uploaded-doc">
                                                                            <img src="/assets/admin/images/logo.png" id="preview_logo">
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
                                    <div class="row justify-content-center">
                                        <div class="col-md-4">
                                            <button type="button" data-request="ajax-submit" data-target="[role=post-data]" id="save" class="btn login-btn btn-block btn-primary">
                                                Register
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            {{-- <div class="col-md-7 d-none d-md-block">
                                <img alt="" src="/assets/admin/images/login-img.png" class="login-img" />
                            </div> --}}
                        </div>
                    </div>
                </div>
                <div class="col-md-12 text-center login-foot">
                    <a href="#">Terms of Use</a> <a href="/privacy-policy">Privacy Policy</a>
                    <p>© Copyright 2023 MyxTV Media. All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- jQuery -->

    
    <script src="/assets/admin/js/jquery.min.js"></script>
    <script src="/assets/admin/js/jquery-ui.min.js"></script>
    <script src="/assets/admin/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/admin/css/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <script src="/assets/admin/js/main.js"></script>
    <script src="/js/custom-script.js"></script>
    <script src="/js/sweetalert.js"></script>
    <script>
        var app_url = "{{ config('app.api_url') }}";
        var base_url = "{{ config('app.url') }}";
        var bearer_token = 'Bearer <?= session('auth_access_token') ?>';

        $.ajaxSetup({
            headers: {
                'Access-Control-Allow-Origin': '*',
                'Authorization': bearer_token,
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('select[name=country_id]').change(function(){
            getStates(this.value,'');
        });
        
        $('select[name=state_id]').change(function(){
            getCities(this.value,'');
        });

        function getCities(state_id,cityId){
            data = {
                'state_id' : state_id,
                '_token' : '{{ csrf_token() }}'
            }
            $.ajax({
                url: '/ajax/cities' ,
                type: 'POST',
                data: data,
                success:function(data) {
                    var selectbox = '';
                    if(data)
                    {
                        selectbox += '<option value="">Select</option>';
                        $.each(data, function (i, item) {
                            var selected = '';
                            if(cityId != '' && cityId == i){
                                selected = 'selected';
                            }
                            selectbox += '<option value="'+i+'" '+selected+'>'+item+'</option>';
                        });
                        
                    }
                    $('select[name=city_id]').html(selectbox);
                }
            });
        }
        
        function getStates(country_id,stateId){
            data = {
                'country_id' : country_id,
                '_token' : '{{ csrf_token() }}'
            }
            $.ajax({
                url: '/ajax/states' ,
                type: 'POST',
                data: data,
                success:function(data) {
                    var selectbox = '';
                    if(data)
                    {
                        selectbox += '<option value="">Select</option>';
                        $.each(data, function (i, item) {
                            var selected = '';
                            if(stateId != '' && stateId == i){
                                selected = 'selected';
                            }
                            selectbox += '<option value="'+i+'" '+selected+'>'+item+'</option>';
                        });
                        
                    }
                    $('select[name=state_id]').html(selectbox);
                    $('select[name=city_id]').html('<option value="">Select</option>');
                }
            });
        }
    </script>
</body>

</html>
