@extends('admin/app')
{{-- Web site Title --}}
@section('title') Categories :: @parent @stop
@section('content')

    <div class="content-header">
        <div class="container-fluid mt-3">
            <div class="row mb-2">
                <div class="col-sm-12 col-md-12 col-12">
                    <div class="tophead">
                        <div class="allTitle">
                            <a class="d-block d-lg-none" data-widget="pushmenu" href="#" role="button"><img src="/assets/admin/img/menu-left-alt.svg" width="18px" /></a>
                            <h2>Product Attributes</h2>
                            <div class="subTitle">Manage attributes & variables</div>
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
                            <div class="adlogo d-inline-block"><img src="/assets/frontend/img/logo/logo-black.png"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-12">
                    <div class="backbtnPanel">
                        <div><a href="javascript:history.back()" class="btn btn-sm btn-auto btn-outline-dark">Back</a></div>
                        <div>
                            <div class="searchTb">
                                <form action="" method="GET">
                                    <div class="input-group custom-search">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-search"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="search" value="{{ Request::get('search') }}" placeholder="Search" aria-label="Search" aria-describedby="basic-addon1">
                                    </div>
                                </form>    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="content mb-5">
        <div class="container-fluid">
            <div class="row">
                <section class="col-lg-8 connectedSortable">
                    {{-- <div class="tableHead">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="filterarea">
                                    <div class="sel_all">
                                        <input class="filled-in" name="group1" type="checkbox" id="news">
                                        <label for="news" class="text-dark">Select All</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <div class="table-responsive">
                        <table class="table table-color table-bordered admintable border-0" cellspacing="0" cellpadding="0">
                            
                            @foreach ($productAttributes as $key => $productAttribute)
                                <tr>
                                    {{-- <td colspan="1">
                                        <input class="filled-in" name="group1" type="checkbox" id="news1">
                                        <label for="news1"></label>
                                    </td> --}}
                                    <td><strong>{{ $productAttribute->name }}</strong>Attribute Name</td>
                                    <td><strong>{{ $productAttribute->type }}</strong>Attribute Type</td>
                                    <td><strong>{{ count($productAttribute->productAttributeVariables) }}</strong>Total Variables</td>
                                    <td>
                                        <a href="#" onclick="setEditForm({{json_encode($productAttribute)}})" class="btn btn-sm btn-outline-dark">Edit</a>
                                        <a href="#" data-url="/admin/product-attributes/{{ $productAttribute->id }}" data-request="remove" data-redirect="/admin/product-attributes" class="btn btn-sm btn-outline-dark">Remove</a>
                                    </td>
                                </tr>
                                @if (count($productAttribute->productAttributeVariables)>0)
                                @foreach ($productAttribute->productAttributeVariables as $key => $productAttributeVariable)
                                <tr>
                                    <td class="bg-white">&nbsp;</td>
                                    {{-- <td>
                                        <input class="filled-in" name="group1" type="checkbox" id="news2">
                                        <label for="news2"></label>
                                    </td> --}}
                                    <td colspan="1"><strong>{{ $productAttributeVariable->option_name }}</strong>Variable Name</td>
                                    <td colspan="1"><strong>{{ $productAttributeVariable->option_value }}</strong>Variable value</td>
                                    <td>
                                        <a href="#" onclick="setVariableEditForm({{json_encode($productAttributeVariable)}})" class="btn btn-sm btn-outline-dark">Edit</a>
                                        <a href="#" data-url="/admin/delete-variables/{{ $productAttributeVariable->id }}" data-request="remove" data-redirect="/admin/product-attributes" class="btn btn-sm btn-outline-dark">Remove</a>
                                    </td>
                                </tr>
                                 @endforeach
                                 @endif
                            @endforeach
                        </table>
                    </div>
                  {{ $productAttributes->appends(request()->except('page'))->links('admin.layouts.pagination') }}
                </section>

                <section class="col-lg-4 connectedSortable">
                    <div class="card">
                        <form role="post-data" id="form_action" method="POST" redirect="/admin/product-attributes" action="/admin/product-attributes" enctype="multipart/form-data">
                            <input type="hidden" name="_method" id="form_method" value="post">
                            <div class="card-header">
                                <h3 class="card-title" id="publish_head">Add New</h3>
                                <p>Attribute</p>
                            </div>

                            <div class="card-body">
                                <div class="md-form">
                                    <input type="text" name="name" id="attribute_name" placeholder="Enter Name" class="form-control">
                                    <label for="stitle">Attribute name</label>
                                </div>
                                <div class="form-group">
                                    <label for="status">Attribute Type</label>
                                    <select class="form-control" name="type" id="type">
                                        <option value="">Please select</option>
                                        @foreach ($option_types as $option_type)
                                            <option value="{{ $option_type }}">{{ ucfirst($option_type) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="add-more-row">
                                    <div class="md-form" id="option_name">
                                        <input type="text" id="set_option_name" name="variables[0][option_name]" placeholder="Enter Name" class="form-control position-relative">
                                        <label for="stitle">Variable</label>
                                        {{-- <a href="#" class="delBtn"><img src="/assets/admin/img/delete.svg" /></a> --}}
                                    </div>
                                    <div class="md-form" id="option_value" >
                                        <input type="text" id="set_option_value" name="variables[0][option_value]" placeholder="Enter HEX Code" class="form-control position-relative">
                                        <label for="stitle">Variable - Color HEX Code</label> 
                                    </div>
                                    <div class="md-form">
                                        <input type="text" id="stitle" placeholder="Upload" disabled class="form-control position-relative">
                                        <label for="stitle">Variable - Image Swatch</label>
                                        <div class="upload-btn-wrapper upload-right" id="variable_image">
                                            <button class="uploadBtn m-0">Upload</button>
                                            <input type="file" accept="image/png" onchange="renderImage(this, 'prev_variable_image_0')" name="variables[0][variable_image]">
                                        </div>
                                        <div class="float-left mr-3">
                                            <div class="position-relative">
                                                <img src="/assets/admin/img/image.svg"  style="height:80px;" id="prev_variable_image_0" class="border changeSrc"/>
                                                <a>
                                                    <img src="/assets/admin/img/img-close.svg" class="img-close" />
                                                </a>
                                            </div>
                                        </div>
                                    </div> 
                                </div>

                                <div class="ordeRow1 mt-2 variable-btnamin">
                                    <a href="#" id="add-more" class="btn btn-sm btn-auto btn-outline-dark">Add Variable</a>
                                    <button type="button" id="publish" data-request="ajax-submit" data-target="[role=post-data]" class="btn btn-sm btn-auto btn-dark">Publish Attribute</a>
                                </div>
                            </div>
                        </form>
                        <form role="update-data" style="display: none" id="variable_form_action" method="POST" redirect="/admin/product-attributes" action="" enctype="multipart/form-data">
                            <input type="hidden" name="_method" value="PUT">
                            <div class="card-header">
                                <h3 class="card-title">Update</h3>
                                <p>Attribute Variable</p>
                            </div>

                            <div class="card-body">
                                <div class="md-form">
                                    <input type="text" id="set_option_name" name="option_name" placeholder="Enter Name" class="form-control position-relative set_option_name">
                                    <label for="stitle">Variable</label>
                                </div>
                                <div class="md-form">
                                    <input type="text" id="set_option_value" name="option_value" placeholder="Enter HEX Code" class="form-control position-relative set_option_value">
                                    <label for="stitle">Variable - Color HEX Code</label> 
                                </div>
                                <div class="md-form">
                                    <input type="text" id="stitle" placeholder="Upload" disabled class="form-control position-relative">
                                    <label for="stitle">Variable - Image Swatch</label>
                                    <div class="upload-btn-wrapper upload-right">
                                        <button class="uploadBtn m-0">Upload</button>
                                        <input type="file" accept="image/png" onchange="renderImage(this, 'prev_variable_image')" name="variable_image">
                                    </div>
                                    <div class="float-left mr-3">
                                        <div class="position-relative">
                                            <img src="/assets/admin/img/image.svg" style="height:80px;" id="prev_variable_image" class="border"/>
                                            <a>
                                                <img src="/assets/admin/img/img-close.svg" class="img-close" />
                                            </a>
                                        </div>
                                    </div>
                                </div> 

                                <div class="ordeRow1 mt-2">
                                    <button type="button" data-request="ajax-submit" data-target="[role=update-data]" class="btn btn-sm btn-auto btn-dark">Update Variable</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </section>
@stop

@section('scripts')
<script src="{{ asset('js/custom-script.js') }}"></script>
<script src="{{ asset('js/sweetalert.js') }}"></script>
<script type="text/javascript">
    var add_row_count = 1;
    var max_fields = 10;
    $("#add-more").click(function(){
        var html = $(".add-more-row").first().clone();
        if(add_row_count < max_fields) {
            let prev_variable_image = "'prev_variable_image_"+add_row_count+"'";
            $(html).find("#option_name").html('<input type="text" id="stitle" name="variables['+add_row_count+'][option_name]" placeholder="Enter Name" class="form-control position-relative">'+
                                        '<label for="stitle" class="active">Variable</label> <a href="#" id="remove" class="delBtn"><img src="/assets/admin/img/delete.svg" /></a>');
            $(html).find("#option_value").html('<input type="text" id="stitle" name="variables['+add_row_count+'][option_value]" placeholder="Enter HEX Code" class="form-control position-relative">'+
                                        '<label for="stitle" class="active">Variable - Color HEX Code</label> ');
            $(html).find(".changeSrc").attr('id', "prev_variable_image_"+add_row_count);
            $(html).find("#variable_image").html('<button class="uploadBtn m-0">Upload</button>'+
                                            '<input type="file" accept="image/png" onchange="renderImage(this, '+prev_variable_image+')" name="variables['+add_row_count+'][variable_image]">');
            $(".add-more-row").last().after(html);
            add_row_count++;
        }else{
        Swal.fire({
            icon: 'warning',
            title: 'Alert! ',
            text: 'You can add only '+max_fields+' attachments'
        })
        }
    });

    $("body").on("click","#remove",function(){
        add_row_count--;
        $(this).parents(".add-more-row").remove();
    });

    function setEditForm(data) {
        $('#form_action').show();
        $('#variable_form_action').hide();
        $(".has-error").removeClass('has-error');
        $('.help-block').remove();
        $('.set_option_name').val('');
        $('.set_option_value').val('');


        $("#type option[value="+data.type+"]").attr('selected', 'selected');
        $('#attribute_name').val(data.name);
        $('#form_action').attr('action', '/admin/product-attributes/'+data.id);
        $('#form_method').val('put');
        $('#publish').html('Update Attribute');
        $('#publish_head').html('Update Attribute');
    }

    function setVariableEditForm(data) {
        console.log(data);
        $('#form_action').hide();
        $('#variable_form_action').show();
        $(".has-error").removeClass('has-error');
        $('.help-block').remove();

        $('.set_option_name').val(data.option_name);
        $('.set_option_value').val(data.option_value);
        if(data.variable_image) {
            $('#prev_variable_image').attr('src', data.variable_image);
        } else {
            $('#prev_variable_image').attr('src', '/assets/admin/img/image.svg');

        }
        $('#variable_form_action').attr('action', '/admin/product-variables/'+data.id);
    }
</script>
@stop

@section('styles')
<style type="text/css">
 
</style>
@endsection