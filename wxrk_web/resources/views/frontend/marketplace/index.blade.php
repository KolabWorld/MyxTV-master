@extends('frontend.app')

{{-- Web site Title --}}
@section('title') :: @parent @stop

@section('content')
    @include('frontend.partials.nav', [
        'title' => 'All Marketplace',
        'description' => $offers->total().' Records',
    ])

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row align-items-center">
                        <div class="col-4 d-none d-sm-block">
                            <a href="javascript:history.back()" class="btn btn-outline-secondary">Go Back</a>
                            <a href="#filter" data-toggle="modal" class="btn btn-primary btn-filter mr-2">
                                <i class="fas fa-filter mr-1"></i> Filter
                            </a>
                        </div>
                        @if((\Auth::user()->hasRoles(['vendor'])))
                            <div class="col-12 col-md-8 text-sm-right">
                                <a href="/marketplace/create" class="btn btn-secondary btn-filter mr-2">
                                    <i class="far fa-plus-square mr-1"></i> Add New
                                </a>
                            </div>
                        @endif
                    
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
                                                    <th>Created Date</th>
                                                    <th>Offer Name</th>
                                                    <th>Type</th>
                                                    <th>Category</th>
                                                    {{-- <th>Premium Category</th> --}}
                                                    <th>Price</th>
                                                    <th>$MyX Price</th>
                                                    <th>Period</th>
                                                    <th>Start Date</th>
                                                    <th>Stock</th>
                                                    <th>Promocodes</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($offers as $offer)
                                                    <tr>
                                                        <td>
                                                            <span class="badge 
                                                            @if($offer->status == 'active')
                                                                badge-success
                                                            {{-- @elseif($offer->status == 'blacklist')
                                                                badge-warning --}}
                                                            @else
                                                                badge-danger
                                                            @endif
                                                            ">
                                                                {{ ucWords($offer->status) }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            {{ date('d M-Y', strtotime($offer->created_at)) }}
                                                        </td>
                                                        <td>
                                                            {{ $offer->offer_name }}
                                                        </td>
                                                        <td>
                                                            {{ $offer->offerType ? $offer->offerType->name : '' }}
                                                        </td>
                                                        <td>
                                                            {{ $offer->offerCategory ? $offer->offerCategory->name : '' }}
                                                        </td>
                                                        {{-- <td>
                                                            {{ $offer->premiumCategory ? $offer->premiumCategory->name : '' }}
                                                        </td> --}}
                                                        <td>
                                                            {{ intval($offer->offer_price) }}
                                                        </td>
                                                        <td>
                                                            {{ $offer->offer_price_in_wxrk }}
                                                        </td>
                                                        <td>
                                                            {{ $offer->offer_period }}
                                                        </td>
                                                        <td>
                                                            {{ $offer->start_date ? date('d M-Y', strtotime($offer->start_date)) : '-' }}
                                                        </td>
                                                        <td>
                                                            {{ intval($offer->stock) }}
                                                        </td>
                                                        <td>
                                                            {{ count($offer->promoCodes) }}
                                                        </td>
                                                        <td>
                                                            @if((\Auth::user()->hasRoles(['vendor'])))
                                                                <a href="/marketplace/{{ $offer->id }}/edit">
                                                                    <i class="fas fa-pencil-alt"></i>
                                                                </a>
                                                            @endif
                                                            <a href="/marketplace/{{ $offer->id }}/view">
                                                                <i class="fas fa-eye"></i></a>
                                                            <a href="#" data-url="/marketplace/{{ $offer->id }}/delete"
                                                                data-request="remove" data-redirect="/marketplaces">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    {{ $offers->links('frontend.layouts.pagination') }}
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
