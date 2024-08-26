@extends('admin/app')
{{-- Web site Title --}}
@section('title') Dashboard :: @parent @stop
@section('content')
@include('admin.partials.header',['title'=>'Payouts ('. $payouts->total() .')','description'=>'View & Track Payouts'])

  <section class="content mb-5">
      <div class="container-fluid">
          <div class="row">
              <section class="col-lg-12 connectedSortable">
                  <div class="tableHead">
                      <div class="row">
                          <div class="col-sm-5 col-md-5">
                              <div class="filterarea">
                                  <div class="sel_all">
                                        <input class="filled-in" name="group1" type="checkbox" id="checkedAll">
                                        <label for="checkedAll" class="text-dark">Select All</label>
                                    </div>
                                  <div class="sortlink">
                                    <form action="{{ url('admin/payout-exports?').Request::getQueryString() }}" id="exportForm" method="GET">
                                      <a href="#" class="text-dark"  data-toggle="modal" data-target="#filterModal"><img src="/assets/admin/img/filter.svg" /> Sort & Filter</a>
                                      <input type="hidden" name="filter_ids" id="filterIds">
                                        <a  href="javascript:void(0);" class="text-dark" onclick="exportdata();"><img src="/assets/designer/img/export.svg"  /> Export Payouts</a>
                                      
                                    </form>
                                  </div>
                              </div>
                          </div>
                          <div class="col-sm-7 col-md-7 textM-right">
                              <a class="btn btn-md btn-dark btn-auto mb-0" href="{{ url('admin/payouts/create') }}">Add New Payout</a>
                              <div class="searchTb">
                                <form action="" method="GET">
                                  <div class="input-group custom-search">
                                      <div class="input-group-prepend">
                                          <span class="input-group-text"><i class="fa fa-search"></i></span>
                                      </div>
                                      <input type="text" class="form-control" value="{{ Request::get('search') }}" name="search" placeholder="Search by TXN ID" aria-label="TXN ID" aria-describedby="basic-addon1">
                                  </div>
                                </form>
                              </div>
                          </div>
                      </div>
                  </div>

                  <div class="table-responsive">
                      <table class="table table-color table-bordered admintable border-0" cellspacing="0" cellpadding="0">
                        @foreach ($payouts as $key => $payout)
                          <tr>
                              <td>
                                    <input class="filled-in checklist" name="checklist[]" type="checkbox" id="check{{$key}}" value="{{$payout->id}}">
                                    <label for="check{{$key}}"></label>
                                </td>
                              <td>
                                  <div class="tb_status {{ $payout->status =='processing' ? 'dark':'light' }}">{{ $payout->status }}</div>
                              </td>
                              <td><strong>{{ $payout->transaction_id }}</strong>TXN ID#</td>
                              <td><strong>{{ ucfirst($payout->payout_for) }}</strong>For</td>
                              <td>
                                  <strong>{{ $payout->designer ? $payout->designer->name : "-" }}</strong>
                                  {{$payout->designer ? ucfirst($payout->designer->user_type) : ''}} Name
                                </td>
                              <td><strong>$ {{ (int)$payout->total_deducted_fee }} </strong>Total Fee Deducted</td>
                              <td><strong>$ {{ (int)$payout->total_payout }}</strong>Total Payout</td>
                              <td><strong>{{ dateFormat($payout->created_at) }}</strong>Est. Payout Date</td>
                              <td>
                                    <div class="dropdown">
										<a class="admintabledrop btn btn-sm btn-outline-dark" data-toggle="dropdown" href="#" aria-expanded="true">
											More
										</a>
										<div class="dropdown-menu dropdown-menu-md tableaction dropdown-menu-right" style="left: inherit; right: 0px;">
											<ul>
												<li>
                                                    <a href="{{ url('admin/payouts/'.$payout->id.'/edit') }}" class="btn btn-sm btn-outline-dark">Edit Details</a>
                                                </li>
												<li>
                                                    <a data-toggle="modal" onclick="viewDetails({{json_encode($payout)}})" data-target="#payoutpayment" class="btn btn-sm btn-outline-dark">View Details</a>
                                                </li>
											</ul>
										</div>
									</div>
                              </td>
                          </tr>
                          @endforeach
                          
                      </table>
                  </div>
                  {{ $payouts->appends(request()->except('page'))->links('admin.layouts.pagination') }}
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
                                    <div class="form-group">
                                        <label for="status">Status</label>
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
                                    <a href="{{ url('admin/payouts') }}" class="btn btn-dark btn-rounded btn-block my-4 z-depth-0 waves-effect waves-light">Reset</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
{{-- Payout Details Modal --}}
    <div class="modal fade rightModal" id="payoutpayment" tabindex="-1" role="dialog" aria-labelledby="trackorder" aria-hidden="true">
        <div class="modal-dialog modal-dialog-slideout" role="document">
            <div class="modal-content">
                <form class="needs-validation" novalidate>
                    <div class="modal-header pt-5 pl-5 pr-5 border-0 pb-0">
                        <div class="popTitle">
                            Payout details
                        </div>
                        <div class="float-right">
                            <button type="button" class="closebtn" data-dismiss="modal" aria-label="Close">Close <img src="/assets/admin/img/close-line.svg" /></button>
                        </div>
                    </div>
                    <div class="modal-body pt-3 pr-5 pl-5">
                        <div class="cancelAppmnt">
                            <div class="row">
								<div class="col-md-12 mb-3">
                                    <div class="tb_status dark" id="payout_status">-</div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="helptext">TXN ID</div>
                                    <div class="maintext" id="transaction_id">-</div>
                                </div>
                                <div class="col-sm-6 textright">
                                    <div class="helptext">Date</div>
                                    <div class="maintext" id="created_at">-</div>
                                </div>
                                <div class="col-sm-12 my-3">
                                    <div class="border-bottom"></div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="helptext">Payout for</div>
                                    <div class="maintext" id="payout_for">-</div>
                                </div>
                                <div class="col-sm-6 textright">
                                    <div class="helptext">Designer name</div>
                                    <div class="maintext" id="designer">-</div>
                                </div>
								<div class="col-sm-12 my-3">
                                    <div class="border-bottom"></div>
                                </div>
								 <div class="col-sm-12">
                                    <div class="helptext">Total fee deducted (in USD)</div>
                                    <div class="maintext" id="total_deducted_fee">$ 0</div>
                                </div>
                                <div class="col-sm-12 mt-3">
                                    <div class="helptext">Total payout (in USD)</div>
                                    <div class="maintext" id="total_payout">$ 0</div>
                                </div>
								<div class="col-sm-12 my-3">
                                    <div class="border-bottom"></div>
                                </div>
								<div class="col-sm-6 mb-2">
                                    <div class="helptext">Bank name</div>
                                    <div class="maintext" id="bank_name"></div>
                                </div>
                                <div class="col-sm-6 mb-2 textright">
                                    <div class="helptext">Bank address</div>
                                    <div class="maintext" id="bank_address"></div>
                                </div>
                                <div class="col-sm-6 mb-2">
                                    <div class="helptext">Account No.</div>
                                    <div class="maintext"id="account_number">-</div>
                                </div>
                                <div class="col-sm-6 textright mb-2">
                                    <div class="helptext">Account Holder Name</div>
                                    <div class="maintext"id="account_holder_name">-</div>
                                </div>
								<div class="col-sm-6">
                                    <div class="helptext">IBAN</div>
                                    <div class="maintext" id="iban_code">-</div>
                                </div>
                                <div class="col-sm-6 textright">
                                    <div class="helptext">Swift Code</div>
                                    <div class="maintext" id="swift_code"></div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script type="text/javascript">
    function viewDetails(data) {
        var created_at = moment(data.created_at).format("D MMM, YYYY");
        $('#total_payout').html('$ '+data.total_payout);
        $('#total_deducted_fee').html('$ '+data.total_deducted_fee);
        $('#payout_for').html(data.payout_for.toUpperCase());
        $('#transaction_id').html(data.transaction_id);
        $('#designer').html(data.designer.name);
        $('#created_at').html(created_at);
        $('#payout_status').html(data.status.toUpperCase());
        if(data.designer.account) {
            var account = data.designer.account;
            $('#account_number').html(account.account_number);
            $('#account_holder_name').html(account.account_holder_name);
            $('#iban_code').html(account.iban_code);
            $('#swift_code').html(account.swift_code);
            $('#bank_name').html(account.bank_name);
            $('#bank_address').html(account.bank_address);
        } else {
            $('#account_number').html('-');
            $('#account_holder_name').html('-');
            $('#iban_code').html('-');
            $('#swift_code').html('-');
            $('#bank_name').html('-');
            $('#bank_address').html('-');
        }
    }
</script>
@stop

@section('styles')
    <style type="text/css">
    
    </style>
@endsection