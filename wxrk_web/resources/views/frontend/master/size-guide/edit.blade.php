@extends('admin/app')
{{-- Web site Title --}}
@section('title') Size Guide :: @parent @stop
@section('content')

<div class="content-header">
    <div class="container-fluid mt-3">
        <div class="row mb-2">
            <div class="col-sm-12 col-md-12 col-12">
                <div class="tophead">
                    <div class="allTitle">
                        <a class="d-block d-lg-none" data-widget="pushmenu" href="#" role="button"><img src="/assets/admin/img/menu-left-alt.svg" width="18px" /></a>
                        <h2>Size guides</h2>
                        <div class="subTitle">Edit</div>
                    </div>
                    <div class="headpanel">
                        <div class="setting">
                            <a href="account-setting.html"><img src="/assets/admin/img/settings.svg" /></a>
                        </div>
                        <div class="notify">
                            <a href="#"><img src="/assets/admin/img/notify.svg" /></a>
                        </div>
                        <!-- <div class="setting">
                            <a href="{{ url('admin/admin-logout') }}"><img src="/assets/admin/img/logout.png" width="23" style="opacity: 0.8"></a>
                        </div>  -->
                        <div class="adlogo d-inline-block"><img src="/assets/frontend/img/logo/logo-black.png" /></div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row mb-2">
            <div class="col-sm-12">
                <div class="backbtnPanel">
                    <div><a href="javascript:history.back()" class="btn btn-sm btn-auto btn-outline-dark">Back</a></div>
                    <div><button type="button" id="update" class="btn btn-sm btn-dark btn-auto">Update Size Guide</button></div>
                </div>
            </div>
        </div>

    </div>
</div>

<section class="content mb-5">
    <div class="container-fluid">
        <div class="row">
            <section class="col-lg-8 connectedSortable">
            {!! Form::open(['action' => ['Admin\Master\ProductSizeGuideController@update', $productSizeGuide->id], 'id'=>"post-data", 'method'=>'PUT', 'enctype' => 'multipart/form-data']) !!}
                <div class="row">
                    <div class="col-lg-12">
                        <div class="myordersData">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="md-form">
                                        <input type="text" id="stitle" placeholder="Enter the Title here" name="title" value="{{ $productSizeGuide->title }}" class="form-control" value="Title of the Image">
                                        <label for="stitle">Size guide title</label>
                                    </div>
                                    @error('title')
                                        <label class="label">
                                            <strong class="text-danger"> {{ $message }}</strong>
                                        </label>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <div class="md-form upload-btn-wrapper2">
                                        <input type="file" id="inputFile" accept="image/gif, image/jpeg, image/png, video/mp4, video/mov, video/avi" onchange="renderImage(this, 'preview')" placeholder="Enter the Title here" class="form-control" name="size_image" value="Title of the Image">
                                        <label for="stitle" class="active">Upload</label>
                                        <button class="uploadBtn2">Browse File</button>
                                        <!-- <a href="#" class="delBtn" data-url="/admin/delete-media/{{ isset($productSizeGuide->media[0]) ? $productSizeGuide->media[0]->id:'' }}" data-request="remove" data-redirect="/admin/size-guides/{{ $productSizeGuide->id }}/edit">
                                            <img src="/assets/admin/img/delete.svg" />
                                        </a> -->
                                    </div>
                                    @error('size_image')
                                        <label class="label">
                                            <strong class="text-danger"> {{ $message }}</strong>
                                        </label>
                                    @enderror
                                    <h4 class="f-13 mt-4 theme-Dtext playfair">Upload Size Guide Image</h4>
                                    <p class="f-12 theme-Ltext">Dimension: 1024 px x 1024 px<br>Ratio: 1:1</p>
                                    <p class="f-12 theme-Ltext">Format: JPEG, JPG, PNG only<br>Mode: sRGB</p>
                                    <p class="f-12 theme-Ltext">Weight: Less than 3mb</p>
                                    <p class="f-12 theme-Ltext">Please note that the image should not contain any kind of watermark and you have the appropriate legal rights to publish the image.</p>
                                    <h4 class="f-13 mt-4 theme-Dtext playfair">Upload Size Guide Video</h4>
                                    <p class="f-12 theme-Ltext">Dimension: 1920 px x 1080 px<br>Ratio: 1:1</p>
                                    <p class="f-12 theme-Ltext">Format: MOV, MP4, AVI only</p>
                                    <p class="f-12 theme-Ltext">Weight: Less than 150mb</p>
                                    <p class="f-12 theme-Ltext">Please note that the video should not contain any kind of watermark and you have the appropriate legal rights to publish the video.</p>
                          
                                </div>
                                <div class="col-md-6">
                                    <video width="100%" muted style="object-fit: cover; display:{{ isset($productSizeGuide->media[0]) && $productSizeGuide->media[0]->mime_type =='video/mp4' ? '' :'none;'}}" class="video_upload_preview" controls>
                                        <source id="video_upload_preview" src="{{ $productSizeGuide->size_image ? $productSizeGuide->size_image :'' }}">
                                    </video>
                                    <img id="image_upload_preview" style="display:{{ isset($productSizeGuide->media[0]) && $productSizeGuide->media[0]->mime_type !='video/mp4' ? '' :'none;'}}" src="{{ $productSizeGuide->size_image ? $productSizeGuide->size_image :'/assets/admin/img/image.svg' }}" class="border w-100" />
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
                                @foreach ($status as $value)
                                <option value="{{ $value }}" {{ $productSizeGuide->status == $value ? 'selected' :'' }}> {{ ucfirst($value) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </section>
        {!! Form::close() !!} 
        </div>
    </div>
</section>

@stop

@section('scripts')
<script src="{{ asset('js/custom-script.js') }}"></script>
<script src="{{ asset('js/sweetalert.js') }}"></script>
<script type="text/javascript">
$('#update').on('click', function (e) { 
    $('#post-data').submit();
});
$('#inputFile').on('change', function() {
    var file = this.files[0];
    var fileType = file["type"];
    console.log(fileType)
    var validImageTypes = ["image/jpeg", "image/png"];
    if ($.inArray(fileType, validImageTypes) < 0) {
        videoRender(this, 'video_upload_preview');
        $('#image_upload_preview').hide();
        $('.video_upload_preview').show();

    } else {
        renderImage(this, 'image_upload_preview');
        $('.video_upload_preview').hide();
        $('#image_upload_preview').show();

    }
});
</script>
@stop

@section('styles')
<style type="text/css">
 
</style>
@endsection