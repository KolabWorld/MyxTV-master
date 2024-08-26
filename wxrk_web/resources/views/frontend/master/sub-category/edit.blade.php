@extends('frontend.app')

{{-- Web site Title --}}
@section('title') :: @parent @stop


@section('content')
    @include('frontend.partials.nav', [
        'title' => 'Sub Category',
        'description' => 'Edit',
    ])

    @php
        //dd($supportCategory,$subCategory);
    @endphp

    <section class="content mb-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row align-items-center position-top-sticky">
                        <div class="col-sm-5 d-none d-sm-block">
                            <a href="/sub-categories" class="btn btn-outline-secondary">Go Back</a>
                        </div>
                        <div class="col-sm-7 text-sm-right">
                            <button type="button" data-request="ajax-submit" data-target="[role=post-data]" id="update"class="btn btn-success mr-2">
                                Update
                            </button>
                        <a href="/sub-categories" class="btn btn-danger">Cancel</a>
                        </div>
                    </div>
                    <div class="dashbed-border-bottom mt-2 mb-3"></div>
                    <form method="post" data-target="[role=post-data]" action="{{ $action }}" redirect="/sub-categories" role="post-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card formCard">
                                    <div class="card-body">
                                        <div class="head-title form-head mb-4">
                                            <h2>Support-Sub</h2>
                                            <h5>Category</h5>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group innerappform">
                                                            <label>Category</label>
                                                            <select class="form-control" name="parent_id">
                                                                <option value="">Select</option>
                                                                @foreach ($supportCategory as $key => $supportCategoryValue)
                                                                    <option value="{{$supportCategoryValue['id']}}" {{$supportCategoryValue['id'] == $subCategory->parent_id ? 'selected' : ''}}>{{$supportCategoryValue['name']}}</option>
                                                                {{-- <option value="{{$supportCategoryValue->id}}" {{ old('parent_id') == $supportCategoryValue->id ? 'selected': ($subCategory->parent_id == $supportCategoryValue->id ? 'selected':'')}} {{supportCategory->name}}> </option> --}}
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        @error('parent_id')
                                                        <label class="label">
                                                            <strong class="text-danger">
                                                                {{ $message }}</strong>
                                                        </label>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group innerappform">
                                                            <label>Name</label>
                                                            <input type="text" name="category_name"
                                                                value="{{ $subCategory->name ? $subCategory->name : '' }}"
                                                                class="form-control" placeholder="Enter Category" />
                                                        </div>
                                                        @error('name')
                                                            <label class="label">
                                                                <strong class="text-danger"> {{ $message }}</strong>
                                                            </label>
                                                        @enderror
                                                    </div>
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
                                            <input class="filled-in" name="status" type="radio" id="active" value="active"
                                                {{ !(isset($subCategory) && $subCategory->id)
                                                    ? 'checked'
                                                    : (old('name', $subCategory->status == 'active')
                                                        ? 'checked'
                                                        : '') }}>
                                            <label for="active">ACTIVE</label>
                                        </div>
                                        <div class="activechkbox mb-0">
                                            <input class="filled-in" name="status" type="radio" id="inactive"
                                                value="inactive"
                                                {{ old('name', $subCategory->status == 'inactive') ? 'checked' : '' }}>
                                            <label for="inactive">INACTIVE</label>
                                        </div>
                                    </div>
                                    @error('status')
                                        <label class="label">
                                            <strong class="text-danger"> {{ $message }}</strong>
                                        </label>
                                    @enderror
                                </div>
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
    {{-- <script>
    jQuery.ajax({
        url : "{{route('user-dynamic-address-list')}}",
        type : "POST",
        data: {  _token: "{{csrf_token()}}",userAddressFormArray:'' },
        success:function(data)
        {
            
            //  $(".add-user-address-html").empty();

            // var wrapper1       	= $(".add-user-address-html");
            // jQuery.each(data.userAddress, function(key,value){

            //     let htmlId = (value.id + 1);
            //     let  html12='<div class="col-md-4"><div class="address-radio"><input class="with-gap fill-gap" name="userAddressSectedData" type="radio" id="number'+htmlId+'" value="'+value.id+'" '+(data.defaultAddress.id ? "checked" : "")+'><label for="number'+htmlId+'" class="w-100" ><div class="card address-card"><div class="card-header address-card-header">'+value['address']+'</div><div class="card-body address-card-body"><p>'+ value['contact_name'] +'</p><p>'+value['temp_address']+'</p><p>Post box -'+value['pincode']+'</p><p>'+value.district.name+'</p><p>Landmark: near old chowk.</p><h6>Phone: <strong> '+value['phoneNumber']+'</strong></h6></div></div></label></div></div>';

            //     $(wrapper1).append(html12);

            // });


        }
    });
    </script> --}}
@endsection
