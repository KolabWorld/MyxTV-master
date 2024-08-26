@extends('admin.app')

{{-- Web site Title --}}
@section('title') User Account :: @parent @stop

@section('content')
	@if (isset($status))
		<div class="pad margin no-print">
			<div class="alert alert-{{$status['code']}} alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
				<h4><i class="icon fa fa-ban"></i> {{ $status['header'] }}</h4>
				<ul>
					@foreach ($status['messages'] as $m)
						<li>{{$m}}</li>
					@endforeach
				</ul>
			</div>
		</div>
	@endif

	<section class="content-header">
		<h1>Wallet Debits :: {{$wallet->user->name}}</h1>
		<ol class="breadcrumb">
			<li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Accounts
			</li>
		</ol>
		<br>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-md-7">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Report Filter</h3>
                        <!-- <a href="/admin/accounts/user/{{$wallet->id}}/report" class="btn btn-sm pull-right btn-primary"><span class="glyphicon glyphicon-download"></span> Download Report</a> -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body clearfix">

                        <form method='get' >
                            <div class="pull-left">
                               <input type=text name="from" class="datepicker" data-date-format="yyyy-mm-dd" value='{{$from}}'>
                            </div>
                             <div class="pull-left">
                                <input type=text name="to" class="datepicker" data-date-format="yyyy-mm-dd" value='{{$to}}'>
                            </div>
                            <div class="pull-right">
                                <button type=submit class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-filter"></span> Filter Data</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<!-- general form elements -->
				<div class="box box-primary">
					<div class="box-header">
						<ul class="nav nav-tabs" style="clear:both;">
							<li><a href="/admin/accounts/user/{{$wallet->id}}/view">Credits</a></li>
							<li class="active"><a href="/admin/accounts/user/{{$wallet->id}}/debits">Debits</a></li>
							 <li><a href="/admin/accounts/user/{{$wallet->id}}/transfers">Transfers</a></li>
							<li><a href="/admin/accounts/user/{{$wallet->id}}/transactions">Transactions</a></li>
						</ul>

					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<div class="row">
									<table id="table" class="table table-bordered table-striped">
			                            <thead>
			                                <tr>
			                                    <th>Date</th>
			                                    <th>Type</th>
			                                    <th>Amount</th>
			                                    <th>Description</th>
			                                    <th>Status</th>
			                                    <th>Remark</th>
			                                    <th>Created At</th>
			                                    <th>Actions</th>
			                                </tr>
			                            </thead>
			                            <tbody></tbody>
			                        </table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection

@section('styles')
            
<link rel="stylesheet" href="/assets/plugins/timepicker/bootstrap-timepicker.min.css" type='text/css'>
@stop

{{-- Scripts --}}
@section('scripts')

<script src="/assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>

<script type="text/javascript">
	var oTable;

    function rejectRecord(id) {
    	bootbox.prompt({ 
			size: "small",
			title: "Cancellation Remark",
		    inputType: 'textarea',
		    callback: function (result) {
		  		if (result) {
			        $.ajax({
			        	data : {
			        		'remark' : result,
			        		'_token' : '{{{csrf_token()}}}'
			        	},
			        	method: 'POST',
			            url: "/admin/user-debit/"+id+"/reject",
			            async: false,
			            success: function(json){
				  			bootbox.alert({ 
								size: "small",
								message: "Record rejected.",
							});
							oTable.ajax.reload();
						}
					});
		  		}
			}
		})
    }

    function approveRecord(id) {
    	bootbox.confirm({ 
			size: "small",
			message: "Are you sure?", 
			callback: function(result){ 
		  		if (result) {
			        $.ajax({
			            url: "/admin/user-debit/"+id+"/approve",
			            async: false,
			            success: function(json){
				  			bootbox.alert({ 
								size: "small",
								message: "Record approved.",
							});
							oTable.ajax.reload();
						}
					});
		  		}
			}
		})
    }

    function resetRecord(id) {
    	bootbox.confirm({ 
			size: "small",
			message: "Are you sure?", 
			callback: function(result){ 
		  		if (result) {
			        $.ajax({
			            url: "/admin/user-debit/"+id+"/reset",
			            async: false,
			            success: function(json){
				  			bootbox.alert({ 
								size: "small",
								message: "Record reset.",
							});
							oTable.ajax.reload();
						}
					});
		  		}
			}
		})
    }

    $(document).ready(function() {
        
        $(".timepicker").timepicker({
            showMeridian: false,
            showInputs: false
        });

        $(".datepicker").datepicker();

        oTable = $('#table').DataTable({
            "order" : [[0, "desc"]],
            "sDom": "<'row'<'col-md-2'l><'col-md-7'a><'col-md-2'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
            //"sPaginationType": "bootstrap",
            "processing": true,
            "serverSide": true,
            "ajax": "{{ URL::to('admin/accounts/user/'.$wallet->id.'/debits-data') }}",
			"columns": [
				{ data: 'date', name: 'date' },
				{ data: 'type', name: 'type' },
				{ data: 'amount', name: 'amount' },
				{ data: 'description', name: 'description' },
				{ data: 'status', name: 'status' },
				{ data: 'remark', name: 'remark' },
				{ data: 'created_at', name: 'created_at' },
				{ data: 'actions', name: 'actions' }
			],
            "fnDrawCallback": function (oSettings) {
                $(".iframe").colorbox({
                    iframe: true,
                    width: "80%",
                    height: "80%",
                    onClosed: function () {
                        window.location.reload();
                    }
                });
            }
        });

    });

</script>
@endsection
