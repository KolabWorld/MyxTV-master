function showPassword() {
    var password = document.getElementById("password");
    var password_icon = document.getElementById("password-icon");
    if (password.type === "password") {
        password.type = 'text';
        password_icon.src = app_url + '/assets/img/close.svg';
    } else {
        password.type = 'password';
        password_icon.src = app_url + '/assets/img/open.svg';
    }
}

$(function () {

    /*-----ADD & UPDATE DATA--------*/
    $(document).on('click', '[data-request="ajax-submit"]', function () {
        /*REMOVING PREVIOUS ALERT AND ERROR CLASS*/
        console.log(this);
        $('.alert').remove();
        $(".has-error").removeClass('has-error');
        $('.help-block').remove();
        var $this = $(this);
        var $target = $this.data('target');
        var $url = $($target).attr('action');
        var $method = $($target).attr('method');
        var $redirect = $($target).attr('redirect');

        var $data = new FormData($($target)[0]);
        if (!$method) {
            $method = 'get';
        }
        $.ajax({
            url: base_url + $url,
            data: $data,
            cache: false,
            type: $method,
            dataType: 'JSON',
            contentType: false,
            processData: false,
            beforeSend: function () {
                $('#loading-image').show();
            },
            success: function ($response) {
                    $('#loading-image').hide();
                    $($target).trigger('reset');
                    Swal.fire(
                        'Success',
                        $response.message,
                        'success'
                    )
                    setTimeout(function () {
                        if ($redirect) {
                            window.location.href = $redirect;
                        } else {
                            location.reload();
                        }
                    }, 2200);
            },
            error: function ($response) {
                $('#loading-image').hide();
                if ($response.status === 422) {
                    if (Object.size($response.responseJSON) > 0 && Object.size($response.responseJSON.errors) > 0) {
                        show_validation_error($response.responseJSON.errors);
                    }
                } else {
                    Swal.fire(
                        'Error',
                        $response.responseJSON.message,
                        'warning'
                    )
                    setTimeout(function () {}, 1200)
                }
            }
        });
    });
});

/*DELETE DATA */
    $(document).on("click", '[data-request="remove"]', function() {
        var $this = $(this);
        // var table = $('#dataTable').DataTable();
        var $target = $this.attr("data-target");
        var $message = $this.attr("data-message");
        var $url = $this.attr("data-url");
        var $redirect = $this.attr("data-redirect");
        var $nredirect = $this.attr("data-no-redirect");

        Swal.fire({
            title: "Alert",
            text: $message ? $message : "Are you sure you want to delete ?",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, Please",
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: base_url + $url,
                    type: "DELETE",
                    success: function(data) {

                        if (data.message == 'Record deleted successfully!') {
                            Swal.fire("Success", data.message, "success");
                            $this.closest("tr")
                                .children("td")
                                .animate({
                                    padding: 0,
                                })
                                .wrapInner("<div/>")
                                .children()
                                .slideToggle(function() {
                                    $(this).closest("tr").remove();
                                });
                            setTimeout(function() {
                                if ($redirect) {
                                    window.location.href = $redirect;
                                } else {
                                    location.reload();
                                }

                            }, 2200);
                        } else{
                            Swal.fire("Error", data.message, "error");
                        } 
                    },
                    error: function(data) {
                        Swal.fire(
                            "Error",
                            data.responseJSON.message,
                            "warning"
                        );
                        setTimeout(function() {}, 1200);
                    },
                });
            }
        });
    });

// DELETE MEDIA
    $(document).on('click', '[data-request="remove-file"]', function() {
        var $this = $(this);
        
        Swal.fire({
            title: "Alert",
            text: "Are you sure you want to delete ?",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, Please",
        }).then((result) => {
            if (result.value) {
                $this.closest('div').parent().remove();
                $.ajax({
                    url: $this.attr('data-url'),
                    type: 'DELETE',
                    success: function(res) {
                        console.log(res);
                    }
                });
            }
        });
    });

function show_validation_error(msg) {

    if ($.isPlainObject(msg)) {
        $data = msg;
    } else {
        $data = $.parseJSON(msg);
    }

    var html = '<div class="alert alert-danger alert-block" id="ajax-error">';
        html +=     '<button type="button" class="close" data-dismiss="alert">×</button>';
        html +=     '<strong>Please check below form errors</strong>';
        html += '</div>';
    
    $('#ajax-error-div').html(html);

    setTimeout(function(){
        $('#ajax-error').remove();
    }, 5000);

    $.each($data, function (index, value) {
        var name = index.replace(/\./g, '][');

        if (index.indexOf('.') !== -1) {
            name = name.substring(0,name.length - 1);
            name = name + ']';
            name = name.replace(']', '');
        }
        if (name.indexOf('[]') !== -1) {
            $('form [name="' + name + '"]').last().closest('').addClass('has-error');
            $('form [name="' + name + '"]').after('<span class="help-block text fw-bold text-red">' + value + '</span>');
        } else if ($('form [name="' + name + '[]"]').length > 0) {
            $('form [name="' + name + '[]"]').closest('.form-group').addClass('has-error');
            $('form [name="' + name + '[]"]').parent().after('<span class="help-block text fw-bold text-red">' + value + '</span>');
        } else {
            if ($('form [name="' + name + '"]').attr('type') == 'checkbox' || $('form [name="' + name + '"]').attr('type') == 'radio') {
                if ($('form [name="' + name + '"]').attr('type') == 'checkbox') {
                    $('form [name="' + name + '"]').closest('.form-group').addClass('has-error');
                    $('form [name="' + name + '"]').parent().after('<span class="help-block text fw-bold text-red">' + value + '</span>');
                } else {
                    $('form [name="' + name + '"]').closest('.form-group').addClass('has-error');
                    $('form [name="' + name + '"]').parent().parent().append('<span class="help-block text fw-bold text-red">' + value + '</span>');
                }
            } else if ($('form [name="' + name + '"]').get(0)) {
                if ($('form [name="' + name + '"]').get(0).tagName == 'select') {
                    $('form [name="' + name + '"]').closest('.form-group').addClass('has-error');
                    $('form [name="' + name + '"]').after('<span class="help-block text fw-bold text-red">' + value + '</span>');
                } else if ($('form [name="' + name + '"]').attr('type') == 'password' && $('form [name="' + name + '"]').hasClass('hideShowPassword-field')) {
                    $('form [name="' + name + '"]').closest('.form-group').addClass('has-error');
                    $('form [name="' + name + '"]').parent().after('<span class="help-block text fw-bold text-red">' + value + '</span>');
                } else if ($('form [name="' + name + '"]').attr('type') == 'file') {
                    $('form [name="' + name + '"]').closest('.form-group').addClass('has-error');
                    $('form [name="' + name + '"]').parent().after('<span class="help-block text fw-bold text-red">' + value + '</span>');
                } else {
                    $('form [name="' + name + '"]').closest('.form-group').addClass('has-error');
                    $('form [name="' + name + '"]').after('<span class="help-block text fw-bold text-red">' + value + '</span>');
                }
            } else {
                $('form [name="' + name + '"]').closest('.form-group').addClass('has-error');
                $('form [name="' + name + '"]').after('<span class="help-block text fw-bold text-red">' + value + '</span>');
            }
        }
        // $('.error-message').html($('.error-message').text().replace(".,",". "));
    });

    /*SCROLLING TO THE INPUT BOX*/
    scroll();
}


function scroll() {
    if ($(".help-block").not('.modal .help-block text text-red').length > 0) {
        $('html, body').animate({
            scrollTop: ($(".help-block").offset().top - 200)
        }, 200);
    }
}

function strip_html_tags(str) {
    if ((str === null) || (str === '')) {
        return false;
    } else {
        str = str.toString();
    }
    return str.replace(/<[^>]*>/g, '');
}

Object.size = function (obj) {
    var size = 0,
        key;
    for (key in obj) {
        if (obj.hasOwnProperty(key)) size++;
    }
    return size;
};

function renderImage(input, render_place_id, render_link_id = null) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function (e) {
            $('#' + render_place_id + '').attr('src', e.target.result);
            $('#' + render_place_id + '').show();
            if(render_link_id){
                $('#' + render_link_id + '').attr('href', e.target.result);
                $('#' + render_link_id + '').attr('target', '_blank');
                $('#' + render_link_id + '').show();
            }

        }

        reader.readAsDataURL(input.files[0]);
    }
}

function removeFile(value_id, render_id) {
    $('#' + value_id + '').val('');
    $('#' + render_id + '').attr('src', '/assets/admin/img/image.svg');
}

function removeVideoFile(value_id, render_id) {
    $('#' + value_id + '').val('');
    $('#' + render_id + '').attr('src', '');
    $('.' + render_id + '').attr('src', '');
}
    
function videoRender(event, render_id) {
    
    let file = event.files[0];
    let blobURL = URL.createObjectURL(file);
    $('#' + render_id + '').attr('src', blobURL);
    $('.' + render_id + '').attr('src', blobURL);
    $('.' + render_id + '').show();
}

// ############### Set Dropdown ###############
function dropdown(url, selected_id, selected_value) {
    $.ajax({
        beforeSend: function(xhr) {},
        url: base_url + url,
        method: "GET",
        dataType: "json",
        success: function(response) {
            $("#" + selected_id + "").empty("");
            var options = '<option value="">Select</option>';
            if (response.data) {
                var option_list = response.data;
                $.each(option_list, function(index, value) {
                    let selected = parseInt(selected_value) === value.id ? "selected" : "";
                    let name = value.name;
                    options +='<option value="' +value.id +'"' +selected +">" +name +"</option>";
                });
                $("#" + selected_id + "").append(options);
            }
        },
    });
}



