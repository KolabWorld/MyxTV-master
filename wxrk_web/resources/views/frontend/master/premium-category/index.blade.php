@extends('frontend.app')

{{-- Web site Title --}}
@section('title') :: @parent @stop


@section('content')

    @include('frontend.partials.nav', [
        'title' => 'All Premium Categories',
        'description' => $records->total() . ' Records',
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
                            <a href="/premium-category/create" class="btn btn-secondary btn-filter mr-2"><i
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
                                    <div class="table-responsive">
                                        <table class="table dashtable">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Name</th>
                                                    <th>Created At</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($records as $record)
                                                    <tr>
                                                        <td>
                                                            <span class="badge 
                                                            @if($record->status == 'active')
                                                                badge-success
                                                            @elseif($record->status == 'inactive')
                                                                badge-danger
                                                            @else
                                                                badge-warning
                                                            @endif
                                                            ">
                                                                {{ ucWords($record->status) }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            {{ $record->name }}
                                                        </td>
                                                        <td>
                                                            {{ $record->created_at }}
                                                        </td>
                                                        <td>
                                                            <a href="/premium-category/{{ $record->id }}/edit">
                                                                <i class="fas fa-pencil-alt"></i>
                                                            </a>
                                                            <a href="#" data-url="/premium-category/{{ $record->id }}/delete"
                                                                data-request="remove" data-redirect="/premium-categories">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    {{ $records->links('frontend.layouts.pagination') }}

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
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group innerappform innerappform">
                                    <label>From Date</label>
                                    <input type="date" name="from_date" value="{{ Request::get('from_date') }}" class="form-control" />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group innerappform innerappform">
                                    <label>To Date</label>
                                    <input type="date" name="to_date" value="{{ Request::get('to_date') }}" class="form-control" />
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
