@extends('admin.app')
<!-- Main Container  -->
@section('content')
@include('admin.partials.header',['title'=>''.$designer->name.'','description'=>'Account Setting'])

<section class="content mb-5">
        <div class="container-fluid">
            <div class="accordian_area">
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-12">
                        <!-- @include('flash::message') -->
                        <h5 class="mb-2 accord_cat">
                            <a class="f-16 playfair colapseClickmoew {{ (Session::get('tab_type')=='cat0') ? '' : 'collapsed' }} " data-toggle="collapse" data-target="#cat0" role="button" aria-expanded="false" aria-controls="cat0">
                                Profile Settings
                            </a>
                        </h5>
                        <div class="collapse {{ (Session::get('tab_type')=='cat0') ? 'show' : '' }}" id="cat0" style="">
                            <form method="post" action="">
                                @csrf
                                <input type="hidden" name="tab_type" value="cat0">
                                <input type="hidden" name="designer_id" value="{{$designer->id}}">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="md-form">
                                            <input type="text" id="nametext" class="form-control" name="name" value="{{ old('name', @$designer->name) }}">
                                            <label for="nametext">Your Name</label>
                                            @if ($errors->has('name')) <p class="text-danger">{{ $errors->first('name') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="md-form">
                                            <input type="email" id="emailid" class="form-control" name="email" value="{{ old('email', @$designer->email) }}">
                                            <label for="emailid">Email address</label>
                                            @if ($errors->has('email')) <p class="text-danger">{{ $errors->first('email') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="md-form">
                                            <input type="text" id="contactno" class="form-control" name="mobile" value="{{ old('mobile', @$designer->mobile) }}">
                                            <label for="contactno">Contact no.</label>
                                            @if ($errors->has('mobile')) <p class="text-danger">{{ $errors->first('mobile') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="currency">Preferred Currency</label>
                                            <select id="currency" class="form-control" name="currency_id">
                                                <option value="">Choose...</option>
                                                @foreach ($currencies as $currency)
                                                    <option value="{{ $currency->id }}" {{ ( $currency->id==@$designer->currency_id) ? 'selected':'' }}>{{ $currency->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('currency_id')) <p class="text-danger">{{ $errors->first('currency_id') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3 mt-3">
                                        <button type="submit" class="btn btn-dark btn-sm">Save Setting</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="mt-2 mb-2"></div>
                        <h5 class="mb-2 accord_cat">
                            <a class="f-16 playfair colapseClickmoew {{ (Session::get('tab_type')=='cat1') ? '' : 'collapsed' }}" data-toggle="collapse" data-target="#cat1" role="button" aria-expanded="false" aria-controls="cat1">
                            About Me
                            </a>
                        </h5>
                        <div class="collapse {{ (Session::get('tab_type')=='cat1') ? 'show' : '' }}" id="cat1" style="">
                            <form method="post" action="">
                                @csrf
                                <input type="hidden" name="tab_type" value="cat1">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group textarea-group border-0 p-0">
                                            <label for="about_me_title">Write something about you</label>
                                            <textarea class="form-control border-bottom rounded-0 pb-4" name="about_me" id="about_me_title" placeholder="Enter here">{{$designer->about_me ?: old('about_me')}}</textarea>
                                            @if($errors->has('about_me')) 
                                                <p class="text-danger">{{ $errors->first('about_me') }}</p> 
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3 mt-3">
                                        <button type="submit" class="btn btn-dark btn-sm">Update About me</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="mt-2 mb-2"></div>
                        <h5 class="mb-2 accord_cat">
                            <a class="f-16 playfair colapseClickmoew {{ (Session::get('tab_type')=='cat2') ? '' : 'collapsed' }}" data-toggle="collapse" data-target="#cat2" role="button" aria-expanded="false" aria-controls="cat2">
                                Average Cost & Lead Time
                            </a>
                        </h5>
                        <div class="collapse {{ (Session::get('tab_type')=='cat2') ? 'show' : '' }}" id="cat2" style="">    
                            <form method="post" action="">
                                @csrf
                                <input type="hidden" name="tab_type" value="cat2">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="md-form">
                                            <input type="text" name="consultation_fee" id="consultation_fee_title" placeholder="Enter Avg. Appointment Cost here" class="form-control" value="{{(int)$designer->consultation_fee ?: old('consultation_fee')}}" onkeypress="javascript:return isNumber(event)">
                                            <label for="avg_cost_range_title">Avg. Appointment Cost (in USD)</label>
                                            @if($errors->has('consultation_fee')) 
                                                <p class="text-danger">{{ $errors->first('consultation_fee') }}</p> 
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="md-form">
                                            <input type="text" name="avg_lead_time" id="avg_lead_time_title" placeholder="Enter Avg. Lead Time here" class="form-control" value="{{$designer->avg_lead_time ?: old('avg_lead_time')}}" onkeypress="javascript:return isNumber(event)">
                                            <label for="avg_lead_time_title">Avg. Lead Time (in Days)</label>
                                            @if($errors->has('avg_lead_time')) 
                                                <p class="text-danger">{{ $errors->first('avg_lead_time') }}</p> 
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3 mt-3">
                                        <button type="submit" class="btn btn-dark btn-sm">Update Average Cost & Lead Time</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                        <div class="mt-2 mb-2">
                        </div>
                        <h5 class="mb-2 accord_cat">
                            <a class="f-16 playfair colapseClickmoew {{ (Session::get('tab_type')=='cat4') ? '' : 'collapsed' }} " data-toggle="collapse" data-target="#cat4" role="button" aria-expanded="false" aria-controls="cat4">
                                Bank Details
                            </a>
                        </h5>
                        <div class="collapse {{ (Session::get('tab_type')=='cat4') ? 'show' : '' }}" id="cat4" style="">
                            <form method="post" action="{{url('admin/designer/'.$designer->id.'/bank-account-setting')}}">
                                @csrf
                                <input type="hidden" name="tab_type" value="cat4">
                                <input type="hidden" name="id" value="{{$designer->account ? $designer->account->id : ''}}" />
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="md-form">
                                            <input type="text" id="stitle6" name="bank_name" value="{{$designer->account ? $designer->account->bank_name : old('bank_name')}}" placeholder="Enter here" class="form-control">
                                            <label for="stitle6">Bank Name</label>
                                        </div>
                                        @error('bank_name')
                                            <label class="label">
                                                <strong class="text-danger"> {{ $message }}</strong>
                                            </label>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="md-form">
                                            <input type="text" id="stitle10" name="bank_address" value="{{$designer->account ? $designer->account->bank_address : old('bank_address')}}" placeholder="Enter here" class="form-control">
                                            <label for="stitle10">Bank Address</label>
                                        </div>
                                        @error('bank_address')
                                            <label class="label">
                                                <strong class="text-danger"> {{ $message }}</strong>
                                            </label>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="md-form">
                                            <input type="text" id="stitle7" name="account_number" value="{{$designer->account ? $designer->account->account_number : old('account_number')}}" placeholder="Enter here" class="form-control">
                                            <label for="stitle7">Account No.</label>
                                        </div>
                                        @error('account_number')
                                            <label class="label">
                                                <strong class="text-danger"> {{ $message }}</strong>
                                            </label>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="md-form">
                                            <input type="text" id="stitle11" name="account_holder_name" value="{{$designer->account ? $designer->account->account_holder_name : old('account_holder_name')}}" placeholder="Enter here" class="form-control">
                                            <label for="stitle11">Account Holder Name</label>
                                        </div>
                                        @error('account_holder_name')
                                            <label class="label">
                                                <strong class="text-danger"> {{ $message }}</strong>
                                            </label>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="md-form">
                                            <input type="text" id="stitle8" name="iban_code" value="{{$designer->account ? $designer->account->iban_code : old('iban_code')}}" placeholder="Enter here" class="form-control">
                                            <label for="stitle8">IBAN</label>
                                        </div>
                                        @error('iban_code')
                                            <label class="label">
                                                <strong class="text-danger"> {{ $message }}</strong>
                                            </label>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="md-form">
                                            <input type="text" id="stitle9" name="swift_code" value="{{$designer->account ? $designer->account->swift_code : old('swift_code')}}" placeholder="Enter here" class="form-control">
                                            <label for="stitle9">SWIFT CODE</label>
                                        </div>
                                        @error('swift_code')
                                            <label class="label">
                                                <strong class="text-danger"> {{ $message }}</strong>
                                            </label>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 mb-3 mt-3">
                                        <button type="submit" class="btn btn-dark btn-sm">Update Bank Detail</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                            
                        <div class="mt-2 mb-2">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts') 
    @parent
    <script type="text/javascript">
        function isNumber(evt) {
            var iKeyCode = (evt.which) ? evt.which : evt.keyCode
            if (iKeyCode != 46 && iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57))
                return false;

            return true;
        }
    </script>
    
@endsection