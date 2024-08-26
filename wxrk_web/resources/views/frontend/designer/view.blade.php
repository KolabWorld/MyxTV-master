@extends('admin/app')
{{-- Web site Title --}}
@section('title') Dashboard :: @parent @stop
@section('content')

<div class="content-header">
    <div class="container-fluid mt-3">
        <div class="row mb-2">
            <div class="col-sm-12 col-md-12 col-12">
                <div class="tophead">
                    <div class="allTitle">
                        <a class="d-block d-lg-none" data-widget="pushmenu" href="#" role="button"><img src="/assets/admin/img/menu-left-alt.svg" width="18px" /></a>
                        <h2>{{ $designer->name }}</h2>
                        <div class="subTitle">Details</div>
                    </div>
                    <div class="headpanel">
                        <div class="setting">
                            <a href="account-setting.html"><img src="/assets/admin/img/settings.svg" /></a>
                        </div>
                        <div class="notify">
                            <a href="#"><img src="/assets/admin/img/notify.svg" /></a>
                        </div>
                        <!-- <div class="setting">
                            <a href="{{ url('admin/admin-logout') }}"><img src="/assets/admin/img/logout.png" width="23" style="opacity: 0.8"></a>
                        </div> -->
                        <div class="adlogo d-inline-block"><img src="/assets/frontend/img/logo/logo-black.png"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-12">
                <div class="backbtnPanel nonflex">
                    <div><a href="javascript:history.back()" class="btn btn-sm btn-auto btn-outline-dark">Back</a>
                    {{-- <a href="{{ url('admin/sellers/'.$designer->id.'/edit') }}" class="btn btn-sm btn-auto btn-outline-dark">Edit Details</a> --}}
                    </div>
                    <div>
                        @if($designer->status == 'pending')
                        <form style="display: none" role="approve-data" method="POST" redirect="/admin/sellers/{{ $designer->id }}" action="/admin/update-designer-status/{{ $designer->id }}" enctype="multipart/form-data">
                            <input type="hidden" name="status" value="active">
                            <input type="button" id="approve_submit" data-request="ajax-submit" data-target="[role=approve-data]" style="display: none;">
                        </form>    
                            <a class="btn btn-sm btn-outline-dark btn-auto" id="approve">Approve</a>
                            <a class="btn btn-sm btn-dark btn-auto" data-toggle="modal" data-target="#rejectModal" >&nbsp;Reject&nbsp;&nbsp;</a>
            
                        @endif
                        {{-- <a href="/admin/designer/{{ $designer->id }}/payouts" class="btn btn-sm btn-dark btn-auto">View Payouts</a>
                        <a href="#" data-toggle="modal" data-target="#calavailability" class="btn btn-sm btn-dark btn-auto">View Appointment Availability Calender </a> --}}
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<section class="content mb-5">
    <div class="container-fluid">
        <form method="post" action="/admin/designer/{{$designer->id}}/update">
            @csrf
            <div class="row">
                <section class="col-lg-8 connectedSortable">

                    <div class="row">

                        <div class="col-lg-12">
                            <div class="myordersData">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="mb-4">
                                            <div class="border-top"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="ordeRow1 f-15 playfair">
                                            <div>
                                                Seller Id# {{ $designer->id }}<br>
                                                Joined on: {{ $designer->created_at }} <br>
                                                Email: {{ $designer->email }}<br/>
                                                Contact No: {{ $designer->mobile }}
                                            </div>
                                            <div class="mt-auto textM-right">
                                                Company Email: {{ $designer->company_email }}<br/>
                                                Company Website: {{ $designer->company_website }}<br/>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="row pt-4">
                                    <div class="col-6 col-sm-6 col-md-3 col-lg-3">
                                        <h6 class="playfair">Company Billing Address</h6>
                                        <div class="theme-Ltext normal-line-height">{{ $designer->name }} <br/>
                                             @isset($designer->billingAddress)
                                            {{ $designer->billingAddress->line_1 }} <br/>
                                            {{ $designer->billingAddress->line_2 }} <br/>
                                            {{ $designer->billingAddress->city ? $designer->billingAddress->city->name:'-' }} <br/>
                                            {{ $designer->billingAddress->postal_code }} <br/>
                                            <strong class="font-weight-Mbolder">{{ $designer->billingAddress->state ? $designer->billingAddress->state->name:'-' }}, {{ $designer->billingAddress->country ? $designer->billingAddress->country->name:'-' }}</strong>
                                            @endisset
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-6 col-md-3 col-lg-3">
                                        {{-- <h6 class="playfair">Payout Details</h6>
                                        <div class="theme-Ltext normal-line-height">
                                            @isset($designer->accounts[0])
                                                {{ $designer->account ? $designer->account->account_number:'' }}<br /> 
                                                {{ $designer->account ? $designer->account->account_holder_name:'' }}<br /> 
                                                {{ $designer->account ? $designer->account->bank_name:'' }} <br/>
                                                {{ $designer->account ? $designer->account->bank_address:'' }} <br/>
                                                {{ $designer->account ? $designer->account->iban_code:'' }}<br/>
                                                {{ @$designer->account ? $designer->account->swift_code:'' }}
                                            @endisset
                                        </div> --}}
                                    </div>
                                    <div class="col-6 col-sm-6 col-md-3 col-lg-3">
                                        <h6 class="playfair">Company Address</h6>
                                        <div class="theme-Ltext normal-line-height">{{ $designer->company_name }} <br/>
                                            @isset($designer->companyAddress)
                                            {{ $designer->companyAddress->line_1 }} <br/>
                                            {{ $designer->companyAddress->line_2 }} <br/>
                                            {{ $designer->companyAddress->city ? $designer->companyAddress->city->name:'-' }} <br/>
                                            {{ $designer->companyAddress->postal_code }} <br/>
                                            <strong class="font-weight-Mbolder">{{ $designer->companyAddress->state ? $designer->companyAddress->state->name:'-' }}, {{ $designer->companyAddress->country ? $designer->companyAddress->country->name:'-' }}</strong>
                                            @endisset
                                        </div>
                                    </div>
                                    {{-- <div class="col-6 col-sm-6 col-md-3 col-lg-3">
                                        <h6 class="playfair">Avg. Lead Time</h6>
                                        <div class="form-group">
                                            <label for="time">Time</label>
                                            <select class="form-control" id="time" name="avg_lead_time" required="">
                                                <option value="14" {{($designer->avg_lead_time == '14') ? 'selected' : ''}}>14 Days</option>
                                                <option value="20" {{($designer->avg_lead_time == '20') ? 'selected' : ''}}>20 Days</option>
                                                <option value="30" {{($designer->avg_lead_time == '30') ? 'selected' : ''}}>30 Days</option>
                                        </select>
                                        </div>
                                    </div> --}}
                                    <div class="col-6 col-sm-6 col-md-3 col-lg-3 textM-right">
                                        <h6 class="playfair">Total Earned</h6>
                                        <div class="f-40">$ {{$designer->total_earn}}</div>
                                    </div>
                                </div>
                                <div class="mt-2 mb-2">
                                    &nbsp;
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="col-lg-4 connectedSortable">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Update</h3>
                            <p>Seller Status</p>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status" required="">
                                    <option value="">Select status</option>
                                    @foreach ($status as $value)
                                        <option value="{{ $value }}" {{ $value == $designer->status ? 'selected':'' }}>{{ ucfirst($value) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- <div class="md-form">
                                <input type="text" id="stitle" name="consultation_fee" value="{{(int)$designer->consultation_fee}}" class="form-control">
                                <label for="stitle">Appointment Cost(USD/Hr)</label>
                            </div>
                            @error('consultation_fee')
                                <label class="label">
                                    <strong class="text-danger"> {{ $message }}</strong>
                                </label>
                            @enderror --}}
                            <div>
                                <button type="submit" class="btn btn-sm btn-dark">
                                    Update Seller
                                </button>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </form>
        {{-- <div class="row">
            @foreach ($modules as $key => $module)
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="box1 text-center">
                    <span class="num">{{$key+1}}</span>
                    <div class="editBtn">
                        <a href="#" class="text-dark">
                            <div class="toogleSwitch">
                                OFF
                                <label class="switch">
                                    <input type="checkbox" value="{{ $module->id }}" id="{{ $designer->id }}" onclick="moduleToggle(this)" {{ is_array($designerModules) && in_array($module->id, $designerModules) ? 'checked' : '' }}>
                                    <span class="slider round"></span>
                                </label>ON
                            </div>
                        </a>
                    </div>
                    <img src="/assets/admin/{{ $module->icon }}" />
                    <h5><a href="{{ url($module->alias ? 'admin/designer/'.$designer->id.'/'.$module->alias:'#') }}">{{ $module->title }}</a></h5>
                    <div class="titleDesc mb-3">{{ $module->description }}</div>
                </div>
            </div>
            @endforeach --}}
        </div>
        <h6 class="playfair mb-0">Company Documents</h6><br>
        @foreach ($designer->company_docs as $doc)
            <a href="{{$doc->getFullUrl()}}" target="_blank" style="color: #333333"><i class="fa fa-file f-22 mx-3"></i></a>
        @endforeach
    </div>
</section>
<div class="modal fade rightModal" id="calavailability" tabindex="-1" role="dialog" aria-labelledby="calavailability" aria-hidden="true">
    <div class="modal-dialog modal-dialog-slideout" role="document">
        <div class="modal-content">
            <form class="needs-validation" novalidate>
                <div class="modal-header pt-5 pl-5 pr-5 border-0">
                    <div class="popTitle">
                        Calender Availability
                    </div>
                    <div class="float-right">
                        <button type="button" class="closebtn" data-dismiss="modal" aria-label="Close">Close <img src="/assets/admin/img/close-line.svg" /></button>
                    </div>
                </div>
                <div class="modal-body pt-3 pr-5 pl-5">
                    <div class="cancelAppmnt">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group mb-3">
                                    <label for="currency">Select month</label>
                                    <select id="currency" class="form-control">
                                        <option selected="">January 2021</option>
                                        <option>Febraury 2021</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="calendar mt-3">
                                    <h5>Availability</h5>
                                    <div class="days">
                                        <span>M</span>
                                        <span>T</span>
                                        <span>W</span>
                                        <span>T</span>
                                        <span>F</span>
                                        <span>S</span>
                                        <span>S</span>
                                    </div>
                                    <div class="dates">
                                        <button>
                                            <time>1</time>
                                        </button>
                                        <button>
                                            <time>2</time>
                                        </button>
                                        <button>
                                            <time>3</time>
                                        </button>
                                        <button>
                                            <time>4</time>
                                        </button>
                                        <button>
                                            <time>5</time>
                                        </button>
                                        <button>
                                            <time>6</time>
                                        </button>
                                        <button>
                                            <time>7</time>
                                        </button>
                                        <button>
                                            <time>8</time>
                                        </button>
                                        <button>
                                            <time>9</time>
                                        </button>
                                        <button>
                                            <time>10</time>
                                        </button>
                                        <button>
                                            <time>11</time>
                                        </button>
                                        <button>
                                            <time>12</time>
                                        </button>
                                        <button class="unavailable">
                                            <time>13</time>
                                        </button>
                                        <button>
                                            <time>14</time>
                                        </button>
                                        <button class="unavailable">
                                            <time>15</time>
                                        </button>
                                        <button>
                                            <time>16</time>
                                        </button>
                                        <button>
                                            <time>17</time>
                                        </button>
                                        <button class="unavailable">
                                            <time>18</time>
                                        </button>
                                        <button>
                                            <time>19</time>
                                        </button>
                                        <button>
                                            <time>20</time>
                                        </button>
                                        <button>
                                            <time class="unavailable">21</time>
                                        </button>
                                        <button>
                                            <time>22</time>
                                        </button>
                                        <button>
                                            <time>23</time>
                                        </button>
                                        <button>
                                            <time>24</time>
                                        </button>
                                        <button>
                                            <time>25</time>
                                        </button>
                                        <button>
                                            <time>26</time>
                                        </button>
                                        <button>
                                            <time>27</time>
                                        </button>
                                        <button>
                                            <time>28</time>
                                        </button>
                                        <button>
                                            <time>29</time>
                                        </button>
                                        <button>
                                            <time>30</time>
                                        </button>
                                        <button>
                                            <time>31</time>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="selTimeslot">
                                    <input type="radio" id="radio1" name="radios" value="all" checked="">
                                    <label for="radio1">2:30 pm - 3:30 pm</label>
                                    <input type="radio" id="radio2" name="radios" value="false">
                                    <label for="radio2">5:00 pm - 6:00 pm</label>
                                    <input type="radio" id="radio3" name="radios" value="true">
                                    <label for="radio3">6:00 pm - 7:00 pm</label>
                                    <input type="radio" id="radio4" name="radios" value="true">
                                    <label for="radio4">8:30 pm - 9:30 pm</label>
                                    <input type="radio" id="radio5" name="radios" value="true">
                                    <label for="radio5">9:30 pm - 10:30 pm</label>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="calstatus"><i class="fa fa-square available"></i> Available</div>
                                <div class="calstatus"><i class="fa fa-square unavailable"></i> Unavailable</div>
                            </div>

                            <div class="col-sm-12 mt-4">
                                <button class="btn btn-outline-dark btn-rounded btn-block my-4 z-depth-0 waves-effect waves-light" type="submit">Update Calendar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- Reject Modal --}}
<div class="modal fade rightModal" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="edittext" aria-hidden="true">
    <div class="modal-dialog modal-dialog-slideout" role="document">
        <div class="modal-content">
            <form role="post-data" method="POST" redirect="/admin/sellers/{{ $designer->id }}" action="/admin/update-designer-status/{{ $designer->id }}" enctype="multipart/form-data">
                <div class="modal-header pt-5 pl-5 pr-5 border-0">
                    <div class="popTitle">
                        Reject
                    </div>
                    <div class="float-right">
                        <button type="button" class="closebtn" data-dismiss="modal" aria-label="Close">Close <img src="/assets/admin/img/close-line.svg" /></button>
                    </div>
                </div>
                <div class="modal-body pt-3 pr-5 pl-5">
                    <div class="cancelAppmnt">
                        <div class="row">
                            <div class="col-sm-12">
                                <input type="hidden" name="status" value="rejected">
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea2">Rejection Reason</label>
                                    <textarea class="form-control" name="rejection_reason" placeholder="Enter the reason here"rows="3"></textarea>
                                </div>
                            </div>

                            <div class="col-sm-12 mt-4">
                                <button class="btn btn-outline-dark btn-rounded btn-block my-4 z-depth-0 waves-effect waves-light" type="button" data-request="ajax-submit" data-target="[role=post-data]">Submit</button>
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
<script type="text/javascript">
$('#approve').on('click', function (e) { 
    $('#approve_submit').click();
});
function moduleToggle(e){
    var designer_id = e.id;
    var module_id = e.value;
    var is_checked = e.checked;
    if(is_checked) {
        var url ='/admin/update-designer-module/'+designer_id+'/'+module_id;
        var method ="PUT";
    } else {
        var url ='/admin/delete-designer-module/'+designer_id+'/'+module_id;
        var method ="DELETE";
    }
      $.ajax({
        url: base_url + url,
        type: method,
        success: function(data) {
            // 
        },
        error: function(data) {
            Swal.fire(
                "Error!",
                data.responseJSON.message,
                "warning"
            );
            setTimeout(function() {}, 1200);
        },
    });
} 

</script>
@stop

@section('styles')
<style type="text/css">
 
</style>
@endsection