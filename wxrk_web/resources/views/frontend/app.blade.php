<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>MyxTV</title>

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="/assets/admin/css/bootstrap.min.css">
        {{-- <link rel="stylesheet" href="/assets/admin/css/jquery-ui.min.css"> --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
        <link rel="stylesheet" href="/assets/admin/css/plugins/overlayScrollbars/css/OverlayScrollbars.min.css"> 
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
        <link href="/assets/admin/css/material.css" rel="stylesheet"> 
        <link href="/assets/admin/css/select2.min.css" rel="stylesheet"> 
        <link href="/assets/admin/css/style.css" rel="stylesheet">
        <link href="/assets/admin/css/responsive.css" rel="stylesheet">
        @yield('styles')
    </head>

    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">
            @include('frontend.partials.side')
            <div class="content-wrapper">
                @include('frontend.partials.flash-message')
                <div id="ajax-error-div">
                </div>
                @yield('content')
                @yield('modals')
            </div>
            @include('frontend.partials.loader')
            @include('frontend.partials.footer')
        </div>

        <!-- jQuery -->
        <script src="/assets/admin/js/jquery.min.js"></script>
        <script src="/assets/admin/js/jquery-ui.min.js"></script>
        <script src="/assets/admin/js/select2.full.min.js"></script>
        <script src="/assets/admin/js/bootstrap.bundle.min.js"></script>
        <script src="/assets/admin/css/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
        <script src="/assets/admin/js/main.js"></script>


        <script src="{{ asset('js/custom-script.js') }}"></script>
        <script src="{{ asset('js/sweetalert.js') }}"></script>
        
        <script>
            
            $(document).ready(function() {
                $(window).keydown(function(event){
                    if(event.keyCode == 13) {
                        event.preventDefault();
                        return false;
                    }
                });
            });

            var app_url = "{{ config('app.api_url') }}";
            var base_url = "{{ config('app.url') }}";
            var bearer_token = 'Bearer <?= session('auth_access_token') ?>';

            $.ajaxSetup({
                headers: {
                    'Access-Control-Allow-Origin': '*',
                    'Authorization': bearer_token,
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(document).ready(function() {
                $("#checkedAll").change(function() {
                    if (this.checked) {
                        $(".checklist").each(function() {
                            this.checked=true;
                        });
                    } else {
                        $(".checklist").each(function() {
                            this.checked=false;
                        });
                    }
                });

                setTimeout(function() {
                    $(".alert").alert('close');
                }, 3000);
            });
            $(function () {
                //Initialize Select2 Elements
                $('.select2').select2({placeholder: "Select Multiple Checklist"})
    
              })
        </script>
        <script>
            function exportdata() {
                $selectedCheckBox = [];
                if ($("[name='checklist[]']:checked").length) {
                    $(".checklist").each(function() {
                        if (this.checked) {
                            $selectedCheckBox.push($(this).val());
                        } 
                    });
                    $("#filterIds").val($selectedCheckBox); 
                }
                $("#exportForm").submit();
            };   
        </script>
        <script>
			$('.submit_promo').on('click',function(e){
                $('.errPromocode').remove();
                form = e.target.closest("form");
                var formData = new FormData(form);
				$('#error').html('');
				$('.form-error').html('');
				var offer_id = $('.offer_id').val();
                formData.append('offer_id',offer_id);
                $.ajax({
					url: '/promo-codes/submit' 
					, type: 'POST'
                    , data: formData
                    , cache: false
                    , processData: false
                    , contentType: false,
					success:function(res) {
                        var message = res.message;
						$(".message-section").html('<div class="alert alert-success alert-dismissible fade show" role="alert">'+message+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                        setTimeout(function () {
                                location.reload();
                        }, 1000);
					},
					error :function( data ) {
						if( data.status === 422 ) {
							var errors = $.parseJSON(data.responseText);
							$.each(errors, function (key, value) {
								if($.isPlainObject(value)) {
									$.each(value, function (key, value) {                       
                                        var name = key.replace(/\./g, '][');
                                        if (key.indexOf('.') !== -1) {
                                            name = name + ']';
                                            name = name.replace(']', '');
                                        }

                                        var errHtml = '<div class="errPromocode" style="color: rgb(255, 0, 0);">'+value+'</div>';
                                        $('input[name="'+name+'"]').after(errHtml);
									});
								} else{
								}
							});
						}
					}
				})
			});
		
            var promoSrNo = 1;

            $('#addRow').click(function() {
                var html = '<tr>';
                html += '   <td>' + (promoSrNo + 1) + '</td>';
                html += '   <td><input type="text" name="promo_codes[' + promoSrNo + '][promo_code]" class="inputpromocode" /></td>';
                html += '   <td><a id="removeRow" href="javascript:void(0);" class="text-danger"><i class="fas fa-trash" aria-hidden="true"></i></a></td>';
                html += '</tr>';
                
                $('#appendRow').append(html);
                promoSrNo++;
            });

            $(document).on('click', '#removeRow', function() {
                $(this).closest('tr').remove();
                //bankSrNo--;
            });

		</script>
        @yield('scripts')
    </body>
</html>