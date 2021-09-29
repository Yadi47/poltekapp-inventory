@extends('mrp')

@section('title', $page_title)
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
    @if (auth()->user()->can('report_forcast-list'))
    <div class="col-lg-3 col-md-6" id="report_forecast" onclick="location.href='{{ route('mrp.report_smc-list')}}'">
        <div class="box card">
            <div class="box-body">
                <div class="d-flex align-items-center">
                    <div class="me-15 bg-success h-50 w-50 l-h-50 rounded text-center">
                        <img src="{{ asset('img/report4.svg') }}" style="height: 30px" alt="">
                    </div>
                    <div class="d-flex flex-column tx-xs-medium">
                        <span class="text-dark font-weight-bold" style="font-size: 16px;">Report Forecast</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if (auth()->user()->can('report_planning_production-list'))
    <div class="col-lg-3 col-md-6" id="report_planning_production" onclick="location.href='{{ route('mrp.report_planning-list')}}'">
        <div class="box card">
            <div class="box-body">
                <div class="d-flex align-items-center">
                    <div class="me-15 bg-success h-50 w-50 l-h-50 rounded text-center">
                        <img src="{{ asset('img/analytics.svg') }}" style="height: 30px" alt="">
                    </div>
                    <div class="d-flex flex-column tx-xs-medium">
                        <span class="text-dark font-weight-bold" style="font-size: 16px;">Report Planning Production</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if (auth()->user()->can('report_production-list'))
    <div class="col-lg-3 col-md-6" id="report_production" onclick="location.href='{{ route('mrp.report.report-list')}}'">
        <div class="box card">
            <div class="box-body">
                <div class="d-flex align-items-center">
                    <div class="me-15 bg-light h-50 w-50 l-h-50 rounded text-center">
                        <img src="{{ asset('img/bar-chart.svg') }}" style="height: 30px" alt="">
                    </div>
                    <div class="d-flex flex-column tx-xs-medium">
                        <span class="text-dark font-weight-bold" style="font-size: 16px;">Report Production</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if (auth()->user()->can('report_wip-list'))
    <div class="col-lg-3 col-md-6" id="report_wip" onclick="location.href='{{ route('mrp.report.report_wip-list')}}'">
        <div class="box card">
            <div class="box-body">
                <div class="d-flex align-items-center">
                    <div class="me-15 bg-info h-50 w-50 l-h-50 rounded text-center">
                        <img src="{{ asset('img/statistics.svg') }}" style="height: 30px" alt="">
                    </div>
                    <div class="d-flex flex-column tx-xs-medium">
                        <span class="text-dark font-weight-bold" style="font-size: 16px;">Report Wip</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- @if (auth()->user()->can('report_initial-list'))
    <div class="col-lg-3 col-md-6" id="report_initial" onclick="location.href='{{ route('mrp.report_initial-list')}}'">
        <div class="box card">
            <div class="box-body">
                <div class="d-flex align-items-center">
                    <div class="me-15 bg-info h-50 w-50 l-h-50 rounded text-center">
                        <img src="{{ asset('img/report2.svg') }}" style="height: 30px" alt="">
                    </div>
                    <div class="d-flex flex-column tx-xs-medium">
                        <span class="text-dark font-weight-bold" style="font-size: 16px;">Report Initial</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif -->

    @if (auth()->user()->can('report_bom-list'))
    <div class="col-lg-3 col-md-6" id="report_bom" onclick="location.href='{{ route('mrp.report.report_bom-list')}}'">
        <div class="box card">
            <div class="box-body">
                <div class="d-flex align-items-center">
                    <div class="me-15 bg-light h-50 w-50 l-h-50 rounded text-center">
                        <img src="{{ asset('img/report3.svg') }}" style="height: 30px" alt="">
                    </div>
                    <div class="d-flex flex-column tx-xs-medium">
                        <span class="text-dark font-weight-bold" style="font-size: 16px;">Report Bom</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="col-lg-3 col-md-6" id="report_inventory" onclick="location.href='{{ route('mrp.report-inventory-index')}}'">
        <div class="box card">
            <div class="box-body">
                <div class="d-flex align-items-center">
                    <div class="me-15 bg-secondary h-50 w-50 l-h-50 rounded text-center">
                        <img src="{{ asset('img/chart.svg') }}" style="height: 30px" alt="">
                    </div>
                    <div class="d-flex flex-column tx-xs-medium">
                        <span class="text-dark font-weight-bold" style="font-size: 16px;">Report Inventory</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (auth()->user()->can('report_delivery-index'))
    <div class="col-lg-3 col-md-6" id="report_delivery" onclick="location.href='{{ route('mrp.report.report_delivery-list')}}'">
        <div class="box card">
            <div class="box-body">
                <div class="d-flex align-items-center">
                    <div class="me-15 bg-secondary h-50 w-50 l-h-50 rounded text-center">
                        <img src="{{ asset('img/graph-bar.svg') }}" style="height: 30px" alt="">
                    </div>
                    <div class="d-flex flex-column tx-xs-medium">
                        <span class="text-dark font-weight-bold" style="font-size: 16px;">Report Delivery</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>
@endsection

@push('css')
    <!-- datatable CSS -->
    <link rel="stylesheet" href="{{ asset('assets') }}/vendors/datatable/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendors/datatable/css/responsive.dataTables.min.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendors/datatable/css/buttons.dataTables.min.css" />
@endpush
@push('js')

    <script src="{{ asset('assets') }}/vendors/datatable/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('assets') }}/vendors/datatable/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('assets') }}/vendors/datatable/js/dataTables.buttons.min.js"></script>

    {{-- SEARCH --}}
    <script>
        const dictionary = ['report_forecast', 'report_planning_production', 'report_production','report_wip','report_initial','report_bom','report_inventory','report_delivery'];
        const searchInput = document.getElementById("search");

        searchInput.addEventListener("keyup", (e) => {
            dictionary.forEach(element => {
                let id = '#' + element;
                $(id).addClass('hidden')
            });

            const inputText = e.target.value.toLowerCase();
            let filtered = dictionary.filter((data) => {
                return data.indexOf(inputText.toLowerCase()) !== -1;
            });

            filtered.forEach(element => {
                let id = '#' + element;
                $(id).removeClass('hidden')
            });
            console.log(filtered)
        });

    </script>


@endpush
