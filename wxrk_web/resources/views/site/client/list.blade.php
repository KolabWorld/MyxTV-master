@extends('invoice/app')

{{-- Web site Title --}}
@section('title') List Clients :: @parent @stop

@section('content')
	<div id="content">
		<div id="filter_results">
			<div class="table-responsive">
				<table class="table table-striped" id="table">
					<thead>
						<tr>
							<th>Name</th>
							<th>Email</th>
							<th>Phone</th>
							<th>State</th>
							<th>Options</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>    
		</div>
	</div>
@stop 

@section('styles')
<!-- DATA TABLES -->
    <link href="/assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
@endsection

{{-- Scripts --}}
@section('scripts')
    @parent

	<!-- DATA TABES SCRIPT -->
	<script src="/assets/plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
	<script src="/assets/plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>

    <script src="{{asset('assets/admin/js/datatables.fnReloadAjax.js')}}"></script>

	<script type="text/javascript">
        var oTable;
        $(document).ready(function () {
            oTable = $('#table').DataTable({
                "order" : [[1, "desc"]],
                "sDom": "<'row'<'col-md-2'l><'col-md-7'a><'col-md-2'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
                //"sPaginationType": "bootstrap",
                "processing": true,
                "serverSide": true,
                "ajax": "{{ URL::to('invoice/clients/data/') }}"
            });
        });
    </script>
@endsection