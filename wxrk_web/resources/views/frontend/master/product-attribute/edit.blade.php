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
                        <h2>Designer Name</h2>
                        <div class="subTitle">Edit</div>
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
                        <div class="adlogo d-inline-block"><img src="/assets/frontend/img/logo/logo-black.png"></div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row mb-2">
            <div class="col-sm-12">
                <div class="backbtnPanel">
                    <div><a href="javascript:history.back()" class="btn btn-sm btn-auto btn-outline-dark">Back</a></div>
                    <div>
                        <button type="button" id="update" class="btn btn-sm btn-dark btn-auto">Update designer</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<section class="content mb-5">
    <div class="container-fluid">
        <div class="row">
            <section class="col-lg-12 connectedSortable">
                {!! Form::open(array('route'=>['categories.update',$productCategory->id] , 'method'=>'PUT', 'id'=>'post-data', 'enctype'=>'multipart/form-data' ))!!}
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="myordersData">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="md-form">
                                            <input type="text" id="stitle" name="name" value="{{ $productCategory->name }}" placeholder="Enter the Category Name here" class="form-control">
                                            <label for="stitle">Category Name</label>
                                        </div>
                                        @error('name')
                                            <label class="label">
                                                <strong class="text-danger"> {{ $message }}</strong>
                                            </label>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="md-form">
                                            <input type="text" id="stitle" name="alias" value="{{ $productCategory->alias }}" placeholder="Enter the Category Alias here" class="form-control">
                                            <label for="stitle">Category Alias</label>
                                        </div>
                                        @error('alias')
                                            <label class="label">
                                                <strong class="text-danger"> {{ $message }}</strong>
                                            </label>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="status1">Parent</label>

                                            <select class="form-control" id="country" name="parent_id" required="">
                                                <option value="">Select Country</option>
                                                @foreach ($parents as $parent)
                                                <option value="{{ $parent->id }}" {{ $productCategory->parent_id == $parent->id ? 'selected':'' }}>{{ $parent->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('parent_id')
                                            <label class="label">
                                                <strong class="text-danger"> {{ $message }}</strong>
                                            </label>
                                        @enderror
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                {!! Form::close() !!} 
            </section>
        </div>
    </div>
</section>

@stop

@section('scripts')
<script type="text/javascript">
$('#update').on('click', function (e) { 
    $('#post-data').submit();
});
</script>
@stop

@section('styles')
<style type="text/css">
 
</style>
@endsection