@extends('admin.app')

{{-- Web site Title --}}
@section('title') Labours Accounts :: @parent @stop

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
		<h1>Labour Accounts</h1>
		<ol class="breadcrumb">
			<li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Labour Accounts
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
                        <a href="/admin/accounts/labours/report" class="btn btn-sm pull-right btn-primary"><span class="glyphicon glyphicon-download"></span> Download Report</a>
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
					<div class="box-body">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<div class="row">
									<table id="table" class="table table-bordered table-striped">
			                            <thead>
			                                <tr>
			                                    <th>Name</th>
			                                    <th>Total Recieved</th>
			                                    <th>Month Income</th>
			                                    <th>Month Pending</th>
			                                    <th>Action</th>
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

{{-- Scripts --}}
@section('scripts')

<script src="/assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        
         $(".datepicker").datepicker();

    	var oTable;
        oTable = $('#table').DataTable({
            "order" : [[0, "asc"]],
            "sDom": "<'row'<'col-md-2'l><'col-md-7'a><'col-md-2'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
            //"sPaginationType": "bootstrap",
            "processing": true,
            "serverSide": true,
            "ajax": "{{ URL::to('admin/accounts/labours/data') }}",
			"columns": [
				{ data: 'name', name: 'name' },
				{ data: 'total_income', name: 'total_income',"searchable": false },
				{ data: 'month_income', name: 'month_income',"searchable": false },
				{ data: 'month_pending', name: 'month_pending',"searchable": false },
				{ data: 'actions', name: 'actions',"searchable": false }
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
