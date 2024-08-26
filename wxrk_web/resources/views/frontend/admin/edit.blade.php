@extends('frontend.app')
{{-- Web site Title --}}
@section('title') Update {{ucFirst($role)}} :: @parent @stop
@section('content')
@if($role == 'contractor')
    @include('frontend.partials.nav',['title'=>'Coordinator Master','description'=> 'Update'])
@else 
    @include('frontend.partials.nav',['title'=>'User Master','description'=> 'Update'])
@endif
<section class="content mb-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="row align-items-center position-top-sticky">
                    <div class="col-5">
                         <a href="javascript:history.back()" class="btn btn-outline-secondary">Go Back</a>
                    </div>
                    <div class="col-7 text-right">
                        <button type="button" id="update" class="btn btn-success mr-2">Update</button>
                        <a href="/main/{{ $type }}" class="btn btn-danger">Cancel</a>
                    </div> 
                </div>
                <div class="dashbed-border-bottom mt-2 mb-3"></div> 
                <form method="post" id="post-data" enctype="multipart/form-data">
                    <input type="hidden" name="_method" value="PUT">
                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card formCard">
                                <div class="card-body">
                                    <div class="head-title form-head mb-4">
                                        <h2>{{ucFirst($role)}}</h2>
                                        <h5>Details</h5>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group innerappform">
                                                        <label for="name">Name</label>
                                                        <input type="text" id="name" name="name" value="{{old('name',$admin->name)}}" class="form-control" placeholder="Enter Full Name" />
                                                    </div>
                                                    @error('name')
                                                        <label class="label">
                                                            <strong class="text-danger"> {{ $message }}</strong>
                                                        </label>
                                                    @enderror
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group innerappform">
                                                        <label for="email">Email-Id</label>
                                                        <input type="email" id="email" name="email" value="{{old('email',$admin->email)}}" class="form-control" placeholder="Enter Email-Id	" readonly />
                                                    </div>
                                                    @error('email')
                                                        <label class="label">
                                                            <strong class="text-danger"> {{ $message }}</strong>
                                                        </label>
                                                    @enderror
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group innerappform">
                                                        <label for="mobile">Mobile No.</label>
                                                        <input type="text" id="mobile" name="mobile" value="{{old('mobile',$admin->mobile)}}" class="form-control" placeholder="Enter Mobile No.	" />
                                                    </div>
                                                    @error('mobile')
                                                        <label class="label">
                                                            <strong class="text-danger"> {{ $message }}</strong>
                                                        </label>
                                                    @enderror
                                                </div>
                                                @if($type != 'contractors')
                                                <div class="col-md-12 ml-1">
                                                        <div class="mb-3">
                                                            <label>Role</label> 
                                                            <div class="row">
                                                                @foreach($roles as $key => $role)
                                                                    <!-- <input class="filled-in" name="admin_roles[]" type="checkbox" id="{{$role->alias}}" value="{{$role->id}}" {{ old('admin_roles') && in_array($role->id,old('admin_roles')) ? 'checked' : '' }}>
                                                                    <label class="mr-3" for="{{$role->alias}}">
                                                                        {{$role->name}}
                                                                    </label> -->
                                                                    <div class="col-4 col-md-4">
                                                                        <div class="activechkbox">
                                                                            <input class="filled-in" value="{{$role->id}}"  name="admin_roles[]" type="radio" id="Checklistyee{{$key}}" {{ old('admin_roles') && in_array($role->id,old('admin_roles')) ? 'checked' : ( in_array($role->id,$adminRoles) ? 'checked' : '') }}>
                                                                            <label for="Checklistyee{{$key}}"><span>{{$role->name}}</span></label>                  
                                                                        </div>
                                                                    </div>
                                                                    
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                        @error('admin_roles')
                                                            <label class="label">
                                                                <strong class="text-danger"> {{ $message }}</strong>
                                                            </label>
                                                        @enderror
                                                        @error('admin_roles.*')
                                                            <label class="label">
                                                                <strong class="text-danger"> {{ $message }}</strong>
                                                            </label>
                                                        @enderror
                                                    </div>
                                                @else 
                                                    <div class="col-md-12 ml-1">
                                                        <div class="mb-3">
                                                            <div>
                                                                @foreach($roles as $key => $role)
                                                                    <input class="filled-in" name="admin_roles[]" type="hidden" id="{{$role->alias}}" value="{{$role->id}}">
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>    
                                                @endif
                                                @if($type == 'contractors')
                                                    <div class="col-md-12">
                                                        <div class="form-group innerappform">
                                                            <label for="company_name">Company Name</label>
                                                            <input type="text" id="company_name" name="company_name" value="{{ old('company_name',$admin->company_name) }}" class="form-control" placeholder="Enter Company Name" />
                                                        </div>
                                                        @error('company_name')
                                                            <label class="label">
                                                                <strong class="text-danger"> {{ $message }}</strong>
                                                            </label>
                                                        @enderror
                                                    </div>
                                                @endif
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
                                        <input class="filled-in" name="status" type="radio" id="active" value="active"@if((old('status') == 'active') || ($admin->status && ($admin->status == 'active'))) checked @endif>
                                        <label for="active">ACTIVE</label>
                                    </div>
                                    <div class="activechkbox mb-0">
                                        <input class="filled-in" name="status" type="radio" value="inactive" id="inactive" @if((old('status') == 'inactive') || ($admin->status && ($admin->status == 'inactive'))) checked @endif>
                                        <label for="inactive">INACTIVE</label>
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
    <script src="/js/custom-script.js"></script>
    <script src="/js/sweetalert.js"></script>
    <script type="text/javascript">
        $('#update').on('click', function (e) { 
            $('#post-data').submit();
        });
    </script>
@stop

@section('styles')
    <style type="text/css"></style>
@endsection