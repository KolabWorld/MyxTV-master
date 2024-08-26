@extends('frontend.app')

{{-- Web site Title --}}
@section('title') :: @parent @stop


@section('content')

    @include('frontend.partials.nav', [
        'title' => 'All Events',
        'description' => $events->total() . ' Records',
    ])

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row align-items-center">
                        <div class="col-4 d-none d-sm-block">
                            <a href="javascript:history.back()" class="btn btn-outline-secondary">Go Back</a>
                        </div>
                        <div class="col-12 col-md-8 text-sm-right">
                            <a href="/event/create" class="btn btn-secondary btn-filter mr-2"><i
                                    class="far fa-plus-square mr-1"></i> Add New</a>
                            <a href="#filter" data-toggle="modal" class="btn btn-primary btn-filter mr-2"><i
                                    class="fas fa-filter mr-1"></i> Filter</a>
                            {{--  <a href="#" class="btn btn-success btn-filter"><i class="far fa-file-excel mr-1"></i>
                                Export to Excel</a>  --}}
                        </div>
                    </div>

                    <div class="dashbed-border-bottom mt-2 mb-3"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table dashtable">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Created At</th>
                                                    <th>Name</th>
                                                    <th>Event Host</th>
                                                    <th>Event Hightlight</th>
                                                    <th>Venue</th>
                                                    <th>Event Type</th>
                                                    <th>Company Name</th>
                                                    <th>Start Date</th>
                                                    <th>End Date</th>
                                                    <th>Total Enrollment</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($events as $event)
                                                    <tr>
                                                        <td>
                                                            <span class="badge 
                                                            @if($event->status == 'active')
                                                                badge-success
                                                            @elseif($event->status == 'blacklist')
                                                                badge-warning
                                                            @else
                                                                badge-danger
                                                            @endif
                                                            ">
                                                                {{ ucWords($event->status) }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            {{ date('d M-Y', strtotime($event->created_at)) }}
                                                        </td>
                                                        <td>
                                                            {{ $event->name }}
                                                        </td>
                                                        <td>
                                                            {{ $event->event_host}}
                                                        </td>
                                                        <td style="white-space: normal; min-width:300px">
                                                            {!! $event->highlights !!}
                                                        </td>
                                                        <td>
                                                            {{ $event->venue }}
                                                        </td>
                                                        <td>
                                                            {{ $event->eventType ? $event->eventType->name : '' }}
                                                        </td>
                                                        <td>
                                                            {{ $event->company_name }}
                                                        </td>
                                                        <td>
                                                            {{ $event->start_date_time ? date('d M-Y H:i', strtotime($event->start_date_time)) : '-' }}
                                                        </td>
                                                        <td>
                                                            {{ $event->end_date_time ? date('d M-Y H:i', strtotime($event->end_date_time)) : '' }}
                                                        </td>
                                                        <td>
                                                            {{ !empty($event->users) ? count($event->users) : 0 }}
                                                        </td>
                                                        <td>
                                                            <a href="/event/{{ $event->id }}/edit">
                                                                <i class="fas fa-pencil-alt"></i>
                                                            </a>
                                                            <a href="#" data-url="/event/{{ $event->id }}/delete"
                                                                data-request="remove" data-redirect="/events">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    {{ $events->links('frontend.layouts.pagination') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('modals')
    @parent
    <div class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="loginpopupTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-slideout" role="document">
            <div class="modal-content bg-white">
                <form>
                    <div class="modal-header d-block pt-5 px-3 px-sm-5 border-0">
                        <div class="pt-3">
                            <button type="button" class="close search-btn addaddressbtn p-0" data-dismiss="modal"
                                aria-label="Close">
                                <img src="/assets/admin/images/close.png" width="40px" />
                            </button>
                            <div class="head-title">
                                <h2>Filter</h2>
                                <h5>Change and Apply the Filter</h5>
                            </div>
                            <div class="dashbed-border-bottom mt-3"></div>
                        </div>
                    </div>
                    <div class="modal-body pt-3 pb-5 px-3 px-sm-5">
                        <div class="form-group innerappform">
                            <label>Status</label>
                            <select class="form-control" name="status">
                                <option value="">Select</option>
                                <option value="active" @if(Request::get('status') == 'active') selected @endif>Active</option>
                                <option value="inactive" @if(Request::get('status') == 'inactive') selected @endif>Inactive</option>
                                {{-- <option value="blacklist" @if(Request::get('status') == 'blacklist') selected @endif>Blacklist</option> --}}
                            </select>
                        </div>

                        <div class="form-group innerappform">
                            <label>Country</label>
                            <select class="form-control bg-white" name="country_id">
                                <option value="">Select</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}" @if(Request::get('country_id') == $country->id) selected @endif>{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group innerappform innerappform">
                                    <label>Start Date</label>
                                    <input type="date" name="start_date" value="{{ Request::get('start_date') }}" class="form-control" />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group innerappform innerappform">
                                    <label>End Date</label>
                                    <input type="date" name="end_date" value="{{ Request::get('end_date') }}" class="form-control" />
                                </div>
                            </div>
                            @error('end_date')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary mt-3 px-5">Apply Filter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent
@endsection
