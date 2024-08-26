@extends('frontend.app')
{{-- Web site Title --}}
@section('title') Dashboard :: @parent @stop
@section('content')
@include('frontend.partials.nav',['title'=>'Dashboard','description'=> 'Welcome back, <span class="theme-Dtext">' . $user->name.' <strong>'. ($user->hasRoles(["contractor"]) ? "(".$user->company_name.")" : "").'</strong></span>'])
<section class="content">
    <div class="container-fluid">
        <form method="get" id="filter-form">
            {{-- @if($user->hasRoles(['admin', 'admin-it'])) --}}
            <div class="row mb-2">
                <div class="col-md-2 workdataselect">
                    <select class="form-control" name="created_at">
                        <option value="">Select</option>
                        @foreach ($createdAt as $item)
                        <option value="{{ $item }}" @if(Request::get('created_at')==$item) selected @endif>{{ $item }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 from_to_date">
                    <div class="form-group innerappform top-dateformat">
                        <label>From</label>
                        <input type="date" name="from_date" value="{{ Request::get('from_date') }}" class="form-control bg-white" placeholder="Enter Capacity (in TON)" onchange="this.form.submit()">
                    </div>
                </div>
                <div class="col-md-2 from_to_date">
                    <div class="form-group innerappform top-dateformat">
                        <label>To</label>
                        <input type="date" name="to_date" value="{{ Request::get('to_date') }}" class="form-control bg-white" placeholder="Enter Capacity (in TON)" onchange="this.form.submit()">
                    </div>
                    @error('to_date')
                    <label for="to_date" class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
                <div class="col-md-2 d-none d-sm-block">
                    <div class="form-group innerform top-dateformat">
                        <label>Company</label>
                        <select class="form-control bg-white" name="company_name" onchange="this.form.submit()">
                            <option value="">Select</option>
                            @foreach ($companies as $company=>$value)
                            <option value="{{ $company }}" @if($request->company_name == $company)
                                selected
                                @endif>{{ $company }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-2 d-none d-sm-block">
                    <div class="form-group innerform top-dateformat">
                        <label>Equipment type</label>
                        <select class="form-control bg-white" name="equipment_type" onchange="this.form.submit()">
                            <option value="">Select</option>
                            @foreach ($equipmentTypes as $equipmentType)
                            <option value="{{ $equipmentType->id }}" @if($request->equipment_type == $equipmentType->id)
                                selected
                                @endif>{{ $equipmentType->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-2  mt-2 mt-sm-2 mb-2 mb-sm-0 justify-content-mobbetween">
                    <a href="/dashboard" class="btn btn-outline-secondary"><i class="far fa-times-circle mr-1"></i> Clear</a>
                    <div class=" d-inline-block d-sm-none">
                        <a href="#filter" data-toggle="modal" class="btn btn-primary btn-filter mr-2"><i class="fas fa-filter mr-1"></i> Filter</a>
                    </div>
                </div>
            </div>


            <div class="row">
                {{-- <div class="col-md-4">
                    <div class="card dashcard">
                        <div class="card-header">
                            <div class="row align-items-end">
                                <div class="col-9">
                                    <h2>Requests</h2>
                                    <h3>Applications</h3>
                                </div>
                                <div class="col-3 text-right">
                                    <img src="/assets/admin/images/folder-open.png" height="43px">
                                </div>
                            </div>
                        </div>
                        <div class="card-body approdashstat">
                            <div class="row align-items-center">
                                <div class="col-6">
                                <a href="/equipment-details?status=pending&company_name={{Request::get('company_name')}}&equipment_type={{Request::get('equipment_type')}}&created_at={{Request::get('created_at')}}&from_date={{Request::get('from_date')}}&to_date={{Request::get('to_date')}}">
                                  <h4>{{ sprintf('%02d', $pending) }}</h4>
                                <p class="text-success">All</p>
                </a>
            </div>
            <div class="col-6">
                <a href="/equipment-details?status=pending&company_name={{Request::get('company_name')}}&equipment_type={{Request::get('equipment_type')}}&created_at={{Request::get('created_at')}}&from_date={{Request::get('from_date')}}&to_date={{Request::get('to_date')}}">
                    <h4>{{ sprintf('%02d', $pending) }}</h4>
                    <p class="text-warning">Pending Requests</p>
                </a>
            </div>
    </div>
    </div>
    </div>
    </div>
    <div class="col-md-8">
        <div class="row ">
            <div class="col-md-12">
                <div class="card dashcard">
                    <div class="card-header">
                        <div class="row align-items-end">
                            <div class="col-9">
                                <h2>Inspection Status</h2>
                                <h3>Applications</h3>
                            </div>
                            <div class="col-3 text-right">
                                <img src="/assets/admin//assets/admin/images/folder-open-fade.png" height="43px">
                            </div>
                        </div>
                    </div>
                    <div class="card-body approdashstat">
                        <div class="row align-items-center">
                            <div class="col-4">
                                <a href="/equipment-details?status=approved&company_name={{Request::get('company_name')}}&equipment_type={{Request::get('equipment_type')}}&created_at={{Request::get('created_at')}}&from_date={{Request::get('from_date')}}&to_date={{Request::get('to_date')}}">
                                    <h4>{{ sprintf('%02d', $approved) }}</h4>
                                    <p class="text-success"> Approved</p>
                                </a>
                            </div>
                            <div class="col-4">
                                <a href="/equipment-details?status=cond-approved&company_name={{Request::get('company_name')}}&equipment_type={{Request::get('equipment_type')}}&created_at={{Request::get('created_at')}}&from_date={{Request::get('from_date')}}&to_date={{Request::get('to_date')}}">
                                    <h4>{{ sprintf('%02d', $conditionallyApproved) }}</h4>
                                    <p class="text-danger">Cond. Approved</p>
                                </a>
                            </div>
                            <div class="col-4">
                                <a href="/equipment-details?status=rejected&company_name={{Request::get('company_name')}}&equipment_type={{Request::get('equipment_type')}}&created_at={{Request::get('created_at')}}&from_date={{Request::get('from_date')}}&to_date={{Request::get('to_date')}}">
                                    <h4>{{ sprintf('%02d', $rejected) }}</h4>
                                    <p class="text-warning">Rejected</p>
                                </a>
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="col-md-4">
        <div class="card dashcard">
            <div class="card-header">
                <div class="row align-items-end mt-2">
                    <div class="col-5">
                        <h2>Requests</h2>
                        <h3>Applications</h3>
                    </div>
                    <div class="col-7 text-right">
                        @if($user->hasRoles(["contractor"]))
                        <a href="/equipment-details/create" class="btn btn-secondary"><i class="far fa-plus-square mr-1"></i> Add New</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body approdashstat">
                <div class="row align-items-center">
                    <div class="col-6">
                        <a href="/equipment-details?company_name={{Request::get('company_name')}}&equipment_type={{Request::get('equipment_type')}}&created_at={{Request::get('created_at')}}&from_date={{Request::get('from_date')}}&to_date={{Request::get('to_date')}}">
                            <h4>{{ sprintf('%02d', $all) }}</h4>
                            <p class="text-success">All</p>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="/equipment-details?status=pending&company_name={{Request::get('company_name')}}&equipment_type={{Request::get('equipment_type')}}&created_at={{Request::get('created_at')}}&from_date={{Request::get('from_date')}}&to_date={{Request::get('to_date')}}">
                            <h4>{{ sprintf('%02d', $pending) }}</h4>
                            <p class="text-warning">Pending Requests</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="row ">
            <div class="col-md-12">
                <div class="card dashcard">
                    <div class="card-header">
                        <div class="row align-items-end">
                            <div class="col-9">
                                <h2>Inspection Status</h2>
                                <h3>Applications</h3>
                            </div>
                            <div class="col-3 text-right">
                                <img src="/assets/admin/images/folder-open-fade.png" height="43px" />
                            </div>
                        </div>
                    </div>
                    <div class="card-body approdashstat">
                        <div class="row align-items-center">
                            <div class="col-6 col-sm-2">
                                <a href="/equipment-details?status=total_inspection&company_name={{Request::get('company_name')}}&equipment_type={{Request::get('equipment_type')}}&created_at={{Request::get('created_at')}}&from_date={{Request::get('from_date')}}&to_date={{Request::get('to_date')}}">
                                <h4>{{ sprintf('%02d', ($approved + $rejected + $conditionallyApproved + $demobilizedPending + $demobilized)) }}</h4>
                                <p class="text-black">Total</p>
                            </div>
                            <div class="col-6 col-sm-2">
                                <a href="/equipment-details?status=approved&company_name={{Request::get('company_name')}}&equipment_type={{Request::get('equipment_type')}}&created_at={{Request::get('created_at')}}&from_date={{Request::get('from_date')}}&to_date={{Request::get('to_date')}}">
                                <h4>{{ sprintf('%02d', $approved) }}</h4>
                                <p class="text-success">Approved</p>
                                </a>  
                            </div>
                            <div class="col-6 col-sm-2">
                                <a href="/equipment-details?status=rejected&company_name={{Request::get('company_name')}}&equipment_type={{Request::get('equipment_type')}}&created_at={{Request::get('created_at')}}&from_date={{Request::get('from_date')}}&to_date={{Request::get('to_date')}}">
                                <h4>{{ sprintf('%02d', $rejected) }}</h4>
                                <p class="text-warning">Rejected</p>
                                </a>
                            </div>
                            <div class="col-6 col-sm-2">
                                <a href="/equipment-details?status=cond-approved&company_name={{Request::get('company_name')}}&equipment_type={{Request::get('equipment_type')}}&created_at={{Request::get('created_at')}}&from_date={{Request::get('from_date')}}&to_date={{Request::get('to_date')}}">
                                <h4>{{ sprintf('%02d', $conditionallyApproved) }}</h4>
                                <p class="text-danger">Cond. Approved</p>
                                </a>
                            </div>
                            <div class="col-6 col-sm-2">
                                <a href="/equipment-details?status=demobilize-req.&company_name={{Request::get('company_name')}}&equipment_type={{Request::get('equipment_type')}}&created_at={{Request::get('created_at')}}&from_date={{Request::get('from_date')}}&to_date={{Request::get('to_date')}}">
                                <h4>{{ sprintf('%02d', $demobilizedPending) }}</h4>
                                <p class="text-warning">Demobilize Req.</p>
                                </a>
                            </div>
                            <div class="col-6 col-sm-2">
                                <a href="/equipment-details?status=demobilized&company_name={{Request::get('company_name')}}&equipment_type={{Request::get('equipment_type')}}&created_at={{Request::get('created_at')}}&from_date={{Request::get('from_date')}}&to_date={{Request::get('to_date')}}">
                                    <h4>{{ sprintf('%02d', $demobilized) }}</h4>
                                    <p class="text-success">Demobilized</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- <div class="col-md-4">
        <div class="row ">
            <div class="col-md-12">
                <div class="card dashcard">
                    <div class="card-header">
                        <div class="row align-items-end">
                            <div class="col-9">
                                <h2>Demobilization Status</h2>
                                <h3>Applications</h3>
                            </div>
                            <div class="col-3 text-right">
                                <img src="/assets/admin/images/folder-open-fade.png" height="43px" />
                            </div>
                        </div>
                    </div>
                    <div class="card-body approdashstat">
                        <div class="row align-items-center">
                            <div class="col-4 col-sm-4">
                                <h4>{{ sprintf('%02d', $demobilized + $demobilizedPending) }}</h4>
                                <p class="text-black">Total</p>
                            </div>
                            <div class="col-4 col-sm-4">
                                <a href="/equipment-details?status=demobilized&company_name={{Request::get('company_name')}}&equipment_type={{Request::get('equipment_type')}}&created_at={{Request::get('created_at')}}&from_date={{Request::get('from_date')}}&to_date={{Request::get('to_date')}}">
                                <h4>{{ sprintf('%02d', $demobilized) }}</h4>
                                <p class="text-success">Demobilized</p>
                                </a>
                            </div>
                            <div class="col-4 col-sm-4">
                                <a href="/equipment-details?status=demobilize-req.&company_name={{Request::get('company_name')}}&equipment_type={{Request::get('equipment_type')}}&created_at={{Request::get('created_at')}}&from_date={{Request::get('from_date')}}&to_date={{Request::get('to_date')}}">
                                <h4>{{ sprintf('%02d', $demobilizedPending) }}</h4>
                                <p class="text-warning">Pending</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-md-4">
        <div class="row ">
            <div class="col-md-12">
                <div class="card dashcard">
                    <div class="card-header">
                        <div class="row align-items-end">
                            <div class="col-9">
                                <h2>Inspection Due Status</h2>
                                <h3>Applications</h3>
                            </div>
                            <div class="col-3 text-right">
                                <img src="/assets/admin/images/folder-open-fade.png" height="43px" />
                            </div>
                        </div>
                    </div>
                    <div class="card-body approdashstat">
                        <div class="row align-items-center">
                            <div class="col-4 col-sm-4">
                                <a href="/equipment-details?due_date=Today&company_name={{Request::get('company_name')}}&equipment_type={{Request::get('equipment_type')}}&created_at={{Request::get('created_at')}}&from_date={{Request::get('from_date')}}&to_date={{Request::get('to_date')}}">
                                <h4>{{ sprintf('%02d', $inspectionDueToday) }}</h4>
                                <p class="text-danger">Today</p>
                                </a>
                            </div>
                            <div class="col-4 col-sm-4">
                                <a href="/equipment-details?due_date=Next 1 Week&company_name={{Request::get('company_name')}}&equipment_type={{Request::get('equipment_type')}}&created_at={{Request::get('created_at')}}&from_date={{Request::get('from_date')}}&to_date={{Request::get('to_date')}}">
                                <h4>{{ sprintf('%02d', $inspectionDue1Week) }}</h4>
                                <p class="text-success">Next 1 Week</p>
                                </a>
                            </div>
                            <div class="col-4 col-sm-4">
                                <a href="/equipment-details?due_date=Next 1 Month&company_name={{Request::get('company_name')}}&equipment_type={{Request::get('equipment_type')}}&created_at={{Request::get('created_at')}}&from_date={{Request::get('from_date')}}&to_date={{Request::get('to_date')}}">
                                <h4>{{ sprintf('%02d', $inspectionDue1Month) }}</h4>
                                <p class="text-warning">Next 1 Month</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-md-4">
        <div class="row ">
            <div class="col-md-12">
                <div class="card dashcard">
                    <div class="card-header">
                        <div class="row align-items-end">
                            <div class="col-9">
                                <h2>Expiry Doc Status</h2>
                                <h3>Applications</h3>
                            </div>
                            <div class="col-3 text-right">
                                <img src="/assets/admin/images/folder-open-fade.png" height="43px" />
                            </div>
                        </div>
                    </div>
                    <div class="card-body approdashstat">
                        <div class="row align-items-center">
                            <div class="col-4 col-sm-4">
                               <a href="/equipment-details?expiry_docs=Today&company_name={{Request::get('company_name')}}&equipment_type={{Request::get('equipment_type')}}&created_at={{Request::get('created_at')}}&from_date={{Request::get('from_date')}}&to_date={{Request::get('to_date')}}">
                                <h4>{{ sprintf('%02d', $expiryDocToday) }}</h4>
                                <p class="text-danger">Today</p>
                                </a> 
                            </div>
                            <div class="col-4 col-sm-4">
                                <a href="/equipment-details?expiry_docs=Next 1 Week&company_name={{Request::get('company_name')}}&equipment_type={{Request::get('equipment_type')}}&created_at={{Request::get('created_at')}}&from_date={{Request::get('from_date')}}&to_date={{Request::get('to_date')}}">
                                <h4>{{ sprintf('%02d', $expiryDoc1Week) }}</h4>
                                <p class="text-success">Next 1 week</p>
                                </a>  
                            </div>
                            <div class="col-4 col-sm-4">
                                <a href="/equipment-details?expiry_docs=Next 1 Month&company_name={{Request::get('company_name')}}&equipment_type={{Request::get('equipment_type')}}&created_at={{Request::get('created_at')}}&from_date={{Request::get('from_date')}}&to_date={{Request::get('to_date')}}">
                                <h4>{{ sprintf('%02d', $expiryDoc1Month) }}</h4>
                                <p class="text-warning">Next 1 month</p>
                                </a>   
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}


    {{--  <div class="col-md-12">
        <div class="row ">
            <div class="col-md-12">
                <div class="card dashcard">
                    <div class="card-header">
                        <div class="row align-items-end">
                            <div class="col-9">
                                <h2>Observation Status</h2>
                                <h3>Applications</h3>
                            </div>
                            <div class="col-3 text-right">
                                <img src="/assets/admin/images/folder-open-fade.png" height="43px" />
                            </div>
                        </div>
                    </div>
                    <div class="card-body approdashstat">
                        <div class="row align-items-center">
                            <div class="col-2">
                                <a href="/equipment-details?obs_status=equipment_technical_problem&company_name={{Request::get('company_name')}}&equipment_type={{Request::get('equipment_type')}}&created_at={{Request::get('created_at')}}&from_date={{Request::get('from_date')}}&to_date={{Request::get('to_date')}}">
                                    <h4>{{ sprintf('%02d', $obsTechnical) }}</h4>
                                    <p class="text-black">Technical Problem</p>
                                </a>
                            </div>
                            <div class="col-2">
                                <a href="/equipment-details?obs_status=equipment_mechanical_problem&company_name={{Request::get('company_name')}}&equipment_type={{Request::get('equipment_type')}}&created_at={{Request::get('created_at')}}&from_date={{Request::get('from_date')}}&to_date={{Request::get('to_date')}}">
                                    <h4>{{ sprintf('%02d', $obsMechanical) }}</h4>
                                    <p class="text-success">Mechanical Problem</p>
                                </a>
                            </div>
                            <div class="col-2">
                                <a href="/equipment-details?obs_status=equipment_document_error&company_name={{Request::get('company_name')}}&equipment_type={{Request::get('equipment_type')}}&created_at={{Request::get('created_at')}}&from_date={{Request::get('from_date')}}&to_date={{Request::get('to_date')}}">
                                    <h4>{{ sprintf('%02d', $obsDocsErr) }}</h4>
                                    <p class="text-warning">Eq. Doc Error</p>
                                </a>
                            </div>
                            <div class="col-2">
                                <a href="/equipment-details?obs_status=operator_certificate&company_name={{Request::get('company_name')}}&equipment_type={{Request::get('equipment_type')}}&created_at={{Request::get('created_at')}}&from_date={{Request::get('from_date')}}&to_date={{Request::get('to_date')}}">
                                    <h4>{{ sprintf('%02d', $obsOpreratorCerti) }}</h4>
                                    <p class="text-black">Operator Certificate</p>
                                </a>
                            </div>
                            <div class="col-2">
                                <a href="/equipment-details?obs_status=operator_document_error&company_name={{Request::get('company_name')}}&equipment_type={{Request::get('equipment_type')}}&created_at={{Request::get('created_at')}}&from_date={{Request::get('from_date')}}&to_date={{Request::get('to_date')}}">
                                    <h4>{{ sprintf('%02d', $obsOpDocsErr) }}</h4>
                                    <p class="text-success">Op. Doc Error</p>
                                </a>
                            </div>
                            <div class="col-2">
                                <a href="/equipment-details?obs_status=others&company_name={{Request::get('company_name')}}&equipment_type={{Request::get('equipment_type')}}&created_at={{Request::get('created_at')}}&from_date={{Request::get('from_date')}}&to_date={{Request::get('to_date')}}">
                                    <h4>{{ sprintf('%02d', $obsOthers) }}</h4>
                                    <p class="text-warning">Others</p>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


        </div>

    </div>  --}}

    </div>
    </form>
    </table>    
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
</section>
@stop

@section('styles')
<style type="text/css"></style>
@stop

@section('scripts')
<script src="{{ asset('js/custom-script.js') }}"></script>
<script src="{{ asset('js/sweetalert.js') }}"></script>
<script src="//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>
<script type="text/javascript">
    // function exportexcel(tableId,filename) {  
    //     $("#"+tableId).table2excel({  
    //         name: "Table2Excel",  
    //         filename: filename+".xls",  
    //         fileext: ".xls"  
    //     });  
    // }  
    $(document).ready(function() {
        @if(!(Request::get('created_at') == 'Custom'))
        $('.from_to_date').hide();
        @endif
    });
    $('select[name=created_at]').change(function(e) {
        if (e.target.value != 'Custom') {
            $('input[name=from_date]').val('');
            $('input[name=to_date]').val('');
            e.target.closest('form').submit();
        } else {
            $('.from_to_date').show();
        }
    });
    $('.make-pending').click(function(e) {
        e.preventDefault();
        Swal.fire({
            title: "Alert"
            , text: "Are you sure you want to make this application Pending ?"
            , showCancelButton: true
            , confirmButtonColor: "#3085d6"
            , cancelButtonColor: "#d33"
            , confirmButtonText: "Yes, Please"
        , }).then((result) => {
            if (result.value) {
                var data = {
                    'id': $(this).data('item')
                    , '_token': '{{ csrf_token() }}'
                }
                $.ajax({
                    url: base_url + '/equipment-details/make-pending'
                    , data: data
                    , type: "POST"
                    , success: function(data) {
                        Swal.fire("Success", data.message, "success");
                        location.reload();
                    }
                });
            }
        });
    });

</script>
@stop
