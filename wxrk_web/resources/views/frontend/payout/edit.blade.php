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
                        <div class="subTitle">Update Status</div>
                    </div>
                    <div class="headpanel">
                        <div class="setting">
                            <a href="#">
                                <img src="/assets/admin/img/settings.svg" />
                            </a>
                        </div>									
                        <div class="notify">
                            <a href="#">
                                <img src="/assets/admin/img/notify.svg" />
                            </a>
                        </div>
                        {{-- <div class="setting">
                            <a href="#">
                                <img src="/assets/admin/img/logout.png" width="23" style="opacity: 0.8" />
                            </a>
                        </div> --}}
                        <div class="adlogo d-inline-block">
                            <img src="/assets/admin/img/logo.svg" />
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row mb-2">
            <div class="col-sm-12">
                <div class="backbtnPanel">
                    <div>
                        <a href="/admin/payouts" class="btn btn-sm btn-auto btn-outline-dark">Back</a></div>
                    <div>
                        @if($payout->status == 'transfered') 
                            <a class="btn btn-sm btn-dark btn-auto disabled" >Update Payout</a>
                        @else 
                            <button type="button" id="update" class="btn btn-sm btn-dark btn-auto">Update Payout</button>    
                        @endif 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{!! Form::open(array('url'=>'/admin/payouts/'.$payout->id , 'method'=>'PUT', 'id'=>'post-data', 'enctype'=>'multipart/form-data' ))!!}
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
                                            <input type="text" placeholder="Enter here" id="transaction_id" value="{{$payout->transaction_id}}" class="form-control" readonly="true">
                                            <label for="transaction_id">Txn ID</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="payout_for">Payout for</label>
                                            <select class="form-control" id="payout_for" readonly="true">
                                                <option value="{{$payout->payout_for}}">{{ ucfirst($payout->payout_for) }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="designer_id">Select designer</label>
                                            <select class="form-control" id="designer_id" readonly="true">
                                                <option value="{{$payout->designer ? $payout->designer->name : ''}}">{{ ucfirst($payout->designer ? $payout->designer->name : '') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-6">
                                        <div class="md-form">
                                            <input type="text" id="total_deducted_fee" placeholder="Enter here" value="{{(int)$payout->total_deducted_fee}}" class="form-control" disabled="true">
                                            <label for="total_deducted_fee">Total fee deducted (in USD)</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="md-form">
                                            <input type="text" id="total_payout" placeholder="Enter here" value="{{(int)$payout->total_payout}}" class="form-control" disabled="true">
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
                                    @if($payout->status == 'processing')
                                    <option value="transfered">Transfer</option>
                                    @elseif($payout->status == 'transfered') 
                                        <option value="transfered">Transfered</option>
                                    @else 
                                        <option value="processing">Processing</option> 
                                        <option value="transfer">Transfer</option>
                                        <option value="decline">Decline</option>

                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
{!! Form::close() !!} 

@stop

@section('scripts')
<script src="{{ asset('js/custom-script.js') }}"></script>
<script src="{{ asset('js/sweetalert.js') }}"></script>
<script type="text/javascript">
    $('#update').on('click', function (e) { 
        // $('#final_submit').click();
        $('#post-data').submit();
    });
</script>
@stop

@section('styles')
<style type="text/css">
 
</style>
@endsection