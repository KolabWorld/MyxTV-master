@extends('frontend.app')
{{-- Web site Title --}}
@section('title') Create QR Codes History :: @parent @stop
@section('content')

@include('frontend.partials.nav',['title'=>'QR Codes History','description'=> (isset($qrcodeHxs) && $qrcodeHxs->id) ? 'Edit' : 'Add'])
<section class="content mb-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                {!! Form::model($qrcodeHxs, ['method' => isset($qrcodeHxs) && $qrcodeHxs->id ? 'put' : 'post']) !!}
                <div class="row align-items-center position-top-sticky">
                    <div class="col-5">
                        <a href="javascript:history.back()" class="btn btn-outline-secondary">Go Back</a>
                    </div>
                    <div class="col-7 text-right">
                        @if(!($number && $company_name))
                        <button type="submit" id="save" class="btn btn-success mr-2">
                            @if (isset($qrcodeHxs) && $qrcodeHxs->id)
                            Update
                            @else
                            Generate
                            @endif
                        </button>
                        @else
                        <a href="/qr-codes/print?number={{ $number }}&company_name={{ $company_name }}" class="btn btn-primary" target="_blank">Print</a>
                        @endif
                        <a href="/qr-codes" class="btn btn-danger">Cancel</a>
                    </div>
                </div>
                <div class="dashbed-border-bottom mt-2 mb-3"></div>
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="card formCard">
                            <div class="card-body">
                                <div class="head-title form-head mb-4">
                                    <h2>QR Code</h2>
                                    <h5>Master</h5>
                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="row">
                                            {{-- <div class="col-md-12">
                                                    <div class="form-group innerappform">
                                                        <label>Contractor</label>
                                                        <select name="admin_id" id="admin_id" class="form-control">
                                                            <option value="">Select Contractor</option>
                                                            @foreach ($contractors as $contractor)
                                                                <option value="{{ $contractor->id }}">{{ $contractor->name }}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                        @error('admin_id')
                                        <label class="label">
                                            <strong class="text-danger"> {{ $message }}</strong>
                                        </label>
                                        @enderror
                                    </div> --}}
                                    <div class="col-md-12">
                                        <div class="form-group innerappform">
                                            <label>Company</label>
                                            <select name="company_name" id="company_name" class="form-control">
                                                <option value="">Select</option>
                                                @foreach ($companies as $company=>$value)
                                                <option value="{{ $company }}" @if (old('company_name')==$company) selected @endif>{{ $company }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('company_name')
                                        <label class="label">
                                            <strong class="text-danger"> {{ $message }}</strong>
                                        </label>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group innerappform">
                                            <label>No. of QR Codes</label>
                                            <input type="text" name="number" value="{{ old('number') }}" class="form-control" placeholder="Enter Here" />
                                        </div>
                                        @error('number')
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
                {!! Form::close() !!}
                @if(!empty($records))
                <div class="dashbed-border-bottom mt-2 mb-3"></div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table dashtable">
                                <thead>
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>Company Name</th>
                                        <th>QR Code Number</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($records as $key => $record)
                                    <tr>
                                        {{-- <td>
                                                    <a href="#" data-url="/qr-code/{{ $record->id }}/delete" data-request="remove" data-redirect="/qr-codes" class="btn btn-sm btn-outline-dark">
                                        <i class="far fa-trash-alt text-danger"></i>
                                        </a>
                                        </td> --}}
                                        {{-- <td>
                                                    @if(($record->status == 'active'))
                                                    <span class="badge badge-success">
                                                        {{ucfirst($record->status)}}
                                        </span>
                                        @else
                                        <span class="badge badge-warning">
                                            {{ucfirst($record->status)}}
                                        </span>
                                        @endif
                                        </td> --}}
                                        <td>
                                            {{$key + 1}}.
                                        </td>
                                        <td>
                                            <strong>
                                                {{$record->company_name}}
                                            </strong>
                                        </td>
                                        <td>
                                            {{$record->qr_code_number}}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    </div>
    </div>
</section>

@stop

@section('scripts')
<script src="{{ asset('js/custom-script.js') }}"></script>
<script src="{{ asset('js/sweetalert.js') }}"></script>
<script type="text/javascript">
    $('#save').on('click', function(e) {
        $('#post-data').submit();
    });

</script>
@stop

@section('styles')
<style type="text/css"></style>
@endsection
