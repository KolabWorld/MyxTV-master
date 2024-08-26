@extends('admin.app')

{{-- Web site Title --}}
@section('title') Sent Box :: @parent @stop

@section('content')
    <section class="content-header">
	<h1>Mailbox<small></small></h1>
	<ol class="breadcrumb">
	    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
	    <li class="active">Mailbox</li>
	</ol>
    </section>
    <!-- Main content -->
    <section class="content">
		<div class="row">	    
		    <!-- /.col -->
		    <div class="col-md-12">
			    <div class="box box-primary">
					<div class="box-header with-border">
					    <h3 class="box-title">Sent Box</h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body no-padding">
					    <div class="table-responsive mailbox-messages">
							<table id="table"  class="table table-hover table-striped">
						    
								<thead>
									<tr>
										<th></th>
										<th>Email To</th>
										<th>Subject</th>
										<th>Status</th>
										<th>Created At</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
							<!-- /.table -->
				    	</div>
				    <!-- /.mail-box-messages -->
					</div>
				<!-- /.box-body -->	     
			    </div>
			</div>
		    <!-- /. box -->
		</div>
	<!-- /.row -->
    </section>
<!-- /.content -->
@endsection

{{-- Scripts --}}
@section('scripts')
    @parent

<script type="text/javascript">
		var oTable;
		$(document).ready(function () {
			oTable = $('#table').DataTable({
				"order" : [[1, "desc"]],
				"sDom": "<'row'<'col-md-2'l><'col-md-7'a><'col-md-2'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
				//"sPaginationType": "bootstrap",
				"processing": true,
				"serverSide": true,
				"ajax": "{{ URL::to('admin/mail/data/') }}",
				"fnDrawCallback": function (oSettings) {
				}
			});
		});
	</script>
@endsection