@extends('index')
@section('content')
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
                    <p class="h4 text-dark" style="display:inline !important;"><i class="fas fa-layer-group" ></i> Master Data </p>
                    <a href="{{ route('home') }}" style="float:right;">
                        <button type="button" class="btn btn-warning btn-sm"><i class="ti-arrow-left"></i></button>
                    </a>
                    <hr>
                    <div class="br-pagebody">
                        <div class="row mt-30"> 
                        @if (auth()->user()->can('machine-list'))
                            <div class="col-lg-3 col-md-6" onclick="location.href='{{ route('oee.machine.index')}}'">
                                <div class="box card">
                                    <div class="box-body bg-light">
                                        <div class="d-flex align-items-center">
                                            <div class="me-15  bg-secondary h-50 w-50 l-h-50 rounded text-center">
                                                <img src="{{ asset('img/machine-list.svg') }}" style="height: 35px" alt="">
                                            </div>
                                            <div class="d-flex flex-column tx-xs-medium">
                                                <span class="text-dark font-weight-bold" style="font-size: 18px;">Display List</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        <!-- @if (auth()->user()->can('machine-list')) -->
                            <div class="col-lg-3 col-md-6" onclick="location.href='{{ route('oee.alarm-setting.index')}}'">
                                <div class="box card">
                                    <div class="box-body bg-light">
                                        <div class="d-flex align-items-center">
                                            <div class="me-15  bg-warning h-50 w-50 l-h-50 rounded text-center">
                                                <img src="{{ asset('img/alarm.svg') }}" style="height: 35px" alt="">
                                            </div>
                                            <div class="d-flex flex-column tx-xs-medium">
                                                <span class="text-dark font-weight-bold" style="font-size: 18px;">Alarm Setting</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!-- @endif -->
                    </div>
                </div>
            </div><!-- br-pagebody -->
        </div>
    </div>
</div>

@endsection
