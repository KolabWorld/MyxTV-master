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
                        <h2>Payout</h2>
                        <div class="subTitle">Create new</div>
                    </div>
                    <div class="headpanel">
                        <div class="setting">
                            <a href="#">
                                <img src="/assets/admin/img/settings.svg" />
                            </a>
                        </div>									
                        <div class="notify">
                            <a href="#"><img src="/assets/admin/img/notify.svg" /></a>
                        </div>
                        {{-- <div class="setting">
                            <a href="login.html"><img src="/assets/admin/img/logout.png" width="23" style="opacity: 0.8" /></a>
                        </div> --}}
                        <div class="adlogo d-inline-block"><img src="/assets/admin/img/logo.svg" /></div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row mb-2">
            <div class="col-sm-12">
                <div class="backbtnPanel">
                    <div><a href="javascript:history.back()" class="btn btn-sm btn-auto btn-outline-dark">Back</a></div>
                    <div>
                        <a id="save" class="btn btn-sm btn-dark btn-auto">Add Payout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<form role="post-data" method="POST" redirect="/admin/payouts" action="/admin/payouts" enctype="multipart/form-data">
    <section class="content mb-5">
        <div class="container-fluid">
            <div class="row">
                <section class="col-lg-8 connectedSortable">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="myordersData">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="md-form">
                                            <input type="text" placeholder="Enter here" id="transaction_id" value="" name="transaction_id" class="form-control">
                                            <label for="transaction_id">Txn ID</label>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="payout_for">Payout for</label>
                                            <select class="form-control" id="payout_for" name="payout_for" onchange="dropdown('/admin/get-payout-designer/'+this.value, 'designer_id', '');">
                                                <option value="">Select</option>
                                                @foreach ($payout_for as $for)
                                                    <option value="{{ $for }}">{{ ucfirst($for) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="designer_id">Select designer</label>
                                            <select class="form-control" id="designer_id" name="designer_id">
                                                <option>Select</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-6">
                                        <div class="md-form">
                                            <input type="text" id="total_deducted_fee" placeholder="Enter here" name="total_deducted_fee" class="form-control">
                                            <label for="total_deducted_fee">Total fee deducted (in USD)</label>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-6">
                                        <div class="md-form">
                                            <input type="text" id="total_payout" placeholder="Enter here" name="total_payout" class="form-control">
                                            <label for="total_payout">Total payout (in USD)</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="col-lg-4 connectedSortable">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Update</h3>
                            <p>Status</p>
                        </div>

                        <div class="card-body">

                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status">
                                    @foreach ($status as $value)
                                        <option value="{{ $value }}">{{ ucfirst($value) }}</option> 
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
    <input type="button" id="final_submit" data-request="ajax-submit" data-target="[role=post-data]" style="display: none;">

</form>

@stop

@section('scripts')
<script src="{{ asset('js/custom-script.js') }}"></script>
<script src="{{ asset('js/sweetalert.js') }}"></script>
<script type="text/javascript">
$('#save').on('click', function (e) { 
    $('#final_submit').click();
});
</script>
@stop

@section('styles')
<style type="text/css">
 
</style>
@endsection