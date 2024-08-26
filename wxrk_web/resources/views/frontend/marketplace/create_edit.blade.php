@extends('frontend.app')

{{-- Web site Title --}}
@section('title') :: @parent @stop

@section('content')
    @include('frontend.partials.nav', [
        'title' => 'Marketplace',
        'description' => 'Add/Edit',
    ])

    <section class="content mb-3">
        <div class="container-fluid">
            <form method="post" action="{{ $action }}" role="post-data" redirect="/marketplaces" enctype="multipart/form-data">
                @csrf
                @if($offer && $offer->id)
                    @method('PUT')
                @endif
                <div class="row">
                    <div class="col-md-12">
                        <div class="row align-items-center position-top-sticky">
                            <div class="col-sm-5 d-none d-sm-block">
                                <a href="/marketplaces" class="btn btn-outline-secondary">Go Back</a>
                            </div>
                            <div class="col-sm-7 text-sm-right">
                                <button type="button" id="submitbutton" data-request="ajax-submit" data-target="[role=post-data]" class="btn btn-success mr-2">
                                    @if($offer && $offer->id)
                                        Update
                                    @else
                                        {{-- @if((\Auth::user()->hasRoles(['vendor'])))
                                            Proceed To Pay
                                        @else --}}
                                            Submit
                                        {{-- @endif     --}}
                                    @endif
                                </button>
                                <a href="/marketplaces" class="btn btn-danger">Cancel</a>
                            </div>
                        </div>
                        <div class="dashbed-border-bottom mt-2 mb-3"></div>
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
                                                                <h2>Offer Details</h2>
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
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>Offer Name</label>
                                                                    <input type="hidden" name="offer_id" value="{{ $offer->id }}">
                                                                    <input type="text" class="form-control" name="offer_name" value="{{ $offer->offer_name }}"
                                                                        placeholder="Enter Offer Name" />
                                                                </div>
                                                                @error('offer_name')
                                                                    <label class="label">
                                                                        <strong class="text-danger"> {{ $message }}</strong>
                                                                    </label>
                                                                @enderror
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>Offer Price</label>
                                                                    <input type="number" class="form-control" name="offer_price" min="1" value="{{$offer->offer_price ? intval($offer->offer_price) : '' }}"
                                                                        placeholder="Enter offer price" />
                                                                </div>
                                                                @error('offer_price')
                                                                    <label class="label">
                                                                        <strong class="text-danger"> {{ $message }}</strong>
                                                                    </label>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>Offer Type</label>
                                                                    <select class="form-control" name="offer_type_id">
                                                                        <option value="">Select</option>
                                                                        @foreach ($offerTypes as $offerType)
                                                                            <option value="{{ $offerType->id }}" 
                                                                                @if($offerType->id == $offer->offer_type_id) selected @endif>
                                                                                {{ $offerType->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                @error('offer_type_id')
                                                                    <label class="label">
                                                                        <strong class="text-danger"> {{ $message }}</strong>
                                                                    </label>
                                                                @enderror
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>Offer Category</label>
                                                                    <select class="form-control" name="offer_category_id">
                                                                        <option value="">Select</option>
                                                                        @foreach ($offerCategories as $offerCategory)
                                                                            <option value="{{ $offerCategory->id }}" 
                                                                                @if($offerCategory->id == $offer->offer_category_id) selected @endif>
                                                                                {{ $offerCategory->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                @error('offer_category_id')
                                                                    <label class="label">
                                                                        <strong class="text-danger"> {{ $message }}</strong>
                                                                    </label>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group form-label-group innerappform">
                                                                    <label>Select Countries</label>
                                                                    <select class="form-control select2" name="countries[]" multiple
                                                                        style="width: 100%;">
                                                                        <option value="">Select</option>
                                                                        @foreach ($countries as $country)
                                                                            <option value="{{ $country->id }}" @if(in_array($country->id,$offer->countries->pluck('id')->toArray())) selected @endif>{{ $country->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                @error('countries')
                                                                    <label class="label">
                                                                        <strong class="text-danger"> {{ $message }}</strong>
                                                                    </label>
                                                                @enderror
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>Time to Redeem</label>
                                                                    <input type="number" class="form-control" name="time_to_redeem" min="1" value="{{$offer->time_to_redeem ? intval($offer->time_to_redeem) : '' }}"
                                                                        placeholder="Enter Time to Redeem" />
                                                                </div>
                                                                @error('time_to_redeem')
                                                                    <label class="label">
                                                                        <strong class="text-danger"> {{ $message }}</strong>
                                                                    </label>
                                                                @enderror
                                                            </div>
                                                        </div>  
                                                        {{-- <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>Shipping</label>
                                                                    <input type="number" class="form-control" name="shipping_cost" min="1" value="{{$offer->shipping_cost ? intval($offer->shipping_cost) : '' }}"
                                                                        placeholder="Enter Shipping Cost" />
                                                                </div>
                                                                @error('shipping_cost')
                                                                    <label class="label">
                                                                        <strong class="text-danger"> {{ $message }}</strong>
                                                                    </label>
                                                                @enderror
                                                            </div>
                                                        </div>  --}}
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group innerappform">
                                                                    <label>Highlights of the offer</label>
                                                                    <textarea class="form-control h-100" name="highlight_of_offer"
                                                                    placeholder="Enter Highlights of the offer">{{$offer->highlight_of_offer}}</textarea>
                                                                </div>
                                                                @error('highlight_of_offer')
                                                                    <label class="label">
                                                                        <strong class="text-danger"> {{ $message }}</strong>
                                                                    </label>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>Offer By(Company Name)</label>
                                                                    <input type="text" class="form-control" name="company_name" value="{{ $offer->company_name }}"
                                                                        placeholder="Enter Company Name" />
                                                                </div>
                                                                @error('company_name')
                                                                    <label class="label">
                                                                        <strong class="text-danger"> {{ $message }}</strong>
                                                                    </label>
                                                                @enderror
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform uploadformbox">
                                                                    <label>Company Logo</label>
                                                                    <input type="text" class="form-control"
                                                                        disabled="" placeholder="(JPG, png only)">
                                                                    <div class="upload-btn-wrapper up-loposition">
                                                                        <button class="uploadBtn">Upload</button>
                                                                        <input type="file" name="company_logo" onchange="renderImage(this,'preview_company_logo')">
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-2">
                                                                    <div class="col-4">
                                                                        <div class="uploaded-doc">
                                                                            <img src="{{ $offer->company_logo?: '/assets/admin/images/logo.png' }}" id="preview_company_logo">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @error('company_logo')
                                                                    <label class="label">
                                                                        <strong class="text-danger"> {{ $message }}</strong>
                                                                    </label>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group innerappform">
                                                                    <label>About the company</label>
                                                                    <textarea class="form-control h-100" name="about_the_company"
                                                                    placeholder="About the company">{{$offer->about_the_company}}</textarea>
                                                                </div>
                                                                @error('about_the_company')
                                                                    <label class="label">
                                                                        <strong class="text-danger"> {{ $message }}</strong>
                                                                    </label>
                                                                @enderror
                                                            </div>
                                                        </div> 
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group innerappform">
                                                                    <label>Links</label>
                                                                    <input type="text" class="form-control" name="link" value="{{$offer->link}}"
                                                                        placeholder="Enter Website link to redeem the offer" />
                                                                </div>
                                                                @error('link')
                                                                    <label class="label">
                                                                        <strong class="text-danger"> {{ $message }}</strong>
                                                                    </label>
                                                                @enderror
                                                            </div>
                                                        </div> 
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>Offer Card - BG color</label>
                                                                    <input type="text" class="form-control" name="offer_code_bg_color"
                                                                    value="{{$offer->offer_code_bg_color}}" placeholder="Enter 6 digit color code" />
                                                                </div>
                                                                @error('offer_code_bg_color')
                                                                    <label class="label">
                                                                        <strong class="text-danger"> {{ $message }}</strong>
                                                                    </label>
                                                                @enderror
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>Offer Card - Text color</label>
                                                                    <input type="text" class="form-control" name="offer_code_text_color"
                                                                    value="{{$offer->offer_code_text_color}}" placeholder="Enter 6 digit color code" />
                                                                </div>
                                                                @error('offer_code_text_color')
                                                                    <label class="label">
                                                                        <strong class="text-danger"> {{ $message }}</strong>
                                                                    </label>
                                                                @enderror
                                                            </div>
                                                        </div> 
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>Attachment Type</label>
                                                                    <select name="attachment_type" class="form-control" onchange="vedioAttchment(this, 'autoplay_id')">
                                                                        <option value="">Select Attachment Type</option>
                                                                        <option value="image" {{ ($offer->attachment_type == 'image') ? 'selected' : '' }}>Image</option>
                                                                        <option value="video" {{ ($offer->attachment_type == 'video') ? 'selected' : '' }}>Video</option>
                                                                    </select>
                                                                </div>
                                                                @error('attachment_type')
                                                                    <label class="label">
                                                                        <strong class="text-danger"> {{ $message }}</strong>
                                                                    </label>
                                                                @enderror
                                                            </div>
                                                            <div class="col-md-6" id="autoplay_id" style="display: {{ $offer->attachment_type ? ($offer->attachment_type != 'video' ? 'none' : 'block') : 'block' }}">
                                                                <div class="form-group innerappform">
                                                                    <label>Autoplay</label>
                                                                    <select name="is_auto_play" class="form-control">
                                                                        <option value="">Select Autoplay</option>
                                                                        <option value="1" {{ $offer->is_auto_play == '1' ? 'selected' : '' }}>Yes</option>
                                                                        <option value="0" {{ $offer->is_auto_play == '0' ? 'selected' : '' }}>No</option>
                                                                    </select>
                                                                </div>
                                                                @error('is_auto_play')
                                                                    <label class="label">
                                                                        <strong class="text-danger"> {{ $message }}</strong>
                                                                    </label>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6 pl-4"> 
                                                                <div class="image-content" style="display : {{ $offer->attachment_type ? (($offer->attachment_type == 'image') ? 'block' : 'none') : 'block'}}">    
                                                                    <h4 class="f-13 mt-4 theme-Dtext playfair">Upload Portfolio Image</h4>
                                                                    <p class="f-12 theme-Ltext">Dimension: 1024 px x 1024 px<br>Ratio: 1:1</p>
                                                                    <p class="f-12 theme-Ltext">Format: JPEG, JPG, PNG only<br>Mode: sRGB</p>
                                                                    <p class="f-12 theme-Ltext">Weight: Less than 3mb</p>
                                                                    <p class="f-12 theme-Ltext">Please note that the image should not contain any kind of watermark and you have the appropriate legal rights to publish the image.</p>
                                                                </div>
                                                                <div class="video-content" style="display : {{ $offer->attachment_type ? (($offer->attachment_type == 'video') ? 'block' : 'none') : 'none' }}">    
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
                                                                        <input type="file" id="inputFile" name="thumbnail_image" accept="image/gif, image/jpeg, image/png">
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-2">
                                                                    <div class="col-8">
                                                                        <div class="uploaded-doc" style="height: 150px !important;">
                                                                            <img src="{{ @$offer->thumbnail_image ?: '/assets/admin/images/logo.png' }}" id="image_upload_preview" style="display : {{ $offer->attachment_type ? ($offer->attachment_type == 'image') ? 'block' : 'none' : 'block' }}">
                                                                            {{--  <a href="#"><img src="/assets/admin/images/close.svg"></a>  --}}
                                                                            <video width="100%" muted class="video_upload_preview" style="display : {{ ($offer->attachment_type == 'video') ? 'block' : 'none' }}" controls>
                                                                                <source id="video_upload_preview" src="{{ @$offer->thumbnail_image }}">
                                                                            </video>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @error('thumbnail_image')
                                                                    <label class="label">
                                                                        <strong class="text-danger"> {{ $message }}</strong>
                                                                    </label>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform uploadformbox">
                                                                    <label>Banners</label>
                                                                    <input type="text" class="form-control"
                                                                        disabled="" placeholder="(JPG, Png only)">
                                                                    <div class="upload-btn-wrapper up-loposition">
                                                                        <button class="uploadBtn">Upload</button>
                                                                        <input type="file" name="banners[]" multiple id="banner">
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-2" id="appendBanners">
                                                                    {{-- append banners --}}
                                                                    @if($offer && $offer->banners && (count($offer->banners)>0)) 
                                                                        @foreach ($offer->banners as $banner)
                                                                            <div class="col-md-3">
                                                                                <img src="{{ $banner->full_url ? $banner->full_url:'/assets/admin/img/collect-big.jpg' }}" class="border w-100" style="width:60px;height:80px;">
                                                                                <a href="#" class="delImageNew mr-1" data-url="/delete-media/{{ isset($banner->id) ? $banner->id:'' }}" data-request="remove" data-redirect="/marketplace/{{ $offer->id }}/edit">
                                                                                    <img src="/assets/frontend/img/closered.svg" width="25" />
                                                                                </a>
                                                                            </div>
                                                                        @endforeach
                                                                    @endif
                                                                </div>
                                                                @error('banners')
                                                                    <label class="label">
                                                                        <strong class="text-danger"> {{ $message }}</strong>
                                                                    </label>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if($offer && ($offer->id) && !empty($offer->promoCodes))
                                        <div class="card formCard">
                                            <div class="card-header">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                                                        data-target="#EquipmentDocuments">
                                                        <div class="row">
                                                            <div class="col-md-9">
                                                                <div class="head-title form-head">
                                                                    <h2>Promo Code</h2>
                                                                    <h5>Details</h5>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 mt-2">
                                                                <a href="#promocode" data-toggle="modal"
                                                                    class="text-primary fw-bold f-12">Add Promocode</a>
                                                            </div>
                                                        </div>
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="EquipmentDocuments" class="collapse" data-parent="#addAccordian">
                                                <div class="card-body pt-2">
                                                    <div class="row align-items-center"> 
                                                        <div class="col-6 col-sm-3">
                                                            <h4>{{count($offer->promoCodes)}}</h4>
                                                            <p class="text-black">No. Of Coupons</p>
                                                        </div>
                                                        <div class="col-6 col-sm-3">
                                                            <h4>{{count($offer->soldPromoCodes)}}</h4>
                                                            <p class="text-black">Coupons Sold</p>
                                                        </div>
                                                        <div class="col-6 col-sm-3">
                                                            <h4>{{ $offer->remaining_promocodes }}</h4>
                                                            <p class="text-black">Coupons Remaining</p>
                                                        </div>
                                                        <div class="col-6 col-sm-3">
                                                            <h4>{{ $offer->low_stock }}</h4>
                                                            <p class="text-black">Low Stock Warning</p>
                                                        </div> 
                                                        <div class="col-6 col-sm-3">
                                                            <input type="number" class="form-control" id="low-stock-perc" @if(!count($offer->promoCodes)) disabled @endif>
                                                            <label class="text-danger" id="low_stock_perc_error"></label>
                                                            <p class="text-black">Low Stock Warning %</p>
                                                        </div> 
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <table class="table datatbalennew">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Promocode</th>
                                                                        <th>Status</th>
                                                                        <th>Created Date</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach($offer->promoCodes as $promoCode)
                                                                        <tr>
                                                                            <td>
                                                                                <strong>
                                                                                    {{ $promoCode->promo_code }}
                                                                                </strong>
                                                                            </td>
                                                                            <td>
                                                                                <span class="badge 
                                                                                @if($promoCode->status == 'active')
                                                                                    badge-success
                                                                                @elseif($promoCode->status == 'sold')
                                                                                    badge-danger
                                                                                @else
                                                                                    badge-warning
                                                                                @endif
                                                                                ">
                                                                                    {{ ucWords($promoCode->status) }}
                                                                                </span>
                                                                            </td>
                                                                            <td>
                                                                                {{ date('Y-m-d', strtotime($promoCode->created_at)) }}
                                                                            </td>
                                                                            <td>
                                                                                @if($promoCode->status == 'active')
                                                                                <a href="#" data-url="/promo-code/{{ $promoCode->id }}/delete"
                                                                                    data-request="remove" data-redirect="/marketplace/{{ $offer->id }}/edit">
                                                                                    <i class="fas fa-trash-alt"></i>
                                                                                </a>
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card dashcard">
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
                                                {{ $offer->status ? ($offer->status == 'active' ? 'checked' : '') : 'checked' }}>
                                            <label for="active">ACTIVE</label>
                                        </div>
                                        @if($offer && $offer->id)
                                            <div class="activechkbox">
                                                <input class="filled-in" name="status" type="radio" id="inactive" value="inactive"
                                                {{ $offer->status == 'inactive' ? 'checked' : '' }}>
                                                <label for="inactive">INACTIVE</label>
                                            </div>
                                            {{-- <div class="activechkbox mb-0">
                                                <input class="filled-in" name="status" type="radio" id="blacklist" value="blacklist"
                                                {{ $offer->status == 'blacklist' ? 'checked' : '' }}>
                                                <label for="black">BLACKLIST</label>
                                            </div> --}}
                                        @endif
                                    </div>
                                </div>
                                <div class="card dashcard">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h2>Offer Listing</h2>
                                                <h3>Add details for below field</h3>
                                            </div> 
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12" id="price-view-msg-div" style="display: none">
                                                <label class="ml-1 text-danger" id="price-view-msg"></label>
                                            </div> 
                                            <div class="col-md-12">
                                                <div class="form-group innerappform">
                                                    <label>Start Date</label>
                                                    <input type="date" class="form-control start_date" id="start_date" name="start_date" value="{{ $offer->start_date }}"
                                                        placeholder="Enter Start Date" />
                                                </div>
                                                @error('start_date')
                                                    <label class="label">
                                                        <strong class="text-danger"> {{ $message }}</strong>
                                                    </label>
                                                @enderror
                                            </div> 
                                            <div class="col-md-12">
                                                <div class="form-group innerappform">
                                                    <label>Offer Listing Period</label>
                                                    <input type="number" class="form-control offer_period" id="offer_listing_period" name="offer_period" min="1" value="{{ $offer->offer_period ? intval($offer->offer_period) : '' }}"
                                                        placeholder="Enter period in days" />
                                                    <span class="text fw-bold text-red" id="offer_listing_period_error" style="display: none"></span>
                                                </div>
                                                @error('offer_period')
                                                    <label class="label">
                                                        <strong class="text-danger"> {{ $message }}</strong>
                                                    </label>
                                                @enderror
                                            </div>
                                            {{-- <div class="col-md-12">
                                                <div class="form-group innerappform">
                                                    <label>Offer Listing Price</label>
                                                    <input type="text" class="form-control offer_listing_price" id="offer_listing_price" name="offer_listing_price" value="{{ $offer->offer_listing_price ? intval($offer->offer_listing_price) : '' }}"
                                                        placeholder="Enter offer listing price" readonly />
                                                </div>
                                                @error('offer_listing_price')
                                                    <label class="label">
                                                        <strong class="text-danger"> {{ $message }}</strong>
                                                    </label>
                                                @enderror
                                            </div> 
                                            <div class="col-md-12">
                                                <div class="form-group innerappform">
                                                    <label>Offer Listing Value</label>
                                                    <input type="text" class="form-control offer_listing_value" id="offer_listing_value" name="offer_listing_value" value="{{ $offer->offer_listing_value ? intval($offer->offer_listing_value) : '' }}"
                                                        placeholder="Enter offer listing value" readonly />
                                                </div>
                                                @error('offer_listing_value')
                                                    <label class="label">
                                                        <strong class="text-danger"> {{ $message }}</strong>
                                                    </label>
                                                @enderror
                                            </div>  --}}
                                            {{-- <div class="col-md-12">
                                                <div class="form-group innerappform">
                                                    <label>Premium Category</label>
                                                    <select class="form-control premium_category_id" name="premium_category_id" min="1"  id="premium_category_id">
                                                        <option value="">Select</option>
                                                        @foreach ($premiumCategories as $premiumCategory)
                                                            <option value="{{ $premiumCategory->id }}" 
                                                                @if($premiumCategory->id == $offer->premium_category_id) selected @endif>
                                                                {{ $premiumCategory->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @error('premium_category_id')
                                                    <label class="label">
                                                        <strong class="text-danger"> {{ $message }}</strong>
                                                    </label>
                                                @enderror
                                            </div> 
                                            <div class="col-md-12">
                                                <div class="form-group innerappform">
                                                    <label>Premium Listing Period</label>
                                                    <input type="number" class="form-control offer_period premium_listing_period" id="premium_listing_period" name="premium_listing_period" min="1" value="{{ $offer->premium_listing_period ? intval($offer->premium_listing_period) : '' }}"
                                                        placeholder="Enter premium listing period" />
                                                </div>
                                                @error('premium_listing_period')
                                                    <label class="label">
                                                        <strong class="text-danger"> {{ $message }}</strong>
                                                    </label>
                                                @enderror
                                            </div> --}}
                                            {{-- <div class="col-md-12">
                                                <div class="form-group innerappform">
                                                    <label>Premium Listing Price</label>
                                                    <input type="text" class="form-control premium_listing_price" id="premium_listing_price" name="premium_listing_price" value="{{ $offer->premium_listing_price ? intval($offer->premium_listing_price) : '' }}"
                                                        placeholder="Enter premium listing price" readonly />
                                                </div>
                                                @error('premium_listing_price')
                                                    <label class="label">
                                                        <strong class="text-danger"> {{ $message }}</strong>
                                                    </label>
                                                @enderror
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group innerappform">
                                                    <label>Premium Value</label>
                                                    <input type="text" class="form-control premium_listing_value" id="premium_listing_value" name="premium_listing_value" value="{{ $offer->premium_listing_value ? intval($offer->premium_listing_value) : '' }}"
                                                        placeholder="Enter premium listing value" readonly />
                                                </div>
                                                @error('premium_listing_value')
                                                    <label class="label">
                                                        <strong class="text-danger"> {{ $message }}</strong>
                                                    </label>
                                                @enderror
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group innerappform">
                                                    <label>Total Value</label>
                                                    <input type="text" class="form-control total_value" id="total_value" name="total_value" value="{{ $offer->total_value ? intval($offer->total_value) : '' }}"
                                                        placeholder="Enter total value" readonly />
                                                </div>
                                                @error('total_value')
                                                    <label class="label">
                                                        <strong class="text-danger"> {{ $message }}</strong>
                                                    </label>
                                                @enderror
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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
    <script>
        var lengthFIle = 0;
        var maxAllowedImages = 4;
        $("#banner").on("change", function (e) {
            var files = e.target.files,
                filesLength = files.length;
            lengthFIle++;
            if (filesLength > maxAllowedImages || lengthFIle > maxAllowedImages) {
                Swal.fire(
                    'Warning!',
                    'You can upload maximum '+maxAllowedImages+' banners',
                    'warning'
                );
                return false;
            } else {
                for (var i = 0; i < filesLength; i++) {
                    var f = files[i]
                    var fileReader = new FileReader();

                    fileReader.onload = (function (e) {
                        var file = e.target;
                        let append = '<div class="col-md-3">' +
                            '<img src="' + e.target.result + '" class="border w-100"  style="width:60px;height:80px;">' +
                            '<a data-request="remove-image" href="#" class="delImageNew mr-1"><img src="/assets/frontend/img/closered.svg" width="25" /></a>' +
                            '</div>';
                        $('#appendBanners').append(append);
                    });
                    fileReader.readAsDataURL(f);
                }
            }
        });

        $(document).on('click', '[data-request="remove-image"]', function () {
            var $this = $(this);
            $this.closest('div').remove();
        });
    </script>

    <script>
        $(document).ready(function() {
            $("#premium_listing_period").prop('disabled', true);
            $('.offer_period1').change(function() {  
                var start_date = $('#start_date').val();
                var offer_period = $('#offer_period').val();
                var premium_period = $('#premium_listing_period').val();
                data = {
                    'start_date' : start_date,
                    'offer_period' : offer_period,
                    'premium_period' : premium_period,
                    '_token' : '{{ csrf_token() }}'
                }
                $.ajax({
                    url: '/get-price-values',
                    type: 'POST',
                    data: data,
                    success:function(data) {
                        console.log('hi', data);
                        if (data.code == 200) {
                            $('#offer_listing_price').val(data.data.offer_listing_price);
                            $('#offer_listing_value').val(data.data.offer_listing_value);
                            $('#premium_listing_price').val(data.data.premium_listing_price);
                            $('#premium_listing_value').val(data.data.premium_listing_value);
                            $('#total_value').val(data.data.total_value);
                            $('#price-view-msg-div').hide();

                        } else {
                            $('#offer_listing_value').val('');
                            $('#offer_listing_price').val('');
                            $('#premium_listing_price').val('');
                            $('#premium_listing_value').val('');
                            $('#total_value').val('');
                            $('#price-view-msg-div').show();
                            $('#price-view-msg').text(data.message);
                        }
                    }
                });
            });

            $("#offer_listing_period").on("keyup",function (e) {
                var inputValue = $(this).val();
                var now = new Date();
                var no_of_days = new Date(now.getFullYear(), now.getMonth()+1, 0).getDate();
                var dd = String(now.getDate()).padStart(2, '0');
                var result =(no_of_days - dd + 1);
                if (result < inputValue) {
                    $('#submitbutton').attr('disabled', true);
                    $('#offer_listing_period_error').html("The Offer Listing Period can't be greater than "+result+" days.");
                    $('#offer_listing_period_error').show();
                
                }
                else{
                    $('#submitbutton').attr('disabled', false);
                    $('#offer_listing_period_error').hide();
                }
                    // console.log(result,inputValue,no_of_days,dd);
            });

            $('#low-stock-perc').change(function() {  
                var low_stock_perc = $('#low-stock-perc').val();
                var offer_id = $('#offer_id').val();
                data = {
                    'offer_id' : offer_id,
                    'low_stock_perc' : low_stock_perc,
                    '_token' : '{{ csrf_token() }}'
                }
                $.ajax({
                    url: '/store-low-stock',
                    type: 'POST',
                    data: data,
                    success:function(data) {
                        console.log('hi', data);
                        if (data.code == 200) {
                          location.reload();
                        }
                    },
                    error: function ($response) {
                        if ($response.status === 422) {
                            $('#low_stock_perc_error').html($response.responseJSON.errors['low_stock_perc']);
                        }
                    }
                });
            });

            $('.premium_category_id').change(function() {  
                var premium_category_id = $('#premium_category_id').val();
                if(premium_category_id == ''){
                    $("#premium_listing_period").prop('disabled', true);
                }
                else{
                    $("#premium_listing_period").prop('disabled', false);
                }
                
            });
        });
    </script>

@endsection
