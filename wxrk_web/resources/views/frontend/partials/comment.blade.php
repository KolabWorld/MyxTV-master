<div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Comments</h3>
                </div>
                <form action="{{$url}}" method="POST"> 
                    @csrf
                    <div class="panel-body">
                        <h4>
                            <strong>Remark</strong>
                        </h4>
                        <div class="row">
                            <div class="col-sm-12 nopadding">
                                <div class="form-group">
                                    <textarea id="description-textarea" name="remark" rows="3" cols="80" class="form-control" style="height:100px;"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" value="1" name="is_private"> Is Private</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="reset" class="btn btn-warning close_popup">
                            <span class="glyphicon glyphicon-ban-circle"></span> {{trans("admin/modal.cancel") }}
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <span class="glyphicon glyphicon-ok-circle"></span>
                            {{trans("admin/modal.create") }}
                        </button>
                    </div>
                </form>
                <div class="box-body chat" style="padding:2%;">
                    <!-- chat item -->
                    @foreach($comments as $comment)
                        <div class="row" style="background: #eee;margin-bottom:2%;">
                            <div class="col-md-12">
                                <h4>
                                    {!! $comment->remark !!}
                                </h4>
                                <h5 class="text-muted">
                                    <i class="fa fa-clock-o"></i> {{date('d M Y H:i:s', strtotime($comment->created_at))}}
                                    <a href="/admin/comment/{{$comment->id}}/delete" class="btn btn-danger btn-xs">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </h5>
                            </div>
                        </div>
                    @endforeach
                </div> 
            </div>
        </div>
        <div class="col-md-6">
            <!-- general form elements -->
            
        </div><!--/.col (left) -->
    </div>   <!-- /.row -->