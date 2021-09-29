@extends('index')
@section('content')
<div class="row ">
    <div class="col-xl-3">
        <a href="{{route('access-management.user-list')}}" class="menu-select">
            <div class="white_card mb_30 shadow">
                <div class="white_card_header">
                    <div class="row align-items-center justify-content-between flex-wrap">
                        <div class="col-lg-12">
                            <div class="main-title">
                                <h3 class="m-0">Users</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="white_card_body ">
                    <p>Manage user list & access
                    </p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-xl-3">
        <a href="{{route('access-management.role-list')}}" class="menu-select">
            <div class="white_card mb_30 shadow">
                <div class="white_card_header">
                    <div class="row align-items-center justify-content-between flex-wrap">
                        <div class="col-lg-12">
                            <div class="main-title">
                                <h3 class="m-0">Roles</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="white_card_body ">
                    {{-- <img src="{{asset('/assets/img/logo/itokin.png')}}" alt=""> --}}
                    {{-- <h5>PT. Itokin Indonesia</h5> --}}
                    <p>Manage role list & permission
                    </p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-xl-3">
        <a href="{{route('access-management.permission-list')}}" class="menu-select">
            <div class="white_card mb_30 shadow">
                <div class="white_card_header">
                    <div class="row align-items-center justify-content-between flex-wrap">
                        <div class="col-lg-12">
                            <div class="main-title">
                                <h3 class="m-0">Permissions</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="white_card_body ">
                    {{-- <img src="{{asset('/assets/img/logo/itokin.png')}}" alt=""> --}}
                    {{-- <h5>PT. Itokin Indonesia</h5> --}}
                    <p>Manage permission for roles
                    </p>
                </div>
            </div>
        </a>
    </div>


</div>
@endsection
