@extends('frontend.app')

{{-- Web site Title --}}
@section('title') :: @parent @stop

@section('content')

    @include('frontend.partials.nav', [
        'title' => 'Subscription Plan',
        'description' => 'Add/Edit',
    ])

    <section class="content mb-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row align-items-center position-top-sticky">
                        <div class="col-sm-5 d-none d-sm-block">
                            <a href="/subscription-plans" class="btn btn-outline-secondary">Go Back</a>
                        </div>
                        <div class="col-sm-7 text-sm-right">
                            <button type="button" data-request="ajax-submit" data-target="[role=post-data]" id="save"
                                class="btn btn-success mr-2">
                                @if($record && $record->id)
                                    Update
                                @else
                                    Submit
                                @endif
                            </button>
                            <a href="/subscription-plans" class="btn btn-danger">Cancel</a>
                        </div>
                    </div>
                    <div class="dashbed-border-bottom mt-2 mb-3"></div>
                    <form method="post" action="{{ $action }}" redirect="/subscription-plans" role="post-data"
                        enctype="multipart/form-data">
                        @if($record && $record->id)
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
                                                                <h2>Subscription Plan</h2>
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
                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>
                                                                        Plan Type <span style="color:red;">*</span>
                                                                    </label>
                                                                    <select class="form-control" id="plan_type" name="plan_type" required="">
                                                                        <option value="">Please select</option>
                                                                        @foreach ($planTypes as $planType)
                                                                            <option value="{{$planType}}" {{ ($planType == @$record->plan_type) ? 'selected':'' }}>
                                                                                {{ ucfirst($planType) }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>
                                                                        Plan Name <span style="color:red;">*</span> 
                                                                    </label>
                                                                    <input type="text" class="form-control" name="name" value="{{ $record->name }}"
                                                                        placeholder="Enter Plan Name" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>
                                                                        Offers in a month <span style="color:red;">*</span>
                                                                    </label>
                                                                    <input type="text" class="form-control" name="offers_in_a_month" value="{{ $record->offers_in_a_month }}"
                                                                        placeholder="Enter Offers in a month" />
                                                                </div>
                                                            </div>
                                                            {{-- <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>
                                                                        Premium Days <span style="color:red;">*</span>
                                                                    </label>
                                                                    <input type="text" class="form-control" name="premium_days" value="{{ $record->premium_days }}" 
                                                                     placeholder="Enter Premium Days"> 
                                                                </div>
                                                            </div> --}}
                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>
                                                                        Price <span style="color:red;">*</span>
                                                                    </label>
                                                                    <input type="text" class="form-control" name="price" value="{{ $record->price }}"
                                                                        placeholder="Enter Price" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <div class="form-group innerappform textarea-group">
                                                                    <label for="exampleFormControlTextarea1">
                                                                        Plan Description
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12" style="margin-top:3%;">
                                                                <div class="form-group innerappform textarea-group">
                                                                    <textarea class="form-control" name="description"
                                                                        id="exampleFormControlTextarea1" placeholder="Enter the long description here"
                                                                        rows="3">{{ $record->description ?: old('description') }}</textarea>
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
                                            {{ $record->status ? ($record->status == 'active' ? 'checked' : '') : 'checked' }}>
                                            <label for="active">ACTIVE</label>
                                        </div>
                                        @if($record && $record->id)
                                        <div class="activechkbox">
                                            <input class="filled-in" name="status" type="radio" id="inactive" value="inactive"
                                            {{ $record->status == 'inactive' ? 'checked' : '' }}>
                                            <label for="inactive">INACTIVE</label>
                                        </div>
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

@section('styles')
    <style type="text/css"></style>
    <link rel="stylesheet" href="/assets/admin/ckeditor/samples/toolbarconfigurator/lib/codemirror/neo.css">
@endsection

@section('scripts')
    @parent
    <script src="/assets/admin/ckeditor/ckeditor.js"></script>
    <script src="/assets/admin/ckeditor/samples/js/sample.js"></script>
    <script type="text/javascript"> 
        CKEDITOR.replace( 'description' );
        CKEDITOR.add            
    </script>
    <script type="text/javascript">
        $('#save').on('click', function (e) {
            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }
            $('#final_submit').click();
        });

        $(document).ready(function(){
            $("#plan_type").change();
        });

        function allowedImages(){
            var max_images_allowed = $('#name option:selected').data('max-images');
            $('#no_of_allowed_images').val(max_images_allowed);
        }

        function allowedPlans(th){
            planTypeId = $(th).val();
            selectedPlan = '{{ $record->plan_name_id }}';

            var data = {
                'plan_type_id' : planTypeId,
                '_token' : '{{ csrf_token() }}',
            };
            
            $.ajax({
		        url: '/get-subscription-plan' ,
				type: 'POST',
		        data: data,
		        success:function(data) {
                    var html = '<option value="">Please select</option>';
                    $.each(data.data, function(key, val){
                        if(selectedPlan && selectedPlan == val.id){
                            html += '<option value="'+val.id+'" data-max-images="'+val.max_images_allowed+'" selected>'+val.name+'</option>';
                        }else{
                            html += '<option value="'+val.id+'" data-max-images="'+val.max_images_allowed+'">'+val.name+'</option>';
                        }
                    });

                    $('#name').html(html);
                    allowedImages();
                }
		    });
        }
    </script>
@endsection
