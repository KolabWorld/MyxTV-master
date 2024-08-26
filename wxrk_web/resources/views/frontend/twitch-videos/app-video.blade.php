<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<style>
			iframe { width: 100vw; height: calc(100vh - 30px)}
            #close-video-div { 
                display: block;
                position: absolute;
                top: 0px;
                margin-top: 10px;
                width: 100%
            }
            #close-video-div > a{
                /* float: right; */
                margin-left: 10px;
            }    
		</style>
	</head>
    <body style="margin: 0; padding: 0; background: black">

        <div style="display:none; text-align: center; font-size: 15px; color: #fff; margin-top: 7px">
            Video Timmer : <span id="timmer"> 0 sec </span>
        </div>

        <div id="twitch-feed"></div>

        <div id="close-video-div">
            {{-- <a href="#" id="close-video">
                <img src="/assets/frontend/img/closeimg.svg" alt="">
            </a> --}}
        </div>

        <script src="/assets/admin/js/jquery.min.js"></script>
        <script src="/js/timer.js"></script>
        <script src="https://player.twitch.tv/js/embed/v1.js"></script>
        <script>
            (function() {
 
                var options = { 
                    video: '{{$id}}',
                    controls: true,
                    allowfullscreen: true,
                    playsinline: true
                };
                var player = new Twitch.Player("twitch-feed", options);
                player.setVideo('{{$id}}')
                //player.pause();
                function pauseVid() {
                    player.pause();
                }

                function playVid() {
                    player.play();
                    $('#timmer').timer();
                }

                player.addEventListener(Twitch.Embed.VIDEO_READY, function() {
                    $('#timmer').timer();
                    $('#timmer').timer('pause');
                    console.log('The video is ready');
                });

                player.addEventListener(Twitch.Embed.VIDEO_PLAY, function() {
                    console.log('The video is VIDEO_PLAY');
                    $('#timmer').timer('resume');
                });

                player.addEventListener(Twitch.Embed.VIDEO_PAUSE, function() {
                    console.log('The video is VIDEO_PAUSE');
                    $('#timmer').timer('pause');

                    var watchTime = $('#timmer').html();
                    var videoId = '{{$id}}';
                    var userId = '{{$user_id}}';
                    var data = {
                        video_id : videoId,
                        user_id : userId,
                        watch_time : watchTime,
                        '_token' : '{{{csrf_token()}}}'
                    }
                    $('#timmer').timer('reset');
                    $('#timmer').timer('pause');
                    $.ajax({
                        url: '/twitch-time-calculation',
                        type: 'POST',
                        data: data,
                        success:function(data) {
                            var selectbox = '';
                            console.log(data);
                            if(data.status==200)
                            {
                                console.log(data);
                            }
                        }
                    });
                });
/*
                player.addEventListener(Twitch.Embed.ENDED, function() {
                    console.log('The video is ENDED');
                    stop();
                    var watchTime = $('#timmer').html();
                    var videoId = '{{$id}}';
                    var userId = '{{$user_id}}';
                    var data = {
                        twitch_id : videoId,
                        user_id : userId,
                        watch_time : watchTime,
                        '_token' : '{{{csrf_token()}}}'
                    }
                    $.ajax({
                        url: '/twitch-time-calculation',
                        type: 'POST',
                        data: data,
                        success:function(data) {
                            var selectbox = '';
                            console.log(data);
                            if(data.status==200)
                            {
                                console.log(data);        
                            }
                        }
                    });
                });
*/
                player.addEventListener(Twitch.Embed.SEEK, function(r) {
                    console.log('The video is SEEK', r);
                });

                $('#close-video').click(function () {
                    console.log('The video is closed');
                    pauseVid();

                //     $('#timmer').timer('pause');
                //     var watchTime = $('#timmer').html();
                //     var videoId = '{{$id}}';
                //     var userId = '{{$user_id}}';
                //     var data = {
                //         video_id : videoId,
                //         user_id : userId,
                //         watch_time : watchTime,
                //         '_token' : '{{{csrf_token()}}}'
                //     }
                //     $('#timmer').timer('reset');
                //     $('#timmer').timer('pause');
                //     $.ajax({
                //         url: '/twitch-time-calculation',
                //         type: 'POST',
                //         data: data,
                //         success:function(data) {
                //             var selectbox = '';
                //             console.log(data);
                //             if(data.status==200)
                //             {
                //                 console.log(data);
                //             }
                //         }
                //     });
                });

            })();

            // 

            setInterval(function() {
                var watchTime = $('#timmer').html();
                if(watchTime == '3300'){
                    var videoId = '{{$id}}';
                    var userId = '{{$user_id}}';
                    var data = {
                        video_id : videoId,
                        user_id : userId,
                        watch_time : watchTime,
                        '_token' : '{{{csrf_token()}}}'
                    }
                    $('#timmer').timer('reset');
                    $.ajax({
                        url: '/twitch-time-calculation',
                        type: 'POST',
                        data: data,
                        success:function(data) {
                            var selectbox = '';
                            console.log(data);
                            if(data.status==200)
                            {
                                console.log(data);
                            }
                        }
                    });
                }
            },1000);
        </script>

    </body>

</html>
