@extends('admin/app')
{{-- Web site Title --}}
@section('title') Dashboard :: @parent @stop
@section('content')

 <div class="content-header">
    <div class="container-fluid mt-3">
        <div class="row mb-2">
            <div class="col-sm-12 col-md-12 col-12">
                <div class="tophead">
                    <div class="allTitle">
                        <a class="d-block d-lg-none" data-widget="pushmenu" href="#" role="button"><img src="/assets/admin/img/menu-left-alt.svg" width="18px" /></a>
                        <h2>Add New Offer</h2>
                        <div class="subTitle">Create new offers & assign designers and categories</div>
                    </div>
                    <div class="headpanel">
                        <div class="setting">
                            <a href="account-setting.html"><img src="/assets/admin/img/settings.svg" /></a>
                        </div>									
                        <div class="notify">
                            <a href="#"><img src="/assets/admin/img/notify.svg" /></a>
                        </div>
                        {{-- <div class="setting">
                            <a href="login.html"><img src="/assets/admin/img/logout.png" width="23" style="opacity: 0.8" /></a>
                        </div> --}}
                        <div class="adlogo d-inline-block"><img src="/assets/admin/img/logo.svg" /></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-12">
                <div class="backbtnPanel">
                    <div>
                        <a href="javascript:history.back()" class="btn btn-sm btn-auto btn-outline-dark">Back</a>
                    </div>
                    <div>
                        <a id="save" class="btn btn-sm btn-dark btn-auto">Publish Offer</a>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
<form role="post-data" method="POST" redirect="/admin/offers" action="/admin/offers/" enctype="multipart/form-data">
    <section class="content mb-5">
        <div class="container-fluid">
            <div class="row">
                <section class="col-lg-8 connectedSortable">
                    <div class="row">

                        <div class="col-lg-12">
                            <div class="myordersData">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="md-form">
                                            <input type="text" name="title" placeholder="Enter the Title here" class="form-control">
                                            <label for="stitle">Offer title</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 mt-2">
                                        <div class="form-group textarea-group">
                                            <label for="exampleFormControlTextarea2">Description</label>
                                            <textarea class="form-control" name="descriptions" rows="3"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">Image</h3>
                                                <p>Featured Image</p>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <img src="/assets/admin/img/image.svg" id="preview_featured" class="border w-100 mb-2" style="display: none">
                                                        {{-- <a href="#" class="delImageNew mr-1"><img src="/assets/admin/img/closered.svg" width="25" /></a> --}}
                                                    </div>
                                                </div> 
                                                <div class="upload-btn-wrapper">
                                                    <button class="uploadBtn">Upload Featured Image</button>
                                                    <input type="file" accept="image/*" name="featured_image" onchange="renderImage(this, 'preview_featured')">
                                                </div>
                                                @error('featured_image')
                                                <label class="label">
                                                    <strong class="text-danger"> {{ $message }}</strong>
                                                </label>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        &nbsp;
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-0">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="allTitle">
                                                        <h2>Offer discounts</h2>
                                                        <div class="subTitle mb-3">Define cart discounts</div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-4">
                                                    <div class="form-group">
                                                        <label for="status">Type</label>
                                                        <select class="form-control" name="offer_type">
                                                            <option value="">Select</option>
                                                            @foreach ($offer_types as $offer_type)
                                                            <option value="{{ $offer_type }}">{{ ucfirst($offer_type) }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-4">
                                                    <div class="md-form">
                                                        <input type="text" placeholder="Enter here" name="value" class="form-control">
                                                        <label for="stitle">Value (%)</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-4">
                                                    <div class="md-form">
                                                        <input type="date" placeholder="Enter here" name="from_date" class="form-control">
                                                        <label for="stitle">From Date</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-4">
                                                    <div class="md-form">
                                                        <input type="date" placeholder="Enter here" name="end_date" class="form-control">
                                                        <label for="stitle">End Date</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-4">
                                                    <div class="md-form">
                                                        <input type="text" placeholder="Enter here" name="usage_limit" class="form-control">
                                                        <label for="stitle">Usage limit</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-4">
                                                    <div class="md-form">
                                                        <input type="text" placeholder="Enter here" name="min_spend" class="form-control">
                                                        <label for="stitle">Min. Spend (USD)</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-4">
                                                    <div class="md-form">
                                                        <input type="text" placeholder="Enter here" name="max_spend" class="form-control">
                                                        <label for="stitle">Max. Spend (USD)</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-4">&nbsp;</div>

                                            </div>

                                            <div class="row mt-4 mb-2">
                                                <div class="col-sm-5">
                                                    <div class="allTitle">
                                                        <h2>Specific products</h2>
                                                        <div class="subTitle mb-3">Select</div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-7 textM-right mb-2">
                                                    <a class="btn btn-md btn-dark btn-auto mt-2" onclick="getCategoriesProducts();">Fetch from the selected categories</a>
                                                </div>
                                            </div>
                                            <div class="row my-2" style="display: none" id="specific_products">
                                                {{-- append specific products --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="col-lg-4 connectedSortable">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Product Category</h3>
                            <p>Select category & sub category</p>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                @foreach ($productCategories as $productCategory)
                                <div class="col-12">
                                    <input class="filled-in" onclick="checkChild(this);" name="category_id[]"
                                        value="{{ $productCategory->id }}" type="checkbox"
                                        id="cat_{{ $productCategory->id }}">
                                    <label for="cat_{{ $productCategory->id }}">{{ $productCategory->name }}</label>
                                </div>
                                @if (count($productCategory->childs)>0)
                                @foreach ($productCategory->childs as $child)
                                <div class="col-11 offset-1">
                                    <input class="filled-in sub_category parent_check_{{ $productCategory->id }}"
                                        name="sub_category_id[]" value="{{ $child->id }}" type="checkbox"
                                        id="child_{{ $child->id }}">
                                    <label for="child_{{ $child->id }}">{{ $child->name }}</label>
                                </div>
                                @endforeach
                                @endif
                                @endforeach
                            </div>
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
$('#save').on('click', function (e) {
    $('#final_submit').click();
});

$('#specific_products').on('click', '#all_products',function (e) {
    $(".all-products").attr("checked",e.currentTarget.checked);
});



function checkChild(element) {
    let parentId = element.value;
    let isChecked = element.checked;
    if (isChecked) {
        $('.parent_check_' + parentId).prop('checked', true)
    } else {
        $('.parent_check_' + parentId).prop('checked', false)
    }
}

function getCategoriesProducts() {
    var categories = [];
    $('.sub_category:checkbox:checked').each(function() {
        categories.push(parseInt($(this).val()));
    });

    var products = '<div class="col-md-3 col-6">'+
                            '<input class="filled-in all_products" name="all_products" value="all_products" type="checkbox" id="all_products">'+
                            '<label for="all_products">All Products</label>'+
                        '</div>';
    $.ajax({
        beforeSend: function(xhr) {},
        url: base_url + '/admin/get-categories-products?categories='+categories.join(),
        method: "GET",
        dataType: "json",
        success: function(response) {
            $.each(response.data, function(index, value) {
                products +='<div class="col-md-3 col-6">'+
                            '<input class="filled-in all-products" name="products['+index+']" value="'+value.id+'" type="checkbox" id="products_'+value.id+'">'+
                            '<label for="products_'+value.id+'">'+value.title+'</label>'+
                        '</div>';
            });

            $('#specific_products').html(products);
            $('#specific_products').show();
        },
        error: function (response) {
            console.log("Error: "+response)
        }
    });
}
</script>
@stop

@section('styles')
<style type="text/css">
 
</style>
@endsection