@extends('index')
@section('content')

<!-- Home page awal -->
<!-- <div class="row ">
    <div class="col-xl-10">

        <div class="white_card mb_30 shadow">
            <div class="white_card_header">
                <div class="row align-items-center justify-content-between flex-wrap">
                    <div class="col-lg-4">
                        <div class="main-title">
                            <h3 class="m-0">Welcome , Administrator</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-7">
                    <div class="white_card_body ">
                        <img src="{{asset('/assets/img/logo/itokin.png')}}" alt="">
                        <h5>PT. Itokin Indonesia</h5>
                        <p>Jl. Mitra Raya II, Parungmulya, Kec. Ciampel, Kabupaten Karawang, Jawa Barat
                            41362
                        </p>
                    </div>
                </div>
                <div class="col-xl-5">
                    <div class="white_card_body">
                        <div class="row ">
                            <div class="col-lg-12">
                                <a href="{{url('/oee')}}" class="menu-select">
                                    <div class="card_box  position-relative  green_bg ">
                                        <div class="box_body" style="padding:20px">
                                            <div class="row">
                                                <div class="col-3">
                                                    <i class="ti-desktop text_white" style="font-size: 50px"></i>
                                                </div>
                                                <div class="col-9">
                                                    <div class="text_white" style="color: white">
                                                        <h4 class="text_white">OEE Monitoring</h4>
                                                        <p class="text_white">Outlines keep you and
                                                            honest
                                                            indulging honest.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="row mt_20">
                            <div class="col-lg-12">
                                <a href="{{route('mrp.master-data-index')}}" class="menu-select">
                                    <div class="card_box position-relative  blue_bg ">

                                        <div class="box_body" style="padding:20px">
                                            <div class="row">
                                                <div class="col-3">
                                                    <i class="ti-receipt text_white" style="font-size: 50px"></i>
                                                </div>
                                                <div class="col-9">
                                                    <div class="text_white" style="color: white">
                                                        <h4 class="text_white">MRP System</h4>
                                                        <p class="text_white">Outlines keep you and
                                                            honest
                                                            indulging honest.</p>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="row mt_20">
                            <div class="col-lg-12">
                                <a href="{{url('/access-management')}}" class="menu-select">
                                    <div class="card_box position-relative  orange_bg    ">

                                        <div class="box_body" style="padding:20px">
                                            <div class="row">
                                                <div class="col-3">
                                                    <i class="ti-user text_white" style="font-size: 50px"></i>
                                                </div>
                                                <div class="col-9">
                                                    <div class="text_white" style="color: white">
                                                        <h4 class="text_white">Access Management</h4>
                                                        <p class="text_white">Outlines keep you and
                                                            honest
                                                            indulging honest.</p>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>


                </div>

            </div>
        </div>


    </div>


</div> -->

<!-- Home Page Baru -->

<style>

  .info-box-icon {
    border-radius: 5px;
    align-items: center;
    display: flex;
    padding: 5px;
    font-size: 2.5rem;
    justify-content: center;
  }
  .info-box-text{
    display: block;
    font-size: 21px;
    margin-top: .776rem;
    margin-left: .776rem;
  }

  .box-body {
        padding: 1rem;
        -ms-flex: 1 1 auto;
        flex: 1 1 auto;
        border-radius: 10px; 
    }
    
    .card {
        cursor: pointer;
        transition: all 0.7s;
    }

    .card:hover {
        transform: scale(1.07) !important;
        box-shadow: 0 10px 20px rgba(0, 0, 0, .12), 0 5px 8px rgba(0, 0, 0, .06);
    }

    .mt-30 {
        margin-top: 30px;
    }

    .me-15 {
        margin-right: 15px !important; 
    }

    .h-50 {
        height: 50px !important; 
    }  

    .w-50 {
        width: 50px !important; 
    }

    .l-h-50 {
        line-height: 3.0714285714rem!important; 
    }

    .rounded { 
        border-radius: .25rem !important;
    }

    @media (max-width: 767px) {
        .small-box {
            text-align: center; 
            }
            .small-box .icon {
            display: none; 
            }
            .small-box p {
            font-size: 0.8571rem; 
            } 
        }
        .box {
            position: relative;
            margin-bottom: 1.5rem;
            width: 100%;
            background-color: #ffffff;
            border-radius: 10px;
            padding: 0px;
            -webkit-transition: .5s;
            transition: .5s;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            -webkit-box-shadow: 0 0 30px 0 rgba(82, 63, 105, 0.05);
            box-shadow: 0 0 30px 0 rgba(82, 63, 105, 0.05); 
        }
    }
</style>
<div class="row ">
    <div class="col-lg-12">
        <div class="white_card mb_30 shadow">
            <div class="white_card mb_30 shadow">
                <div class="white_card_header">
                    <p class="h4 text-dark" style="display:inline !important;"><i class=" fas fa-layer-group"></i> OEE </p>
                    <a href="{{ route('home') }}" style="float:right;">
                        <button type="button" class="btn btn-warning btn-sm"><i class="ti-arrow-left"></i></button>
                    </a>
                    <hr>
                    <div class="br-pagebody">
                        <div class="row mt-30"> 
                        @if (auth()->user()->can('oee-dashboard'))
                            <div class="col-lg-3 col-md-6" onclick="location.href='{{ route('oee.dashboard')}}'">
                                <div class="box card">
                                    <div class="box-body bg-light">
                                        <div class="d-flex align-items-center">
                                            <div class="me-15  h-50 w-50 l-h-50 rounded text-center">
                                                <img src="{{ asset('img/oee.svg') }}" style="height: 30px" alt="">
                                            </div>
                                            <div class="d-flex flex-column tx-xs-medium">
                                                <span class="text-dark font-weight-bold" style="font-size: 16px;">OEE</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if (auth()->user()->can('pde-dashboard'))
                            <div class="col-lg-3 col-md-6" onclick="location.href='{{ route('oee.pde')}}'">
                                <div class="box card">
                                    <div class="box-body bg-light">
                                        <div class="d-flex align-items-center">
                                            <div class="me-15 bg-success h-50 w-50 l-h-50 rounded text-center">
                                                <img src="{{ asset('img/pde.svg') }}" style="height: 30px" alt="">
                                            </div>
                                            <div class="d-flex flex-column tx-xs-medium">
                                                <span class="text-dark font-weight-bold" style="font-size: 16px;">Production Realtime</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if (auth()->user()->can('summary-dashboard'))
                            <div class="col-lg-3 col-md-6 d-none" onclick="location.href='{{ route('oee.')}}'">
                                <div class="box card">
                                    <div class="box-body bg-light">
                                        <div class="d-flex align-items-center">
                                            <div class="me-15 bg-info h-50 w-50 l-h-50 rounded text-center">
                                                <img src="{{ asset('img/sumary.svg') }}" style="height: 30px" alt="">
                                            </div>
                                            <div class="d-flex flex-column tx-xs-medium">
                                                <span class="text-dark">Summary</s style="font-size: 16px;"pan>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div><!-- br-pagebody -->
        </div>
    </div>
</div>

@endsection
