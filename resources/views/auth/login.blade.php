<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Login - IoT Monitoring System</title>

    <!-- vendor css -->
    <link href="{{ asset('backend/') }}/login/font/%40fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('backend/') }}/login/font/ionicons/css/ionicons.min.css" rel="stylesheet">
    
    <!-- Bracket CSS -->
    <link rel="stylesheet" href="{{ asset('backend/') }}/login/css/bracket.css">
</head>

<body>
    <div class="d-flex align-items-center justify-content-center ht-100v">
        <video id="headVideo" class="pos-absolute a-0 wd-100p ht-100p object-fit-cover" autoplay muted loop>
            <source src="{{asset('backend/video/video4hd.mp4')}}" type="video/mp4">
        </video>

        <div class="overlay-body bg-black-7 d-flex align-items-center justify-content-center">
            <div class="login-wrapper wd-300 wd-xs-350 pd-25 pd-xs-40 rounded bg-black-6 text-center">
                <img class="img-fluid m-b-10" width="70%" src="{{asset('assets/img/poltekapp.png')}}" alt="">
                <div class="tx-white-5 tx-center mg-b-10 mt-2">Inventory Management</div>
                    @if(Session::has('message'))
                        <div class="alert-text tx-danger tx-13">
                            <p>{{ Session::get('message') }}</p>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            <input id="email" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }} fc-outline-dark" name="username" value="{{ old('username') }}" placeholder="Enter your username / email" required autofocus >

                            @if ($errors->has('username'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('username') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}  fc-outline-dark" name="password" placeholder="Enter your password" required>

                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group row">
                            <div class="col-12 text-center ">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                            <!-- <div class="col-4  "> -->
                                <!-- <div class="form-check">
                                <input class="form-check-input" id="demo" type="checkbox" name="demo">

                                <label class="form-check-label" for="remember">
                                    Sign As Guest
                                </label> -->
                            <!-- </div> -->
                        </div>
                        
                        <div class="col-md-12 mt-2">
                            <button type="submit" class="btn btn-info btn-block">Sign In</button>
                        </div>
                        {{-- <div class="mg-t-60 tx-center">Powered by:
                            <a href="goiot.id" class="tx-info">
                                <img src="{{asset('backend/goiot-logo.png')}}" alt="" style="max-width: 100px;">
                            </a>
                        </div> --}}
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('backend/') }}/login/js/jquery/jquery.min.js"></script>
 
        <script>
        $(function () {
            'use strict';

            // Check if video can play, and play it
            var video = document.getElementById('headVideo');
            video.addEventListener('canplay', function () {
                video.play();
            });

        });

          $(document).ready(function(){
            $('#demo').click(function(){
                if($(this).prop("checked") == true){
                    document.getElementById("email").value = "guest@gmail.com";
                    document.getElementById("password").value = "guest";
                    $('button[type="submit"').click();
                }
                else if($(this).prop("checked") == false){
                    document.getElementById("email").value = "";
                    document.getElementById("password").value = "";
                }
            });
        });

    </script>

</body>

</html>
