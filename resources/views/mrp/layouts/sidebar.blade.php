<nav class="sidebar dark_sidebar ">
    <div class="logo d-flex justify-content-between " style="border-bottom: #ffffff26 1px solid;">
        <a class="large_logo mx-auto" href="{{ url('/') }}"><img src="{{asset('assets')}}/img/poltekapp.png" alt="" style=" max-width: 140; width: auto; max-height: 70px;"></a>
        {{-- <a class="large_logo mx-auto" href="{{ url('/') }}"><h3 style="font-size: 20px; color: white;">Inventory Management</h3></a> --}}
        <a class="small_logo" href="{{ url('/') }}"><img src="{{ asset('assets') }}/img/poltekapp.png" alt="" width="50"></a>
        <div class="sidebar_close_icon d-lg-none">
            <i class="ti-close"></i>
        </div>
    </div>
    <ul id="sidebar_menu">

        

       
        <!-- Inventory -->
        <li class="">
            <a class="" href="{{ route('mrp.inventory-index') }} " aria-expanded="false">
                <div class="nav_icon_small">
                    <i class="ti-archive"></i>
                    {{-- <img src="{{asset('assets')}}/img/menu-icon/dashboard.svg" alt=""> --}}
                </div>
                <div class="nav_title">
                    <span>Inventory </span>
                </div>
            </a>
        </li>
        <!-- End Inventory -->

        <li class="">
            <a class="" href="{{ route('mrp.master-data-index') }} " aria-expanded="false">
                <div class="nav_icon_small">
                    <i class="ti-folder"></i>
                    {{-- <img src="{{asset('assets')}}/img/menu-icon/dashboard.svg" alt=""> --}}
                </div>
                <div class="nav_title">
                    <span>Master Data </span>
                </div>
            </a>
        </li>
        <!-- End Master Data -->

        <!-- Master Data -->
        <li class="">
            <a class="" href="{{ route('mrp.report-inventory-index') }} " aria-expanded="false">
                <div class="nav_icon_small">
                    <i class="ti-folder"></i>
                    {{-- <img src="{{asset('assets')}}/img/menu-icon/dashboard.svg" alt=""> --}}
                </div>
                <div class="nav_title">
                    <span>Report </span>
                </div>
            </a>
        </li>
        

    </ul>
</nav>
