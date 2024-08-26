@extends('frontend.app')

{{-- Web site Title --}}
@section('title') :: @parent @stop

@section('content')
    @include('frontend.partials.nav', [
        'title' => 'Support',
        'description' => 'Add/Edit',
    ])

    <section class="content mb-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row align-items-center position-top-sticky">
                        <div class="col-sm-5 d-none d-sm-block">
                            <a href="/supports" class="btn btn-outline-secondary">Go Back</a>
                        </div>
                        <div class="col-sm-7 text-sm-right">
                            <button type="button" data-request="ajax-submit" data-target="[role=post-data]" id="save"
                                class="btn btn-success mr-2">
                                @if ($support && $support->id)
                                    Update
                                @else
                                    Submit
                                @endif
                            </button>
                            <a href="/supports" class="btn btn-danger">Cancel</a>
                        </div>
                    </div>
                    <div class="dashbed-border-bottom mt-2 mb-3"></div>
                    <input type="hidden" name="support_ticket_id" id="support_ticket_id" value="{{ $support->id }}">
                    <form method="post" action="{{ $action }}" redirect="/supports" role="post-data"
                        enctype="multipart/form-data">
                        @if ($support && $support->id)
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
                                                                <h2>Support</h2>
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
                                                                    <label>Name</label>
                                                                    <input type="text" class="form-control"
                                                                        name="name" value="{{ $support->name }}"
                                                                        placeholder="Enter Name" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>Mobile No.</label>
                                                                    <input type="text" class="form-control"
                                                                        name="mobile_no" value="{{ $support->mobile_no }}"
                                                                        placeholder="Enter Mobile No." />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform">
                                                                    <label>Email</label>
                                                                    <input type="text" class="form-control"
                                                                        name="email" value="{{ $support->email }}"
                                                                        placeholder="Enter Email" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group innerappform uploadformbox">
                                                                    <label>Attachment</label>
                                                                    <input type="text" class="form-control"
                                                                        disabled=""
                                                                        @if ($user->hasRole('vendor')) placeholder="(JPG, Png only)" @endif>
                                                                    @if ($user->hasRole('vendor'))
                                                                        <div class="upload-btn-wrapper up-loposition">
                                                                            <button class="uploadBtn">Upload</button>
                                                                            <input type="file" name="attachments[]"
                                                                                multiple="" id="attachment"
                                                                                accept="image/*">
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                <div class="row mb-2" id="appendAttachments">
                                                                     {{-- @dd($user->roles)  --}}
                                                                    @if ($support && $support->attachments && !empty($support->attachments) > 0)
                                                                        @foreach ($support->attachments as $attachment)
                                                                            <div class="col-md-3">
                                                                                <img src="{{ $attachment->full_url ? $attachment->full_url : '/assets/admin/img/collect-big.jpg' }}"
                                                                                    class="border w-100"
                                                                                    style="width:60px;height:80px;">
                                                                                @if ($user->hasRole('vendor'))
                                                                                    <a href="#"
                                                                                        class="delImageNew mr-1"
                                                                                        data-url="/delete-media/{{ isset($attachment->id) ? $attachment->id : '' }}"
                                                                                        data-request="remove"
                                                                                        data-redirect="/support/{{ $support->id }}/edit">
                                                                                        <img src="/assets/frontend/img/closered.svg"
                                                                                            width="25" />
                                                                                    </a>
                                                                                @endif
                                                                            </div>
                                                                        @endforeach
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group innerappform">
                                                                    <label>Feedback</label>
                                                                    <textarea class="form-control h-100" name="feedback" placeholder="Enter Your Feedback">{{ $support->feedback }}</textarea>
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
                                @if ($user->hasRole('admin'))
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
                                                <input class="filled-in" name="status" type="radio" id="open"
                                                    value="open"
                                                    {{ $support->status ? ($support->status == 'open' ? 'checked' : '') : 'checked' }}>
                                                <label for="open">OPEN</label>
                                            </div>
                                            @if ($support && $support->id)
                                                <div class="activechkbox">
                                                    <input class="filled-in" name="status" type="radio"
                                                        id="closed" value="closed"
                                                        {{ $support->status == 'closed' ? 'checked' : '' }}>
                                                    <label for="closed">CLOSED</label>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                @if($user->hasRole('admin') || ($user->hasRole('vendor') && !empty($support->comments)))
                                {{-- @dd(true)  --}}
                                    <div class="card dashcard">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <h2>Comments</h2>
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
                                                        <label>Remark</label>
                                                        <textarea class="form-control h-100" name="remark" id="remark" col="30" row="10"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group innerappform uploadformbox">
                                                        <label>Attachment</label>
                                                        <input type="text" class="form-control" disabled=""
                                                            placeholder="(JPG, Png only)">
                                                        <div class="upload-btn-wrapper up-loposition">
                                                            <button class="uploadBtn">Upload</button>
                                                            <input type="file" name="attachment" id="attachment1"
                                                                accept="image/*">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2" id="appendAttachments1">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group innerappform uploadformbox">
                                                        <button type="button" id="send-btn"
                                                            class="btn btn-secondary">Send</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @if (!empty($support->comments))
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="accordion addformaccordian" id="addAccordian1">
                                        <div class="card formCard">
                                            <div class="card-header">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link" type="button" data-toggle="collapse"
                                                        data-target="#Equipment1" aria-expanded="false">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="head-title form-head">
                                                                    <h2>Comments</h2>
                                                                    <h5>Details</h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="Equipment1" class="collapse show" data-parent="#addAccordian1"
                                                style="">
                                                <div class="card-body pt-0">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="table-responsive"
                                                                style="max-height: 500px; overflow-y:scroll">
                                                                <table class="table datatbalennew">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>S.NO</th>
                                                                            <th>Date</th>
                                                                            <th>Remark</th>
                                                                            <th>Attachment</th>
                                                                            <th>Added By</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($support->comments as $key => $val)
                                                                            <tr>
                                                                                <td>
                                                                                    {{ $loop->iteration }}
                                                                                </td>
                                                                                <td>
                                                                                    <strong>
                                                                                        {{ date('d M Y', strtotime($val->created_at)) }}
                                                                                    </strong>
                                                                                </td>
                                                                                <td>
                                                                                    {{ $val->remark }}
                                                                                </td>
                                                                                <td>
                                                                                    @if ($val->attachment)
                                                                                        <a href="{{ $val->attachment }}"
                                                                                            target="_blank"><i
                                                                                                class="fa fa-file"></i></a>
                                                                                    @else
                                                                                        -
                                                                                    @endif
                                                                                </td>
                                                                                <td>
                                                                                    {{ @$val->createdBy->contact_person_name }}
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection
@section('scripts')
    @parent
    <script>
        var maxAllowedImages = 3;
        $("#attachment").on("change", function(e) {
            var files = e.target.files,
                filesLength = files.length;
            if (filesLength > maxAllowedImages) {
                e.target.value = '';
                Swal.fire(
                    'Warning!',
                    'You can upload maximum ' + maxAllowedImages + ' attachments',
                    'warning'
                );
                return false;
            } else {
                for (var i = 0; i < filesLength; i++) {
                    var f = files[i]
                    var fileReader = new FileReader();

                    fileReader.onload = (function(e) {
                        var file = e.target;
                        let append = '<div class="col-md-3">' +
                            '<img src="' + e.target.result +
                            '" class="border w-100"  style="width:60px;height:80px;">' +
                            {{-- '<a data-request="remove-image" href="#" class="delImageNew mr-1"><img src="/assets/frontend/img/closered.svg" width="25" /></a>' + --}} '</div>';
                        $('#appendAttachments').append(append);
                    });
                    fileReader.readAsDataURL(f);
                }
            }
        });
        $("#attachment1").on("change", function(e) {
            var files = e.target.files,
                filesLength = files.length;
            if (filesLength > maxAllowedImages) {
                e.target.value = '';
                Swal.fire(
                    'Warning!',
                    'You can upload maximum ' + maxAllowedImages + ' attachments',
                    'warning'
                );
                return false;
            } else {
                for (var i = 0; i < filesLength; i++) {
                    var f = files[i]
                    var fileReader = new FileReader();

                    fileReader.onload = (function(e) {
                        var file = e.target;
                        let append = '<div class="col-md-3">' +
                            '<img src="' + e.target.result +
                            '" class="border w-100"  style="width:60px;height:80px;">' +
                            {{-- '<a data-request="remove-image" href="#" class="delImageNew mr-1"><img src="/assets/frontend/img/closered.svg" width="25" /></a>' + --}} '</div>';
                        $('#appendAttachments1').html(append);
                    });
                    fileReader.readAsDataURL(f);
                }
            }
        });

        $('#send-btn').click(function() {
            $('.help-block').remove();
            var formdata = new FormData();
            formdata.append('support_ticket_id', $('#support_ticket_id').val());
            formdata.append('remark', $('#remark').val());

            if ($('#attachment1').prop('files').length) {
                formdata.append('attachment', $('#attachment1').prop('files')[0]);
            }

            $.ajax({
                url: '/support/save-comments',
                data: formdata,
                cache: false,
                type: "POST",
                dataType: 'JSON',
                contentType: false,
                processData: false,
                success: function($response) {
                    Swal.fire(
                        'Success',
                        $response.message,
                        'success'
                    )
                    setTimeout(function() {
                        location.reload();
                    }, 2200);
                },
                error: function($response) {
                    $('#loading-image').hide();
                    if ($response.status === 422) {
                        if (Object.size($response.responseJSON) > 0 && Object.size($response
                                .responseJSON.errors) > 0) {
                            show_validation_error($response.responseJSON.errors);
                        }
                    } else {
                        Swal.fire(
                            'Error',
                            $response.responseJSON.message,
                            'warning'
                        )
                        setTimeout(function() {}, 1200)
                    }
                }
            });
        });
    </script>
@endsection
