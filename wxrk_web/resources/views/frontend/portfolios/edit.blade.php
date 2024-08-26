@extends('admin.app')
<!-- Main Container  -->
@section('content')
@include('admin.partials.header',['title'=>$designer['name'],'description'=>'Manage & update'])
{!! Form::open(['action' => ['Admin\PortfoliosController@update', $designer->id, $portfolio->id], 'method' => 'PUT', 'id'=>'post-data','enctype' => 'multipart/form-data' ]) !!}
    <section class="content mb-5">
        <div class="container-fluid">
            <div class="row mb-2" style="margin-top:-15px">
                <div class="col-sm-12 mb-3">
                    <div class="backbtnPanel">
                        <div><a href="javascript:history.back()" class="btn btn-sm btn-auto btn-outline-dark waves-effect waves-light">Back</a></div>
                        <div><button type='submit' class="btn btn-sm btn-dark btn-auto">Update Section</button></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <section class="col-lg-8 connectedSortable">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="myordersData">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="md-form">
                                            <input type="text" id="title" name='title' placeholder="Enter the Portfolio here" class="form-control" value="{{$portfolio->title}}" required>
                                            <label class="active" for="stitle">Portfolio title</label>
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
                                            <input type="file" id="inputFile" name="attachment" accept="image/gif, image/jpeg, image/png, video/mp4, video/mov, video/avi" placeholder="Enter the Title here" class="form-control" value="Title of the Image" data-filename-placement="inside">
                                            <label for="stitle" class="active">Portfolio Image</label>
                                            <button class="uploadBtn2">Browse File</button>
                                            <!-- <a href="#" class="delBtn"><img src="/assets/admin/img/delete.svg" /></a> -->
                                        </div>
                                        @error('attachment')
                                        <label class="label">
                                            <strong class="text-danger"> {{ $message }}</strong>
                                        </label>
                                        @enderror
                                        <h4 class="f-13 mt-4 theme-Dtext playfair">Upload Portfolio Image</h4>
                                        <p class="f-12 theme-Ltext">Dimension: 1024 px x 1024 px<br>Ratio: 1:1</p>
                                        <p class="f-12 theme-Ltext">Format: JPEG, JPG, PNG, MP4 only<br>Mode: sRGB</p>
                                        <p class="f-12 theme-Ltext">Weight: Less than 3mb</p>
                                        <p class="f-12 theme-Ltext">Please note that the image should not contain any kind of watermark and you have the appropriate legal rights to publish the image.</p>

                                    </div>
                                    <div class="col-md-6">
                                        <video width="100%" id="video_preview" autoplay=1 muted  @if($portfolio->attachment_type != 'video') style="object-fit: cover;display:none"  @else  style="object-fit: cover;"  @endif >
                                            <source id="video_upload_preview" src="{{($portfolio->attachment_type == 'video') ? $portfolio->attachment : ''}}">
                                        </video>
                                        <img src="{{($portfolio->attachment_type != 'video') ? $portfolio->attachment : '/assets/common/img/dummy.png'}}" class="border w-100" @if($portfolio->attachment_type == 'video') style="display:none"  @endif id='image_upload_preview' />
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
                                <select class="form-control" id="status" name='status' required="">
                                    @foreach ($status as $value)
                                    <option value="{{ $value }}" {{$portfolio->status==$value?'selected':''}}>{{ ucfirst($value) }}</option>
                                    @endforeach
                                </select>
                            </div>
                             
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
{!! Form::close() !!}
@endsection
@section('scripts')
<script type="text/javascript">
     function readURL(input) {
        if (input.files && input.files[0]) {

            var file = input.files[0];
            var fileType = file["type"];
            var validImageTypes = ["image/gif", "image/jpeg",  "image/jpg", "image/png"];
            var validVideoTypes = ["video/avi","video/mp4",  "video/mov"];

            if ($.inArray(fileType, validImageTypes) >= 0) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#image_upload_preview').attr('src', e.target.result);
                    $('#video_preview').hide();
                    $('#image_upload_preview').show();
                }
                reader.readAsDataURL(input.files[0]);
            }

            if ($.inArray(fileType, validVideoTypes) >= 0) {
                $('#video_upload_preview').remove();
                const video = document.getElementById('video_preview');
                const videoSource = document.createElement('source');
                var reader = new FileReader();
                reader.onload = function(e) {
                    videoSource.setAttribute('src', e.target.result);
                    videoSource.setAttribute('id', 'video_upload_preview');
                    video.appendChild(videoSource);
                    video.load();
                    video.play();

                    $('#image_upload_preview').hide();
                    $('#video_preview').show();
                }
                reader.readAsDataURL(input.files[0]);
            }
            
        }
    }

    $("#inputFile").change(function() {
        readURL(this);
    });
</script>
@stop