@extends('frontend.app')
{{-- Web site Title --}}
@section('title') Change Password :: @parent @stop
@section('content')

@include('frontend.partials.nav',['title'=>'Change Password','description'=> 'Edit'])
<section class="content mb-3">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="row align-items-center position-top-sticky">
                    <div class="col-5">
                        <a href="javascript:history.back()" class="btn btn-outline-secondary">Go Back</a>
                    </div>
                    <div class="col-7 text-right">
                        <a href="#" id="save" class="btn btn-success mr-2">Update</a>
                        <a href="/dashboard" class="btn btn-danger">Cancel</a>
                    </div>
                </div>


                <div class="dashbed-border-bottom mt-2 mb-3"></div>



                <form action="" id="post-data" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card formCard">
                                <div class="card-body">
                                    <div class="row justify-content-between">
                                        <div class="col-md-7">
                                            <div class="head-title form-head my-4">
                                                <h2>Change password</h2>
                                                <h5>Update your old password</h5>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group innerappform">
                                                        <label>Old password</label>
                                                        <input type="password" class="form-control" name="old_password" value="" placeholder="Enter Old password" />
                                                    </div>
                                                    @error('old_password')
                                                        <label for="old_password" class="text-danger">{{ $message }}</label>
                                                    @enderror
                                                </div> 
                                            </div> 
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group innerappform">
                                                        <label>New password</label>
                                                        <input type="password" class="form-control" id="materialLoginFormInputPassword" name="new_password" value="" placeholder="Enter New password" />
                                                        <a id="materialLoginFormShowPassword" onclick="showPassword('materialLoginForm')">
                                                            <i class="fas fa-eye showeye"></i>
                                                        </a>
                                                        <a id="materialLoginFormHidePassword" onclick="hidePassword('materialLoginForm')" style="display : none;">
                                                            <i class="fas fa-eye-slash showeye"></i>
                                                        </a>
                                                    </div>
                                                    @error('new_password')
                                                        <label for="new_password" class="text-danger">{{ $message }}</label>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group innerappform">
                                                        <label>Confirm password</label>
                                                        <input type="password" class="form-control" name="confirm_password" value="" placeholder="Enter Confirm password" />
                                                    </div>
                                                    @error('confirm_password')
                                                        <label for="confirm_password" class="text-danger">{{ $message }}</label>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@stop

@section('scripts')
<script src="{{ asset('js/custom-script.js') }}"></script>
<script src="{{ asset('js/sweetalert.js') }}"></script>
<script type="text/javascript">
    $('#save').on('click', function(e) {
        $('#post-data').submit();
    });
    function showPassword(tabModule) {
        $('#' + tabModule + 'InputPassword').attr('type','text');
        $('#' + tabModule + 'ShowPassword').hide();
        $('#' + tabModule + 'HidePassword').show();
    }

    function hidePassword(tabModule) {
        $('#' + tabModule + 'InputPassword').attr('type','password');
        $('#' + tabModule + 'ShowPassword').show();
        $('#' + tabModule + 'HidePassword').hide();
    }
</script>
@stop

@section('styles')
<style type="text/css"></style>
@endsection
