
@if (isset($status))
	<div class="pad margin no-print">
		<div class="alert alert-{{$status['code']}} alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">×</span>
			</button>
			<h4>
				<i class="icon fa fa-ban"></i> {{ $status['header'] }}
			</h4>
			<ul>
				@foreach ($status['messages'] as $m)
					<li>{{$m}}</li>
				@endforeach
			</ul>
		</div>
	</div>
@endif

@if (count($errors) > 0)
	<div class="pad margin no-print">
		<div class="alert alert-danger alert-dismissible fade in">
			There were some problems adding offer.<br />
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	</div>
@endif
