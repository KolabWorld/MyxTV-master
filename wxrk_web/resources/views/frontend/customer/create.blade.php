@extends('admin/app')
{{-- Web site Title --}}
@section('title') Dashboard :: @parent @stop
@section('content')

<div class="content-header">
    <div class="container-fluid mt-3">
        <div class="row mb-2">
            <div class="col-sm-12 col-md-12 col-12">
                <div class="tophead">
                    <div class="allTitle">
                        <a class="d-block d-lg-none" data-widget="pushmenu" href="#" role="button"><img src="/assets/admin/img/menu-left-alt.svg" width="18px" /></a>
                        <h2>Designer</h2>
                        <div class="subTitle">Add</div>
                    </div>
                    <div class="headpanel">
                        <div class="setting">
                            <a href="account-setting.html"><img src="/assets/admin/img/settings.svg" /></a>
                        </div>
                        <div class="notify">
                            <a href="#"><img src="/assets/admin/img/notify.svg" /></a>
                        </div>
                        <!-- <div class="setting">
                            <a href="{{ url('admin/admin-logout') }}"><img src="/assets/admin/img/logout.png" width="23" style="opacity: 0.8"></a>
                        </div>  -->
                        <div class="adlogo d-inline-block"><img src="/assets/admin/img/logo.svg"></div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row mb-2">
            <div class="col-sm-12">
                <div class="backbtnPanel">
                    <div><a href="javascript:history.back()" class="btn btn-sm btn-auto btn-outline-dark">Back</a></div>
                    <div>
                        <button type="button" id="save" class="btn btn-sm btn-dark btn-auto">Add designer</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<section class="content mb-5">
    <div class="container-fluid">
        <div class="row">
             
            <section class="col-lg-8 connectedSortable">
                 {!! Form::open(['action' => 'Admin\DesignerController@store', 'id'=>"post-data", 'method'=>'POST', 'enctype' => 'multipart/form-data']) !!}
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="myordersData">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="md-form">
                                            <input type="text" id="stitle" name="name" value="{{ old('name') }}" placeholder="Enter the Designer Name here" class="form-control">
                                            <label for="stitle">Designer’s Name</label>
                                        </div>
                                        @error('name')
                                            <label class="label">
                                                <strong class="text-danger"> {{ $message }}</strong>
                                            </label>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="md-form">
                                            <input type="text" id="stitle1" name="email" value="{{ old('email') }}" placeholder="Enter the Email ID here" class="form-control">
                                            <label for="stitle1">Email address</label>
                                        </div>
                                        @error('email')
                                            <label class="label">
                                                <strong class="text-danger"> {{ $message }}</strong>
                                            </label>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="md-form">
                                            <input type="text" id="stitle2" value="{{ old('mobile') }}" name="mobile" placeholder="Enter the Contact No here" class="form-control">
                                            <label for="stitle2">Contact no.</label>
                                        </div>
                                        @error('mobile')
                                            <label class="label">
                                                <strong class="text-danger"> {{ $message }}</strong>
                                            </label>
                                        @enderror
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="md-form">
                                            <input type="password" name="password" id="password" placeholder="Enter password" class="form-control">
                                            <label for="password">Password</label>
                                        </div>
                                        @error('password')
                                            <label class="label">
                                                <strong class="text-danger"> {{ $message }}</strong>
                                            </label>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="md-form">
                                            <input type="password" name="confirm_password" id="confirm_password" placeholder="Re-enter password" class="form-control">
                                            <label for="confirm_password">Confirm Password</label>
                                        </div>
                                        @error('confirm_password')
                                            <label class="label">
                                                <strong class="text-danger"> {{ $message }}</strong>
                                            </label>
                                        @enderror
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group textarea-group">
                                            <label for="exampleFormControlTextarea1">Designer’s Description</label>
                                            <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3">{{ old('description') }}</textarea>
                                        </div>
                                    </div>
                                    <div>
                                        &nbsp;
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="tableHead mb-0">
                                            <div class="row allTitle">
                                                <div class="col-md-12">
                                                    <h2>Billing details</h2>
                                                    <p class="subTitle">Edit / update</p>
                                                </div>
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="md-form">
                                            <input type="text" name="line_1" id="stitle3" value="{{ old('line_1') }}" placeholder="Enter here" class="form-control">
                                            <label for="stitle3">Address</label>
                                        </div>
                                        @error('line_1')
                                            <label class="label">
                                                <strong class="text-danger"> {{ $message }}</strong>
                                            </label>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="status1">Country</label>
                                            <select class="form-control" id="country" name="country_id" required="">
                                                <option value="">Select Country</option>
                                                @foreach ($countries as $country)
                                                <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected':'' }}>{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('country_id')
                                            <label class="label">
                                                <strong class="text-danger"> {{ $message }}</strong>
                                            </label>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="md-form">
                                            <input type="text" id="stitle4" name="district" value="{{ old('district') }}" placeholder="Enter here" class="form-control">
                                            <label for="stitle4">Town/City</label>
                                        </div>
                                        @error('district')
                                            <label class="label">
                                                <strong class="text-danger"> {{ $message }}</strong>
                                            </label>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="md-form">
                                            <input type="text" name="postal_code" id="stitle5" value="{{ old('postal_code') }}" placeholder="Enter here" class="form-control">
                                            <label for="stitle5">Zip code</label>
                                        </div>
                                        @error('postal_code')
                                            <label class="label">
                                                <strong class="text-danger"> {{ $message }}</strong>
                                            </label>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-lg-12">
                                        <div class="tableHead mb-0">
                                            <div class="row allTitle">
                                                <div class="col-md-12">
                                                    <h2>Payout details</h2>
                                                    <p class="subTitle">Edit / update</p>
                                                </div>
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="md-form">
                                            <input type="text" id="stitle6" name="bank_name" value="{{ old('bank_name')}}" placeholder="Enter here" class="form-control">
                                            <label for="stitle6">Bank Name</label>
                                        </div>
                                        @error('bank_name')
                                            <label class="label">
                                                <strong class="text-danger"> {{ $message }}</strong>
                                            </label>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-sm-6">
                                        <div class="md-form">
                                            <input type="text" id="stitle7" name="account_number" value="{{ old('account_number')}}" placeholder="Enter here" class="form-control">
                                            <label for="stitle7">Account No.</label>
                                        </div>
                                        @error('account_number')
                                            <label class="label">
                                                <strong class="text-danger"> {{ $message }}</strong>
                                            </label>
                                        @enderror
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="md-form">
                                            <input type="text" id="stitle8" name="iban_code" value="{{ old('iban_code')}}" placeholder="Enter here" class="form-control">
                                            <label for="stitle8">IBAN</label>
                                        </div>
                                        @error('iban_code')
                                            <label class="label">
                                                <strong class="text-danger"> {{ $message }}</strong>
                                            </label>
                                        @enderror
                                    </div>
                                        
                                    <div class="col-sm-6">
                                        <div class="md-form">
                                            <input type="text" id="stitle9" name="swift_code" value="{{ old('swift_code')}}" placeholder="Enter here" class="form-control">
                                            <label for="stitle9">SWIFT CODE</label>
                                        </div>
                                        @error('swift_code')
                                            <label class="label">
                                                <strong class="text-danger"> {{ $message }}</strong>
                                            </label>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

            </section>


            <section class="col-lg-4 connectedSortable">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Update</h3>
                        <p>Status</p>
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" name="status" id="status" required="">
                                @foreach ($status as $value)
                                <option value="{{ $value }}" {{ old('status') == $value ? 'selected':'' }}>{{ ucfirst($value) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </section>
            {!! Form::close() !!} 

        </div>
    </div>
</section>

@stop

@section('scripts')
<script type="text/javascript">
$('#save').on('click', function (e) { 
    $('#post-data').submit();
});
</script>
@stop

@section('styles')
<style type="text/css">
 
</style>
@endsection