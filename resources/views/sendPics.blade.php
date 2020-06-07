<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title> Smart Auth </title>
    <style type="text/css">
        body { font-family: Helvetica, sans-serif; }
        h2, h3 { margin-top:0; }
        form { margin-top: 15px; }
        form > input { margin-right: 15px; }
        #results { float:right; margin:20px; padding:20px; border:1px solid; background:#ccc; }
    </style>
    <link href="/css/fontiran.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
</head>
<body>
    @include('layouts.nav')
    <div style="margin: 0 15% 0 15%;direction: ltr">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
    <div style="margin: 10% 35% 10% 35%; direction: rtl;text-align: center">
        <div class="card">
            <h5 class="card-header bg-dark text-light">ارسال عکس</h5>
            <form action="/pics" method="POST" enctype="multipart/form-data">
                <div style="margin: 7% 5% 0 5%; direction: rtl;text-align: center">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="exampleInputEmail1">سریال کارت ملی</label>
                        <input type="text" name="card_serial" id="serial" class="form-control"  placeholder="سریال کارت ملی" onchange="setSerial()">
                    </div>

                    <div class="row" style="margin-top: 7%">
{{--                        <div class="form-group col-md-6">--}}
{{--                            <label for="moz" >ارسال عکس کارت ملی</label>--}}
{{--                            <input type="file" name="card_image" class="form-control-file" id="moz">--}}
{{--                        </div>--}}

                        <div class="form-group col-md-6">
                            <label for="exampleFormControlFile2">ارسال عکس امضا</label>
                            <input type="file" name="sign_image" class="form-control-file" id="exampleFormControlFile2">
                        </div>
                    </div>

                    <label>ارسال عکس کارت ملی</label>
                    <div id="my_camera" style="margin:10% 17%"></div>
                    <div id="my_result" style="margin-bottom: 10%"></div>
                    <script type="text/javascript" src="/js/webcam.min.js"></script>
                    <script src="/js/pics-camera.js"></script>

                    <a class="btn btn-outline-dark" href="javascript:void(take_snapshot())" style="border-radius: 10px"> ثبت عکس</a>
                    <div style="margin: 6% 0 5% 0; direction: rtl;text-align: center">
                        <button type="submit" class="btn btn-outline-dark" style="width: 40%;border-radius: 14px">ثبت</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


</body>
</html>
