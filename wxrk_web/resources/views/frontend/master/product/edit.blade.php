@extends('admin/app')
{{-- Web site Title --}}
@section('title') Products :: @parent @stop
@section('content')

<div class="content-header">
    <div class="container-fluid mt-3">
        <div class="row mb-2">
            <div class="col-sm-12 col-md-12 col-12">
                <div class="tophead">
                    <div class="allTitle">
                        <a class="d-block d-lg-none" data-widget="pushmenu" href="#" role="button">
                            <img src="/assets/admin/img/menu-left-alt.svg" width="18px" />
                        </a>
                        <h2>Update Product</h2>
                        <div class="subTitle">
                            Update product, categories, sub-categories & attributes
                        </div>
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
                            <img src="/assets/frontend/img/logo/logo-black.png" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-12">
                <div class="backbtnPanel nonflex">
                    <div>
                        <a href="javascript:history.back()" class="btn btn-sm btn-auto btn-outline-dark">
                            Back
                        </a>
                    </div>
                    <div>
                        {{-- <a href="#" class="btn btn-sm btn-outline-dark btn-auto">Preview Draft</a> --}}
                        <button type="button" id="update" class="btn btn-sm btn-dark btn-auto">
                            Update Product
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<form role="post-data" method="POST" redirect="/admin/products/{{ $product->id }}/edit" action="/admin/products/{{ $product->id }}" enctype="multipart/form-data">
    <input type="hidden" name="_method" value="PUT">
    <section class="content mb-5">
        <div class="container-fluid">
            <div class="row">
                <section class="col-lg-8 connectedSortable">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="designer_id">Seller</label>
                                <select class="form-control" name="designer_id" id="designer_id" required="">
                                    @foreach ($designers as $designer)
                                        <option value="{{$designer->id}}" {{ ($product->designer && ($product->designer->id == $designer->id)) ? 'selected':'' }}>{{ ucfirst($designer->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('designer_id')
                            <label class="label">
                                <strong class="text-danger"> {{ $message }}</strong>
                            </label>
                            @enderror
                        </div>
                        <div class="col-lg-12">
                            <div class="myordersData">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="md-form">
                                            <input type="text" id="stitle" name="title" value="{{ $product->title }}" placeholder="Enter the Title here" class="form-control">
                                            <label for="stitle">Item Title</label>
                                        </div>
                                        @error('title')
                                            <label class="label">
                                                <strong class="text-danger"> {{ $message }}</strong>
                                            </label>
                                        @enderror
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group textarea-group">
                                            <label for="exampleFormControlTextarea2">Short Description</label>
                                            <textarea class="form-control" name="short_description" id="exampleFormControlTextarea2" placeholder="Enter the description here" rows="3">{{ $product->short_description }}</textarea>
                                        </div>
                                        @error('short_description')
                                            <label class="label">
                                                <strong class="text-danger"> {{ $message }}</strong>
                                            </label>
                                        @enderror
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group textarea-group">
                                            <label for="exampleFormControlTextarea1">Long Description</label>
                                            <textarea class="form-control" name="long_description" id="exampleFormControlTextarea1" placeholder="Enter the long here" rows="3">{{ $product->long_description }}</textarea>
                                        </div>
                                        @error('long_description')
                                            <label class="label">
                                                <strong class="text-danger"> {{ $message }}</strong>
                                            </label>
                                        @enderror
                                    </div>
                                    <div>
                                        &nbsp;
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-0">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="allTitle">
                                                        <h2>Attributes</h2>
                                                        <div class="subTitle mb-3">Add attributes, variables and images</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 textM-right mt-2">
                                                    <a href="{{ url('admin/product-attributes') }}" target="_blank" class="btn btn-md btn-dark btn-auto mb-0 waves-effect waves-light ">Add More Attributes</a>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h3 class="card-title">Select</h3>
                                                            <p>Attributes</p>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                @foreach ($productAttributes as $productAttribut)
                                                                <div class="col-md-3">
                                                                    <div>
                                                                        <input class="filled-in productAttributes" type="checkbox" data-title="{{ $productAttribut->name }}" data-id="{{ $productAttribut->id }}" data-type="{{ $productAttribut->type }}" value="{{ json_encode($productAttribut->productAttributeVariables) }}" name="product_attributes" id="productAttribut_{{ $productAttribut->id }}" {{ is_array($productVarientOptions) && in_array($productAttribut->id, $productVarientOptions) ? 'checked' : '' }}>
                                                                        <label for="productAttribut_{{ $productAttribut->id }}">{{ $productAttribut->name }}</label>
                                                                    </div>
                                                                </div>
                                                                @endforeach
                                                                    
                                                                <div class="col-md-12">
                                                                    <button type="button" class="btn btn-sm btn-outline-dark btn-auto mb-0 waves-effect waves-light float-right" data-request="generate-attribute">Generate Attributes</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12">
                                                    <div class="accordianPanel">
                                                        <h5 class="mb-2 accordTitle">
                                                            <a class="colapseClickmoew playfair" data-toggle="collapse" data-target="#cat0" role="button" aria-expanded="false" aria-controls="cat0">
                                                                Generated Variables
                                                            </a>
                                                        </h5>
                                                        <div class="collapse show">
                                                            @foreach ($product->varients as $key => $varients)
                                                            <div class="row">
                                                                <input type="hidden" name="varient[{{ $key }}][id]" value="{{ $varients->id }}">

                                                                @if(count($varients->varientOptions) >0)
                                                                @foreach ($varients->varientOptions as $varientOptions)
                                                                @php
                                                                    $options = isset($attributeOptions[$varientOptions->product_attribute_id]) ? $attributeOptions[$varientOptions->product_attribute_id] : false;
                                                                    $type = isset($attributeType[$varientOptions->product_attribute_id]['type']) ? $attributeType[$varientOptions->product_attribute_id]['type'] : false;
                                                                @endphp
                                                                @if ($type == 'option')
                                                                <div class="col-lg-2">
                                                                    <div class="form-group">
                                                                        <label class="active" for="status">{{ $varientOptions->attribute_name }}</label>
                                                                        <select class="form-control" name="varient[{{ $key }}][attribute][{{ $varientOptions->product_attribute_id }}]">
                                                                            <option value="">Select</option>
                                                                            @if($options)
                                                                                @foreach ($options as $option)
                                                                                    <option value="{{ $option->id }}" {{ $varientOptions->product_attribute_variable_id == $option->id ? 'selected':'' }}>{{ $option->option_name }}</option>
                                                                                @endforeach
                                                                            @endif
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                @else 
                                                                <div class="col-lg-2">
                                                                    <div class="md-form">
                                                                        <input type="text" name="varient[{{ $key }}][attribute][{{ $varientOptions->product_attribute_id }}]" placeholder="{{ $varientOptions->attribute_name }}" class="form-control" value="{{ $varientOptions->option_name }}">
                                                                        <label class="active" for="stitle">{{ $varientOptions->attribute_name }}</label>
                                                                    </div>
                                                                </div>
                                                                @endif
                                                                @endforeach
                                                                @endif
                                                                
                                                                <div class="col-lg-2">
                                                                    <div class="md-form">
                                                                        <input type="text" name="varient[{{ $key }}][cost]" placeholder="Cost" class="form-control" value="{{ $varients->cost }}">
                                                                        <label for="stitle">Cost in USD</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-2">
                                                                    <div class="md-form">
                                                                        <input type="text" name="varient[{{ $key }}][stock]" placeholder="Stock" class="form-control" value="{{ $varients->available_stock }}">
                                                                        <label for="stitle">Stock (QTY)</label>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-lg-1 text-center">
                                                                    <a class="mt-3 d-block" data-url="/admin/product-varient/{{ $varients->id }}" data-request="remove" data-redirect="/admin/products/{{ $product->id }}/edit">
                                                                        <img src="/assets/admin/img/delete.svg" />
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="mb-4 row m-0">
                                                                <div class="float-left mr-3">
                                                                    <div class="upload-btn-wrapper">
                                                                        <button class="uploadBtn uploadBtnfixbox p-0 m-0 border-0">
                                                                            <img height="54" src="{{ $varients->varient_image_1 ? $varients->varient_image_1 :'/assets/admin/img/image2.svg' }}" id="one_prv_image_{{ $key }}"/> 
                                                                        </button>
                                                                        <input type="file" name="varient[{{ $key }}][varient_image_1]" accept="image/*" id="one_image_{{ $key }}" onchange="renderImage(this, 'one_prv_image_{{ $key }}')">
                                                                    </div>
                                                                </div>
                                                                <div class="float-left mr-3">
                                                                    <div class="position-relative">
                                                                        <div class="upload-btn-wrapper">
                                                                            <button class="uploadBtn uploadBtnfixbox p-0 m-0 border-0">
                                                                                <img height="54" src="{{ $varients->varient_image_2 ? $varients->varient_image_2 :'/assets/admin/img/image2.svg' }}" id="two_prv_image_{{ $key }}"/> 
                                                                            </button>
                                                                            <input type="file" name="varient[{{ $key }}][varient_image_2]" accept="image/*" id="twor_image_{{ $key }}" onchange="renderImage(this, 'two_prv_image_{{ $key }}')">
                                                                        </div>
                                                                        <img src="/assets/admin/img/img-close.svg" class="img-close" />
                                                                    </div>
                                                                </div>
                                                                <div class="float-left mr-3">
                                                                    <div class="position-relative">
                                                                        <div class="upload-btn-wrapper">
                                                                            <button class="uploadBtn uploadBtnfixbox p-0 m-0 border-0">
                                                                                <img height="54" src="{{ $varients->varient_image_3 ? $varients->varient_image_3 :'/assets/admin/img/image2.svg' }}" id="three_prv_image_{{ $key }}"/> 
                                                                            </button>
                                                                            <input type="file" name="varient[{{ $key }}][varient_image_3]" accept="image/*" id="three_image_{{ $key }}" onchange="renderImage(this, 'three_prv_image_{{ $key }}')">
                                                                        </div>
                                                                        <img src="/assets/admin/img/img-close.svg" class="img-close" />
                                                                    </div>
                                                                </div>
                                                                <div class="float-left mr-3">
                                                                    <div class="position-relative">
                                                                        <div class="upload-btn-wrapper">
                                                                            <button class="uploadBtn uploadBtnfixbox p-0 m-0 border-0">
                                                                                <img height="54" src="{{ $varients->varient_image_4 ? $varients->varient_image_4 :'/assets/admin/img/image2.svg' }}" id="four_prv_image_{{ $key }}"/> 
                                                                            </button>
                                                                            <input type="file" name="varient[{{ $key }}][varient_image_4]" accept="image/*" id="four_image_{{ $key }}" onchange="renderImage(this, 'four_prv_image_{{ $key }}')">
                                                                        </div>
                                                                        <img src="/assets/admin/img/img-close.svg" class="img-close" />
                                                                    </div>
                                                                </div>
                                                                <div class="float-left mr-3">
                                                                    <div class="position-relative">
                                                                        <div class="upload-btn-wrapper">
                                                                            <button class="uploadBtn p-0 m-0 border-0"> 
                                                                                <video src="{{ $varients->varient_video ? $varients->varient_video :'' }}" class="videoUpload2View_{{ $key }}" height="50" style="object-fit: cover;">
                                                                                    <source src="{{ $varients->varient_video ? $varients->varient_video :'' }}" type="video/mp4" id="videoUpload2View_{{ $key }}">
                                                                                </video>
                                                                            </button>
                                                                            <input type="file" id="videoUpload_{{ $key }}" onchange="videoRender(this, 'videoUpload2View_{{ $key }}')" name="varient[{{ $key }}][varient_video]" accept="video/*">
                                                                        </div>
                                                                        <img src="/assets/admin/img/img-close.svg" class="img-close" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                        <div id="set_generated_attributes"></div>
                                                        <div class="border-top mt-3 mb-3 opacity40"></div>
                                                        <!-- <h5 class="accordTitle mb-0">
                                                            <a class="colapseClickmoew playfair" data-toggle="collapse" data-target="#cat1" role="button" aria-expanded="false" aria-controls="cat1">
                                                            Attribute: Monogram
                                                        </a>
                                                        </h5>
                                                        <p class="subTitle f-11">* This is a custom text field</p>
                                                        <div class="collapse show" id="cat1">
                                                            <div class="row">
                                                                <div class="col-lg-2">
                                                                    <div class="md-form">
                                                                        <input type="text" id="stitle" placeholder="Cost" class="form-control" value="1000">
                                                                        <label for="stitle">Cost (In USD)</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-2">
                                                                    <div class="md-form">
                                                                        <input type="text" id="stitle" placeholder="Cost" class="form-control" value="1000">
                                                                        <label for="stitle">Set Letter Limit</label>
                                                                    </div>
                                                                </div>
                                                            
                                                            </div>
                                                        </div> -->
                                                            
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="col-lg-4 connectedSortable">
                    @if($product->status != 'pending')
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Update</h3>
                                <p>Product Status</p>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <select class="form-control" id="status" name="status">
                                        <option value="">Please select</option>
                                        @if($product->status == 'active')
                                            <option value="active" selected>Active</option>
                                            <option value="inactive">In Active</option>
                                        @endif 
                                        @if($product->status == 'inactive')
                                            <option value="inactive" selected>In Active</option>
                                            <option value="active">Active</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Image</h3>
                            <p>Featured Image</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <img src="{{ $product->featured_image ? $product->featured_image :'/assets/admin/img/image.svg' }}" id="preview_featured" class="border w-100 mb-2" style="display:{{ $product->featured_image ? '' :'none' }}">
                                    {{-- <a href="#" class="delImageNew mr-1"><img src="/assets/admin/img/closered.svg" width="25" /></a> --}}
                                </div>
                            </div>
                            <div class="upload-btn-wrapper">
                                <button class="uploadBtn">Upload Featured Image</button>
                                <input type="file" name="featured_image" onchange="renderImage(this, 'preview_featured')">
                            </div>
                            @error('featured_image')
                                <label class="label">
                                    <strong class="text-danger"> {{ $message }}</strong>
                                </label>
                            @enderror
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Image</h3>
                            <p>Featured Hover Image</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <img src="{{ $product->featured_hover_image ? $product->featured_hover_image :'/assets/admin/img/image.svg' }}" id="preview_hover_featured" class="border w-100 mb-2" style="display:{{ $product->featured_hover_image ? '' :'none' }}">
                                    {{-- <a href="#" class="delImageNew mr-1"><img src="/assets/admin/img/closered.svg" width="25" /></a> --}}
                                </div>
                            </div>
                            <div class="upload-btn-wrapper">
                                <button class="uploadBtn">Upload Featured Hover Image</button>
                                <input type="file" name="featured_hover_image" onchange="renderImage(this, 'preview_hover_featured')">
                            </div>
                            @error('featured_hover_image')
                                <label class="label">
                                    <strong class="text-danger"> {{ $message }}</strong>
                                </label>
                            @enderror
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Other Image</h3>
                            <p>Upload other shots</p>
                        </div>
                        <div class="card-body">
                            <div class="row" id="appendImages">
                                @if(count($product->other_images)>0) 
                                @foreach ($product->other_images as $other_image)
                                <div class="col-md-6">
                                    <img src="{{ $other_image->full_url ? $other_image->full_url:'/assets/admin/img/collect-big.jpg' }}" class="border w-100">
                                    <a href="#" class="delImageNew mr-1" data-url="/admin/delete-media/{{ isset($other_image->id) ? $other_image->id:'' }}" data-request="remove" data-redirect="/admin/products/{{ $product->id }}/edit"><img src="/assets/admin/img/closered.svg" width="25" /></a>
                                </div>
                                @endforeach
                                @endif
                            </div>
                            <div class="upload-btn-wrapper">
                                <button class="uploadBtn">Upload Images</button>
                                <input type="file" name="other_images[]" multiple id="other_image">
                            </div>
                            @error('other_image')
                                <label class="label">
                                    <strong class="text-danger"> {{ $message }}</strong>
                                </label>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Video</h3>
                            <p>Upload video (mp4, mov only)</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12" id="videoUploadRemove">
                                    <video width="100%" class="videoUpload" height="200" controls="" style="object-fit: cover; display:{{ $product->product_video ? '' :'none' }}">	 
                                        <source src="{{ $product->product_video ? $product->product_video :'' }}" id="videoUpload" type="video/mp4">
                                    </video>
                                    @if($product->product_video_data)
                                        <a href="#" class="delImageNew mr-1" data-url="/admin/delete-media/{{ $product->product_video_data ? $product->product_video_data->id:'' }}" data-request="remove" data-redirect="/admin/products/{{ $product->id }}/edit"><img src="/assets/admin/img/closered.svg" width="25" /></a>
                                    @endif
                                </div> 
                            </div>
                            <div class="upload-btn-wrapper">
                                <button class="uploadBtn">Upload video</button>
                                <input type="file" onchange="videoRender(this, 'videoUpload')" name="product_video" accept="video/*" id="product-video">
                            </div>
                            @error('product_video')
                                <label class="label">
                                    <strong class="text-danger"> {{ $message }}</strong>
                                </label>
                            @enderror
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Category</h3>
                            <p>Select category & sub category</p>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                @error('category_id')
                                    <label class="label">
                                        <strong class="text-danger"> {{ $message }}</strong>
                                    </label>
                                @enderror
                                @error('sub_category_id')
                                    <label class="label">
                                        <strong class="text-danger"> {{ $message }}</strong>
                                    </label>
                                @enderror
                                @foreach ($productCategories as $productCategory)
                                    <div class="col-12">
                                        <input class="filled-in" name="category_id[]" onclick="checkChild(this)" {{ is_array($categories) && in_array($productCategory->id, $categories) ? 'checked' : '' }} value="{{ $productCategory->id }}" type="checkbox" id="cat_{{ $productCategory->id }}">
                                        <label for="cat_{{ $productCategory->id }}">{{ $productCategory->name }}</label>
                                    </div>
                                    @if (count($productCategory->childs)>0)
                                        @foreach ($productCategory->childs as $child)
                                            <div class="col-11 offset-1">
                                                <input class="filled-in parent_check_{{ $productCategory->id }}" name="sub_category_id[]" value="{{ $child->id }}" {{ is_array($subCategories) && in_array($child->id, $subCategories) ? 'checked' : '' }} type="checkbox" id="child_{{ $child->id }}">
                                                <label for="child_{{ $child->id }}">{{ $child->name }}</label>
                                            </div>
                                        @endforeach
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    
                    {{-- <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Custom Size</h3>
                            <p>Select category</p>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                @error('product_custom_size_id')
                                    <label class="label">
                                        <strong class="text-danger"> {{ $message }}</strong>
                                    </label>
                                @enderror
                                @foreach ($productCustomSizes as $productCustomSize) 
                                <div class="col-12">
                                    <input class="filled-in product_custom_size_id" name="product_custom_size_id" {{ $productCustomSize->id ==$product->product_custom_size_id ? 'checked':''  }} value="{{ $productCustomSize->id }}" type="checkbox" id="productCustomSize_{{ $productCustomSize->id }}">
                                    <label for="productCustomSize_{{ $productCustomSize->id }}">{{ $productCustomSize->title }}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div> --}}
                        
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Avg. Lead time</h3>
                            <p>In Days</p>
                        </div>

                        <div class="card-body">
                                <div class="md-form mt-0">
                                <input type="text" name="avg_lead_time" placeholder="Enter the Days here" value="{{ $product->avg_lead_time }}" class="form-control">
                            </div>
                        </div>
                        @error('avg_lead_time')
                            <label class="label">
                                <strong class="text-danger"> {{ $message }}</strong>
                            </label>
                        @enderror
                    </div>
                    
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Size Guide</h3>
                            <p>Attach a size guide</p>
                        </div>

                        <div class="card-body">

                            <div class="form-group"> 
                                <select class="form-control" id="product_size_guide_id" name="product_size_guide_id">
                                    <option value="">Please select</option>
                                    @foreach ($productSizeGuides as $productSizeGuide)
                                    <option value="{{ $productSizeGuide->id }}" {{ $productSizeGuide->id ==$product->product_size_guide_id ? 'selected':''  }}>{{ $productSizeGuide->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('product_size_guide_id')
                                <label class="label">
                                    <strong class="text-danger"> {{ $message }}</strong>
                                </label>
                            @enderror
                        </div>
                    </div>
                    
                </section>
            </div>
        </div>
    </section>
    <input type="button" id="final_submit" data-request="ajax-submit" data-target="[role=post-data]" style="display: none;">

</form>    

@stop

@section('scripts')
<script src="{{ asset('js/custom-script.js') }}"></script>
<script src="{{ asset('js/sweetalert.js') }}"></script>
<script type="text/javascript">
    $('#update').on('click', function (e) { 
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

        $("#product-video").on("change", function(e) {
            var append = '<a data-request="remove-video" href="#" class="delImageNew mr-1"><img src="/assets/admin/img/closered.svg" width="25" /></a>'
            $('#videoUploadRemove').append(append);
        });

        $(document).on('click', '[data-request="remove-video"]', function () {
            var $this = $(this);
            var videoHtml =  '<video width="100%" class="videoUpload" height="200" controls="" style="object-fit: cover; display:none">'+ 
                                '<source src="" id="videoUpload" type="video/mp4">'+
                            '</video>';
            $('#videoUploadRemove').html(videoHtml);
            $this.remove();
        });


    $(document).on('click', 'input[type="checkbox"]', function() {      
        $('.product_custom_size_id').not(this).prop('checked', false);      
    });
    $(document).on('click', '[data-request="remove-image"]', function () {
        var $this = $(this);
        $this.closest('div').remove();
    });
    var set_generated_attributes ='';
    var number_index = '<?=count($product->varients)?>'+1;
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
<style type="text/css">
 
</style>
@endsection