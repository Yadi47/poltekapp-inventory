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

        #table2 {
        overflow: auto !important;
         
    }
    
    /* .user_crm_wrapper .single_crm{
        width: 150px !important;
    } */
    </style>

<div class="row ">
    <div class="col-xl-12">
        <div class="white_card mb_30 shadow ">
            <div class="white_card_header">
                <div class="row align-items-center justify-content-between flex-wrap">
                    <div class="col-lg-6 ">
                        <div class="main-title">
                            <h3 class="m-0 d-inline">{{$page_title}}</h3>
                        </div>
                    </div>
                    <div class="col-lg-6 text-right ">
                        <input autocomplete="off"
                            class="datepicker-here  digits @error('start_date') is-invalid @enderror"
                            type="text" data-language="en" data-min-view="months" data-view="months"
                            data-date-format="MM yyyy" name="start_date" id="date_filter">
                        @error('start_date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <button class="button btn-sm btn-primary" onclick="filter()">SUBMIT</button>
                    </div>
                </div>
                <br>
                
                <div class="row align-items-center justify-content-end flex-wrap">
                    <div class="col-lg-12 text-right">
                        <select class="nice_Select2" id="material_choose">
                            <option value="all">All (Material)</option>
                            @foreach ($inventory_material as $material)
                            <option value="{{ $material->material_id }}">
                              {{ $material->material->material_code }} | {{ $material->material->material_name }} <span>( {{$material->material->part_number}} )</span>
                            </option>
                            @endforeach
                        </select>
                        <select class="nice_Select2" id="product_choose">
                            <option value="all">All (Product)</option>
                            @foreach ($inventory_product as $product)
                            <option value="{{ $product->product_id }}">
                              {{ $product->product->product_code }} | {{ $product->product->part_name }} <span>( {{ $product->product->part_number}} )</span> 
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- <div class="col-xl-12 d-block">
        <div class="white_card card_height_100 mb_30 user_crm_wrapper">
            <div class="row">
                <div class="col-lg-6">
                    <div class="single_crm">
                        <div class="crm_head d-flex align-items-center justify-content-between" style="background: #536162;">
                            <div class="thumb">
                                <a onclick="detailModal('Data', '/mrp/'+'dashboard/detail-logistic', 'x-large')" style="cursor: pointer"> <i class="ti-eye"></i></a>
                                <img src="img/crm/businessman.svg" alt="">
                            </div>
                            <i class="fas fa-ellipsis-h f_s_11 white_text"></i>
                        </div>
                        <div class="crm_body text-center">
                            <h1 class="font-weight-bold" id="totalConveyorLogistic">{{ $sumconveyorlogistic }}</h1>
                            <p class="text-dark" style="font-size: 20px;">Total Conveyor Logistic</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" >
                    <div class="single_crm text-center">
                        <div class="crm_head d-flex align-items-center justify-content-between" style="background: #536162;">
                            <div class="thumb">
                                <a onclick="detailModal('Details Conveyor Production', '/mrp/'+'dashboard/detail-production', 'x-large')" style="cursor: pointer"> <i class="ti-eye"></i></a>
                                <img src="img/crm/customer.svg" alt="">
                            </div>
                            <i class="fas fa-ellipsis-h f_s_11 white_text"></i>
                        </div>
                        <div class="crm_body">
                            <h1 class="font-weight-bold" id="totalConveyorProduction">{{ $sumconveyorproduction }}</h1>
                            <p class="text-dark" style="font-size: 20px;">Total Conveyor Production </p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="single_crm text-center">
                        <div class="crm_head d-flex align-items-center justify-content-between" style="background: #BD2000;">
                            <div class="thumb">
                                <a onclick="detailModal('Details Sortir Material', '/mrp/'+'dashboard/detail-total_sortir', 'x-large')" style="cursor: pointer"> <i class="ti-eye"></i></a>
                                <img src="img/crm/infographic.svg" alt="">
                            </div>
                            <i class="fas fa-ellipsis-h f_s_11 white_text"></i>
                        </div>
                        <div class="crm_body">
                            <h1 class="font-weight-bold" id="totalSortirMaterial">{{ $sumsortirmaterial }}</h1>
                            <p class="text-dark" style="font-size: 20px;">Total Recheck Material</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="single_crm text-center">
                        <div class="crm_head d-flex align-items-center justify-content-between" style="background: #BD2000;">
                            <div class="thumb">
                                <a onclick="detailModal('Details In Sortir Material', '/mrp/'+'dashboard/detail-total_in', 'x-large')" style="cursor: pointer"> <i class="ti-eye"></i></a>
                                <img src="img/crm/sqr.svg" alt="">
                            </div>
                            <i class="fas fa-ellipsis-h f_s_11 white_text"></i>
                        </div>
                        <div class="crm_body">
                            <h1 class="font-weight-bold" id="totalInSortirMaterial">{{ $suminsortirmaterial }}</h1>
                            <p class="text-dark" style="font-size: 20px;">Total In Recheck Material</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="single_crm text-center">
                        <div class="crm_head d-flex align-items-center justify-content-between" style="background: #BD2000;" >
                            <div class="thumb">
                                <a onclick="detailModal('Details Reject Material', '/mrp/'+'dashboard/detail-total_ng', 'x-large')" style="cursor: pointer"> <i class="ti-eye"></i></a>
                                <img src="img/crm/sqr.svg" alt="">
                            </div>
                            <i class="fas fa-ellipsis-h f_s_11 white_text"></i>
                        </div>
                        <div class="crm_body">
                            <h1 class="font-weight-bold" id="totalRejectMaterial">{{ $sumrejectmaterial }}</h1>
                            <p class="text-dark" style="font-size: 20px;">Total Reject Material</p>
                        </div>
                    </div>
                 </div>
                <div class="col-lg-4">
                    <div class="single_crm text-center">
                        <div class="crm_head d-flex align-items-center justify-content-between" style="background: #FED049;" >
                            <div class="thumb">
                                <a onclick="detailModal('Details Sortir Product', '/mrp/'+'dashboard/detail-total_product', 'x-large')" style="cursor: pointer"> <i class="ti-eye"></i></a>
                                <img src="img/crm/sqr.svg" alt="">
                            </div>
                            <i class="fas fa-ellipsis-h f_s_11 white_text"></i>
                        </div>
                        <div class="crm_body">
                            <h1 class="font-weight-bold" id="totalSortirProduct">{{ $sumsortirproduct }}</h1>
                            <p class="text-dark" style="font-size: 20px;">Total Recheck Product </p>
                        </div>
                    </div>
                 </div>
                <div class="col-lg-4">
                    <div class="single_crm text-center">
                        <div class="crm_head d-flex align-items-center justify-content-between" style="background: #FED049;" >
                            <div class="thumb">
                                <a onclick="detailModal('Details In Sortir Product', '/mrp/'+'dashboard/detail-total-in-product', 'x-large')" style="cursor: pointer" alt="Detail"> <i class="ti-eye"></i></a>
                                <img src="img/crm/sqr.svg" alt="">
                            </div>
                            <i class="fas fa-ellipsis-h f_s_11 white_text"></i>
                        </div>
                        <div class="crm_body">
                            <h1 class="font-weight-bold" id="totalInSortirProduct">{{ $suminsortirproduct }}</h1>
                            <p class="text-dark" style="font-size: 20px;">Total In Recheck Product </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="single_crm text-center">
                        <div class="crm_head d-flex align-items-center justify-content-between" style="background: #FED049;" >
                            <div class="thumb">
                                <a onclick="detailModal('Details Reject Product ', '/mrp/'+'dashboard/detail-total-ng-product', 'x-large')" style="cursor: pointer"> <i class="ti-eye"></i></a>
                                <img src="img/crm/sqr.svg" alt="">
                            </div>
                            <i class="fas fa-ellipsis-h f_s_11 white_text"></i>
                        </div>
                        <div class="crm_body">
                            <h1 class="font-weight-bold" id="totalRejectProduct">{{ $sumrejectproduct }}</h1>
                            <p class="text-dark" style="font-size: 20px;">Total Product Reject  </p>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    <div class="row ">
        <div class="col-xl-12">
            <div class="white_card mb_30 shadow ">
                <div id="main"></div>
                

            </div>
        </div>
    </div>
    {{-- <div class="col-lg-12 ">
        <div class="white_card mb_30 card_height_100">
            <div class="white_card_header">
                <div class="col-12">
                    <form action="{{ route('mrp.dashboard-list') }}" method="post">
                        @csrf
                    <div class="white_card_header">
                        <div class="row align-items-center justify-content-between flex-wrap">
                            <div class="col-lg-4 text-right d-flex justify-content-end ml-auto">
                                <input autocomplete="off"
                                        class="datepicker-here  digits @error('start_date') is-invalid @enderror"
                                        type="text" data-language="en" data-min-view="months" data-view="months"
                                        data-date-format="MM yyyy" name="start_date">
                                    @error('start_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                <button class="button btn-sm btn-primary">SUBMIT</button>
                            </div>
                        </div>
        
                    </div>
                </form>

                    <table class="table table-bordered pl-2 " id="table2">
                        <thead>
                            <th colspan="4">Dashboard Production List </th>
                        </thead>
                        <tbody>
                            <tr>
                                <td width="100%">
                                    <div style="text-align: center;">
                                        <div class="chart-container mg-b-20"
                                            style="position: relative; margin: auto; height:400px; width: 100%;">
                                            <div id="defect_rate_machine" style="width:100%; height:400px;">
                                            </div>
                                        </div>

                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> --}}
    
    <div class="row">
        <div class="col-xl-12">
            <div class="white_card mb_30 shadow pt-4">
                <div class="white_card_header">
                    <div class="row align-items-center justify-content-between flex-wrap">
                        <div class="col-lg-5 ">
                            <div class="main-title">
                            </div>
                        </div>
                        <div class="col-lg-4 text-right d-flex justify-content-end">
                            {{-- <select class="nice_Select2" id="material_choose">
                                <option value="all">All</option>
                                @foreach ($inventory_material as $material)
                                <option value="{{ $material->material_id }}">
                                    {{ $material->material->material_name }} 
                                </option>
                                @endforeach
                            </select>
                            <input autocomplete="off"
                                    class="datepicker-here  digits @error('start_date') is-invalid @enderror"
                                    type="text" data-language="en" data-min-view="months" data-view="months"
                                    data-date-format="MM yyyy" name="start_date" id="date_filter">
                                @error('start_date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            <button class="button btn-sm btn-primary" onclick="filterMaterial()">SUBMIT</button> --}}
                        </div>
                    </div>
                </div>
                <div class="white_card_body">
                    <div class="row">
                         <div class="col-12">
                            <button class="btn-sm btn-success mb-2 float-right" onclick="screenShootMaterial()"><i class="fa fa-download" aria-hidden="true"></i> Download PNG</button>
                            <table class="table table-bordered" id="savePNG1">
                                <thead>
                                    <th colspan="4" >Stock Material - <span  id="choose_mats"></span>  <span id="part_number_material"></span> <span style="float: right;" id="month_material"></span></th>
                                </thead>
    
                                <tbody>
                                    <tr>
                                        
                                        <td width="100%">
                                            {{-- <span class="tags-overview text-center">Stock Material</span> --}}
                                            <div style="text-align: center;">
                                                <div class="chart-container mg-b-20"
                                                    style="position: relative; margin: auto; height:400px; width: 100%;" id="chartContainerMaterial">
                                                    <div id="inventory_material" style="width:100%; height:400px;">
                                                    </div>
                                                </div>
    
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="white_card mb_30 shadow pt-4">
                <div class="white_card_header">
                    <div class="row align-items-center justify-content-between flex-wrap">
                        <div class="col-lg-5 ">
                            <div class="main-title">
                            </div>
                        </div>
                        <div class="col-lg-4 text-right d-flex justify-content-end">
                            {{-- <select class="nice_Select2" id="product_choose">
                                <option value="all">All</option>
                                @foreach ($inventory_product as $product)
                                <option value="{{ $product->product_id }}">
                                    {{ $product->product->part_name }} 
                                </option>
                                @endforeach
                            </select>
                            <input autocomplete="off"
                                    class="datepicker-here  digits @error('start_date') is-invalid @enderror"
                                    type="text" data-language="en" data-min-view="months" data-view="months"
                                    data-date-format="MM yyyy" name="start_date" id="date_filter_product">
                                @error('start_date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            <button class="button btn-sm btn-primary" onclick="filterProduct()">SUBMIT</button> --}}
                        </div>
                    </div>
                </div>
                <div class="white_card_body">
                    <div class="row">
                         <div class="col-12">
                            <button class="btn-sm btn-success mb-2 float-right" onclick="screenShootProduct()"><i class="fa fa-download" aria-hidden="true"></i> Download PNG</button>
                            <table class="table table-bordered" id="savePNG2">
                                <thead>
                                    <th colspan="4" >Stock Product - <span  id="choose_prods"></span>  <span id="part_number_product"></span> <span style="float: right;" id="month_product"></span></th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td width="100%">
                                            {{-- <span class="tags-overview text-center">Stock Material</span> --}}
                                            <div style="text-align: center;">
                                                <div class="chart-container mg-b-20"
                                                    style="position: relative; margin: auto; height:400px; width: 100%;" id="chartContainerProduct">
                                                    <div id="inventory_product" style="width:100%; height:400px;">
                                                    </div>
                                                </div>
    
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        
@endsection

@push('css')
    <!-- datatable CSS -->
    <link rel="stylesheet" href="{{ asset('assets') }}/vendors/datatable/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendors/datatable/css/responsive.dataTables.min.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendors/datatable/css/buttons.dataTables.min.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendors/datepicker/date-picker.css">

@endpush
@push('js')

    <script src="{{ asset('assets') }}/vendors/datatable/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('assets') }}/vendors/datatable/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('assets') }}/vendors/datatable/js/dataTables.buttons.min.js"></script>

    <script src="{{ asset('assets') }}/vendors/echart/echarts.min.js"></script>
    <script src="{{ asset('assets') }}/vendors/apex_chart/apex-chart2.js"></script>
    <script src="{{ asset('assets') }}/vendors/apex_chart/apex_dashboard.js"></script>

    <script src="{{ asset('assets') }}/vendors/datepicker/datepicker.js"></script>
    <script src="{{ asset('assets') }}/vendors/datepicker/datepicker.en.js"></script>
    <script src="{{ asset('assets') }}/vendors/datepicker/datepicker.custom.js"></script>

    <script src="{{asset('assets')}}/vendors/datatable/js/jquery.dataTables.min.js"></script>
<script src="{{asset('assets')}}/vendors/datatable/js/dataTables.responsive.min.js"></script>
<script src="{{asset('assets')}}/vendors/datatable/js/dataTables.buttons.min.js"></script>
<script src="{{asset('assets')}}/vendors/datatable/js/buttons.flash.min.js"></script>
<script src="{{asset('assets')}}/vendors/datatable/js/jszip.min.js"></script>
<script src="{{asset('assets')}}/vendors/datatable/js/pdfmake.min.js"></script>
<script src="{{asset('assets')}}/vendors/datatable/js/vfs_fonts.js"></script>
<script src="{{asset('assets')}}/vendors/datatable/js/buttons.html5.min.js"></script>
<script src="{{asset('assets')}}/vendors/datatable/js/buttons.print.min.js"></script>
<script src="{{asset('assets')}}/js/html2canvas.js"></script>
<script src="{{asset('assets')}}/js/fileSaver.js"></script>
    {{-- SEARCH --}}
    {{-- production --}}
    


<script>
    function screenShootMaterial() {
        html2canvas($("#savePNG1"), {
                onrendered: function (canvas) {
                    theCanvas = canvas;


                    canvas.toBlob(function (blob) {
                        saveAs(blob, "Stock-Material.png");
                    });
                }
            });
    }

    function screenShootProduct() {
        html2canvas($("#savePNG2"), {
                onrendered: function (canvas) {
                    theCanvas = canvas;


                    canvas.toBlob(function (blob) {
                        saveAs(blob, "Stock-Product.png");
                    });
                }
            });
    }
</script>

{{-- material --}}
<script>
    
    $(window).on('resize', function () {
        if (chart != null && chart != undefined) {
            chart.resize();
        }
        // console.log('Berubah');
    });


        // generateChart('production_output_machine_' + index)
        generateChartMaterial('inventory_material', @json($date), @json($stock_in_material), @json($stock_out_material), @json($diff_stock_material), @json($target_material), @json($target_material_max), @json($target_material_min))
        // resizeChart('production_output_machine_' + index)
        resizeChart('inventory_material')

    function filterMaterial() {

        material = $('#material_choose').val()
        part_number = $('#part_number').val()
        date = $('#date_filter').val()
        
        $.ajax({
            url:"/mrp/dashboard/filter-material",
            type:"GET",
            data: {
                "_token": "{{ csrf_token() }}",
                material,
                date
            },
            success:function (data) {
                    $('#choose_mats').text(data.material_choose);
                    $('#part_number_material').text(data.part_number);
                    $('#month_material').text(data.month_material);
                    console.log(data);
                    generateChartMaterial('inventory_material', data.date, data.stock_in_material, data.stock_out_material, data.diff_stock_material, data.target_material,data.target_material_max, data.target_material_min)

				}
			})

       
    }


       
    

    function generateChartMaterial(id, date, stockInMaterial, stockOutMaterial, diffStockMaterial, targetMaterial, targetMax, targetMin) {
        $("#inventory_material").remove();

        $('#chartContainerMaterial').append('<div id="inventory_material" style="width:100%; height:400px;"></div>');

        // console.log(id, date, stockInMaterial, stockOutMaterial, diffStockMaterial, targetMaterial, targetMax, targetMin);

        var chartDom = document.getElementById(id);
        var myChart = echarts.init(chartDom);
        var option;
        option = {
            responsive: true,
            maintainAspectRatio: false,
            tooltip: {
                trigger: 'axis',
                axisPointer: {
                    type: 'cross',
                    crossStyle: {
                        color: '#999'
                    }
                }
            },
            toolbox: {
                feature: {
                    dataView: {
                        show: false,
                        readOnly: false
                    },
                    magicType: {
                        show: true,
                        type: ['line', 'bar']
                    },
                    restore: {
                        show: true
                    },
                    saveAsImage: {
                        show: false
                    }
                }
            },
            legend: {
                data: ['Tanggal','Stock In', 'Stock Out','Ending Stock', 'Actual Stock (Day)', 'Target Min', 'Target Max']
            },
            xAxis: [{
                type: 'category',
                data: date,
                axisPointer: {
                    type: 'shadow'
                }
            }],
            yAxis: [
                {
                    type: 'value',
                    name: '',
                    min: 0,
                    axisLabel: {
                        formatter: '{value} pcs'
                    }
                },
                {
                    type: 'value',
                    name: 'Target',
                    min: 0,
                    max: function (value) {
                        return Math.ceil(Number(value.max) *1);
                    },
                    // interval: 100,
                    axisLabel: {
                        formatter: '{value} Day'
                    },
                }
            ],
            // color : ['#4908B6','#F78642','#A2D3C6','blue'],
            series: [
                // SETPOINT
                {
                    name: 'TargetMax',
                    type: 'bar',
                    show:false,
                    yAxisIndex:1,
                    itemStyle: {
                        color: '#1F2227'
                    },
                    markLine : {
                        symbol:['circle','pin'],
                        label :{
                            show:true,
                            position:'start'
                        },
                        data:[
                            {
                                show:true,
                                yAxis:targetMax,
                                lineStyle : {
                                    type : 'solid'
                                }
                            }
                        ]
                    }
                },
                {
                    name: 'TargetMin',
                    type: 'bar',
                    show:false,
                    yAxisIndex:1,
                    itemStyle: {
                        color: 'red'
                    },
                    markLine : {
                        symbol:['circle','none'],
                        label :{
                            show:true,
                            position:'start'
                        },
                        data:[
                            {
                                show:true,
                                yAxis:targetMin,
                                lineStyle : {
                                    type : 'solid'
                                }
                            }
                        ]
                    }
                },
                // SETPOINT

                {
                    name: 'Stock In',
                    type: 'bar',
                    data: stockInMaterial,
                    yAxisIndex:0,
                    itemStyle: {
                        color: '#28a745'
                    },
                     
                },
                
                {
                    name: 'Stock Out',
                    type: 'bar',
                    data: stockOutMaterial,
                    yAxisIndex:0,
                    itemStyle: {
                        color: '#dc3545'
                    }
                },
                

                {
                    name: 'Ending Stock',
                    type: 'bar',
                    data: diffStockMaterial,
                    yAxisIndex:0,
                    itemStyle: {
                        color: '#884FFB'
                    }
                },
                {
                    name: 'Actual Stock (Day)',
                    type: 'line',
                    data: targetMaterial,
                    yAxisIndex:1,
                    label: {
                        fontSize: 12,
                        color: 'black',
                        show: true,
                        // position : 'top'
                    },
                    itemStyle: {
                        color: 'blue'
                    },
                   
                }
                
                
            ]
        };

        option && myChart.setOption(option);
    }

    function resizeChart(divId) {
        var chart = echarts.init(document.getElementById(divId));
        new ResizeSensor(jQuery('#' + divId), function () {
            chart.resize();
        })
    }

</script>



{{-- product --}}
<script>
    $(window).on('resize', function () {
        if (chart != null && chart != undefined) {
            chart.resize();
        }
        // console.log('Berubah');
    });


        // generateChart('production_output_machine_' + index)
        generateChartProduct('inventory_product', @json($date), @json($stock_in_product), @json($stock_out_product), @json($diff_stock_product), @json($target_product), @json($target_product_min), @json($target_product_max))
        // resizeChart('production_output_machine_' + index)
        resizeChart('inventory_product')

        function filter() {
            filterProduct();
            filterMaterial();
            filterCard();
            filterCardProduct();
        }

    function filterProduct() {

        product = $('#product_choose').val()
        part_number = $('#part_number').val()
        date = $('#date_filter').val()

        $.ajax({
				url:"/mrp/dashboard/filter-product",
				type:"GET",
				data: {
					"_token": "{{ csrf_token() }}",
					product,
                    date
				},
				success:function (data) {
                    $('#choose_prods').text(data.product_choose);
                    $('#part_number_product').text(data.part_number);
                    $('#month_product').text(data.month_product);

                    // console.log(data);
                    generateChartProduct('inventory_product', data.date, data.stock_in_product, data.stock_out_product, data.diff_stock_product, data.target_product, data.target_product_min, data.target_product_max)

				}
			})

       
    }


       
    

    function generateChartProduct(id, date, stockInProduct, stockOutProduct, diffStockProduct, targetProduct, targetMin, targetMax) {
        $("#inventory_product").remove();

        $('#chartContainerProduct').append('<div id="inventory_product" style="width:100%; height:400px;"></div>');

        // console.log(id, date, stockInProduct, stockOutProduct, diffStockProduct, targetProduct, targetMin, targetMax);

        var chartDom = document.getElementById(id);
        var myChart = echarts.init(chartDom);
        var option;
        option = {
            responsive: true,
            maintainAspectRatio: false,
            tooltip: {
                trigger: 'axis',
                axisPointer: {
                    type: 'cross',
                    crossStyle: {
                        color: '#999'
                    }
                }
            },
            toolbox: {
                feature: {
                    dataView: {
                        show: false,
                        readOnly: false
                    },
                    magicType: {
                        show: true,
                        type: ['line', 'bar']
                    },
                    restore: {
                        show: true
                    },
                    saveAsImage: {
                        show: false
                    }
                }
            },
            legend: {
                data: ['Stock In', 'Stock Out','Ending Stock', 'Target Day', 'Target Min', 'Target Max']
            },
            xAxis: [{
                type: 'category',
                data: date,
                axisPointer: {
                    type: 'shadow'
                }
            }],
            yAxis: [
                {
                    type: 'value',
                    name: '',
                    min: 0,
                    axisLabel: {
                        formatter: '{value} pcs'
                    }
                },
                {
                    type: 'value',
                    name: 'Target Ratio',
                    min: 0,
                    max: function (value) {
                        return Math.ceil(Number(value.max) *1.5);
                    },
                    axisLabel: {
                        formatter: '{value} Day'
                    }
                },
            ],
            // color : ['#4908B6','#F78642','#A2D3C6'],
            series: [
                // SETPOINT
                {
                    name: 'TargetMax',
                    type: 'bar',
                    show:false,
                    yAxisIndex:1,
                    itemStyle: {
                        color: '#1F2227'
                    },
                    markLine : {
                        symbol:['circle','pin'],
                        label :{
                            show:true,
                            position:'end'
                        },
                        data:[
                            {
                                show:true,
                                yAxis:targetMax,
                                lineStyle : {
                                    type : 'solid'
                                }
                            }
                        ]
                    }
                },
                {
                    name: 'TargetMin',
                    type: 'bar',
                    show:false,
                    yAxisIndex:1,
                    itemStyle: {
                        color: 'red'
                    },
                    markLine : {
                        symbol:['circle','none'],
                        label :{
                            show:true,
                            position:'end'
                        },
                        data:[
                            {
                                show:true,
                                yAxis:targetMin,
                                lineStyle : {
                                    type : 'end'
                                }
                            }
                        ]
                    }
                },
                // SETPOINT
                
                {
                    name: 'Stock In',
                    type: 'bar',
                    data: stockInProduct,
                    itemStyle: {
                        color: '#28a745'
                    }
                },
                
                {
                    name: 'Stock Out',
                    type: 'bar',
                    data: stockOutProduct,
                    itemStyle: {
                        color: '#dc3545'
                    }
                },
                

                {
                    name: 'Ending Stock',
                    type: 'bar',
                    data: diffStockProduct,
                    itemStyle: {
                        color: '#884FFB'
                    }
                },

                {
                    name: 'Target Day',
                    type: 'line',
                    data: targetProduct,
                    yAxisIndex: 1,
                    label: {
                        fontSize: 12,
                        color: 'black',
                        show: true,
                        // position : 'top'
                    },
                    itemStyle: {
                        color: '#884FFB'
                    }
                }
                
                
            ]
        };

        option && myChart.setOption(option);
    }

    function resizeChart(divId) {
        var chart = echarts.init(document.getElementById(divId));
        new ResizeSensor(jQuery('#' + divId), function () {
            chart.resize();
        })
    }



</script>

@endpush
