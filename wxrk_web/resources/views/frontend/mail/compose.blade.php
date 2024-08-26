@extends('admin.app')

{{-- Web site Title --}}
@section('title') Groups :: @parent @stop

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

					<form class="form" method="post" enctype='multipart/form-data'>
						<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                           
						<div class="box-header with-border">
							<h3 class="box-title">Compose New Message</h3>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<div class="form-group">
								<input class="form-control" placeholder="To:" disabled="disabled" value="{{$emailTo}}">
							</div>
							<div class="form-group">
								<input class="form-control" name="subject" placeholder="Subject:">
							</div>
							<div class="form-group">
								<textarea id="compose-textarea" name="mail" class="form-control" style="height: 300px">
									<h1><u>Heading Of Message</u></h1>
									<h4>Subheading</h4>
									<p>
									Mail text areas, enter your text here
									</p>
									<ul>
										<li>List item one</li>
										<li>List item two</li>>
									</ul>
									<p>Thank you</p>
									<p>Aims Buildmart</p>
								</textarea>
							</div>
							<div class="form-group">
								<div class="btn btn-default btn-file">
									<i class="fa fa-paperclip"></i> Attachment
									<input type="file" name="attachment">
								</div>
							</div>
						</div>
						<!-- /.box-body -->
						<div class="box-footer">
							<div class="pull-right">
							<button type="button" class="btn btn-default"><i class="fa fa-pencil"></i> Draft</button>
							<button type="submit" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Send</button>
							</div>
							<button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Discard</button>
						</div>
						<!-- /.box-footer -->
					</form>
				</div>
					<!-- /. box -->
			</div>
		<!-- /.col -->
		</div>
		<!-- /.row -->
	</section>
<!-- /.content -->
@endsection

@section('styles')
 <link href="/assets/plugins/bootstrap-wysiwyg/style.css" rel="stylesheet" type="text/css" />
@endsection

{{-- Scripts --}}
@section('scripts')
	@parent

<script src='/assets/plugins/bootstrap-wysiwyg/bootstrap-wysiwyg.js'></script>
	
<script type="text/javascript">
	$(function () {
		//Add text editor
		$("#compose-textarea").wysihtml5();
	});

</script>
@endsection