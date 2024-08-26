@extends('invoice/app')

{{-- Web site Title --}}
@section('title') List Invoices :: @parent @stop

@section('content')

	@if (isset($status))
    <div class="alert alert-{{$status['code']}} alert-dismissible fade in">
        <!-- <h3>{{$status['header']}}</h3><br /> -->
        <ul>
            @foreach ($status['messages'] as $msg)
                <li>{{ $msg }}</li>
            @endforeach
        </ul>
    </div>
    @endif
	<div id="content">
		<div id="filter_results">
			<div class="table-responsive">
				<table id="table" class="table table-striped">
					<thead>
						<tr>
							<th>Invoice No.</th>
							<th>State</th>
							<th style="width: 20%;">Client</th>
							<th style="text-align: right;">Amount</th>
							<th>Created By</th>
							<th>Status</th>
							<th>Created At</th>
							<th>Options</th>
						</tr>
					</thead>

					<tbody>
							
					</tbody>
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
                "ajax": "{{ URL::to('invoices/data/') }}",
				"columns": [
		            { data: 'uid', name: 'uid' },
		            { data: 'state_id', name: 'state_id' },
		            { data: 'client_id', name: 'client_id' },
		            { data: 'total', name: 'total' },
		            { data: 'created_by', name: 'created_by' },
		            { data: 'status', name: 'status' },
		            { data: 'created_at', name: 'created_at' },
		            { data: 'actions', name: 'actions' }
		        ],
            });
        });
    </script>
@endsection