

    @if($message)
    <div class="col-sm-12">
        <div class="sent_msg">
            <p>
                @if($message->content)
                    {{$message->content}}
                @endif
                @if($message->attachment)
                    <a href="{{$message->attachment}}" target="new" ><i class="fa fa-paperclip"></i> View Attachment </a>
                @endif
            </p>
            
        </div>
    </div>
    @endif