<!DOCTYPE html>
<html lang="zxx">


<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Poltekapp - {{$page_title}}</title>

    <link rel="icon" href="img/mini_logo.png" type="image/png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('assets')}}/css/bootstrap.min.css" />
    <!-- themefy CSS -->
    <link rel="stylesheet" href="{{asset('assets')}}/vendors/themefy_icon/themify-icons.css" />
    <!-- select2 CSS -->
    <link rel="stylesheet" href="{{asset('assets')}}/vendors/niceselect/css/nice-select.css" />

    <!-- font awesome CSS -->
    <link rel="stylesheet" href="{{asset('assets')}}/vendors/font_awesome/css/all.min.css" />
    <link rel="stylesheet" href="{{asset('assets')}}/vendors/tagsinput/tagsinput.css" />

    <!-- scrollabe  -->
    <link rel="stylesheet" href="{{asset('assets')}}/vendors/scroll/scrollable.css" />

    <!-- style CSS -->
    <link rel="stylesheet" href="{{asset('assets')}}/css/style.css" />
    <link rel="stylesheet" href="{{asset('assets')}}/css/colors/default.css" id="colorSkinCSS">
    <link rel="stylesheet" href="{{asset('dist')}}/css/app.css" >
    <style>
        .menu-select:hover div {
            -ms-transform: scale(1.1);
            /* IE 9 */
            -webkit-transform: scale(1);
            /* Safari 3-8 */
            transform: scale(1);
        }

    </style>
    @stack('css')
</head>

<body class="crm_body_bg">



    <!-- main content part here -->


    <section class="main_content dashboard_part large_header_bg" style="padding-inline-start: 0px;padding-inline-start: 0px;background: #EFEFEF;"">
        <!-- menu  -->
        <div class=" container-fluid no-gutters">
            <div class="row">
                <div class="col-lg-12 p-0 ">
                    <div class="header_iner d-flex justify-content-between align-items-center">

                        <a href="{{route('home')}}">
                            <div class="line_icon open_miniSide d-none d-lg-block">
                                <i class="ti-home text-dark" style="font-size: 35px"></i>
                                {{-- <img src="{{asset('assets')}}/img/line_img.png" alt=""> --}}
                            </div>
                        </a>

                        <a class="large_logo" href="{{ url('/') }}"><img src="{{asset('assets')}}/img/itokin-2.png" alt="" style=" max-width: 140; width: auto; max-height: 31px;"></a>

                        <div class="header_right d-flex justify-content-between align-items-center">
                            <div class="profile_info">
                                <!-- <img src="{{asset('backend')}}/images/{{ Auth::user()->avatar ?? 'user.svg' }}" alt="#" style="max-width:100px !important; max-height:100px !important; width:45px; height:45px;"> -->
                                <img src="{{asset('backend')}}/images/{{ Auth::user()->avatar ?? 'user.svg' }}" alt="#" style="max-width:100px !important; max-height:100px !important; width:45px; height:45px;">
                                <div class="profile_info_iner">
                                    <div class="profile_author_name text-center">
                                        <img src="{{asset('backend')}}/images/{{ Auth::user()->avatar ?? 'user.svg' }}" alt="#" style="max-width:100px !important; max-height:100px !important; width:70px; height:70px;">
                                        <h6 class= "text-white" style="margin-bottom: 0 !important; margin-top: 10px !important;">{{ Auth::user()->name }} </h5>
                                        <p style="margin-top: 0px !important;">{{ Auth::user()->roles->pluck('name') }}</p>
                                    </div>
                                    <div class="profile_info_details">
                                    <a href="{{ route('access-management.user-profile' , Auth::user()->id)}}">My Profile </a>
                                        <a href="#" onclick="logout()">Log Out</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--/ content  -->
        <div class="main_content_iner overly_inner ">
            <div class="container-fluid p-0 ">
                <!-- page title  -->
                <div class="row">
                    <div class="col-12">
                        <div class="page_title_box d-flex flex-wrap align-items-center justify-content-between">
                            <div class="page_title_left d-flex align-items-center">
                                <h3 class="f_s_25 f_w_700 dark_text mr_30">{{$page_title}}</h3>
                                <ol class="breadcrumb page_bradcam mb-0">
                                    <li class="breadcrumb-item"><a href="{{url('/')}}">Poltekapp</a></li>
                                    <li class="breadcrumb-item active">{{$page_title}}</li>
                                </ol>
                            </div>
                            <div class="page_title_right">
                                <div class="page_date_button d-flex align-items-center">
                                    <img src="{{asset('assets')}}/img/icon/calender_icon.svg" alt="">
                                    {{date('M d,Y ')}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @yield('content')
            </div>
        </div>


        <!-- footer part -->
        {{-- @include('oee.layouts.footer') --}}

    </section>
    <!-- main content part end -->





    <div id="back-top" style="display: none;">
        <a title="Go to Top" href="#">
            <i class="ti-angle-up"></i>
        </a>
    </div>

    <!-- footer  -->
    <script src="{{asset('assets')}}/js/jquery-3.4.1.min.js"></script>
    <script src="{{asset('dist')}}/js/app.js"></script>

    <!-- bootstarp js -->

    

    <!-- custom js -->
    <script>
        $('.menu-select').hover(
            function () {
                $(this).find("div:first").addClass('shadow-lg')
            },
            function () {
                $(this).find("div:first").removeClass('shadow-lg')
            }
        )

    </script>

    <script>

        // Logout function
        function logout() {
            $.confirm({
                icon: 'fa fa-sign-out',
                title: 'Logout',
                theme: 'supervan',
                content: 'Are you sure want to logout?',
                autoClose: 'cancel|8000',
                buttons: {
                    logout: {
                        text: 'logout',
                        action: function() {
                            $.ajax({
                                type: 'GET',
                                url: '/logout',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                data: {
                                    "_token": "{{ csrf_token() }}"
                                },
                                success: function(data) {
                                    location.reload();
                                },
                                error: function(data) {
                                    location.reload();
                                }
                            });
                        }
                    },
                    cancel: function() {

                    }
                }
            });
        }

    </script>
    @stack('js')
</body>


</html>
