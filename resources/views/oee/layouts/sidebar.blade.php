<nav class="sidebar   dark_sidebar">
    <div class="logo d-flex justify-content-between" style="border-bottom: #ffffff26 1px solid;">
        <a class="large_logo mx-auto" href="{{ url('/') }}"><img src="{{asset('assets')}}/img/itokin-2.png" alt="" style=" max-width: 140; width: auto; max-height: 31px;"></a>
        <a class="small_logo" href="{{ url('/') }}"><img src="{{asset('assets')}}/img/mini-itokin2.png" alt="" width="50"></a>
        <div class="sidebar_close_icon d-lg-none">
            <i class="ti-close"></i>
        </div>
    </div>
    <ul id="sidebar_menu">
        <li class="">
            <a class="" href="{{ url('/') }}" aria-expanded="true">
                <div class="nav_icon_small">
                    <i class="ti-bag"></i>
                    <!-- <img src="{{asset('assets')}}/img/itokin-2.png" alt=""> -->
                </div>
                <div class="nav_title">
                    <span>Home Page </span>
                </div>
            </a>
        </li>

        <!-- Dashboard -->
        <li class="">
            <a class="has-arrow" href="#" aria-expanded="false">
                <div class="nav_icon_small">
                    <i class="fas fa-bars"></i>
                </div>
                <div class="nav_title">
                    <span>Dashboard OEE</span>
                </div>
            </a>

            <ul>
                <li><a href="{{ route('oee.dashboard')}}">OEE</a></li>
                <li><a href="{{ route('oee.pde')}}">Production Realtime</a></li>
                <!-- <li><a href="{{url('/oee/dashboard-defect-rate')}}">Defect Rate</a></li>  -->
                <!-- <li><a href="{{url('/oee/dashboard-productivity')}}">Productivity</a></li>  -->
                <!-- <li><a href="{{ route('oee.')}}">Summary</a></li> -->
            </ul>
        </li>
        <!-- end Dashboard -->

        <!-- Production Performance -->
        <li class="">
            <a class="" href="{{ route('oee.production-performance')}}" aria-expanded="true">
                <div class="nav_icon_small">
                    <i class="ti-bag"></i>
                    <!-- <img src="{{asset('assets')}}/img/itokin-2.png" alt=""> -->
                </div>
                <div class="nav_title">
                    <span>Production Performance </span>
                </div>
            </a>
        </li>
        <!-- End Production Performance -->
       
        <!-- Alarm Settings -->
        <li class="">
            <a class="" href="{{ route('oee.alarm-list.index')}}" aria-expanded="true">
                <div class="nav_icon_small">
                    <i class="ti-alarm-clock"></i>
                    <!-- <img src="{{asset('assets')}}/img/itokin-2.png" alt=""> -->
                </div>
                <div class="nav_title">
                    <span>Alarm List </span>
                </div>
            </a>
        </li>
        <!-- End Alarm Settings -->

        <!-- End Master Data -->
        <li class="">
            <a class="has-arrow" href="#" aria-expanded="false">
                <div class="nav_icon_small">
                    <i class="fas fa-folder"></i>
                </div>

                <div class="nav_title">
                    <span>Master Data</span>
                </div>
            </a>
            <ul>
                <li><a href="{{ route('oee.machine.index')}}">Display List</a></li>
                <li><a href="{{ route('oee.alarm-setting.index')}}">Alarm Setting</a></li>
            </ul>
        </li>

        
        <div style="padding:20px" class="d-none">
            <div class="set-production">
                <div class="white_box_tittle " style="padding: 10px;background:#EFEFEF">
                    <div div class=" main-title2 ">
                        <p class=" nowrap text-black " style=" font-weight: 800;color:black;background:#EFEFEF">
                            Production
                            Details</p>
                        <span id="clock">-</span>

                    </div>
                </div>

                <div class="box_body"
                    style="border-bottom-left-radius: 20px;border-bottom-right-radius: 20px;padding: 9px;background: #E6E6E6;color: black;font-size: 12px;">

                    <table class="" style="width: 100%;margin-bottom:10px">
                        <tr>
                            <td width="50%">Shift</td>
                            <td width="50%">: {{ $shift[0]['shift'] ?? $shift[1]['shift'] ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Start Shift </td>
                            <td>: {{ $shift[0]['start_shift'] ??  $shift[1]['start_shift'] ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>End Shift </td>
                            <td>: {{ $shift[0]['stop_shift'] ??  $shift[1]['stop_shift'] ?? '-' }}</td>
                        </tr>
                    </table>

                    @if(Session::has('set-product-message'))
                    <div class="alert  {{ Session::get('alert-class', 'alert-info') }} d-flex align-items-center justify-content-between"
                        role="alert" style=" padding: 2px;margin-bottom: 2px;">
                        <div class="alert-text">
                            <p style="font-size: 13px">{{ Session::get('set-product-message') }}</p>
                        </div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <i class="ti-close  f_s_14"></i>
                        </button>
                    </div>
                    @endif


                    <table class="" style="width: 100%">
                        <tr>
                            <td width="100%">Product Code :</td>
                        </tr>
                        <tr>
                            <td width="100%"><span
                                    style="font-weight: bold;">{{optional($set_product)->product_code}}</span>
                            </td>
                        </tr>
                        <tr>
                            <td width="100%">Product Name :</td>
                        </tr>
                        <tr>
                            <td><span style="font-weight: bold;"> {{optional($set_product)->product_name}}</span>
                            </td>
                        </tr>
                    </table>



                    <table class="" style="width: 100%;margin-top:10px">
                        <tr>
                            <td width="100%">Planning Code </td>
                        </tr>
                        <tr>
                            <td width="100%">
                                <input type="text" readonly class="form-control form-control-sm "
                                    value="{{optional(optional($set_product)->production)->production_code}}">
                                {{-- <span style="font-weight: bold;">{{optional($set_product)->production->production_code}}</span>
                            </td> --}}
                        </tr>
                        <tr>
                            <td width="100%">Production Name </td>
                        </tr>
                        <tr>
                            <td width="100%">
                                <textarea type="text" readonly
                                    class="form-control form-control-sm ">{{optional(optional($set_product)->production)->production_name}}</textarea>

                                {{-- <span style="font-weight: bold;">{{optional($set_product)->production->production_name}}</span>
                                --}}
                            </td>
                        </tr>
                        <tr>
                            <td width="100%">Qty Plan </td>
                        </tr>
                        <tr>
                            <td width="100%">
                                <input type="text" readonly class="form-control form-control-sm "
                                    value="{{optional(optional($set_product)->production)->qty_plan}}">

                                {{-- <span style="font-weight: bold;">{{optional($set_product)->production->qty_plan}}</span>
                                --}}
                            </td>
                        </tr>
                    </table>
                    @if (auth()->user()->can('oee-set-production'))
                    <button class="btn btn-sm btn-danger "
                        style="margin-bottom: 10px;margin-top: 5px;    padding: .27rem;font-size: 10px;line-height: 0.8;border-radius: .2rem;"
                        data-toggle="modal" data-target="#modal_set_production">Set Production</button>
                    @endif
                </div>
            </div>

        </div>
    </ul>



</nav>
