@extends('frontend.app')
{{-- Web site Title --}}
@section('title') Create Notification :: @parent @stop
@section('content')

@include('frontend.partials.nav',['title'=>'Notification','description'=> (isset($notification) && $notification->id) ? 'Edit' : 'Add'])
<section class="content mb-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                {!! Form::model($notification, ['method' => isset($notification) && $notification->id ? 'put' : 'post']) !!}
                <div class="row align-items-center position-top-sticky">
                    <div class="col-5">
                        <a href="javascript:history.back()" class="btn btn-outline-secondary">Go Back</a>
                    </div>
                    <div class="col-7 text-right">
                        <button type="submit" id="save" class="btn btn-success mr-2">
                            @if (isset($notification) && $notification->id)
                                Update
                            @else
                                Save
                            @endif
                        </button>
                        <a href="/notifications" class="btn btn-danger">Cancel</a>
                    </div>
                </div>
                <div class="dashbed-border-bottom mt-2 mb-3"></div>
                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card formCard">
                                <div class="card-body">
                                    <div class="head-title form-head mb-4">
                                        <h2>Notification</h2>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group innerappform">
                                                        <label>Equipment Detail Type</label>
                                                        <input type="text" name="equipment_detail_type" value="{{ old('equipment_detail_type',$notification->equipment_detail_type) }}" class="form-control"  />
                                                    </div>
                                                    @error('equipment_detail_type')
                                                    <label class="label">
                                                        <strong class="text-danger"> {{ $message }}</strong>
                                                    </label>
                                                    @enderror
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group innerappform">
                                                        <label>Equipment Number</label>
                                                        <input type="text" name="equipment_number" value="{{ old('equipment_number',$notification->equipmentDetail->equipment_number) }}" class="form-control" />
                                                    </div>
                                                    @error('equipment_number')
                                                    <label class="label">
                                                        <strong class="text-danger"> {{ $message }}</strong>
                                                    </label>
                                                    @enderror
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group innerappform">
                                                        <label>Admin Type</label>
                                                        <input type="text" name="admin_type" value="{{ old('admin_type',$notification->admin_type) }}" class="form-control" />
                                                    </div>
                                                    @error('admin_type')
                                                    <label class="label">
                                                        <strong class="text-danger"> {{ $message }}</strong>
                                                    </label>
                                                    @enderror
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group innerappform">
                                                        <label>Admin Name</label>
                                                        <input type="text" name="admin_name" value="{{ old('admin_name',$notification->admin->name) }}" class="form-control" />
                                                    </div>
                                                    @error('admin_name')
                                                    <label class="label">
                                                        <strong class="text-danger"> {{ $message }}</strong>
                                                    </label>
                                                    @enderror
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group innerappform">
                                                        <label>Status</label>
                                                        <input type="text" name="status" value="{{ old('status',$notification->status) }}" class="form-control" />
                                                    </div>
                                                    @error('status')
                                                    <label class="label">
                                                        <strong class="text-danger"> {{ $message }}</strong>
                                                    </label>
                                                    @enderror
                                                </div>
                                                <div class="col-md-12" style="msrgin-bottom:3%;>
                                                    <div class="form-group innerappform">
                                                        <label><b>Description : </b> {!! $notification->description !!}</label>
                                                       <input type="text" name="description" value="{!! $notification->description !!}" class="form-control" />
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group innerappform">
                                                        <label>Mark As Read</label>
                                                        <input type="text" name="mark_as_read" value="{{ old('mark_as_read',$notification->mark_as_read) }}" class="form-control" />
                                                    </div>
                                                    @error('mark_as_read')
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
                                        <input class="filled-in" name="status" type="radio" id="active" value="active" {{ (!(isset($notification) && $notification->id)) ? 'checked' : (old('name',$notification->status == 'active') ? 'checked' : '') }}>
                                        <label for="active">ACTIVE</label>
                                    </div>
                                    <div class="activechkbox mb-0">
                                        <input class="filled-in" name="status" type="radio" id="inactive" value="inactive"  {{ old('name',$notification->status == 'inactive') ? 'checked' : '' }}>
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
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</section>

@stop

@section('scripts')
<script src="{{ asset('js/custom-script.js') }}"></script>
<script src="{{ asset('js/sweetalert.js') }}"></script>
<script type="text/javascript">
    $('#save').on('click', function (e) { 
        $('#post-data').submit();
    });
</script>
@stop

@section('styles')
<style type="text/css"></style>
@endsection
