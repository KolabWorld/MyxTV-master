<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>B2B Ecommerce | Seller Panel</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/assets/admin/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/admin/css/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link href="/assets/admin/css/font-awesome.css" rel="stylesheet">
    <link href="/assets/admin/css/font.css" rel="stylesheet">
    <link href="/assets/admin/css/style.css" rel="stylesheet">
    <link href="/assets/admin/css/responsive.css" rel="stylesheet">
    <!-- MDB -->
    <link href="/assets/admin/css/mdb.min.css" rel="stylesheet" />

</head>

<body class="">
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="login-box">
                        <div class="row">
                            <div class="col-sm-4 col-md-4 px-0">
                                <div class="loginImg">
                                    <img src="/assets/admin/img/women.jpg" class="d-none d-sm-block left-img"/>
                                </div>
                            </div>
                            <div class="col-sm-8 col-md-8">
                                <div class="loginPanel" style="padding: 80px 30px 30px 30px;">
                                    <div class="mb-1"><img src="/assets/frontend/img/logo/logo-black.png"></div>
                                    <div class="subTitle">Secure Seller Panel</div>
                                    @if ($message = Session::get('success'))
                                    <div class="alert alert-success alert-block mt-3">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @endif
                                    <div class="loginForm" style="margin-top: 50px">
                                        <!-- Form -->
                                        <form autocomplete="off" id="login-form" method="POST" action="{{ route('designer-signup') }}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <!-- Username -->
                                                    <div class="md-form">
                                                        <input type="text" id="materialLoginFormEmail" class="form-control" name="user_name" value="{{ old('user_name') }}" placeholder="Enter Seller Name">
                                                        <label for="materialLoginFormEmail">Seller Name</label>
                                                    </div>
                                                    @error('user_name')
                                                    <label class="text-danger">{{ $message }}</label>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6">
                                                    <!-- Email -->
                                                    <div class="md-form">
                                                        <input type="text" id="materialLoginFormEmail" class="form-control" name="email" value="{{ old('email') }}" placeholder="Enter Email address">
                                                        <label for="materialLoginFormEmail">Email address</label>
                                                    </div>
                                                    @error('email')
                                                    <label class="text-danger">{{ $message }}</label>
                                                    @enderror
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-md-6">
                                                    <!-- Mobile -->
                                                    <div class="md-form">
                                                        <input type="text" id="materialLoginFormEmail" class="form-control" name="mobile" value="{{ old('mobile') }}" placeholder="Enter Mobile Number">
                                                        <label for="materialLoginFormEmail">Mobile Number</label>
                                                    </div>
                                                    @error('mobile')
                                                    <label class="text-danger">{{ $message }}</label>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <!-- Company Name -->
                                                    <div class="md-form">
                                                        <input type="text" id="materialLoginFormEmail" class="form-control" name="company_name" value="{{ old('company_name') }}" placeholder="Enter Company Name">
                                                        <label for="materialLoginFormEmail">Company Name</label>
                                                    </div>
                                                    @error('company_name')
                                                    <label class="text-danger">{{ $message }}</label>
                                                    @enderror
                                                </div>
                                            </div>
                                           
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <!-- Company Email -->
                                                    <div class="md-form">
                                                        <input type="text" id="materialLoginFormEmail" class="form-control" name="company_email" value="{{ old('company_email') }}" placeholder="Enter Company Email">
                                                        <label for="materialLoginFormEmail">Company Email</label>
                                                    </div>
                                                    @error('company_email')
                                                    <label class="text-danger">{{ $message }}</label>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                        <!-- Company Website -->
                                                        <div class="md-form">
                                                            <input type="text" id="materialLoginFormEmail" class="form-control" name="company_website" value="{{ old('company_website') }}" placeholder="Enter Company Website">
                                                            <label for="materialLoginFormEmail">Company Website</label>
                                                        </div>
                                                        @error('company_website')
                                                        <label class="text-danger">{{ $message }}</label>
                                                        @enderror
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <!-- Password -->
                                                    <div class="md-form">
                                                        <input type="password" id="materialLoginFormInputPassword" name="password" class="form-control" value="{{ old('password') }}" placeholder="Enter Password">
                                                        <label for="materialLoginFormInputPassword">Password</label>
                                                        <a href="#"><img src="/assets/admin/img/eye.svg" width="20" class="eyeIcon" id="materialLoginFormShowPassword" onclick="showPassword('materialLoginForm')" /></a>
                                                        <a href="#"><img src="/assets/admin/img/eyeclose.svg" width="20" class="eyeIcon" id="materialLoginFormHidePassword" onclick="hidePassword('materialLoginForm')" style="display : none;" /></a>
                                                    </div>
                                                    @error('password')
                                                    <label class="text-danger">{{ $message }}</label>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <!-- Confirm Password -->
                                                    <div class="md-form">
                                                        <input type="password" id="materialLoginForm1InputPassword" name="confirm_password" class="form-control" value="{{ old('confirm_password') }}" placeholder="Enter Confirm Password">
                                                        <label for="materialLoginFormInputPassword">Confirm Password</label>
                                                        <a href="#"><img src="/assets/admin/img/eye.svg" width="20" class="eyeIcon" id="materialLoginForm1ShowPassword" onclick="showPassword('materialLoginForm1')" /></a>
                                                        <a href="#"><img src="/assets/admin/img/eyeclose.svg" width="20" class="eyeIcon" id="materialLoginForm1HidePassword" onclick="hidePassword('materialLoginForm1')" style="display : none;" /></a>
                                                    </div>
                                                    @error('confirm_password')
                                                    <label class="text-danger">{{ $message }}</label>
                                                    @enderror
                                                </div>
                                            </div>
                                           
                                            <label for="materialLoginFormEmail">Company Address</label>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="md-form">
                                                        <input type="text" id="address_line_1" class="form-control" name="address_line_1" value="{{ old('address_line_1') }}" placeholder="Enter Address Line 1">
                                                        <label for="materialLoginFormEmail">Address Line 1</label>
                                                    </div>
                                                    @error('address_line_1')
                                                    <label class="text-danger">{{ $message }}</label>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="md-form">
                                                        <input type="text" id="address_line_2" class="form-control" name="address_line_2" value="{{ old('address_line_2') }}" placeholder="Enter Address Line 2">
                                                        <label for="materialLoginFormEmail">Address Line 2</label>
                                                    </div>
                                                    @error('address_line_2')
                                                    <label class="text-danger">{{ $message }}</label>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="md-form">
                                                        <select id="address_country_id" class="form-control" name="address_country_id" onchange="getStates(this.value,'address')">
                                                        <option value="">Please Select Country</option>
                                                        @foreach ($countries as $country)
                                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                        @endforeach
                                                        </select>
                                                    </div>
                                                    @error('address_country_id')
                                                    <label class="text-danger">{{ $message }}</label>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="md-form">
                                                        <select class="form-control" name="address_state_id" id="address_state_id" onchange="getCities(this.value,'address')">
                                                            <option value="">Please Select State</option>
                                                        </select>
                                                    </div>
                                                    @error('address_state_id')
                                                    <label class="text-danger">{{ $message }}</label>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="md-form">
                                                        <select class="form-control" name="address_city_id" id="address_city_id">
                                                            <option value="">Please Select City</option>
                                                        </select>
                                                    </div>
                                                    @error('address_city_id')
                                                    <label class="text-danger">{{ $message }}</label>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                             <div class="md-form">
                                                                <input type="text" id="address_pincode" class="form-control" name="address_pincode" value="{{ old('address_pincode') }}" placeholder="Enter Company Postal Code">
                                                                 <label for="materialLoginFormEmail">Company Postal Code</label>
                                                            </div>
                                                            @error('address_pincode')
                                                            <label class="text-danger">{{ $message }}</label>
                                                            @enderror
                                                </div>
                                            </div>
                                           
                                            <label for="materialLoginFormEmail">Company Billing Address</label>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div>
                                                        <input type="checkbox" class="filled-in" id="customCheck1" onclick="SetBillingAddress(this.checked);">
                                                        <label  for="customCheck1">Same as shipping address</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="md-form">
                                                        <input type="text" id="billing_address_line_1" class="form-control" name="billing_address_line_1" value="{{ old('billing_address_line_1') }}" placeholder="Enter Billing Address Line 1">
                                                        <label for="materialLoginFormEmail">Address Line 1</label>
                                                    </div>
                                                    @error('billing_address_line_1')
                                                    <label class="text-danger">{{ $message }}</label>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="md-form">
                                                        <input type="text" id="billing_address_line_2" class="form-control" name="billing_address_line_2" value="{{ old('billing_address_line_2') }}" placeholder="Enter Billing Address Line 2">
                                                        <label for="materialLoginFormEmail">Address Line 2</label>
                                                    </div>
                                                    @error('billing_address_line_2')
                                                    <label class="text-danger">{{ $message }}</label>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="md-form">
                                                        <select id="billing_address_country_id" class="form-control" name="billing_address_country_id" onchange="getStates(this.value,'billing_address')">
                                                        <option value="">Please Select Country</option>
                                                        @foreach ($countries as $country)
                                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                        @endforeach
                                                        </select>
                                                    </div>
                                                    @error('billing_address_country_id')
                                                    <label class="text-danger">{{ $message }}</label>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="md-form">
                                                        <select class="form-control" name="billing_address_state_id" id="billing_address_state_id" onchange="getCities(this.value,'billing_address')">
                                                            <option value="">Please Select State</option>
                                                        </select>
                                                    </div>
                                                    @error('billing_address_state_id')
                                                    <label class="text-danger">{{ $message }}</label>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="md-form">
                                                        <select class="form-control" name="billing_address_city_id" id="billing_address_city_id">
                                                            <option value="">Please Select City</option>
                                                        </select>
                                                    </div>
                                                    @error('billing_address_city_id')
                                                    <label class="text-danger">{{ $message }}</label>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="md-form">
                                                    <input type="text" id="billing_address_pincode" class="form-control" name="billing_address_pincode" value="{{ old('billing_address_pincode') }}" placeholder="Enter Company Postal Code">
                                                        <label for="materialLoginFormEmail">Company Postal Code</label>
                                                    </div>
                                                    @error('billing_address_pincode')
                                                    <label class="text-danger">{{ $message }}</label>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="md-form">
                                                        <input type="file" id="materialLoginFormEmail" class="form-control" name="company_docs[]" multiple>
                                                        {{-- <label for="materialLoginFormInputPassword">Company Documents</label> --}}
                                                    </div>
                                                    @error('company_docs.*')
                                                    <label class="text-danger">{{ $message }}</label>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    
                                                </div>
                                            </div>
                                            

                                            

                                            @if(isset($errorMsg) && $errorMsg)
                                            <p>
                                                <div class="form-group">
                                                    <h5 style="color:red;">{{$errorMsg}}</h5>
                                                </div>
                                            </p>
                                            @endif
                                            @if (Session::has('flash_notification.message'))
                                            <p>
                                                <div class="form-group">
                                                    <h5 style="color:{{ Session::get('flash_notification.level') == 'success' ? 'green':'red' }};">{{ Session::get('flash_notification.message') }}</h5>
                                                </div>
                                            </p>
                                            @endif


                                            <!-- Remember me -->
                                            {{-- <input class="filled-in" name="remember" type="checkbox" id="d1" {{ old('remember') ? 'checked' : '' }}>
                                            <label for="d1">Remember Me</label> --}}
                                            <div class="lgBtn">
                                                <!-- Sign in button -->
                                                <button type="submit" class="btn btn-outline-dark btn-rounded btn-block my-4 z-depth-0 new-paddLogin text-uppercase">REGISTER YOURSELF</button>
                                                <button type="button" onclick="window.location.href='/seller/login'" class="btn btn-link mt-3 btn-block">Already Have an Account. LogIn</button>
                                            </div>
                                        </form>
                                        <!-- Form -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
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
    <script src="/assets/admin/js/jquery.min.js"></script>
    <script src="/assets/admin/js/jquery-ui.min.js"></script>
    <script src="/assets/admin/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/admin/css/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <script src="/assets/admin/js/adminlte.js"></script>
    <!-- <script src="/js/custom-script.js"></script> -->
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/js/mdb.min.js"></script>
    <script>
            function getStates(countryId,selector) {
                $("#loading").show(); 
                $('#city_id').html('<option value="">Please Select City</option>');
                var data = {
                    country_id: countryId
                    , '_token': '{{{csrf_token()}}}'
                }
                $.ajax({
                    url: '/ajax/states'
                    , type: 'POST'
                    , data: data
                    , success: function(data) {
                        $("#loading").hide(); 
                        
                        var selectbox = '';
                        if (data) {
                            selectbox += '<option value="">Please Select State</option>';
                            $.each(data, function(i, item) {
                                var selected = '';
                                // if(stateId && stateId == i){
                                // 	selected = 'selected';
                                // }
                                selectbox += '<option value="' + i + '" ' + selected + '>' + item + '</option>';
                            });

                        }
                        $('#'+selector+'_state_id').html(selectbox);
                    }
                });
            }

            function getCities(stateId,selector) {
                $("#loading").show(); 
                var data = {
                    state_id: stateId
                    , '_token': '{{{csrf_token()}}}'
                }
                $.ajax({
                    url: '/ajax/cities'
                    , type: 'POST'
                    , data: data
                    , success: function(data) {
                        $("#loading").hide(); 
                        var selectbox = '';
                        if (data) {
                            selectbox += '<option value="">Please Select City</option>';
                            $.each(data, function(i, item) {
                                var selected = '';
                                // if(cityId && cityId == i){
                                // 	selected = 'selected';
                                // }
                                selectbox += '<option value="' + i + '" ' + selected + '>' + item + '</option>';
                            });

                        }
                        $('#'+selector+'_city_id').html(selectbox);
                    }
                });
            }
            function SetBillingAddress(checked) {
                if (checked) {
                    $("#billing_address_country_id").val($("#address_country_id").val()).prop("selected", true);
                    $("#billing_address_state_id").html($("#address_state_id").html());
                    $("#billing_address_state_id").val($("#address_state_id").val()).prop("selected", true);
                    $("#billing_address_city_id").html($("#address_city_id").html());
                    $("#billing_address_city_id").val($("#address_city_id").val()).prop("selected", true);
                    $("#billing_address_line_1").val($("#address_line_1").val());
                    $("#billing_address_line_2").val($("#address_line_2").val());
                    $("#billing_address_pincode").val($("#address_pincode").val());
                }
            }
    </script>
</body>

</html>
