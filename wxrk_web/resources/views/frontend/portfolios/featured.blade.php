@extends('admin.app')
<!-- Main Container  -->
@section('content')
@include('admin.partials.header',['title'=>$designer['name'],'description'=>'Manage & update'])

<section class="content mb-5">
    {!! Form::open(['action' => ['Admin\PortfoliosController@storeFeatured', $designer->id],'method' => 'post', 'id'=>'post-data','enctype' => 'multipart/form-data' ]) !!}
    <div class="container-fluid">
        <div class="row mb-2" style="margin-top:-15px">
            <div class="col-sm-12 mb-3">
                <div class="backbtnPanel">
                    <div><a href="javascript:history.back()" class="btn btn-sm btn-auto btn-outline-dark waves-effect waves-light">Back</a></div>
                    <div><button type='submit' class="btn btn-md btn-dark btn-auto mb-0 waves-effect waves-light">Update Section</button></div>
                </div>
            </div>
        </div>

        <div class="row">
            <section class="col-lg-8 connectedSortable">

                <div class="row">

                    <div class="col-lg-12">
                        <div class="myordersData">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="md-form upload-btn-wrapper2">
                                        <input type="file" id="inputFileVideo" accept="video/mp4, video/mov, video/avi" name="attachment_video" placeholder="Choose any video" class="form-control" value="Featured Video" data-filename-placement="inside">
                                        <label for="stitle" class="active">Featured Video</label>
                                        <button class="uploadBtn2">Browse File</button>
                                        <!-- <a href="#" class="delBtn"><img src="/assets/admin/img/delete.svg" /></a> -->
                                    </div>
                                    @error('attachment')
                                    <label class="label">
                                        <strong class="text-danger"> {{ $message }}</strong>
                                    </label>
                                    @enderror
                                    <h4 class="f-13 mt-4 theme-Dtext playfair">Upload Featured Video</h4>
                                    <p class="f-12 theme-Ltext">Dimension: 1920 px x 1080 px<br>Ratio: 1:1</p>
                                    <p class="f-12 theme-Ltext">Format: MOV, MP4, AVI only</p>
                                    <p class="f-12 theme-Ltext">Weight: Less than 150mb</p>
                                    <p class="f-12 theme-Ltext">Please note that the video should not contain any kind of watermark and you have the appropriate legal rights to publish the video.</p>

                                </div>
                                <div class="col-md-6">
                                    <video width="100%" muted style="object-fit: cover;" id="video_preview" @if($featuredVideo) autoplay=1  @endif controls>
                                        <source id="video_upload_preview" src="{{$featuredVideo ? $featuredVideo->attachment : ''}}">
                                    </video>
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
                            <select class="form-control" id="status_video" name='status_video' required="">
                                @foreach ($status as $value)
                                <option value="{{ $value }}" {{$featuredVideo && $featuredVideo->status==$value?'selected':''}}>{{ ucfirst($value) }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- <div>
                            <button type='submit' class="mt-3 mb-3 btn btn-md btn-dark btn-auto mb-0 waves-effect waves-light">Update status</button>
                        </div> --}}
                    </div>
                </div>
            </section>

        </div>

        <div class="border-top mt-4 mb-4"></div>

        <div class="row">

            <section class="col-lg-8 connectedSortable">

                <div class="row">

                    <div class="col-lg-12">
                        <div class="myordersData">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="md-form upload-btn-wrapper2">
                                        <input type="file" id="inputFile" accept="image/gif, image/jpeg, image/jpg, image/png" name="attachment_image" placeholder="Enter the Title here" class="form-control" value="Featured Image" data-filename-placement="inside">
                                        <label for="stitle" class="active">Featured Image</label>
                                        <button class="uploadBtn2">Browse File</button>
                                        <!-- <a href="#" class="delBtn"><img src="/assets/admin/img/delete.svg" /></a> -->
                                    </div>
                                    @error('attachment')
                                    <label class="label">
                                        <strong class="text-danger"> {{ $message }}</strong>
                                    </label>
                                    @enderror
                                    <h4 class="f-13 mt-4 theme-Dtext playfair">Upload Featured Image</h4>
                                    <p class="f-12 theme-Ltext">Dimension: 1024 px x 1024 px<br>Ratio: 1:1</p>
                                    <p class="f-12 theme-Ltext">Format: JPEG, JPG, PNG only<br>Mode: sRGB</p>
                                    <p class="f-12 theme-Ltext">Weight: Less than 3mb</p>
                                    <p class="f-12 theme-Ltext">Please note that the image should not contain any kind of watermark and you have the appropriate legal rights to publish the image.</p>

                                </div>
                                <div class="col-md-6">
                                    <img src="{{$featuredImage ? $featuredImage->attachment : '/assets/common/img/dummy.png'}}" class="border w-100" id='image_upload_preview' />

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
                            <select class="form-control" id="status_image" name='status_image' required="">
                                @foreach ($status as $value)
                                <option value="{{ $value }}" {{$featuredImage && $featuredImage->status==$value?'selected':''}}>{{ ucfirst($value) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- <div>
                            <button type='submit' class="mt-3 mb-3 btn btn-md btn-dark btn-auto mb-0 waves-effect waves-light">Update status</button>
                        </div> -->
                    </div>
                </div>
            </section>
            
        </div>
    </div>
    {!! Form::close() !!}
</section>
@endsection
@section('scripts')
<script type="text/javascript">
    function readURL(input, output) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $(output).attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function readVideoURL(input) {

        $('#video_upload_preview').remove();
        const video = document.getElementById('video_preview');
        const videoSource = document.createElement('source');

        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                videoSource.setAttribute('src', e.target.result);
                videoSource.setAttribute('id', 'video_upload_preview');
                video.appendChild(videoSource);
                video.load();
                video.play();
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#inputFile").change(function() {
        readURL(this, '#image_upload_preview');
    });

    $("#inputFileVideo").change(function() {
        readVideoURL(this);
    });
</script>
@stop