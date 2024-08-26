@extends('frontend.app')
{{-- Web site Title --}}
@section('title') Create Equipment Type :: @parent @stop
@section('content')

    @include('frontend.partials.nav', [
        'title' => 'Equipment Type',
        'description' => isset($equipment) && $equipment->id ? 'Edit' : 'Add',
    ])
    <section class="content mb-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    {!! Form::model($equipment, ['method' => isset($equipment) && $equipment->id ? 'put' : 'post']) !!}
                    <div class="row align-items-center position-top-sticky">
                        <div class="col-5">
                            <a href="javascript:history.back()" class="btn btn-outline-secondary">Go Back</a>
                        </div>
                        <div class="col-7 text-right">
                            <button type="submit" id="save" class="btn btn-success mr-2">
                                @if (isset($equipment) && $equipment->id)
                                    Update
                                @else
                                    Save
                                @endif
                            </button>
                            <a href="/equipment-types" class="btn btn-danger">Cancel</a>
                        </div>
                    </div>
                    <div class="dashbed-border-bottom mt-2 mb-3"></div>
                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card formCard">
                                <div class="card-body">
                                    <div class="head-title form-head mb-4">
                                        <h2>Equipment</h2>
                                        <h5>Type</h5>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group innerappform">
                                                        <label>Name</label>
                                                        <input type="text" name="name"
                                                            value="{{ old('name', $equipment->name) }}"
                                                            class="form-control" placeholder="Enter Equipment Type" />
                                                    </div>
                                                    @error('name')
                                                        <label class="label">
                                                            <strong class="text-danger"> {{ $message }}</strong>
                                                        </label>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group innerappform">
                                                        <label>Maintenance Cycle(in Days)</label>
                                                        <input type="text" name="maintenance_cycle"
                                                            value="{{ old('maintenance_cycle', $equipment->maintenance_cycle) }}"
                                                            class="form-control" placeholder="Enter Maintenance Cycle" />
                                                    </div>
                                                    @error('maintenance_cycle')
                                                        <label class="label">
                                                            <strong class="text-danger"> {{ $message }}</strong>
                                                        </label>
                                                    @enderror
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group form-label-group innerappform">
                                                        <label>Select Checklist Group</label>
                                                        <select id="group-list" name="group_ids[]" class="form-control select2" multiple
                                                            style="width: 100%;">
                                                            @foreach ($checklists as $key => $group)
                                                                <option value="{{ $group->id }}" @if(in_array($group->id, old('group_ids', $equipment->groupIds()))) selected @endif>{{ $group->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="head-title form-head my-4">
                                                <h2>CheckList for Equipment</h2>
                                                <h5>Please select from below list</h5>
                                                @error('checklist')
                                                    <label class="label my-2">
                                                        <strong class="text-danger"> {{ $message }}</strong>
                                                    </label>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion addformaccordian checklistformselection" id="addAccordian">
                                        @foreach ($checklists as $key => $group)
                                            <div class="card formCard main-checklist-div" id="main-checklist-div{{ $group->id }}" @if(!in_array($group->id, old('group_ids', $equipment->groupIds()))) style="display: none" @endif>
                                                <div class="card-header">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link collapsed" type="button"
                                                            data-toggle="collapse"
                                                            data-target="#checklistGroup{{ $group->id }}"
                                                            aria-expanded="false">
                                                            <div class="head-title form-head ">
                                                                <input class="filled-in grouphead"
                                                                    name="group{{ $group->id }}" type="checkbox"
                                                                    id="Inspection{{ $group->id }}"
                                                                    data-group="{{ $group->id }}">
                                                                <label for="Inspection{{ $group->id }}">
                                                                    <h2 class="f-13">{{ $group->name }}</h2>
                                                                </label>
                                                            </div>
                                                        </button>
                                                    </h5>
                                                </div>

                                                <div id="checklistGroup{{ $group->id }}" class="collapse"
                                                    data-parent="#addAccordian" style="">
                                                    <div class="card-body pt-2">
                                                        <div class="checklistscroll">
                                                            <div class="row">
                                                                @foreach ($group->checklists as $key => $checklist)
                                                                    <div class="col-md-4 mb-2 mb-sm-3">
                                                                        <input class="filled-in group{{ $group->id }}"
                                                                            name="checklist[{{ $checklist->id }}]"
                                                                            type="checkbox"
                                                                            id="checklist{{ $checklist->id }}"
                                                                            value="{{ $checklist->id }}"
                                                                            {{ in_array($checklist->id, old('checklist', $equipment->checklistIds())) ? 'checked' : '' }}>
                                                                        <label
                                                                            for="checklist{{ $checklist->id }}">{{ $checklist->name }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
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
                                            {{ !(isset($equipment) && $equipment->id)
                                                ? 'checked'
                                                : (old('name', $equipment->status == 'active')
                                                    ? 'checked'
                                                    : '') }}>
                                        <label for="active">ACTIVE</label>
                                    </div>
                                    <div class="activechkbox mb-0">
                                        <input class="filled-in" name="status" type="radio" id="inactive"
                                            value="inactive"
                                            {{ old('name', $equipment->status == 'inactive') ? 'checked' : '' }}>
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
        $('#save').on('click', function(e) {
            $('#post-data').submit();
        });
        $('.grouphead').click(function() {
            var group = $(this).data('group');
            if ($(this).is(":checked"))
                $('.group' + group).attr('checked', true);
            else
                $('.group' + group).removeAttr('checked');
        });
        $('#group-list').change(function() {
            var groupId = $(this).val();
            $('.main-checklist-div').hide();
            groupId.forEach(function(value, index){
                $('#main-checklist-div' + value).show();
            });
        });
    </script>
@stop

@section('styles')
    <style type="text/css"></style>
@endsection
