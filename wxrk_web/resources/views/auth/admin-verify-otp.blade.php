<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Work Study</title>

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" type="image/x-icon" href="/assets/admin/images/favicon.png">
	
        <link rel="stylesheet" href="/assets/admin/css/bootstrap.min.css">
        <link rel="stylesheet" href="/assets/admin/css/plugins/overlayScrollbars/css/OverlayScrollbars.min.css"> 
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
        <link href="/assets/admin/css/material.css" rel="stylesheet"> 
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="/assets/admin/css/style.css" rel="stylesheet">
        <link href="/assets/admin/css/responsive.css" rel="stylesheet">
    </head>

    <body class="">
        <div class="wrapper">
            <div class="container mt-4 mt-md-5"> 
                <div class="row justify-content-center">
                     <div class="col-md-12 text-center" >
                         <img src="/assets/admin/images/logo.png" class="login-logo" alt="" />
                     </div>
                    <div class="col-md-5">
                        <div class="login-bg">
                            <div class="row">
                                <div class="col-md-12">
                                    <form autocomplete="off" id="login-form" method="POST" action="/verify-otp">
                                        @csrf
                                        <input type="hidden" name="type" value="admin">
                                        <input type="hidden" id="email" name="email" value="{{ $user ? $user->email : ''  }}">
                                        <input type="hidden" name="token" value="{{ $user ? $user->remember_token : ''  }}">
                                        <div class="head-title mb-4">
                                            <h2>Verify your email address</h2>
									        <h5>We have sent an OTP on {{ $user ? $user->email : '---' }}
                                            </h5>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="d-flex justify-content-start otp-input">
                                                    <input type="text" class="otp" name="otp[0]" maxlength="1" value="{{ old('otp.0') }}" placeholder="enter" autofocus>
                                                    <input type="text" class="otp" name="otp[1]" maxlength="1" value="{{ old('otp.1') }}" placeholder="enter">
                                                    <input type="text" class="otp" name="otp[2]" maxlength="1" value="{{ old('otp.2') }}" placeholder="enter">
                                                    <input type="text" class="otp" name="otp[3]" maxlength="1" value="{{ old('otp.3') }}" placeholder="enter"> 
                                                    <input type="text" class="otp" name="otp[4]" maxlength="1" value="{{ old('otp.4') }}" placeholder="enter"> 
                                                    <input type="text" class="otp" name="otp[5]" maxlength="1" value="{{ old('otp.5') }}" placeholder="enter"> 
                                                </div>
                                                @error('otp.*')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mt-4"> 
                                            <div class="col-6">
                                                <a id="resend-text" class="resendlin">Resend OTP in <span class="text-danger time">59</span>s</a>
                                                <a href="#" id="resend-otp" class="forgetlink">Resend OTP</a>
                                                <a href="#" id="spinner"><span><i class="fa fa-circle-o-notch fa-spin" style="font-size:18px"></i></span></a>
                                            </div>
                                            <div class="col-6 text-right">
                                                <a href="/forget-password" class="forgetlink">Wrong email address?</a>
                                            </div>
                                        </div>
                                        @if (Session::has('flash_notification.message'))
                                            <p>
                                                <div class="form-group">
                                                    <h5 style="color:{{ Session::get('flash_notification.level') == 'success' ? 'green':'red' }};" class="f-16">{{ Session::get('flash_notification.message') }}</h5>
                                                </div>
                                            </p>    
                                        @endif
                                        <p>
                                            <div class="form-group">
                                                <h5 id="otp-msg" class="f-16" style="display: none"></h5>
                                            </div>
                                        </p> 
                                        <div class="row justify-content-center">
                                            <div class="col-md-7">
                                                <button type="submit" class="btn login-btn btn-block btn-primary">Verify OTP</button>
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
                    <div class="col-md-12 text-center login-foot" >
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
        <script>
            var timeLeft = 59;
            var timerId = null;
            $(document).ready(function(){
                $('#resend-otp').hide();
                $('#spinner').hide();
                customtimer();
            });
            $(".otp").keyup(function (event) {
                if(event.keyCode == 8){
                    if($(this).prev().is('.otp')){
                        $(this).val('').blur();
                        $(this).prev('.otp').val('').focus();
                    }
                }
                if (this.value.length == 1) {
                    if($(this).next().is('.otp')){
                        $(this).blur();
                        $(this).next('.otp').focus();
                    }
                }
            });

            function customtimer(){
                timerId = setInterval(countdown, 1000);
            }

            function countdown() {
                if (timeLeft == 0) {
                    $('#resend-text').hide();
                    $('#resend-otp').show();
                    $('#spinner').hide();
                    clearTimeout(timerId);
                } else {
                    $('.time').text(timeLeft);
                    timeLeft--;
                }
            }

            $('#resend-otp').on('click',function(e){
                e.preventDefault();
                $('#spinner').show();
                $('#otp-msg').text('').hide();
                var email_id = $('#email').val();
                var data = {
                    email : email_id,
                    '_token' : '{{csrf_token()}}'
                }
                $.ajax({
                    url: '/resend-otp'
                    , type: 'POST'
                    , data: data
                    , success: function(data) {
                        if(data.result){
                            $('#resend-text').show();
                            $('#resend-otp').hide();
                            $('#spinner').hide();
                            $('#otp-msg').show().css('color','green').text(data.message).delay(5000).fadeOut();;
                            timeLeft = 59;
                            customtimer();
                        }
                    },
                });
            });
        </script>
    </body>
</html>