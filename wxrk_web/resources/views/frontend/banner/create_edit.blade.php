@extends('frontend.app')

{{-- Web site Title --}}
@section('title') :: @parent @stop

@section('content')

    @include('frontend.partials.nav', [
        'title' => 'Advertisement',
        'description' => 'Add/Edit',
    ])

    <section class="content mb-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row align-items-center position-top-sticky">
                        <div class="col-sm-5 d-none d-sm-block">
                            <a href="/banners" class="btn btn-outline-secondary">Go Back</a>
                        </div>
                        <div class="col-sm-7 text-sm-right">
                            <button type="button" data-request="ajax-submit" data-target="[role=post-data]" id="save"
                                class="btn btn-success mr-2">
                                @if($banner && $banner->id)
                                    Update
                                @else
                                    Submit
                                @endif
                            </button>
                            <a href="/banners" class="btn btn-danger">Cancel</a>
                        </div>
                    </div>

                    <div class="dashbed-border-bottom mt-2 mb-3"></div>

                    <form method="post" action="{{ $action }}" redirect="/banners" role="post-data"
                        enctype="multipart/form-data">
                        @if($banner && $banner->id)
                            @method('PUT')
                        @endif
                        <div class="row">
                            <div class="col-md-8">
                                <div class="accordion addformaccordian" id="addAccordian">
                                    <div class="card formCard">
                                        <div class="card-header">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link" type="button" data-toggle="collapse"
                                                    data-target="#Equipment">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="head-title form-head">
                                                                <h2>Advertisement</h2>
                                                                <h5>Details</h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="Equipment" class="collapse show" data-parent="#addAccordian">
                                            <div class="card-body pt-2">
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <div class="row">
                                                            {{--  <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>Type</label>
                                                                    <select name="type" class="form-control">
                                                                        <option value="">Select</option>
                                                                        @foreach($types as $type)
                                                                            <option value="{{$type}}" {{ $banner->type == $type ? 'selected' : '' }}>
                                                                                {{ucFirst($type)}}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>  --}}
                                                            <div class="col-md-12">
                                                                <div class="form-group innerappform">
                                                                    <label>Name</label>
                                                                    <input type="text" class="form-control" name="name" value="{{ $banner->name }}"
                                                                        placeholder="Enter Name" />
                                                                </div>
                                                            </div>
                                                            {{--  <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>Button Text</label>
                                                                    <input type="text" class="form-control" name="button_text" value="{{ $banner->button_text }}"
                                                                        placeholder="Enter Button Text" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>Button Link</label>
                                                                    <input type="text" class="form-control" name="button_link" value="{{ $banner->button_link }}"
                                                                        placeholder="Enter Button Link" />
                                                                </div>
                                                            </div>  --}}
                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>Attachment Type</label>
                                                                    <select name="attachment_type" class="form-control" onchange="vedioAttchment(this, 'autoplay_id')">
                                                                        <option value="">Select Attachment Type</option>
                                                                        <option value="image" {{ ($banner->attachment_type == 'image') ? 'selected' : '' }}>Image</option>
                                                                        <option value="video" {{ ($banner->attachment_type == 'video') ? 'selected' : '' }}>Video</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6" id="autoplay_id" style="display: {{ $banner->attachment_type ? ($banner->attachment_type != 'video' ? 'none' : 'block') : 'block' }}">
                                                                <div class="form-group innerappform">
                                                                    <label>Autoplay</label>
                                                                    <select name="is_auto_play" class="form-control">
                                                                        <option value="">Select Autoplay</option>
                                                                        <option value="1" {{ $banner->is_auto_play == '1' ? 'selected' : '' }}>Yes</option>
                                                                        <option value="0" {{ $banner->is_auto_play == '0' ? 'selected' : '' }}>No</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6 pl-4"> 
                                                                    <div class="image-content" style="display : {{ $banner->attachment_type ? (($banner->attachment_type == 'image') ? 'block' : 'none') : 'block'}}">    
                                                                        <h4 class="f-13 mt-4 theme-Dtext playfair">Upload Portfolio Image</h4>
                                                                        <p class="f-12 theme-Ltext">Dimension: 1024 px x 1024 px<br>Ratio: 1:1</p>
                                                                        <p class="f-12 theme-Ltext">Format: JPEG, JPG, PNG only<br>Mode: sRGB</p>
                                                                        <p class="f-12 theme-Ltext">Weight: Less than 3mb</p>
                                                                        <p class="f-12 theme-Ltext">Please note that the image should not contain any kind of watermark and you have the appropriate legal rights to publish the image.</p>
                                                                    </div>
                                                                    <div class="video-content" style="display : {{ $banner->attachment_type ? (($banner->attachment_type == 'video') ? 'block' : 'none') : 'none' }}">    
                                                                        <h4 class="f-13 mt-4 theme-Dtext playfair">Upload Portfolio Video</h4>
                                                                        <p class="f-12 theme-Ltext">Dimension: 1920 px x 1080 px<br>Ratio: 1:1</p>
                                                                        <p class="f-12 theme-Ltext">Format: MOV, MP4, AVI only</p>
                                                                        <p class="f-12 theme-Ltext">Weight: Less than 150MB</p>
                                                                        <p class="f-12 theme-Ltext">Please note that the video should not contain any kind of watermark and you have the appropriate legal rights to publish the video.</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group innerappform uploadformbox">
                                                                        <label>Attachment</label>
                                                                        <input type="text" class="form-control"
                                                                            disabled="" placeholder="(Described Format only)">
                                                                        <div class="upload-btn-wrapper up-loposition">
                                                                            <button class="uploadBtn">Upload</button>
                                                                            <input type="file" id="inputFile" name="image" accept="image/gif, image/jpeg, image/png">
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mb-2">
                                                                        <div class="col-4">
                                                                            <div class="uploaded-doc">
                                                                                <img src="{{ @$banner->image ?: '/assets/admin/images/logo.png' }}" id="image_upload_preview" style="display : {{ $banner->attachment_type ? ($banner->attachment_type == 'image') ? 'block' : 'none' : 'block' }}">
                                                                                {{--  <a href="#"><img src="/assets/admin/images/close.svg"></a>  --}}
                                                                                <video width="100%" muted class="video_upload_preview" style="display : {{ ($banner->attachment_type == 'video') ? 'block' : 'none' }}" controls>
                                                                                    <source id="video_upload_preview" src="{{ @$banner->image }}">
                                                                                </video>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card dashcard rightapppanel">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h2>Status</h2>
                                                <h3>Select and update the status</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="activechkbox">
                                            <input class="filled-in" name="status" type="radio" id="active" value="active"
                                                {{ $banner->status ? ($banner->status == 'active' ? 'checked' : '') : 'checked' }}>
                                            <label for="active">ACTIVE</label>
                                        </div>
                                        @if($banner && $banner->id)
                                            <div class="activechkbox">
                                                <input class="filled-in" name="status" type="radio" id="inactive" value="inactive"
                                                {{ $banner->status == 'inactive' ? 'checked' : '' }}>
                                                <label for="inactive">INACTIVE</label>
                                            </div>
                                            {{-- <div class="activechkbox mb-0">
                                                <input class="filled-in" name="status" type="radio" id="blacklist" value="blacklist"
                                                {{ $banner->status == 'blacklist' ? 'checked' : '' }}>
                                                <label for="black">BLACKLIST</label>
                                            </div> --}}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
    @parent

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
        function vedioAttchment(th){
            var type = $(th).val();

            if(type == 'video'){
                $('#autoplay_id').css('display', 'block');
                $('.image-content').css('display', 'none');
                $('.video-content').css('display', 'block');
                $('#inputFile').attr('accept',"video/mp4, video/mov, video/avi");
            }
            else{
                $('#autoplay_id').css('display', 'none');
                $('.video-content').css('display', 'none');
                $('.image-content').css('display', 'block');
                $('#inputFile').attr('accept',"image/gif, image/jpeg, image/png");
            }
        }
    </script>

@endsection
