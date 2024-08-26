@extends('admin/app')
{{-- Web site Title --}}
@section('title') Subscription Plan :: @parent @stop
@section('content')

<div class="content-header">
    <div class="container-fluid mt-3">
        <div class="row mb-2">
            <div class="col-sm-12 col-md-12 col-12">
                <div class="tophead">
                    <div class="allTitle">
                        <a class="d-block d-lg-none" data-widget="pushmenu" href="#" role="button"><img src="/assets/admin/img/menu-left-alt.svg" width="18px" /></a>
                        <h2>Update Subscription Plan</h2>
                        <div class="subTitle">Manage Subscription Plan</div>
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
                        <div class="adlogo d-inline-block">
                            <img src="/assets/frontend/img/logo/logo-black.png" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-12">
                <div class="backbtnPanel nonflex">
                    <div><a href="javascript:history.back()" class="btn btn-sm btn-auto btn-outline-dark">Back</a></div>
                    <div>
                        {{-- <a href="#" class="btn btn-sm btn-outline-dark btn-auto">Preview Draft</a> --}}
                        <button type="button" id="update" class="btn btn-sm btn-dark btn-auto">Update Subscription Plan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<form role="post-data" method="POST" redirect="/admin/subscription-plans/{{ $plan->id }}/edit" action="/admin/subscription-plans/{{ $plan->id }}" enctype="multipart/form-data">
    <input type="hidden" name="_method" value="PUT">
    <section class="content mb-5">
        <div class="container-fluid">
            <div class="row">
                <section class="col-lg-8 connectedSortable">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="myordersData">
                                <div class="row">
                                    {{-- <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="designer_id">Designer</label>
                                            <select class="form-control" name="designer_id" id="designer_id" required="">
                                                @if($designer)
                                                    <option value="{{$designerId}}" >{{ ucfirst($designer->name) }}</option>
                                                @else 
                                                    <option value="">Please select</option>
                                                    @foreach ($designers as $designer)
                                                        <option value="{{$designer->id}}" {{ $plan->designer_id == $designer->id ? 'selected':'' }}>{{ ucfirst($designer->name) }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        @error('designer_id')
                                        <label class="label">
                                            <strong class="text-danger"> {{ $message }}</strong>
                                        </label>
                                        @enderror
                                    </div> --}}
                                    <div class="col-sm-12">
                                        <div class="md-form">
                                            <input type="text" id="stitle" name="title" value="{{ $plan->title }}"
                                                placeholder="Enter the Title here" class="form-control">
                                            <label for="stitle">Plan Title</label>
                                        </div>
                                        @error('title')
                                        <label class="label">
                                            <strong class="text-danger"> {{ $message }}</strong>
                                        </label>
                                        @enderror
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group textarea-group">
                                            <label for="exampleFormControlTextarea1">Plan Description</label>
                                            <textarea class="form-control" name="description"
                                                id="exampleFormControlTextarea1" placeholder="Enter the long description here"
                                                rows="3">{{ $plan->description }}</textarea>
                                        </div>
                                        @error('description')
                                        <label class="label">
                                            <strong class="text-danger"> {{ $message }}</strong>
                                        </label>
                                        @enderror
                                    </div>
                                    <div>
                                        &nbsp;
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </section>

                <section class="col-lg-4 connectedSortable">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">No. of Allowed Images</h3>
                            <p>Allowed Images</p>
                        </div>

                        <div class="card-body">
                            <div class="md-form mt-0">
                                <input type="text" name="no_of_allowed_images" placeholder="Enter the no. of allowed images" value="{{ $plan->no_of_allowed_images }}"
                                    class="form-control">
                            </div>
                        </div>
                        @error('no_of_allowed_images')
                        <label class="label">
                            <strong class="text-danger"> {{ $message }}</strong>
                        </label>
                        @enderror
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">No. of Allowed Videos</h3>
                            <p>Allowed Videos</p>
                        </div>

                        <div class="card-body">
                            <div class="md-form mt-0">
                                <input type="text" name="no_of_allowed_videos" placeholder="Enter the no. of allowed videos" value="{{ $plan->no_of_allowed_videos }}"
                                    class="form-control">
                            </div>
                        </div>
                        @error('no_of_allowed_videos')
                        <label class="label">
                            <strong class="text-danger"> {{ $message }}</strong>
                        </label>
                        @enderror
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Allowed Social Media</h3>
                            <p>Select Social Media</p>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                @error('category_id')
                                <label class="label">
                                    <strong class="text-danger"> {{ $message }}</strong>
                                </label>
                                @enderror
                                @foreach ($socialMedias as $socialMedia)
                                <div class="col-12">
                                    <input class="filled-in" name="social_media_id[]"
                                        value="{{ $socialMedia->id }}" type="checkbox"
                                        id="cat_{{ $socialMedia->id }}" @if (in_array($socialMedia->id, $mappings))
                                            checked
                                        @endif>
                                    <label for="cat_{{ $socialMedia->id }}">{{ $socialMedia->name }}</label>
                                </div>
                                @endforeach
                                <br>
                                <br>
                                {{-- <input name="show_on_home" 
                                        value="1" type="checkbox">
                                    <label for="show_on_home">Show this on Home Page</label> --}}
                            </div>
                        </div>
                    </div>
                    {{-- <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Pin on HomeScreen</h3>
                            <p>Blog Status</p>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <select class="form-control" id="show_on_home" name="show_on_home">
                                    <option value="">Please select</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                    </div> --}}
                </section>
                <input type="button" id="final_submit" data-request="ajax-submit" data-target="[role=post-data]" style="display: none;">
            </div>
        </div>
    </section>
    <input type="button" id="final_submit" data-request="ajax-submit" data-target="[role=post-data]" style="display: none;">

</form>    

@stop

@section('scripts')
<script src="{{ asset('js/custom-script.js') }}"></script>
<script src="{{ asset('js/sweetalert.js') }}"></script>
<script src="/assets/admin/ckeditor/ckeditor.js"></script>
<script src="/assets/admin/ckeditor/samples/js/sample.js"></script>
<script type="text/javascript"> 
    CKEDITOR.replace( 'description' );
    CKEDITOR.add            
</script>
<script type="text/javascript">
    $('#update').on('click', function (e) { 
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }
        $('#final_submit').click();
    });

    function checkChild(element) {
        let parentId = element.value;
        let isChecked = element.checked;
        if(isChecked) {
            $('.parent_check_'+parentId).prop('checked', true)
        } else {
            $('.parent_check_'+parentId).prop('checked', false)
        }
    }
    var lengthFIle = 0;
        $("#other_image").on("change", function(e) {
        var files = e.target.files,
        filesLength = files.length;
        lengthFIle++;
        if(filesLength >4 || lengthFIle >4) {
            Swal.fire(
                'Warning!',
                'You can upload maximum 4 images',
                'warning'
            );
            return false;
        } else {
            for (var i = 0; i < filesLength; i++) {
                var f = files[i]
                var fileReader = new FileReader();

                fileReader.onload = (function(e) {
                var file = e.target;
                let append = '<div class="col-md-6">'+
                                        '<img src="'+e.target.result+'" class="border w-100">'+
                                        '<a data-request="remove-image" href="#" class="delImageNew mr-1"><img src="/assets/admin/img/closered.svg" width="25" /></a>'+
                                        '</div>';          
                    $('#appendImages').append(append);
                });
                fileReader.readAsDataURL(f);
            }
        }
        });
        $(document).on('click', '[data-request="remove-image"]', function () {
            var $this = $(this);
            $this.closest('div').remove();
        });


    $(document).on('click', 'input[type="checkbox"]', function() {      
        $('.product_custom_size_id').not(this).prop('checked', false);      
    });
    $(document).on('click', '[data-request="remove-image"]', function () {
        var $this = $(this);
        $this.closest('div').remove();
    });
    var set_generated_attributes ='';
    $(document).on('click', '[data-request="generate-attribute"]', function () {
        set_generated_attributes +='<div class="row generated_row">';

        $("input:checkbox[name=product_attributes]:checked").each(function(){
            let type= $(this).attr('data-type');
            let title= $(this).attr('data-title');
            let attribute_id= $(this).attr('data-id');
            let option_value= JSON.parse($(this).val());
           
            if(type=='option') {
                var options = '';
                if(option_value) {
                    $.each(option_value, function( index, value ) {
                        options +='<option value="'+value.id+'">'+value.option_name+'</option>';
                    });
                }
                set_generated_attributes +='<div class="col-lg-2">'+
                                '<div class="form-group">'+
                                    '<label for="status">'+title+'</label>'+
                                    '<select class="form-control" id="status" name="varient['+number_index+'][attribute]['+attribute_id+']" >'+
                                        '<option value="">Select</option>'+options+
                                    '</select>'+
                                '</div>'+
                           '</div>';
            } else {
            set_generated_attributes +='<div class="col-lg-2">'+
                            '<div class="md-form">'+
                                '<input type="text" class="form-control" name="varient['+number_index+'][attribute]['+attribute_id+']" placeholder="'+title+'" value="">'+
                                '<label class="active" for="stitle">'+title+'</label>'+
                            '</div>'+
                        '</div>';
            }
        });
        set_generated_attributes +='<div class="col-lg-2">'+
                    '<div class="md-form">'+
                        '<input type="text" id="cost_'+number_index+'" placeholder="Cost In USD" name="varient['+number_index+'][cost]" class="form-control" value="">'+
                        '<label class="active" for="cost_'+number_index+'">Cost In USD</label>'+
                    '</div>'+
                '</div>'+
                '<div class="col-lg-2">'+
                    '<div class="md-form">'+
                        '<input type="text" id="stock_'+number_index+'" placeholder="Stock (QTY)" class="form-control" name="varient['+number_index+'][stock]" value="">'+
                        '<label class="active" for="stock_'+number_index+'">Stock (QTY)</label>'+
                    '</div>'+
                '</div>'+
        '<div class="col-lg-1 text-center">'+
                    '<a id="remove" data-index="'+number_index+'" class="mt-3 d-block"><img src="/assets/admin/img/delete.svg" /></a>'+
                '</div>'+
            '</div>'+
            '<div class="mb-4 row m-0 img_generated_row_'+number_index+'">'+
                '<div class="float-left mr-3">'+
                    '<div class="position-relative">'+
                        '<div class="upload-btn-wrapper">'+
                            '<button class="uploadBtn uploadBtnfixbox p-0 m-0 border-0"><img height="54" src="/assets/admin/img/image2.svg" id="one_prv_image_'+number_index+'"/> </button>'+
                            '<input type="file" name="varient['+number_index+'][varient_image_1]" accept="image/*" id="one_image_'+number_index+'" onchange="renderImage(this, '+"'one_prv_image_"+number_index+"'"+')" >'+
                        '</div>'+
                        '<img src="/assets/admin/img/img-close.svg" class="img-close" onclick="removeFile('+"'one_image_"+number_index+"'"+', '+"'one_prv_image_"+number_index+"'"+')"/>'+
                    '</div>'+
                '</div>'+
                '<div class="float-left mr-3">'+
                    '<div class="position-relative">'+
                         '<div class="upload-btn-wrapper">'+
                            '<button class="uploadBtn uploadBtnfixbox p-0 m-0 border-0"><img height="54" src="/assets/admin/img/image2.svg" id="two_prv_image_'+number_index+'"/> </button>'+
                            '<input type="file" name="varient['+number_index+'][varient_image_2]" id="two_image_'+number_index+'" onchange="renderImage(this, '+"'two_prv_image_"+number_index+"'"+')" accept="image/*" >'+
                        '</div>'+
                        '<img src="/assets/admin/img/img-close.svg" class="img-close" onclick="removeFile('+"'two_image_"+number_index+"'"+', '+"'two_prv_image_"+number_index+"'"+')"/>'+
                    '</div>'+
                '</div>'+
                '<div class="float-left mr-3">'+
                    '<div class="position-relative">'+
                         '<div class="upload-btn-wrapper">'+
                            '<button class="uploadBtn uploadBtnfixbox p-0 m-0 border-0"><img height="54" src="/assets/admin/img/image2.svg" id="three_prv_image_'+number_index+'"/> </button>'+
                            '<input type="file" name="varient['+number_index+'][varient_image_3]" id="three_image_'+number_index+'" accept="image/*" onchange="renderImage(this, '+"'three_prv_image_"+number_index+"'"+')">'+
                        '</div>'+
                        '<img src="/assets/admin/img/img-close.svg" class="img-close" onclick="removeFile('+"'three_image_"+number_index+"'"+', '+"'three_prv_image_"+number_index+"'"+')"/>'+
                    '</div>'+
                '</div>'+
                '<div class="float-left mr-3">'+
                    '<div class="position-relative">'+
                         '<div class="upload-btn-wrapper">'+
                            '<button class="uploadBtn uploadBtnfixbox p-0 m-0 border-0"><img height="54" src="/assets/admin/img/image2.svg" id="four_prv_image_'+number_index+'"/> </button>'+
                            '<input type="file" name="varient['+number_index+'][varient_image_4]" accept="image/*" id="four_image_'+number_index+'" onchange="renderImage(this, '+"'four_prv_image_"+number_index+"'"+')">'+
                        '</div>'+
                        '<img src="/assets/admin/img/img-close.svg" class="img-close" onclick="removeFile('+"'four_image_"+number_index+"'"+', '+"'four_prv_image_"+number_index+"'"+')"/>'+
                    '</div>'+
                '</div>'+
                '<div class="float-left mr-3">'+
                    '<div class="position-relative">'+
                         '<div class="upload-btn-wrapper">'+
                            '<button class="uploadBtn p-0 m-0 border-0"> '+
                                '<video class="videoUpload2View_'+number_index+'" height="50" style="object-fit: cover;">'+
                                    '<source src="" type="video/mp4" id="videoUpload2View_'+number_index+'">'+
                                '</video>'+
                            '</button>'+
                            '<input type="file" id="videoUpload_'+number_index+'" onchange="videoRender(this, '+"'videoUpload2View_"+number_index+"'"+')" name="varient['+number_index+'][varient_video]" accept="video/*">'+
                        '</div>'+
                        '<img src="/assets/admin/img/img-close.svg" class="img-close" onclick="removeVideoFile('+"'videoUpload_"+number_index+"'"+', '+"'videoUpload2View_"+number_index+"'"+')"/>'+
                    '</div>'+
                '</div>'+
            '</div>';
        $('#set_generated_attributes').append(set_generated_attributes)
        set_generated_attributes = '';
        number_index++;
    });

    $("body").on("click","#remove",function(){
        let num =  $(this).attr('data-index');
        $(this).parents(".generated_row").remove();
        $(".img_generated_row_"+num).remove();
    });
</script>
@stop

@section('styles')
<link rel="stylesheet" href="/assets/admin/ckeditor/samples/toolbarconfigurator/lib/codemirror/neo.css">
<style type="text/css">
 
</style>
@endsection