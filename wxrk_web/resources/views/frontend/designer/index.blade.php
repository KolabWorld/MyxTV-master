@extends('admin/app')
{{-- Web site Title --}}
@section('title') Dashboard :: @parent @stop
@section('content')
@include('admin.partials.header',['title'=>'Sellers ('. $designers->total() .')','description'=>'Manage sellers'])

  <section class="content mb-5">
      <div class="container-fluid">
          <div class="row">
              <section class="col-lg-12 connectedSortable">
                  <div class="tableHead">
                      <div class="row">
                          <div class="col-sm-5 col-md-5">
                              <div class="filterarea">
                                  {{-- <div class="sel_all">
                                    <input class="filled-in" name="group1" type="checkbox" id="checkedAll">
                                    <label for="checkedAll" class="text-dark">Select All</label>
                                  </div> --}}
                                  <div class="sortlink">
                                    <form action="{{ url('admin/seller-exports?').Request::getQueryString() }}" id="exportForm" method="GET">
                                      <a data-toggle="modal" data-target="#filterModal" class="text-dark"><img src="/assets/admin/img/filter.svg"/> Sort & Filter</a>
                                      <input type="hidden" name="filter_ids" id="filterIds">
                                      <a  href="javascript:void(0);" class="text-dark" onclick="exportdata();"><img src="/assets/designer/img/export.svg"  /> Export Sellers</a>
                                      
                                    </form>
                                  </div>
                              </div>
                          </div>
                          <div class="col-sm-7 col-md-7 textM-right">
                              {{-- <a class="btn btn-md btn-dark btn-auto mb-0" href="{{ url('admin/sellers/create') }}">Add New Designer</a> --}}
                              <div class="searchTb">
                                <form action="" method="GET">
                                  <div class="input-group custom-search">
                                      <div class="input-group-prepend">
                                          <span class="input-group-text"><i class="fa fa-search"></i></span>
                                      </div>
                                      <input type="text" class="form-control" value="{{ Request::get('search') }}" name="search" placeholder="Search by name" aria-label="Username" aria-describedby="basic-addon1">
                                  </div>
                                </form>
                              </div>
                          </div>
                      </div>
                  </div>

                  <div class="table-responsive">
                      <table class="table table-color table-bordered admintable border-0" cellspacing="0" cellpadding="0">
                        @foreach ($designers as $key => $designer)
                          <tr>
                              {{-- <td>
                                <input class="filled-in checklist" name="checklist[]" type="checkbox" id="check{{$key}}" value="{{$designer->id}}">
                                <label for="check{{$key}}"></label>
                              </td> --}}
                              <td>
                                  <div class="tb_status {{ $designer->status =='active' ? 'dark':'light' }}">{{ $designer->status }}</div>
                              </td>
                              <td><strong>{{ $designer->id }}</strong>Seller ID#</td>
                              <td><strong>{{ $designer->email }}</strong>Contact</td>
                              <td><strong>{{ $designer->company_name }}</strong>Company's Name</td>
                              <td><strong>$ {{$designer->total_earn}}</strong>Total Earned</td>
                              <!-- <td>
                                  <a href="{{ url('admin/sellers/'.$designer->id.'/edit') }}" class="btn btn-sm btn-outline-dark">Edit</a>
                              </td>
                              <td>
                                  <a href="#" data-url="/admin/sellers/{{ $designer->id }}" data-request="remove" data-redirect="/admin/sellers" class="btn btn-sm btn-outline-danger">Delete</a>
                              </td> -->
                              <td>
                                  <a href="{{ url('admin/sellers/'.$designer->id) }}" class="btn btn-sm btn-outline-dark">View Details</a>
                              </td>
                          </tr>
                          @endforeach
                          
                      </table>
                  </div>
                  {{ $designers->appends(request()->except('page'))->links('admin.layouts.pagination') }}
              </section>

          </div>

      </div>
  </section>
  {{-- Filter Modal --}}
<div class="modal fade rightModal" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="edittext" aria-hidden="true">
    <div class="modal-dialog modal-dialog-slideout" role="document">
        <div class="modal-content">
            <form class="needs-validation" novalidate action="" method="GET" id="filterForm">
                <div class="modal-header pt-5 pl-5 pr-5 border-0">
                    <div class="popTitle">
                        Filter
                    </div>
                    <div class="float-right">
                        <button type="button" class="closebtn" data-dismiss="modal" aria-label="Close">Close <img src="/assets/admin/img/close-line.svg" /></button>
                    </div>
                </div>
                <div class="modal-body pt-3 pr-5 pl-5">
                    <div class="cancelAppmnt">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="from-group">
                                    <label class="active" for="stitle">Status</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="">Select Status</option>
                                        @foreach ($status as $value)
                                            <option value="{{ $value }}" {{ Request::get('status') == $value ? 'selected':'' }}>{{ ucfirst($value) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6 mt-4">
                                <button class="btn btn-outline-dark btn-rounded btn-block my-4 z-depth-0 waves-effect waves-light" type="submit">Filter</button>
                            </div>
                            <div class="col-sm-6 mt-4">
                                <a href="/admin/designers" class="btn btn-dark btn-rounded btn-block my-4 z-depth-0 waves-effect waves-light" type="button">Reset</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('scripts')
<script src="{{ asset('js/custom-script.js') }}"></script>
<script src="{{ asset('js/sweetalert.js') }}"></script>
<script type="text/javascript"></script>
@stop

@section('styles')
<style type="text/css">
 
</style>
@endsection