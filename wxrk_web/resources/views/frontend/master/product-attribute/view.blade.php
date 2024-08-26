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
                        <h2>Designer Name</h2>
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
                        </div>  -->
                        <div class="adlogo d-inline-block"><img src="/assets/frontend/img/logo/logo-black.png"></div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row mb-2">
            <div class="col-sm-12">
                <div class="backbtnPanel nonflex">
                    <div><a href="javascript:history.back()" class="btn btn-sm btn-auto btn-outline-dark">Back</a>
                    <a href="designer-add-edit.html" class="btn btn-sm btn-auto btn-outline-dark">Edit Details</a>
                    </div>
                    <div><a href="#" class="btn btn-sm btn-dark btn-auto">View Payouts</a>
                        <a href="#" data-toggle="modal" data-target="#calavailability" class="btn btn-sm btn-dark btn-auto">View Appointment Availability Calender </a></div>
                </div>
            </div>
        </div>

    </div>
</div>

<section class="content mb-5">
    <div class="container-fluid">

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
                                    <div class="ordeRow1">
                                        <div>Customer ID# SM00023433
                                            <br>Joined on: 12 Jan 2021
                                        </div>
                                        <div class="mt-auto textM-right">
                                            designer@example.com
                                            <br>+00 9876543210
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row pt-4">
                                <div class="col-6 col-sm-6 col-md-3 col-lg-3">
                                    <h6 class="playfair">Billing details</h6>
                                    <div class="theme-Ltext normal-line-height">Ms. Alexandra Botescu <br/>Rue Marbeuf 25 <br/>75008 Paris <br/><stronng class="font-weight-Mbolder">France</strong></div>

                                </div>
                                <div class="col-6 col-sm-6 col-md-3 col-lg-3">
                                    <h6 class="playfair">Payout Details</h6>
                                    <div class="theme-Ltext normal-line-height">Ms. Alexandra Botescu <br/>Rue Marbeuf 25 <br/>75008 Paris <br/><stronng class="font-weight-Mbolder">France</strong></div>

                                </div>
                                <div class="col-6 col-sm-6 col-md-3 col-lg-3">
                                    <h6 class="playfair">Avg. Lead Time</h6>
                                    <div class="form-group">
                                        <label for="time">Time</label>
                                        <select class="form-control" id="time" required="">
                            <option>14 Days</option>
                            <option>20 Days</option>
                            <option>30 Days</option>
                        </select>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-6 col-md-3 col-lg-3 textM-right">
                                    <h6 class="playfair">Total Earned</h6>
                                    <div class="f-40">$ 12.5k</div>
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
                        <p>Designer Status</p>
                    </div>

                    <div class="card-body">

                        <div class="form-group">
                            <label for="status">Notes</label>
                            <select class="form-control" id="status" required="">
                <option>Select status</option>
                <option>Active</option>
                <option>Option 2</option>
            </select>
                        </div>
                        <div class="md-form">
                            <input type="text" id="stitle" class="form-control">
                            <label for="stitle">Appointment Cost(USD/minute)</label>
                        </div>
                        <div><a href="#" class="btn btn-sm btn-dark">Update Designer</a></div>
                    </div>
                </div>



            </section>
        </div>

        <div class="row">
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="box1 text-center">
                    <span class="num">3</span>
                    <div class="editBtn">
                        <a href="#" data-toggle="modal" data-target="#edittext" class="text-dark">
                            <div class="toogleSwitch">
                                <label class="switch">
                                <input type="checkbox">
                                <span class="slider round"></span>
                            </label>Edit
                            </div>
                        </a>
                    </div>
                    <img src="/assets/admin/img/bag.svg" />
                    <h5><a href="designers-order.html">Orders</a></h5>
                    <div class="titleDesc mb-3">Fusce at nisi eget dolor rhoncus facilisis. Mauris ante nisl,</div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="box1 text-center">
                    <span class="num">5</span>
                    <div class="editBtn">
                        <a href="#" data-toggle="modal" data-target="#edittext" class="text-dark">
                            <div class="toogleSwitch">
                                <label class="switch">
                                <input type="checkbox">
                                <span class="slider round"></span>
                            </label>Edit
                            </div>
                        </a>
                    </div>
                    <img src="/assets/admin/img/calendar-line.svg" />
                    <h5><a href="designers-appointment.html">Appointments</a></h5>
                    <div class="titleDesc mb-3">Fusce at nisi eget dolor rhoncus facilisis. Mauris ante nisl,</div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="box1 text-center">
                    <span class="num">8</span>
                    <div class="editBtn">
                        <a href="#" data-toggle="modal" data-target="#edittext" class="text-dark">
                            <div class="toogleSwitch">
                                <label class="switch">
                                <input type="checkbox">
                                <span class="slider round"></span>
                            </label>Edit
                            </div>
                        </a>
                    </div>
                    <img src="/assets/admin/img/gift.svg" />
                    <h5><a href="designers-collection.html">Collection/Portfolio</a></h5>
                    <div class="titleDesc mb-3">Fusce at nisi eget dolor rhoncus facilisis. Mauris ante nisl,</div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="box1 text-center">
                    <div class="editBtn">
                        <a href="#" data-toggle="modal" data-target="#edittext" class="text-dark">
                            <div class="toogleSwitch">
                                <label class="switch">
                                <input type="checkbox">
                                <span class="slider round"></span>
                            </label>Edit
                            </div>
                        </a>
                    </div>
                    <img src="/assets/admin/img/settings.svg" />
                    
                    <h5><a href="designers-made-measure.html">Made to Measure</a></h5>
                    <div class="titleDesc mb-3">Fusce at nisi eget dolor rhoncus facilisis. Mauris ante nisl,</div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="box1 text-center">
                    <div class="editBtn">
                        <a href="#" data-toggle="modal" data-target="#edittext" class="text-dark">
                            <div class="toogleSwitch">
                                <label class="switch">
                                <input type="checkbox">
                                <span class="slider round"></span>
                            </label>Edit
                            </div>
                        </a>
                    </div>
                    <img src="/assets/admin/img/settings.svg" />
                        
                    <h5><a href="designers-trend.html">Sales Report</a></h5>
                    <div class="titleDesc mb-3">Fusce at nisi eget dolor rhoncus facilisis. Mauris ante nisl,</div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="box1 text-center">
                    <span class="num">5</span>
                    <div class="editBtn">
                        <a href="#" data-toggle="modal" data-target="#edittext" class="text-dark">
                            <div class="toogleSwitch">
                                <label class="switch">
                                <input type="checkbox">
                                <span class="slider round"></span>
                            </label>Edit
                            </div>
                        </a>
                    </div>
                    <img src="/assets/admin/img/settings.svg" />
                        
                    <h5><a href="designers-support-ticket.html">Support Tickets</a></h5>
                    <div class="titleDesc mb-3">Fusce at nisi eget dolor rhoncus facilisis. Mauris ante nisl,</div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="box1 text-center">
                    <span class="num">5</span>
                    <div class="editBtn">
                        <a href="#" data-toggle="modal" data-target="#edittext" class="text-dark">
                            <div class="toogleSwitch">
                                <label class="switch">
                                <input type="checkbox">
                                <span class="slider round"></span>
                            </label>Edit
                            </div>
                        </a>
                    </div>
                    <img src="/assets/admin/img/settings.svg" />
                        
                    <h5><a href="designers-packaging.html">Packaging</a></h5>
                    <div class="titleDesc mb-3">Fusce at nisi eget dolor rhoncus facilisis. Mauris ante nisl,</div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="box1 text-center">
                    <div class="editBtn">
                        <a href="#" data-toggle="modal" data-target="#edittext" class="text-dark">
                            <div class="toogleSwitch">
                                <label class="switch">
                                <input type="checkbox">
                                <span class="slider round"></span>
                            </label>Edit
                            </div>
                        </a>
                    </div>
                    <img src="/assets/admin/img/settings.svg" />								
                    <h5><a href="designer-refund.html">Refund Policy</a></h5>
                    <div class="titleDesc mb-3">Fusce at nisi eget dolor rhoncus facilisis. Mauris ante nisl,</div>
                </div>
            </div>
        </div>


    </div>
</section>

@stop

@section('scripts')
<script type="text/javascript"></script>
@stop

@section('styles')
<style type="text/css">
 
</style>
@endsection