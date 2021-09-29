@extends('oee')

@section('title', $page_title)

@push('css')
<style>
    .chart {
        position: relative;
        display: inline-block;
        width: 150px;
        height: 150px;
        margin-top: 20px;
        text-align: center;
    }

    .chart canvas {
        position: absolute;
        top: 0;
        left: 0;
    }

    .percent {
        display: inline-block;
        line-height: 150px;
        z-index: 2;
        font-weight: 600;
        font-size: 30px;
        color: #645C5C !important;
    }

    .percent-simbol {
        display: inline-block;
        line-height: 150px;
        z-index: 2;
        font-weight: 600;
        font-size: 30px;
    }

    .tags-overview {
        color: #645c5c;
        /* font-weight: bold; */
        font-weight: bolder;
    }


    /* NEW */

    .card__one {
        transition: transform .5s;


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

  
    .progress-group {

        text-align: left;

    }

    .progress,
    .progress>.progress-bar,
    .progress .progress-bar,
    .progress>.progress-bar .progress-bar {

        border-radius: 14px !important;

        /*background: #E288A2 !important;*/

    }

    .progress {
        height: 10px !important;
        background-color: #00bdaf1c;
    }

    .a {
        background-color: #319ec92e;
    }

    .p {
        background-color: #f292001f;
    }

    .q {
        background-color: #94c12024;
    }



    .progress-bar-light-blue,
    .progress-bar-a {
        background-color: #319EC9 !important;

    }

    .progress-bar-p {
        background-color: #F29200 !important;

    }

    .progress-bar-q {
        background-color: #94C120 !important;

    }

    .tags-overview {

        color: #645c5c;

        /*font-weight:bold;*/

    }



    .tags-percent-a {
        color: #645C5C;
        font-weight: bold;
    }

    .tags-percent-p {
        color: #645C5C;
        font-weight: bold;
    }

    .tags-percent-q {
        color: #645C5C;
        font-weight: bold;
    }

</style>
@endpush
@push('js')
<script src="{{asset('assets')}}/js/jquery.easypiechart.min.js"></script>
<script src="{{asset('assets')}}/vendors/apex_chart/apex-chart2.js"></script>
<script>
    // Apex Chart
    /* -------------------------------------------------------------------------- */
    /*                                     chart                                    */
    /* -------------------------------------------------------------------------- */
    options = {
        chart: {
            height: 200,
            type: "line",
            stacked: !1,
            toolbar: {
                show: !1
            },
                theme: "candy",

        },
        stroke: {
            width: [5, 5, 3],
            // curve: "smooth"
        },
        plotOptions: {
            bar: {
                // columnWidth: "30%"
            }
        },
        colors: ["#4908B6", "#F78642", "#A2D3C6"],
        series: [{
                name: "Plan",
                type: "bar",
                data: [23, 11, 22, 27, 13, 22, 37, 21, 44, 22, 30]
            },
            {
                name: "Actual",
                type: "column",
                data: [44, 55, 41, 67, 22, 43, 21, 41, 56, 27, 43]
            },
            {
                name: "Diff",
                type: "column",
                data: [30, 25, 36, 30, 45, 35, 64, 52, 59, 36, -20]
            },
        ],
        fill: {
            // opacity: [0.85, 0.25, 1],
            // gradient: {
            //     inverseColors: !1,
            //     shade: "light",
            //     type: "vertical",
            //     opacityFrom: 0.85,
            //     opacityTo: 0.55,
            //     stops: [0, 100, 100, 100]
            // }
        },
        labels: ["01/01/2003", "02/01/2003", "03/01/2003", "04/01/2003", "05/01/2003", "06/01/2003", "07/01/2003",
            "08/01/2003", "09/01/2003", "10/01/2003", "11/01/2003"
        ],
        markers: {
            size: 0
        },
        xaxis: {
            type: "datetime"
        },
        yaxis: {
            // title: {
            //     text: "Points"
            // }
        },
        tooltip: {
            shared: !0,
            intersect: !1,
            y: {
                formatter: function (e) {
                    return void 0 !== e ? e.toFixed(0) + " points" : e;
                },
            },
        },
        grid: {
            // borderColor: "#f1f1f1"
        },
    };

    function generateChart(indexId){
        (chart = new ApexCharts(document.querySelector("#production_output_machine_"+indexId ), options)).render();
        (chart = new ApexCharts(document.querySelector("#defect_rate_machine_"+indexId ), options)).render();
        (chart = new ApexCharts(document.querySelector("#efficiency_machine_"+indexId ), options)).render();
    }

    for (let index = 0; index < 2; index++) {
        generateChart(index)
    }
    

</script>
@endpush
@section('content')
<div class="row ">
    <div class="col-xl-12">
        <div class="white_card mb_30 shadow ">
            <div class="white_card_header">
                <div class="row align-items-center justify-content-between flex-wrap">
                    <div class="col-lg-4 ">
                        <div class="main-title">
                            <h3 class="m-0">{{$page_title}}</h3>
                        </div>
                    </div>
                    <div class="col-lg-4 text-right d-flex justify-content-end">
                        
                        <select class="nice_Select2 max-width-220">
                            <option value="1">Realtime</option>
                            <option value="1">Daily</option>
                            <option value="1">Monthly</option>
                        </select>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="white_card mb_30 shadow pt-4">
            <div class="white_card_body">
                <div class="row">

                    @for ($i = 0; $i < 2; $i++) <div class="col-12">
                        <table class="table table-bordered">
                            <thead>
                                <th colspan="4">Machine 1</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td width="30%">
                                        <span class="tags-overview text-center">Production Output</span>
                                        <div style="text-align: center;">
                                            <div class="mg-b-20" data-percent="">
                                                <div id="production_output_machine_{{$i}}"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td width="30%">
                                        <span class="tags-overview text-center">Defect Rate</span>
                                        <div style="text-align: center;">
                                            <div class="mg-b-20"
                                                data-percent="">
                                                <div id="defect_rate_machine_{{$i}}"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td width="30%">
                                        <span class="tags-overview text-center">Efficiency</span>
                                        <div style="text-align: center;">
                                            <div class="mg-b-20"
                                                data-percent="">
                                                <div id="efficiency_machine_{{$i}}"></div>

                                            </div>
                                        </div>
                                    </td>

                                </tr>
                            </tbody>
                        </table>
                </div>
                @endfor
            </div>
        </div>
    </div>
</div>




@endsection
