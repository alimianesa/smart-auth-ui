<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Smart Auth</title>

    <!-- Include Video.js stylesheet (https://videojs.com/) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/videojs-record/4.0.0/css/videojs.record.min.css">
    <link href="https://vjs.zencdn.net/7.8.2/video-js.css" rel="stylesheet" />
    <script src="https://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>

    <style>
        /* change player background color */
        #myVideo {
            background-color: #000;
        }
    </style>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>

@include('partials.message')

<div style="margin: 10% 27% 10% 28%; direction: rtl;text-align: center">
    <div class="card">
        <h5 class="card-header bg-dark text-light">ارسال فیلم</h5>
        <div style="margin: 7% 5% 0 5%; direction: rtl;text-align: center">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="exampleFormControlFile1">ارسال ویدیو</label>
                <video id="myVideo" class="video-js vjs-default-skin"></video>
            </div>
            <p class="lead">
                متن شما: {{ $speechText }}
            </p>
        </div>
        <div style="margin: 6% 0 5% 0; direction: rtl;text-align: center">
            <a href="/done" class="btn btn-outline-dark" style="width: 40%;border-radius: 14px">ثبت</a>
        </div>

    </div>
</div>
<!-- Create the preview video element -->


    <script src="https://vjs.zencdn.net/7.8.2/video.js"></script>
<!-- Load video.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/RecordRTC/5.6.1/RecordRTC.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/7.4.0/adapter.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/videojs-record/4.0.0/videojs.record.min.js"></script>
<script>
    var videoMaxLengthInSeconds = 120;

    // Inialize the video player
    var player = videojs("myVideo", {
        controls: true,
        width: 720,
        height: 480,
        fluid: false,
        plugins: {
            record: {
                audio: true,
                video: true,
                maxLength: videoMaxLengthInSeconds,
                debug: true,
                videoMimeType: "video/webm;codecs=H264"
            }
        }
    }, function(){
        // print version information at startup
        videojs.log(
            'Using video.js', videojs.VERSION,
            'with videojs-record', videojs.getPluginVersion('record'),
            'and recordrtc', RecordRTC.version
        );
    });

    // error handling for getUserMedia
    player.on('deviceError', function() {
        console.log('device error:', player.deviceErrorCode);
    });

    // Handle error events of the video player
    player.on('error', function(error) {
        console.log('error:', error);
    });

    // user clicked the record button and started recording !
    player.on('startRecord', function() {
        console.log('started recording! Do whatever you need to');

    });

    // user completed recording and stream is available
    // Upload the Blob to your server or download it locally !
    player.on('finishRecord', function() {
        console.log(player.recordedData);
        // the blob object contains the recorded data that
        // can be downloaded by the user, stored on server etc.
        console.log('finished recording: ', player.recordedData);

        // Create an instance of FormData and append the video parameter that
        // will be interpreted in the server as a file
        var formData = new FormData();
        formData.append('video', player.recordedData);

        // Execute the ajax request, in this case we have a very simple PHP script
        // that accepts and save the uploaded "video" file
        xhr('/routes/video', formData, function (fName) {
            console.log("Video succesfully uploaded !");
        });

        // Helper function to send
        function xhr(url, data, callback) {
            var request = new XMLHttpRequest();
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {
                    callback(location.href + request.responseText);
                }
            };
            request.open('POST', url);
            request.send(data);
        }
    });
</script>
</body>
</html>
