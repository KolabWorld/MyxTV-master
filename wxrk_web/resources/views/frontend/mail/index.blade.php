@extends('admin.app')

{{-- Web site Title --}}
@section('title') Groups :: @parent @stop


@section('content')
    <section class="content-header">
      <h1>
        Mailbox
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Mailbox</li>
      </ol>
</section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-3">
          <a href="mailbox.html" class="btn btn-primary btn-block margin-bottom">Compose</a>

          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Folders</h3>

              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body no-padding">
              <ul class="nav nav-pills nav-stacked">
               
                <li><a href="#"><i class="fa fa-envelope-o"></i> Sent</a></li>
                <li><a href="#"><i class="fa fa-file-text-o"></i> Drafts</a></li>
              </ul>
            </div>
            <!-- /.box-body -->
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