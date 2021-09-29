<!DOCTYPE html>
<html lang="zxx">


<!-- Mirrored from demo.dashboardpack.com/user-management-html/index_3.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 20 May 2021 03:59:52 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>OEE System - {{$page_title}}</title>

    <link rel="icon" href="img/mini_logo.png" type="image/png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('assets')}}/css/bootstrap.min.css" />
    <link rel="stylesheet" href="{{asset('assets')}}/css/datepicker.css" />
    <!-- themefy CSS -->
    <link rel="stylesheet" href="{{asset('assets')}}/vendors/themefy_icon/themify-icons.css" />
    <!-- select2 CSS -->
    <link rel="stylesheet" href="{{asset('assets')}}/vendors/niceselect/css/nice-select.css" />
    <!-- owl carousel CSS -->
    <link rel="stylesheet" href="{{asset('assets')}}/vendors/owl_carousel/css/owl.carousel.css" />
    <!-- gijgo css -->
    <link rel="stylesheet" href="{{asset('assets')}}/vendors/gijgo/gijgo.min.css" />
    <!-- font awesome CSS -->
    <link rel="stylesheet" href="{{asset('assets')}}/vendors/font_awesome/css/all.min.css" />
    <link rel="stylesheet" href="{{asset('assets')}}/vendors/tagsinput/tagsinput.css" />

    <!-- date picker -->
    <link rel="stylesheet" href="{{asset('assets')}}/vendors/datepicker/date-picker.css" />

    <link rel="stylesheet" href="{{asset('assets')}}/vendors/vectormap-home/vectormap-2.0.2.css" />

    <!-- scrollabe  -->
    <link rel="stylesheet" href="{{asset('assets')}}/vendors/scroll/scrollable.css" />
    <!-- datatable CSS -->
    <link rel="stylesheet" href="{{asset('assets')}}/vendors/datatable/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="{{asset('assets')}}/vendors/datatable/css/responsive.dataTables.min.css" />
    <link rel="stylesheet" href="{{asset('assets')}}/vendors/datatable/css/buttons.dataTables.min.css" />
    <!-- text editor css -->
    <link rel="stylesheet" href="{{asset('assets')}}/vendors/text_editor/summernote-bs4.css" />
    <!-- morris css -->
    <link rel="stylesheet" href="{{asset('assets')}}/vendors/morris/morris.css">
    <!-- metarial icon css -->
    <link rel="stylesheet" href="{{asset('assets')}}/vendors/material_icon/material-icons.css" />

    <!-- menu css  -->
    <link rel="stylesheet" href="{{asset('assets')}}/css/metisMenu.css">
    <!-- style CSS -->
    <link rel="stylesheet" href="{{asset('assets')}}/css/style.css" />
    <link rel="stylesheet" href="{{asset('assets')}}/css/colors/default.css" id="colorSkinCSS">
    <link rel="stylesheet" href="{{asset('dist')}}/css/app.css">

    @stack('css')
    <style>
        .card__one {
            transition: transform .5s;

            cursor: pointer;
        }

        .card__one::after {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            transition: opacity 2s cubic-bezier(.165, .84, .44, 1);
            box-shadow: 0 8px 17px 0 rgba(0, 0, 0, .2), 0 6px 20px 0 rgba(0, 0, 0, .15);
            content: '';
            opacity: 0;
            z-index: -1;
        }

        .card__one:hover,
        .card__one:focus {
            transform: scale3d(1.036, 1.036, 1);
            -webkit-box-shadow: -1px -1px 16px -4px rgba(0, 0, 0, 0.53);
            -moz-box-shadow: -1px -1px 16px -4px rgba(0, 0, 0, 0.53);
            box-shadow: -1px -1px 16px -4px rgba(0, 0, 0, 0.53);


        }


        .hilang {
            display: none
        }

    </style>
</head>

<body class="crm_body_bg">



    <!-- main content part here -->

    <!-- sidebar  -->
    @include('oee.layouts.sidebar')
    <!--/ sidebar  -->


    <section class="main_content dashboard_part large_header_bg ">
        <!-- menu  -->
        <div class="container-fluid no-gutters">
            <div class="row">
                <div class="col-lg-12 p-0 ">
                    <div class="header_iner d-flex justify-content-between align-items-center">
                        <div class="sidebar_icon d-lg-none">
                            <i class="ti-menu"></i>
                        </div>
                        <div class="line_icon open_miniSide d-none d-lg-block">
                            <img src="{{asset('assets')}}/img/line_img.png" alt="">
                        </div>

                        <div class="header_right d-flex justify-content-between align-items-center">
                            <div class="header_notification_warp d-flex align-items-center">
                                <!-- <li class="">
                                    <a class="bell_notification_clicker " href="#">

                                        <button class="btn btn-sm btn-dark"><i
                                                class="ti-menu-alt  f_s_14 mr-2"></i></button>
                                    </a>
                                    <div class="Menu_NOtification_Wrap">
                                        <div class="notification_Header" style="background: #343A40">
                                            <h4>Production Details </h4>
                                        </div>
                                        <div class="Notification_body">


                                        </div>
                                    </div>
                                </li> -->
                                <!-- <li>
                                    <a class="bell_notification_clicker" href="#" style="display: none;">

                                        <button class="btn btn-sm btn-dark"><i class="ti-menu-alt  f_s_14 mr-2"></i>
                                            LIST MACHINE</button>
                                    </a>
                                    <div class="Menu_NOtification_Wrap">
                                        <div class="notification_Header">
                                            <h4>Machine List </h4>
                                        </div>
                                        <div class="Notification_body">
                                            <table class="table table-hovered">
                                                <tbody>
                                                    @foreach ($oee_machines as $oee_machine)
                                                    <tr class="card__one list-machine">
                                                        <td> <span>{{$oee_machine->ident}} </span></td>
                                                        <td>
                                                            <input class="listmachine" type="checkbox" name="machine[]"
                                                                value="{{$oee_machine->name}}">
                                                        </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <div class="">
                                                <div class="submit_button text-center pt_20">
                                                    <a href="#" class="btn_1">Check All</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li> -->
                            <!-- <div class="profile_info">
                                <img src="{{asset('backend')}}/images/{{ Auth::user()->avatar ?? 'user.svg' }}" alt="#"
                                    style="max-width:100px !important; max-height:100px !important; width:45px; height:45px;">
                                <div class="profile_info_iner">
                                    <div class="profile_author_name text-center">
                                        <img src="{{asset('backend')}}/images/{{ Auth::user()->avatar ?? 'user.svg' }}" alt="#"
                                            style="max-width:100px !important; max-height:100px !important; width:70px; height:70px;">
                                        <h5 style="margin-bottom: 0 !important; margin-top: 10px !important;">
                                            {{ Auth::user()->name }} </h5>
                                        <p style="margin-top: -10px !important;">{{ Auth::user()->roles->pluck('name')[0] }}</p>
                                    </div>
                                    <div class="profile_info_details">
                                        <a href="{{ route('access-management.user-profile' , Auth::user()->id)}}">My Profile
                                        </a>
                                        <a href="#" onclick="logout()">Log Out</a>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                    <div class="header_right d-flex justify-content-between align-items-center">
                        <div class="profile_info">
                            <img src="{{asset('backend')}}/images/{{ Auth::user()->avatar ?? 'user.svg' }}" alt="#"
                                style="max-width:100px !important; max-height:100px !important; width:45px; height:45px;">
                            <div class="profile_info_iner">
                                <div class="profile_author_name text-center">
                                    <img src="{{asset('backend')}}/images/{{ Auth::user()->avatar ?? 'user.svg' }}"
                                        alt="#"
                                        style="max-width:100px !important; max-height:100px !important; width:70px; height:70px;">
                                    <h6 class= "text-white" style="margin-bottom: 0 !important; margin-top: 10px !important;">
                                        {{ Auth::user()->name }} </h5>
                                    <p style="margin-top: 0px !important;">
                                        {{ Auth::user()->roles->pluck('name')[0] }}</p>
                                </div>
                                <div class="profile_info_details">
                                    <a href="{{ route('access-management.user-profile' , Auth::user()->id)}}">My
                                        Profile </a>
                                    <a href="#" onclick="logout()">Log Out</a>
                                </div>
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
                {{-- <div class="row">
                    <div class="col-12">
                        <div class="page_title_box d-flex flex-wrap align-items-center justify-content-between">
                            <div class="page_title_left d-flex align-items-center">
                                <h3 class="f_s_25 f_w_700 dark_text mr_30">{{$page_title}}</h3>
                <ol class="breadcrumb page_bradcam mb-0">
                    <li class="breadcrumb-item"><a href="{{url('/')}}">Itokin</a></li>
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
        </div> --}}
        @yield('content')
        </div>
        </div>

        <!-- footer part -->
        {{-- @include('oee.layouts.footer') --}}

    </section>
    <!-- main content part end -->

    <!-- ### CHAT_MESSAGE_BOX   ### -->

    <div class="CHAT_MESSAGE_POPUPBOX">
        <div class="CHAT_POPUP_HEADER">
            <div class="MSEESAGE_CHATBOX_CLOSE">
                <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M7.09939 5.98831L11.772 10.661C12.076 10.965 12.076 11.4564 11.772 11.7603C11.468 12.0643 10.9766 12.0643 10.6726 11.7603L5.99994 7.08762L1.32737 11.7603C1.02329 12.0643 0.532002 12.0643 0.228062 11.7603C-0.0760207 11.4564 -0.0760207 10.965 0.228062 10.661L4.90063 5.98831L0.228062 1.3156C-0.0760207 1.01166 -0.0760207 0.520226 0.228062 0.216286C0.379534 0.0646715 0.578697 -0.0114918 0.777717 -0.0114918C0.976738 -0.0114918 1.17576 0.0646715 1.32737 0.216286L5.99994 4.889L10.6726 0.216286C10.8243 0.0646715 11.0233 -0.0114918 11.2223 -0.0114918C11.4213 -0.0114918 11.6203 0.0646715 11.772 0.216286C12.076 0.520226 12.076 1.01166 11.772 1.3156L7.09939 5.98831Z"
                        fill="white" />
                </svg>

            </div>
            <h3>Chat with us</h3>
            <div class="Chat_Listed_member">
                <ul>
                    <li>
                        <a href="#">
                            <div class="member_thumb">
                                <img src="{{asset('assets')}}/img/staf/1.png" alt="">
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <div class="member_thumb">
                                <img src="{{asset('assets')}}/img/staf/2.png" alt="">
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <div class="member_thumb">
                                <img src="{{asset('assets')}}/img/staf/3.png" alt="">
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <div class="member_thumb">
                                <img src="{{asset('assets')}}/img/staf/4.png" alt="">
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <div class="member_thumb">
                                <img src="{{asset('assets')}}/img/staf/5.png" alt="">
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <div class="member_thumb">
                                <div class="more_member_count">
                                    <span>90+</span>
                                </div>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="CHAT_POPUP_BODY">
            <p class="mesaged_send_date">
                Sunday, 12 January
            </p>

            <div class="CHATING_SENDER">
                <div class="SMS_thumb">
                    <img src="{{asset('assets')}}/img/staf/1.png" alt="">
                </div>
                <div class="SEND_SMS_VIEW">
                    <P>Hi! Welcome .
                        How can I help you?</P>
                </div>
            </div>

            <div class="CHATING_SENDER CHATING_RECEIVEr">

                <div class="SEND_SMS_VIEW">
                    <P>Hello</P>
                </div>
                <div class="SMS_thumb">
                    <img src="{{asset('assets')}}/img/staf/1.png" alt="">
                </div>
            </div>

        </div>
        <div class="CHAT_POPUP_BOTTOM">
            <div class="chat_input_box d-flex align-items-center">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Write your message"
                        aria-label="Recipient's username" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn " type="button">
                            <!-- svg      -->
                            <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M18.7821 3.21895C14.4908 -1.07281 7.50882 -1.07281 3.2183 3.21792C-1.07304 7.50864 -1.07263 14.4908 3.21872 18.7824C7.50882 23.0729 14.4908 23.0729 18.7817 18.7815C23.0726 14.4908 23.0724 7.50906 18.7821 3.21895ZM17.5813 17.5815C13.9525 21.2103 8.04773 21.2108 4.41871 17.5819C0.78907 13.9525 0.789485 8.04714 4.41871 4.41832C8.04752 0.789719 13.9521 0.789304 17.5817 4.41874C21.2105 8.04755 21.2101 13.9529 17.5813 17.5815ZM6.89503 8.02162C6.89503 7.31138 7.47107 6.73534 8.18131 6.73534C8.89135 6.73534 9.46739 7.31117 9.46739 8.02162C9.46739 8.73228 8.89135 9.30811 8.18131 9.30811C7.47107 9.30811 6.89503 8.73228 6.89503 8.02162ZM12.7274 8.02162C12.7274 7.31138 13.3038 6.73534 14.0141 6.73534C14.7241 6.73534 15.3002 7.31117 15.3002 8.02162C15.3002 8.73228 14.7243 9.30811 14.0141 9.30811C13.3038 9.30811 12.7274 8.73228 12.7274 8.02162ZM15.7683 13.2898C14.9712 15.1332 13.1043 16.3243 11.0126 16.3243C8.8758 16.3243 6.99792 15.1272 6.22834 13.2744C6.09642 12.9573 6.24681 12.593 6.56438 12.4611C6.64238 12.4289 6.72328 12.4136 6.80293 12.4136C7.04687 12.4136 7.27836 12.5577 7.37772 12.7973C7.95376 14.1842 9.38048 15.0799 11.0126 15.0799C12.6077 15.0799 14.0261 14.1836 14.626 12.7959C14.7625 12.4804 15.1288 12.335 15.4441 12.4717C15.7594 12.6084 15.9048 12.9745 15.7683 13.2898Z"
                                    fill="#707DB7" />
                            </svg>

                            <!-- svg      -->
                        </button>
                        <button class="btn" type="button">
                            <!-- svg  -->
                            <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M11 0.289062C4.92455 0.289062 0 5.08402 0 10.9996C0 16.9152 4.92455 21.7101 11 21.7101C17.0755 21.7101 22 16.9145 22 10.9996C22 5.08472 17.0755 0.289062 11 0.289062ZM11 20.3713C5.68423 20.3713 1.375 16.1755 1.375 10.9996C1.375 5.82371 5.68423 1.62788 11 1.62788C16.3158 1.62788 20.625 5.82371 20.625 10.9996C20.625 16.1755 16.3158 20.3713 11 20.3713ZM15.125 10.3302H11.6875V6.98314C11.6875 6.61363 11.3795 6.31373 11 6.31373C10.6205 6.31373 10.3125 6.61363 10.3125 6.98314V10.3302H6.875C6.4955 10.3302 6.1875 10.6301 6.1875 10.9996C6.1875 11.3691 6.4955 11.669 6.875 11.669H10.3125V15.016C10.3125 15.3855 10.6205 15.6854 11 15.6854C11.3795 15.6854 11.6875 15.3855 11.6875 15.016V11.669H15.125C15.5045 11.669 15.8125 11.3691 15.8125 10.9996C15.8125 10.6301 15.5045 10.3302 15.125 10.3302Z"
                                    fill="#707DB7" />
                            </svg>

                            <!-- svg  -->
                            <input type="file">
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--/### CHAT_MESSAGE_BOX  ### -->

    <div id="back-top" style="display: none;">
        <a title="Go to Top" href="#">
            <i class="ti-angle-up"></i>
        </a>
    </div>

    <!-- Modal Set Product -->
    <div class="modal fade" id="modal_set_product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Set Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('oee.set.product')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Select Product</label>
                            <select name="product" id="" class="form-control" required>
                                <option value="">--SELECT PRODUCT</option>
                                @foreach ($list_products as $lp)
                                <option value="{{$lp->id}}">{{$lp->product_code}} - {{$lp->product_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success btn-sm">Set Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal Set Production -->
    <div class="modal fade bd-example-modal-lg" id="modal_set_production" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                {{-- <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Select Production</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div> --}}
                <form action="{{route('oee.set.production')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Select Production</label>
                            <select name="production" id="set_select_production" class="form-control" required>
                                <option value="">-- SELECT PRODUCTIONS</option>
                                @foreach ($list_productions as $lpr)
                                <option {{optional($set_product)->production_id ? 'selected=selected' : '' }} value="{{$lpr->id}}">{{$lpr->production_code}} - {{$lpr->production_name}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <span>Production Detail</span>
                        <table width="100%" class="table table-bordered">
                            <tr>
                                <td>Production Code/Name</td>
                                <td>
                                    <span id="get_production_code" style="font-weight: bold">{{optional(optional($set_product)->production)->production_code}}</span>
                                    / <span id="get_production_name" style="font-weight: bold">{{optional(optional($set_product)->production)->production_name}}</span></td>
                            </tr>
                            <tr>
                                <td>Planning Code/Name</td>
                                <td><span id="get_planning_code" style="font-weight: bold">{{optional(optional(optional($set_product)->production)->planning)->plan_code}}</span> / <span
                                        id="get_planning_name" style="font-weight: bold">{{optional(optional(optional($set_product)->production)->planning)->plan_name}}</span></td>
                            </tr>
                            <tr>
                                <td>Product Code/Name</td>
                                <td><span id="get_product_code" style="font-weight: bold">{{optional($set_product)->product_code}}</span> / <span
                                        id="get_product_name" style="font-weight: bold">{{optional($set_product)->product_name}}</span></td>
                            </tr>
                            <tr>
                                <td>Shift Code/Name</td>
                                <td><span id="get_shift_code" style="font-weight: bold">{{optional($set_product)->shift_code}}</span> / <span
                                        id="get_shift_name" style="font-weight: bold">{{optional($set_product)->shift_name}}</span></td>
                            </tr>
                            <tr>
                                <td>Qty Plan</td>
                                <td><span id="get_qty_plan" style="font-weight: bold">{{optional(optional($set_product)->production)->qty_plan}}</span></td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success btn-sm">Set Production</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- footer  -->
    <script src="{{asset('assets')}}/js/jquery-3.4.1.min.js"></script>
    <!-- popper js -->
    <script src="{{asset('assets')}}/js/popper.min.js"></script>
    <!-- bootstarp js -->
    {{-- <script src="{{asset('assets')}}/js/bootstrap.min.js"></script> --}}
    <script src="{{asset('assets')}}/js/bootstrap-datepicker.js"></script>
    <!-- sidebar menu  -->
    <script src="{{asset('assets')}}/js/metisMenu.js"></script>
    <!-- waypoints js -->
    {{-- <script src="{{asset('assets')}}/vendors/count_up/jquery.waypoints.min.js"></script> --}}
    <!-- waypoints js -->
    {{-- <script src="{{asset('assets')}}/vendors/chartlist/Chart.min.js"></script> --}}
    <!-- counterup js -->
    {{-- <script src="{{asset('assets')}}/vendors/count_up/jquery.counterup.min.js"></script> --}}

    <!-- nice select -->
    <script src="{{asset('assets')}}/vendors/niceselect/js/jquery.nice-select.min.js"></script>
    <!-- owl carousel -->
    {{-- <script src="{{asset('assets')}}/vendors/owl_carousel/js/owl.carousel.min.js"></script> --}}

    <!-- responsive table -->
    <script src="{{asset('assets')}}/vendors/datatable/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('assets')}}/vendors/datatable/js/dataTables.responsive.min.js"></script>
    <script src="{{asset('assets')}}/vendors/datatable/js/dataTables.buttons.min.js"></script>
    <script src="{{asset('assets')}}/vendors/datatable/js/buttons.flash.min.js"></script>
    <script src="{{asset('assets')}}/vendors/datatable/js/jszip.min.js"></script>
    <script src="{{asset('assets')}}/vendors/datatable/js/pdfmake.min.js"></script>
    <script src="{{asset('assets')}}/vendors/datatable/js/vfs_fonts.js"></script>
    <script src="{{asset('assets')}}/vendors/datatable/js/buttons.html5.min.js"></script>
    <script src="{{asset('assets')}}/vendors/datatable/js/buttons.print.min.js"></script>

    <!-- datepicker  -->
    <script src="{{asset('assets')}}/vendors/datepicker/datepicker.js"></script>
    <script src="{{asset('assets')}}/vendors/datepicker/datepicker.en.js"></script>
    <script src="{{asset('assets')}}/vendors/datepicker/datepicker.custom.js"></script>

    {{-- <script src="{{asset('assets')}}/js/chart.min.js"></script> --}}
    {{-- <script src="{{asset('assets')}}/vendors/chartjs/roundedBar.min.js"></script> --}}

    <!-- progressbar js -->
    {{-- <script src="{{asset('assets')}}/vendors/progressbar/jquery.barfiller.js"></script> --}}
    <!-- tag input -->
    {{-- <script src="{{asset('assets')}}/vendors/tagsinput/tagsinput.js"></script> --}}
    <!-- text editor js -->
    <script src="{{asset('assets')}}/vendors/text_editor/summernote-bs4.js"></script>
    {{-- <script src="{{asset('assets')}}/vendors/am_chart/amcharts.js"></script> --}}

    <!-- scrollabe  -->
    <script src="{{asset('assets')}}/vendors/scroll/perfect-scrollbar.min.js"></script>
    <script src="{{asset('assets')}}/vendors/scroll/scrollable-custom.js"></script>

    <!-- vector map  -->
    {{-- <script src="{{asset('assets')}}/vendors/vectormap-home/vectormap-2.0.2.min.js"></script> --}}
    {{-- <script src="{{asset('assets')}}/vendors/vectormap-home/vectormap-world-mill-en.js"></script> --}}
    {{--  --}}
    <!-- apex chrat  -->
    {{-- <script src="{{asset('assets')}}/vendors/apex_chart/apex-chart2.js"></script> --}}
    {{-- <script src="{{asset('assets')}}/vendors/apex_chart/apex_dashboard.js"></script> --}}

    <!-- <script src="{{asset('assets')}}/vendors/echart/echarts.min.js"></script> -->
    <script src="{{asset('assets')}}/vendors/echart/echarts.min.js"></script>
    <script src="{{asset('assets')}}/js/custom.js"></script>



    <script src="{{asset('dist')}}/js/app.js"></script>

    {{-- <script src="{{asset('assets')}}/vendors/chart_am/core.js"></script>
    <script src="{{asset('assets')}}/vendors/chart_am/charts.js"></script>
    <script src="{{asset('assets')}}/vendors/chart_am/animated.js"></script>
    <script src="{{asset('assets')}}/vendors/chart_am/kelly.js"></script>
    <script src="{{asset('assets')}}/vendors/chart_am/chart-custom.js"></script> --}}
    <!-- custom js -->
    {{-- <script src="{{asset('assets')}}/js/dashboard_init.js"></script> --}}
    <!-- <script src="https://cdn.socket.io/3.1.3/socket.io.min.js"
        integrity="sha384-cPwlPLvBTa3sKAgddT6krw0cJat7egBga3DJepJyrLl4Q9/5WLra3rrnMcyTyOnh" crossorigin="anonymous">
    </script> -->

    <!-- Socket -->
    <script src="{{asset('assets/js/socket.io.js')}}"></script>

    <script>
        // --- global variables
        const base_url = `{!!url('/')!!}`;
        console.log(base_url);
        const socket = io("iot.mksolusi.id:8010");

        // --- GET PRODUCTION
        $('#set_select_production').on('change', async function () {
            let resp = await axios.get(base_url + '/api/get-production/' + this.value);
            console.log(resp.data);
            let data_production = resp.data;
            $('#get_production_code').text(data_production.production_code);
            $('#get_production_name').text(data_production.production_name);
            $('#get_planning_name').text(data_production.planning_name);
            $('#get_planning_code').text(data_production.planning_code);
            $('#get_product_code').text(data_production.product_code);
            $('#get_product_name').text(data_production.product_name);
            $('#get_shift_code').text(data_production.shift_code);
            $('#get_shift_name').text(data_production.shift_name);
            $('#get_qty_plan').text(data_production.qty_plan);
        })

        
        // --- RUNNING CLOCK
        var span = $('#clock');

        function time() {
            var d = new Date();
            var s = d.getSeconds();
            var m = d.getMinutes();
            var h = d.getHours();
            let textContent =
                ("0" + h).substr(-2) + ":" + ("0" + m).substr(-2) + ":" + ("0" + s).substr(-2);
            span.text(textContent);
        }

        setInterval(time, 1000);
        // --- rumus OEE


        var shifts = @json($shift[0]??$shift[1] ?? "0");
        function getQuality(total, good, reject) {
            /*
            rumus :
            good/total*100
            */
            let qlity = (good / total) * 100;
            return qlity;
        }
        function getPerformance(total, timeAvail = shifts.running_operation, cycle) {
            /*
                rumus :
                totalQty/waktuYangtersedia(menit)*100
                */
            // let prfrmnc = (total / (timeAvail * 20)) * 100;
            let prfrmnc = ((total * cycle) / timeAvail) * 100;
            // console.log(timeAvail);
            return prfrmnc;
        }

        function getAvailability(totalTime = 480, timeDownTime = 0, totalOperation = 480) {
            /*
                Total Waktu yang tersedia – (Waktu Breakdown + Waktu Setup)   x 100
                Total Waktu yang tersedia

                480 – (30+20)  x 100  = 89.58%
                480
                */
            let avail = ((totalTime + timeDownTime) - timeDownTime) / (totalTime + timeDownTime) * 100;
            // console.log(timeDownTime);
            return avail;
        }

        function getRejectPercent(total, reject) {
            /*
            rumus :
            good/total*100
            */
            let rejectPcn = (reject / total) * 100;
            return rejectPcn;
        }

        function getValue(name, values) {
            let finalVal = '-';
            values.forEach(v => {
                if (v.TagName == name) {
                    finalVal = v.TagValue
                }
            });
            return finalVal
        }

        function fix_val(val, del = 2) {
            if (val != undefined || val != null) {
                var rounded = val.toFixed(del).toString().replace('.', "."); // Round Number
                return this.numberWithCommas(rounded); // Output Result
            }

        }

        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "");
        }

    </script>

    <script>
        let oee_machines = @json($oee_machines);


           // --- global listener
        //    socket.on('toClientRealtimeValuesResults', (data) => {
        //         // console.log(data[1]);
                
        //         oee_machines.forEach(machine => {
        //             let oams = machine.oee_alarm_master;
        //             if(oams.length > 0){
        //                 // console.log(data)
        //                 oams.forEach(oam => {
                            
        //                     data.forEach(d => {
        //                         if(parseInt(machine.name) === parseInt(d.TagGroupName)){
        //                             //  console.log(d)
        //                             d.values.forEach(d2 => {
                                        
        //                                 if(oam.alarm_tag === d2.TagAddress){
        //                                     oam.alarms.forEach(oad => {
        //                                         if(d2.TagValue[oad.index_array]){
        //                                             console.log(oad.text)
        //                                         }
        //                                     });
        //                                 }
        //                             });
        //                         }
        //                     });
        //                 });
                        
        //             }
                    
        //         })
        //     });
        // console.log(oee_machines);
        let listMachine = [];
        listMachine = oee_machines.map(function (machine) {
            return machine.id;
        });
        $('.list-machine').on('click', function () {
            let checkbox = $(this).find('input')
            if (checkbox.is(':checked')) {
                checkbox.prop("checked", false)
                listMachine.push(checkbox.val())
                $("#machine-" + checkbox.val()).addClass('hilang')
            } else {
                checkbox.prop("checked", true)
                listMachine.shift(checkbox.val())
                $("#machine-" + checkbox.val()).removeClass('hilang')
            }
            console.log(checkbox.is(':checked'))
        })

        showMachine(listMachine)

        function showMachine(listMachine) {
            listMachine.forEach(element => {
                $('#machine-' + element).removeClass('hilang');
            });
        }

        // showMachine(listMachine)
        // $(".listmachine").change(function () {

        // });

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
                        action: function () {
                            $.ajax({
                                type: 'GET',
                                url: '/logout',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                data: {
                                    "_token": "{{ csrf_token() }}"
                                },
                                success: function (data) {
                                    location.reload();
                                },
                                error: function (data) {
                                    location.reload();
                                }
                            });
                        }
                    },
                    cancel: function () {

                    }
                }
            });
        }

    </script>

    @stack('js')
</body>

<!-- Mirrored from demo.dashboardpack.com/user-management-html/index_3.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 20 May 2021 03:59:52 GMT -->

</html>
