@extends('frontend.app')

{{-- Web site Title --}}
@section('title') :: @parent @stop

@section('content')

    @include('frontend.partials.nav', [
        'title' => 'Support Ticket',
        'description' => count($supports) . ' Records',
        
    ])

    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">

                    <div class="row align-items-center">
                        <div class="col-4 d-none d-sm-block">
                            <a href="javascript:history.back()" class="btn btn-outline-secondary">Go Back</a>
                        </div>
                        <div class="col-12 col-md-8 text-sm-right">
                            <a href="#create-ticket" id="create-ticket-btn" data-toggle="modal"
                                class="btn btn-secondary btn-filter mr-2"><i class="far fa-plus-square mr-1"></i> Create
                                Ticket</a>
                            <a href="#filter" data-toggle="modal" class="btn btn-primary btn-filter mr-2"><i
                                    class="fas fa-filter mr-1"></i> Filter</a>
                            {{-- <a href="#" class="btn btn-success btn-filter"><i class="far fa-file-excel mr-1"></i>
                                Export to Excel</a> --}}
                        </div>
                    </div>

                    <div class="dashbed-border-bottom mt-2 mb-3"></div>

                    <div class="row">
                        <div class="col-md-12">


                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table dashtable">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Raised Date</th>
                                                    <th>Enquiry Category</th>
                                                    <th>Enquiry Sub Category</th>
                                                    <th>Enquiry Subject</th>
                                                    <th>Received From</th>
                                                    <th>Response Date and time</th>
                                                    <th>Document</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($supports as $support)
                                                    <tr>
                                                        <td>
                                                            <span
                                                                class="badge 
                                                            @if ($support->status == 'open') badge-success
                                                            @elseif($support->status == 'closed')
                                                            badge-danger
                                                            @else
                                                            badge-warning @endif
                                                            ">
                                                                {{ ucwords($support->status) }}
                                                            </span>
                                                        </td>
                                                        <td><strong>{{ date('d-m-Y', strtotime($support->created_at)) }}</strong>
                                                        </td>
                                                        <td>{{ @$support->category->name }}</td>
                                                        <td>{{ @$support->subCategory->name }}</td>
                                                        <td>{{ $support->subject }}</td>
                                                        <td>
                                                            {{ @$support->createdBy->contact_person_name }}
                                                        </td>
                                                        <td>{{ @$support->firstChat->created_at ? date('d-m-Y', strtotime(@$support->firstChat->created_at)) : '-' }}
                                                        </td>
                                                        <td>
                                                            @foreach ($support->attachments as $key => $attachment)
                                                                <a href="{{ $attachment->full_url }}" target="_blank"><i
                                                                        class="fa fa-file-pdf text-warning"></i></a>
                                                            @endforeach
                                                        </td>
                                                        <td>
                                                            <a href="#" data-item="{{ json_encode($support) }}"
                                                                class="edit-ticket">
                                                                <i class="fas fa-pencil-alt"></i>
                                                            </a>
                                                            <a href="#" data-id="{{ $support->id }}"
                                                                class="chat-ticket">
                                                                <i class="far fa-comment-dots mr-1"></i>
                                                            </a>
                                                            @if ($user->hasRoles(['admin']))
                                                                <a href="#"
                                                                    data-url="/support/{{ $support->id }}/delete"
                                                                    data-request="remove" data-redirect="/supports">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    {{ $supports->links('frontend.layouts.pagination') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('modals')
    @parent
    <div class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="loginpopupTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-slideout" role="document">

            <div class="modal-content bg-white">
                <form>
                    <div class="modal-header d-block pt-5 px-3 px-sm-5 border-0">
                        <div class="pt-3">
                            <button type="button" class="close search-btn addaddressbtn p-0" data-dismiss="modal"
                                aria-label="Close">
                                <img src="/assets/admin/images/close.png" width="40px" />
                            </button>
                            <div class="head-title">
                                <h2>Filter</h2>
                                <h5>Change and Apply the Filter</h5>
                            </div>
                            <div class="dashbed-border-bottom mt-3"></div>

                        </div>
                    </div>
                    <div class="modal-body pt-3 pb-5 px-3 px-sm-5">

                        <div class="form-group innerappform">
                            <label>Status</label>
                            <select name="status" class="form-control bg-white">
                                <option value="">Select</option>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status }}"
                                        {{ Request::get('status') == $status ? 'selected' : '' }}>{{ ucwords($status) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        @if (!$user->hasRole('vendor'))
                            <div class="form-group innerappform">
                                <label>Source</label>
                                <select name="vendor_id" class="form-control bg-white">
                                    <option value="">Select</option>
                                    @foreach ($vendors as $vendor)
                                        <option value="{{ $vendor->id }}"
                                            {{ Request::get('vendor_id') == $vendor->id ? 'selected' : '' }}>
                                            {{ ucwords($vendor->contact_person_name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <div class="form-group innerappform">
                            <label>Category</label>
                            <select name="category_id" class="form-control bg-white">
                                <option value="">Select</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ Request::get('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ ucwords($category->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group innerappform innerappform">
                                    <label>From Date</label>
                                    <input name="from_date" type="date" value="{{ Request::get('from_date') }}"
                                        class="form-control" />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group innerappform innerappform">
                                    <label>To Date</label>
                                    <input name="to_date" type="date" value="{{ Request::get('to_date') }}"
                                        class="form-control" />
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3 px-5">Apply Filter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="create-ticket" tabindex="-1" role="dialog" aria-labelledby="loginpopupTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-slideout" role="document">

            <div class="modal-content bg-white">
                <form action="/support/create" id="ticket-form" method="POST" enctype="multipart/form-data"
                    role="post-data">
                    <input type="hidden" id="ticket-form-method" name="_method" value="PUT" disabled>
                    <div class="modal-header d-block pt-5 px-3 px-sm-5 border-0">
                        <div class="pt-3">
                            <button type="button" class="close search-btn addaddressbtn p-0" data-dismiss="modal"
                                aria-label="Close">
                                <img src="/assets/admin/images/close.png" width="40px" />
                            </button>
                            <div class="head-title">
                                <h2>Raised Ticket</h2>
                                <h5>Fill the below detail</h5>
                            </div>
                            <div class="dashbed-border-bottom mt-3"></div>

                        </div>
                    </div>
                    <div class="modal-body pt-3 pb-5 px-3 px-sm-5">

                        @if ($user->hasRole('admin'))
                            <div class="form-group innerappform">
                                <label>Ticket Status</label>
                                <select name="status" id="ticket-status" class="form-control bg-white">
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status }}">{{ ucwords($status) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <input type="hidden" name="status" id="vendor-status" value="pending">
                        @endif

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group innerappform">
                                    <label>Enquiry Category</label>
                                    <select name="category_id" id="category_id" class="form-control bg-white" @if ($user->hasRole('admin')) disabled @endif>
                                        <option value="">Select</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group innerappform">
                                    <label>Enquiry Sub Category</label>
                                    <select name="sub_category_id" class="form-control bg-white" @if ($user->hasRole('admin')) disabled @endif>
                                        <option value="">Select</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group innerappform">
                            <label>Enquiry Subject</label>
                            <input type="text" name="subject" id="subject" class="form-control"
                                placeholder="Enter Enquiry Subject"  @if ($user->hasRole('admin')) disabled @endif/>
                        </div>

                        <div class="form-group innerappform">
                            <label>Enquiry Description</label>
                            <textarea rows="2" name="description" id="description" class="form-control h-auto"
                                placeholder="Enter Description" @if ($user->hasRole('admin')) disabled @endif></textarea>
                        </div>

                        <div class="form-group innerappform uploadformbox">
                            <label>Upload Document</label>
                            <input type="text" class="form-control" disabled=""
                                placeholder="(pdf, jpg, png format only)">
                            <div class="upload-btn-wrapper up-loposition">
                                <button class="uploadBtn">Upload</button>
                                <input type="file" name="attachments[]" accept="image/*" class="multiple_files"
                                    multiple  @if ($user->hasRole('admin')) disabled @endif>
                            </div>
                        </div>

                        <div class="row" id="uploaded-docs">
                        </div>
                        <div class="row mt-1" id="appended-docs">
                        </div>
                        <a href="#" data-request="ajax-submit" data-target="[role=post-data]"
                            class="btn btn-primary mt-3 px-5">Submit</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="chat" tabindex="-1" role="dialog" aria-labelledby="loginpopupTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-slideout" role="document">

            <div class="modal-content bg-white">
                <form action="/ajax/support-chat/create" id="chat-form" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="support_ticket_id" id="chat_support_ticket_id">
                    <div class="modal-header d-block  px-3 px-sm-5 border-0">
                        <div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="head-title">
                                        <h2>Chat with Vendor</h2>
                                        <h5>Start chating to solve your query</h5>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <button type="button" class="close search-btn addaddressbtn p-0"
                                        data-dismiss="modal" aria-label="Close">
                                        <img src="/assets/admin/images/close.png" width="40px" />
                                    </button>
                                </div>
                            </div>
                            <div class="dashbed-border-bottom mt-3"></div>

                        </div>
                    </div>
                    <div class="modal-body pt-3 pb-3 px-3 px-sm-5">

                        <div class="mesgs chatheightfix">
                            <div class="msg_history" id="msg_history"></div>
                        </div>

                        <div class="input-group chat-send-box">
                            <div class="input-group-prepend">
                                <div class="upload-btn-wrapper">
                                    <button class="uploadBtn"><i class="fa fa-link"></i></button>
                                    <input type="file" id="messageAttachmentFileAdmin" name="attachment">
                                </div>
                            </div>
                            <input type="text" id="textMessageAdmin" name="message" class="form-control"
                                placeholder="Type your message here" aria-label="Username"
                                aria-describedby="basic-addon1">
                            <div class="input-group-prepend">
                                <a href="#" class="input-group-text" id="basic-addon1-admin"><img
                                        src="/assets/admin/images/chat-send.jpg" /></a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    @parent

    <script>
        var subCategoryId = '';
        var userId = '{{ $user->id }}';
        $('.edit-ticket').click(function() {
            var data = $(this).data('item');

            $('#ticket-form-method').removeAttr('disabled');

            subCategoryId = data.sub_category_id;
            $('#category_id').val(data.category_id);
            $('#subject').val(data.subject);
            $('#description').val(data.description);
            var html = '';
            $.each(data.attachments, function(key, attachment) {
                html += '<div class="col-3">';
                html += '    <div class="uploaded-doc">';
                html += '    <img src="' + attachment.full_url + '" width="40px" />';
                @if (!$user->hasRole('admin'))
                html += '        <a data-url="/delete-media/' + attachment.id +
                    '" data-request="remove-file"><img src="/assets/admin/images/close.svg"></a>';
                @endif
                html += '    </div>';
                html += '</div>';
            });

            $('#uploaded-docs').html(html);
            if(data.status == 'closed'){
                $('#vendor-status').val('re-open');
            }else{
                $('#vendor-status').val('pending');
            }

            $('#ticket-status').val(data.status);

            $('#ticket-form').attr('action', '/support/' + data.id + '/edit')
            $('#category_id').trigger('change');
            $('#create-ticket').modal('show');
        });

        $('#create-ticket-btn').click(function() {
            $('#ticket-form')[0].reset();
            $('#ticket-form-method').attr('disabled', true);

            var selectbox = '<option value="">Select</option>';
            $('select[name=sub_category_id]').html(selectbox);

            $('#uploaded-docs').html('');
            $('#ticket-form').attr('action', '/support/create');
        });

        $("#create-ticket").on("hidden.bs.modal", function() {
            location.reload();
        });

        $('#category_id').change(function() {
            $.ajax({
                url: '/ajax/get-support-sub-category',
                type: 'POST',
                data: {
                    'category_id': $(this).val()
                },
                success: function(data) {
                    var selectbox = '';
                    if (data) {
                        selectbox += '<option value="">Select</option>';
                        $.each(data.response, function(i, item) {
                            selectbox += '<option value="' + item.id + '">' +
                                item.name + '</option>';
                        });

                    }
                    $('select[name=sub_category_id]').html(selectbox);
                    $('select[name=sub_category_id]').val(subCategoryId);
                }
            });
        });

        $(".multiple_files").on("change", function(e) {
            var files = e.target.files,
                filesLength = files.length;

            if (filesLength > 5) {
                e.target.value = '';
                $('#appended-docs').html('');
                Swal.fire(
                    'Warning!',
                    'You can upload maximum 5 files.<br>Kindly select again.',
                    'warning', {
                        html: true,
                    }
                );
                return false;
            }

            var html = '';

            for (var i = 0; i < filesLength; i++) {
                var f = files[i];
                var fileReader = new FileReader();
                fileReader.onload = (function(e) {
                    html += '<div class="col-3">';
                    html += '    <div class="uploaded-doc">';
                    html += '        <img src="' + e.target.result + '" width="40px">';
                    html += '    </div>';
                    html += '</div>';
                    $('#appended-docs').html(html);
                });
                fileReader.readAsDataURL(f);
            }
        });

        //chat popup

        $(".chat-ticket").click(function() {
            var support_id = $(this).data('id');

            $('#chat_support_ticket_id').val(support_id);

            $.ajax({
                url: '/ajax/get-support-chats',
                data: {
                    _token: '{{ csrf_token() }}',
                    support_id: support_id
                },
                type: 'POST',
                success: function(res) {
                    var html = '';
                    $.each(res.data, function(key, chat) {
                        if (chat.created_by == userId) {
                            html += '<div class="outgoing_msg">';
                            html += '    <div class="sent_msg">';
                            html += '        <p>' + chat.message + '</p>';
                            if (chat.attachment) {
                                html += '        <p> <a href="' + chat.attachment +
                                    '" target="_blank"><i class="fa fa-file-pdf text-warning"></i></a></p>';
                            }
                            html += '        <span class="time_date text-right">' + chat
                                .formatted_created_at + '</span>';
                            html += '    </div>';
                            html += '</div>';
                        } else {
                            html += '<div class="incoming_msg">';
                            html += '    <div class="received_msg">';
                            html += '        <div class="received_withd_msg">';
                            html += '            <p>' + chat.message + '</p>';
                            if (chat.attachment) {
                                html += '        <p> <a href="' + chat.attachment +
                                    '" target="_blank"><i class="fa fa-file-pdf text-warning"></i></a></p>';
                            }
                            html += '            <span class="time_date">' + chat
                                .formatted_created_at + '</span>';
                            html += '        </div>';
                            html += '    </div>';
                            html += '</div>';
                        }
                    });

                    $('#msg_history').html(html);
                    $('#chat').modal('show');
                }
            });

        });

        $('#basic-addon1-admin').click(function() {
            var form = $('#chat-form');
            var formData = new FormData(form[0]);
            var url = $(form[0]).attr('action');
            if ($('#textMessageAdmin').val() != '' || $('#messageAttachmentFileAdmin').val() != '') {
                $.ajax({
                    url: url,
                    data: formData,
                    cache: false,
                    type: 'POST',
                    dataType: 'JSON',
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('.help-block').remove();
                    },
                    success: function($response) {
                        var chat = $response.data;
                        var html = '<div class="outgoing_msg">';
                        html += '    <div class="sent_msg">';
                        html += '        <p>' + chat.message + '</p>';
                        if (chat.attachment) {
                            html += '        <p><a href="' + chat.attachment +
                                '" target="_blank"><i class="fa fa-file-pdf text-warning"></i></a></p>';
                        }
                        html += '        <span class="time_date text-right">' + chat
                            .formatted_created_at +
                            '</span>';
                        html += '    </div>';
                        html += '</div>';

                        $('#msg_history').append(html);
                        $('#textMessageAdmin').val('');
                        $('#messageAttachmentFileAdmin').val('');
                    },
                    error: function($response) {
                        // $('.loader').hide();
                        if ($response.status === 422) {
                            if (Object.size($response.responseJSON) > 0 && Object.size($response
                                    .responseJSON.errors) > 0) {
                                show_validation_error($response.responseJSON.errors);
                            }
                        } else {
                            Swal.fire(
                                'Error', $response.responseJSON.message, 'warning'
                            )
                            setTimeout(function() {}, 1200)
                        }
                    }
                });
            }
        });
    </script>
@endsection
