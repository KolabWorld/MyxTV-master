@extends('admin/app')
{{-- Web site Title --}}
@section('title') Dashboard :: @parent @stop
@section('content')
@include('admin.partials.header',['title'=>'Gift cards','description'=>'Manage gift cards'])
 

  <section class="content mb-5">
      <div class="container-fluid">
            <div class="row mb-2"  style="margin-top:-15px">
                <div class="col-sm-12 mb-3">
                    <div class="backbtnPanel nonflex">
                        <div><a href="javascript:history.back()" class="btn btn-sm btn-auto btn-outline-dark">Back</a></div>
                        <div> 
                            <button type="button" id="save" class="btn btn-sm btn-dark btn-auto">Update Gift Card</button>
                        </div>
                    </div>
                </div>
            </div>


            <form role="post-data" method="POST"  action="/admin/gift-card" enctype="multipart/form-data">
                <div class="row">
                    
                        <section class="col-lg-8 connectedSortable">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="myordersData">
                                        <div class="row" >
                                            
                                            <div class="col-sm-12">
                                                <div class="md-form">
                                                    <input type="text" id="gtitle" name="title" value="{{ @$giftcard->title }}" placeholder="Enter the item title here" class="form-control">
                                                    <label for="gtitle">Item Title</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group textarea-group">
                                                    <label for="gdescript" class="active">Short Description</label>
                                                    <textarea class="form-control" id="gdescript" placeholder="Start typing here" rows="3" name="short_description">{{ @$giftcard->short_description }}</textarea>
                                                </div>
                                            </div>


                                            <div class="col-md-12">
                                                <h5 class="mb-1 f-16 playfair">Gift card: Values</h5>
                                                <p class=" f-12 theme-Ltext">* Mention the number of values in (USD)</p> 
                                            </div> 
                                            
                                        </div>


                                        <div class="row gift-price">
                                            @if (@$giftcard && !$giftcard->GiftCardItem->isEmpty())
                                          
                                                @foreach ($giftcard->GiftCardItem as $key=>$items)

                                                    <div class="col-lg-3 gift">
                                                        <div class="md-form">
                                                            <input type="text" id="giftcost" placeholder="Cost (In USD)" class="form-control text-blackM" name="price[]" value="{{ (int)$items->price }}">
                                                            <label class="active" for="giftcost">Cost (In USD)</label>
                                                        </div>
                                                        <img src="/assets/admin/img/giftplus.svg" class="mt-4 mr-2 add-new" /> 
                                                        @if(!$loop->first)
                                                            <img src="/assets/admin/img/giftclose.svg" class="mt-4 remove" />
                                                        @endif
                                                       
                                                    </div>

                                                @endforeach                                        


                                            @else

                                                <div class="col-lg-3 gift">
                                                    <div class="md-form">
                                                        <input type="text" id="giftcost" placeholder="Cost (In USD)" class="form-control text-blackM" name="price[]" value="">
                                                        <label class="active" for="giftcost">Cost (In USD)</label>
                                                    </div>
                                                    
                                                        <img src="/assets/admin/img/giftplus.svg" class="mt-4 mr-2 add-new" /> 
                                                    
                                                </div>

                                            @endif
                                            

                                            <!-- div class="col-lg-2">
                                                <div class="md-form">
                                                    <input type="text" id="giftcost1" placeholder="Cost (In USD)" class="form-control text-blackM">
                                                    <label class="active" for="giftcost1">Cost (In USD)</label>
                                                </div>
                                            </div>

                                            <div class="col-lg-1">
                                                <img src="/assets/admin/img/giftplus.svg" class="mt-4 mr-2" />
                                                <img src="/assets/admin/img/giftclose.svg" class="mt-4" />
                                            </div>

                                            <div class="col-lg-2">
                                                <div class="md-form">
                                                    <input type="text" id="giftcost2" placeholder="Cost (In USD)" class="form-control text-blackM">
                                                    <label class="active" for="giftcost2">Cost (In USD)</label>
                                                </div>
                                            </div>

                                            <div class="col-lg-1">
                                                <img src="/assets/admin/img/giftplus.svg" class="mt-4 mr-2" />
                                                <img src="/assets/admin/img/giftclose.svg" class="mt-4" />
                                            </div>

                                            <div class="col-lg-2">
                                                <div class="md-form">
                                                    <input type="text" id="giftcost3" placeholder="Cost (In USD)" class="form-control text-blackM">
                                                    <label class="active" for="giftcost3">Cost (In USD)</label>
                                                </div>
                                            </div>

                                            <div class="col-lg-1">
                                                <img src="/assets/admin/img/giftplus.svg" class="mt-4 mr-2" />
                                                <img src="/assets/admin/img/giftclose.svg" class="mt-4" />
                                            </div>

                                            <div class="col-lg-2">
                                                <div class="md-form">
                                                    <input type="text" id="giftcost4" placeholder="Cost (In USD)" class="form-control text-blackM">
                                                    <label class="active" for="giftcost4">Cost (In USD)</label>
                                                </div>
                                            </div>

                                            <div class="col-lg-1">
                                                <img src="/assets/admin/img/giftplus.svg" class="mt-4 mr-2" />
                                                <img src="/assets/admin/img/giftclose.svg" class="mt-4" />
                                            </div> -->


                                        </div>

                                        
                                    </div>
                                </div>
                            </div>
                        </section>

                        <section class="col-lg-4 connectedSortable">

                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">Update</h3>
                                            <p>Gift Card Status</p>
                                        </div>

                                        <div class="card-body">
                                            <div class="form-group">
                                                <select class="form-control" name="status">
                                                    <option  value="">Please select</option>
                                                    <option value="active" @if(@$giftcard->status == 'active')
                                                        selected
                                                    @endif>Active</option>

                                                    <option @if(@$giftcard->status == 'inactive') selected
                                                    @endif value="inactive">In Active</option>                                         
                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Image</h3>
                                        <p>Featured Image</p>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            @if (@$giftcard->featured_image)
                                            <div class="col-md-12">
                                                <img src="/assets/admin/img/image.svg"  class="border w-100 mb-2" style="display: none">
                                                <img src="{{@$giftcard->featured_image}}"  class="border w-100 mb-2" >
                                            </div>
                                            @endif
                                        </div> 
                                        <div class="upload-btn-wrapper">
                                            <button class="uploadBtn">Upload Featured Image</button>
                                            <input type="file" name="featured_image">
                                        </div>
                                    </div>
                                </div>
            

                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Custom Value</h3>
                                        <p>Applicable or not</p>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <input class="filled-in product_custom_size_id" name="custom_value" value="allowed" type="radio" id="Show"  
                                                @if (@$giftdcard->custom_value == 'allowed')
                                                    checked
                                                @endif>
                                                <label for="Show">Show</label>
                                            </div>
                                            <div class="col-12">
                                                <input class="filled-in product_custom_size_id" name="custom_value" value="disallowed" type="radio" id="Hide" @if(@$giftcard->custom_value == 'disallowed')
                                                    checked
                                                @endif>
                                                <label for="Hide">Hide</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Validity</h3>
                                        <p>Gift Card Validity</p>
                                    </div>

                                    <div class="card-body">

                                        <div class="form-group">
                                            <select class="form-control" name="validity">
                                                <option value="">Please select validity</option>
                                                @for ($i=1; $i<=12; $i++)
                                                    <option @if (@$giftcard->validity==$i)
                                                        selected
                                                    @endif value="{{$i}}">{{$i}} Month</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                        </section> 

                        <input type="button" id="final_submit" data-request="ajax-submit" data-target="[role=post-data]" style="display: none;">   

                </div>

            </form>    

      </div>
  </section>
  {{-- Filter Modal --}}
  

@stop

@section('scripts')
<script src="{{ asset('js/custom-script.js') }}"></script>
<script src="{{ asset('js/sweetalert.js') }}"></script>
<script type="text/javascript">
    $('#save').on('click', function (e) { 
        $('#final_submit').click();
    });
</script>
<script>
    $(document).on('click', 'input[type="checkbox"]', function () {
        $('.product_custom_size_id').not(this).prop('checked', false);
    });

</script>
<script>
    
    $("body").on("click",".add-new",function(e){    
        $(".gift-price").append('<div class="col-lg-3 gift"><div class="md-form"><input type="text" id="giftcost" placeholder="Cost (In USD)" class="form-control text-blackM" name="price[]" value=""><label class="active" for="giftcost">Cost (In USD)</label></div><img src="/assets/admin/img/giftplus.svg" class="mt-4 mr-2 add-new" /><img src="/assets/admin/img/giftclose.svg" class="mt-4 remove" /></div>');
    });
    
    $("body").on("click",".remove",function(e){
        $(this).parents('.gift').remove();
    });
</script>

@stop

@section('styles')
<style type="text/css">
 
</style>
@endsection