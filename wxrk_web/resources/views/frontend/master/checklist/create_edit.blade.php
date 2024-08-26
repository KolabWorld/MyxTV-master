@extends('frontend.app')
{{-- Web site Title --}}
@section('title') Create Checklist Master :: @parent @stop
@section('content')

@include('frontend.partials.nav',['title'=>'Checklist Master','description'=> (isset($checkList) && $checkList->id) ? 'Edit' : 'Add'])
<section class="content mb-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                {!! Form::model($checkList, ['method' => isset($checkList) && $checkList->id ? 'put' : 'post']) !!}
                <div class="row align-items-center position-top-sticky">
                    <div class="col-5">
                        <a href="javascript:history.back()" class="btn btn-outline-secondary">Go Back</a>
                    </div>
                    <div class="col-7 text-right">
                        <button type="submit" id="save" class="btn btn-success mr-2">
                            @if (isset($checkList) && $checkList->id)
                                Update
                            @else
                                Save
                            @endif
                        </button>
                        <a href="/checklists" class="btn btn-danger">Cancel</a>
                    </div>
                </div>
                <div class="dashbed-border-bottom mt-2 mb-3"></div>
                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card formCard">
                                <div class="card-body">
                                    <div class="head-title form-head mb-4">
                                        <h2>Checklist</h2>  
                                        <h5>Master</h5>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group innerappform">
                                                        <label>Checklist Group</label>
                                                        <select name="checklist_group_id" id="checklist_group_id" class="form-control">
                                                            <option value="">Select</option>
                                                            @foreach ($checklistgroups as $checklistgroup)
                                                            <option value="{{ $checklistgroup->id }}" @if (old('checklist_group_id',$checkList->checklist_group_id)==$checklistgroup->id) selected @endif>
                                                                {{ $checklistgroup->name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @error('checklist_group')
                                                    <label class="label">
                                                        <strong class="text-danger"> {{ $message }}</strong>
                                                    </label>
                                                    @enderror
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group innerappform">
                                                        <label>Name</label>
                                                        <input type="text" name="name" value="{{ old('name',$checkList->name) }}" class="form-control" placeholder="Enter Here" />
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
                                        <input class="filled-in" name="status" type="radio" id="active" value="active" {{ (!(isset($checkList) && $checkList->id)) ? 'checked' : (old('name',$checkList->status == 'active') ? 'checked' : '') }}>
                                        <label for="active">ACTIVE</label>
                                    </div>
                                    <div class="activechkbox mb-0">
                                        <input class="filled-in" name="status" type="radio" id="inactive" value="inactive"  {{ old('name',$checkList->status == 'inactive') ? 'checked' : '' }}>
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
