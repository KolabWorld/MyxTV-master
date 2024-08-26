@extends('frontend.app')

{{-- Web site Title --}}
@section('title') :: @parent @stop


@section('content')

    @include('frontend.partials.nav', [
        'title' => 'All Vendors',
        'description' => $vendors->total() . ' Records',
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
                            <a href="/vendor/create" class="btn btn-secondary btn-filter mr-2"><i
                                    class="far fa-plus-square mr-1"></i> Add New</a>
                            <a href="#filter" data-toggle="modal" class="btn btn-primary btn-filter mr-2"><i
                                    class="fas fa-filter mr-1"></i> Filter</a>
                            {{--  <a href="#" class="btn btn-success btn-filter"><i class="far fa-file-excel mr-1"></i>
                                Export to Excel</a>  --}}
                        </div>
                    </div>

                    <div class="dashbed-border-bottom mt-2 mb-3"></div>

                    <div class="row">
                        <div class="col-md-12 ">

                            <div class="row">
                                <div class="col-md-12">
                                    @if ($vendors->count() >= 1)
                                        <div class="table-responsive">
                                            <table class="table dashtable">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Vendor ID</th>
                                                        <th>Company Name</th>
                                                        <th>Contact Person</th>
                                                        <th>Email ID</th>
                                                        <th>Mobile No.</th>
                                                        <th>Country</th>
                                                        <th>Business Category</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($vendors as $vendor)
                                                        <tr>
                                                            <td>
                                                                <span
                                                                    class="badge 
                                                            @if ($vendor->status == 'active') badge-success
                                                            @elseif($vendor->status == 'inactive')
                                                                badge-danger
                                                            @else
                                                                badge-warning @endif
                                                            ">
                                                                    {{ ucWords($vendor->status) }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <strong>{{ $vendor->id }}</strong>
                                                            </td>
                                                            <td>
                                                                {{ $vendor->company_name }}
                                                            </td>
                                                            <td>
                                                                {{ $vendor->contact_person_name }}
                                                            </td>
                                                            <td>
                                                                {{ $vendor->email }}
                                                            </td>
                                                            <td>
                                                                {{ $vendor->mobile }}
                                                            </td>
                                                            <td>
                                                                {{ @$vendor->address->country ? @$vendor->address->country->name : '' }}
                                                            </td>
                                                            <td>
                                                                {{ @$vendor->businessCategory->name }}
                                                            </td>
                                                            <td>
                                                                <a href="/vendor/{{ $vendor->id }}/edit">
                                                                    <i class="fas fa-pencil-alt"></i>
                                                                </a>
                                                                <a href="#"
                                                                    data-url="/vendor/{{ $vendor->id }}/delete"
                                                                    data-request="remove" data-redirect="/vendors">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            <div class="norecordList_bg">
                                                <div class="row">
                                                    <div class="col-12 col-lg-12">
                                                        <strong>No Record Found</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif


                                    {{ $vendors->links('frontend.layouts.pagination') }}

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
                                <option value="active" @if (Request::get('status') == 'active') selected @endif>Active</option>
                                <option value="inactive" @if (Request::get('status') == 'inactive') selected @endif>Inactive</option>
                                <option value="pending" @if (Request::get('status') == 'pending') selected @endif>Pending</option>
                            </select>
                        </div>

                        <div class="form-group innerappform">
                            <label>Country</label>
                            <select class="form-control bg-white" name="country_id">
                                <option value="">Select</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}" @if (Request::get('country_id') == $country->id) selected @endif>
                                        {{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group innerappform innerappform">
                                    <label>From Date</label>
                                    <input type="date" name="from_date" value="{{ Request::get('from_date') }}"
                                        class="form-control" />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group innerappform innerappform">
                                    <label>To Date</label>
                                    <input type="date" name="to_date" value="{{ Request::get('to_date') }}"
                                        class="form-control" />
                                </div>
                            </div>
                            @error('to_date')
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

    </script>
@endsection
