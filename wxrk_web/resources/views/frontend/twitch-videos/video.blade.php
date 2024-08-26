<!DOCTYPE html>
<html>
<body>

    <div style="text-align: center;font-size: 35px;">
        Video Timmer : <span id="timmer"> 0 sec </span>
    </div>

    <div id="twitch-feed"
        style="
        width: 90%;
        text-align: center;
        margin-left: 5%;
        min-height: 550px;
        ">
    </div>

    <script src="/assets/admin/js/jquery.min.js"></script>
    <script src="/js/timer.js"></script>
    <script src="https://player.twitch.tv/js/embed/v1.js"></script>
    <script>
        (function() {

            var options = {
                width: "100%",
                height: "800px",
                video: "{{ $id }}",
                controls: true,
                allowfullscreen: true
            };
            var player = new Twitch.Player("twitch-feed", options);
            player.setVideo("{{ $id }}")
            //player.pause();
            function pauseVid() {
                player.pause();
            }

            function playVid() {
                player.play();
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
                alert('pause');

            });

            player.addEventListener(Twitch.Embed.ENDED, function() {
                console.log('The video is ENDED');
                stop();
            });


            player.addEventListener(Twitch.Embed.SEEK, function(r) {
                console.log('The video is SEEK', r);
            });

        })();

        // {{-- SEEK ,e.VIDEO_PLAY="video.play",e.VIDEO_PAUSE="video.pause",e.CAPTIONS="captions",e.ENDED="ended",  --}}
    </script>

</body>

</html>
