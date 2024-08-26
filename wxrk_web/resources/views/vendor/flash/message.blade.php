@if (Session::has('flash_notification.message'))
    @if (Session::has('flash_notification.overlay'))
        @include('flash::modal', ['modalClass' => 'flash-modal', 'title' => Session::get('flash_notification.title'), 'body' => Session::get('flash_notification.message')])
    @else
        <div class="alert container rounded-0 alert-{{ Session::get('flash_notification.level') }}" data-dis>
            <div class="">
                <div class="row">
                <div class="col-md-8">
                     <span class="f-16 playfair">{{ Session::get('flash_notification.message') }}</span>
                </div>
                <div class="col-md-4">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true"><img src="/assets/admin/img/x.svg"></span>
                    </button>
                </div>
                </div>
            </div>
              

            
        </div>
    @endif
   
@endif
