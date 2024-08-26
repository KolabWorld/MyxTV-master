@extends('frontend.app')
<!-- Main Container  -->
@section('content')
<!--login section-->
    <div class="container-fluid login-bg">
        <div class="container">
            <div class="login-con">
                <div class="login-form-con">
                    <h2>
                        <img src="/frontend/images/key.png" alt="key">
                        <span>Login</span>
                    </h2>
                    <form action="/login/login" method="post" class="login-form">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <ul class="list-unstyled">
                            @if(isset($passwordmsg) && $passwordmsg)
                                <li>
                                    <h4>{{$passwordmsg}}</h4>
                                </li>        
                            @endif
                            @if(isset($successMessage) && $successMessage)
                                <li>
                                    <h4>{{$successMessage}}</h4>
                                </li>
                            @endif
                            <li>
                                <div class="form-group {{{ $errors->has('email') ? 'has-error' : '' }}}">
                                    <label for="email">
                                        <strong>Email Id
                                            <span class="mendatory" style="color:red"> *</span>
                                        </strong>
                                    </label>
                                    <input type="email" class="form-control" name="email" id="email_login" placeholder="Email" aria-label="Email" value="{{ old('email') }}">
                                    {!! $errors->first('email', '<label class="control-label" for="email">:message</label>')!!}
                                </div>   
                            </li>
                            <li>
                                <div class="form-group {{{ $errors->has('password') ? 'has-error' : '' }}}">
                                    <label for="email">
                                        <strong>Password
                                            <span class="mendatory" style="color:red"> *</span>
                                        </strong>
                                    </label>
                                    <input type="password" class="form-control" name="password" id="password_login" placeholder="Password">
                                    {!! $errors->first('password', '<label class="control-label" for="password">:message</label>')!!}
                                </div>    
                            </li>
                            <li>
                                <input type="submit" value="LOGIN">
                            </li>
                        </ul>
                    </form>
                    <p class="text-center">
                        <a href="/login/forget-password">Request a Password Reset</a>
                    </p>
                    @if(isset($errorMsg) && $errorMsg)
                        <p>
                            <div class="form-group">
                                <h5>{{$errorMsg}}</h5>
                            </div>
                        </p>    
                    @endif 
                </div>
            </div>
        </div>
    </div>
    <!--Login section end--> 

    <!--testimonial section start-->
    <div class="clearfix"></div>
   
    <!--partner section end--> 
@endsection