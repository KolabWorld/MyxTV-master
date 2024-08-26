@extends('admin/app')
{{-- Web site Title --}}
@section('title') Manage Slider :: @parent @stop
@section('content')

<div class="content-header">
    <div class="container-fluid mt-3">
        <div class="row mb-2">
            <div class="col-sm-12 col-md-12 col-12">
                <div class="tophead">
                    <div class="allTitle">
                        <a class="d-block d-lg-none" data-widget="pushmenu" href="#" role="button"><img src="/assets/admin/img/menu-left-alt.svg" width="18px" /></a>
                        <h2>
                            {{ $heading }}
                        </h2>
                        <div class="subTitle">Add</div>
                    </div>
                    <div class="headpanel">
                        <div class="setting">
                            <a href="#">
                                <img src="/assets/admin/img/settings.svg" />
                            </a>
                        </div>
                        <div class="notify">
                            <a href="#">
                                <img src="/assets/admin/img/notify.svg" />
                            </a>
                        </div>
                        <!-- <div class="setting">
                            <a href="{{ url('admin/admin-logout') }}"><img src="/assets/admin/img/logout.png" width="23" style="opacity: 0.8"></a>
                        </div>  -->
                        <div class="adlogo d-inline-block">
                            <img src="/assets/frontend/img/logo/logo-black.png">
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row mb-2">
            <div class="col-sm-12">
                <div class="backbtnPanel">
                    <div>
                        <a href="/admin/sliders?type={{ $type }}" class="btn btn-sm btn-auto btn-outline-dark">Back</a>
                    </div>
                    <div>
                        <button type="button" id="save" class="btn btn-sm btn-dark btn-auto">Add Section</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="content mb-5">
    <div class="container-fluid">
        {!! Form::open(['action' => 'Admin\Master\SliderController@store', 'id'=>"post-data", 'method'=>'POST', 'enctype' => 'multipart/form-data']) !!}
            <div class="row">
                <section class="col-lg-8 connectedSortable">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="myordersData">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="stitle">Type</label>
                                            <select class="form-control" id="type" name="type" required="">
                                                <option value="{{ $type }}" {{ old('type') == $type ? 'selected':'' }}>
                                                    {{ ucfirst($type) }}
                                                </option>
                                            </select>
                                        </div>
                                        @error('type')
                                            <label class="label">
                                                <strong class="text-danger"> {{ $message }}</strong>
                                            </label>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="md-form">
                                            <input type="text" id="stitle" name="title" value="{{ old('title') }}" placeholder="Enter the Slider Title here" class="form-control">
                                            <label for="stitle">Title</label>
                                        </div>
                                        @error('title')
                                            <label class="label">
                                                <strong class="text-danger"> {{ $message }}</strong>
                                            </label>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="md-form">
                                            <input type="text" id="stitle" name="description" value="{{ old('description') }}" placeholder="Enter the Description here" class="form-control">
                                            <label for="stitle">Description</label>
                                        </div>
                                        @error('description')
                                            <label class="label">
                                                <strong class="text-danger"> {{ $message }}</strong>
                                            </label>
                                        @enderror
                                    </div>
                                </div>
                                @if($type != 'hero-section')
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="md-form">
                                                <input type="text" id="stitle" name="button_text" value="{{ old('button_text') }}" placeholder="Enter the button text here" class="form-control">
                                                <label for="stitle">Button Text</label>
                                            </div>
                                            @error('button_text')
                                                <label class="label">
                                                    <strong class="text-danger"> {{ $message }}</strong>
                                                </label>
                                            @enderror
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="md-form">
                                                <input type="text" id="stitle" name="button_url" value="{{ old('button_url') }}" placeholder="Enter the button url here" class="form-control">
                                                <label for="stitle">Button Url</label>
                                            </div>
                                            @error('button_url')
                                                <label class="label">
                                                    <strong class="text-danger"> {{ $message }}</strong>
                                                </label>
                                            @enderror
                                        </div>
                                    </div>
                                @endif
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="stitle1">Attachment Type</label>
                                            <select class="form-control" id="attachment_type" name="attachment_type" onchange="vedioAttchment(this, 'autoplay_id')" required="">
                                                <option value="">Select Attachment Type</option>
                                                @foreach ($attachmentTypes as $value)
                                                    <option value="{{ $value }}" {{ old('attachment_type') == $value ? 'selected':'' }}>{{ ucfirst($value) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('attachment_type')
                                            <label class="label">
                                                <strong class="text-danger"> {{ $message }}</strong>
                                            </label>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6" id="autoplay_id" style="display: none;">
                                        <div class="form-group">
                                            <label for="stitle1">Autoplay</label>
                                            <select class="form-control" id="is_auto_play" name="is_auto_play">
                                                <option value="">Select Autoplay</option>
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                            </select>
                                        </div>
                                        @error('attachment_type')
                                            <label class="label">
                                                <strong class="text-danger"> {{ $message }}</strong>
                                            </label>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <div class="md-form upload-btn-wrapper2">
                                            <input type="file" id="inputFile" name="attachment" accept="image/gif, image/jpeg, image/png, video/mp4, video/mov, video/avi" placeholder="Enter the Title here" class="form-control" value="Title of the Image" data-filename-placement="inside" required>
                                            <label for="stitle" class="active">Portfolio Image</label>
                                            <button class="uploadBtn2">Browse File</button>
                                            <!-- <a href="#" class="delBtn"><img src="/assets/admin/img/delete.svg" /></a> -->
                                        </div>
                                        @error('attachment')
                                            <label class="label">
                                                <strong class="text-danger"> {{ $message }}</strong>
                                            </label>
                                        @enderror
                                        <div class="image-content">    
                                            <h4 class="f-13 mt-4 theme-Dtext playfair">Upload Portfolio Image</h4>
                                            <p class="f-12 theme-Ltext">Dimension: 1024 px x 1024 px<br>Ratio: 1:1</p>
                                            <p class="f-12 theme-Ltext">Format: JPEG, JPG, PNG only<br>Mode: sRGB</p>
                                            <p class="f-12 theme-Ltext">Weight: Less than 3mb</p>
                                            <p class="f-12 theme-Ltext">Please note that the image should not contain any kind of watermark and you have the appropriate legal rights to publish the image.</p>
                                        </div>
                                        <div class="video-content" style="display:none;">    
                                            <h4 class="f-13 mt-4 theme-Dtext playfair">Upload Portfolio Video</h4>
                                            <p class="f-12 theme-Ltext">Dimension: 1920 px x 1080 px<br>Ratio: 1:1</p>
                                            <p class="f-12 theme-Ltext">Format: MOV, MP4, AVI onl</p>
                                            <p class="f-12 theme-Ltext">Weight: Less than 150mb</p>
                                            <p class="f-12 theme-Ltext">Please note that the video should not contain any kind of watermark and you have the appropriate legal rights to publish the video.</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <img src="/assets/common/img/dummy.png" class="border w-100" id='image_upload_preview' />

                                        <video width="100%" muted style="object-fit: cover;display: none;" class="video_upload_preview" controls>
                                            <source id="video_upload_preview" src="">
                                        </video>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    
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
                                <select class="form-control" name="status" id="status" required="">
                                    @foreach ($status as $value)
                                        <option value="{{ $value }}" {{ old('status') == $value ? 'selected':'' }}>{{ ucfirst($value) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        {!! Form::close() !!} 
    </div>
</section>

@endsection

@section('scripts')
    <script src="{{ asset('js/custom-script.js') }}"></script>
    <script src="{{ asset('js/sweetalert.js') }}"></script>
    <script type="text/javascript">
        $('#save').on('click', function (e) { 
            $('#post-data').submit();
        });
    </script>
    <script type="text/javascript">
        $('#inputFile').on('change', function() {
            var file = this.files[0];
            var fileType = file["type"];
            console.log(fileType)
            var validImageTypes = ["image/jpeg", "image/jpg", "image/png"];
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
    <script type="text/javascript">
        function vedioAttchment(th){
            var type = $('#attachment_type').val();
            console.log(type);

            if(type == 'video'){
                $('#autoplay_id').css('display', 'block');
                $('.image-content').css('display', 'none');
                $('.video-content').css('display', 'block');
            }
            else{
                $('#autoplay_id').css('display', 'none');
                $('.video-content').css('display', 'none');
                $('.image-content').css('display', 'block');
            }
        }
    </script>
@stop

@section('styles')
    <style type="text/css">
    
    </style>
@endsection