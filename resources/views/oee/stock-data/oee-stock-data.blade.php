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

</style>
@endpush
@push('js')
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/5.0.1/echarts.min.js"></script> --}}
<script src="{{asset('assets')}}/vendors/echart/echarts.min.js"></script>
<script src="{{asset('assets')}}/vendors/echart/ResizeSensor.js"></script>
<script>
    $(window).on('resize', function () {
        if (chart != null && chart != undefined) {
            chart.resize();
        }
        console.log('Berubah');
    });

    for (let index = 0; index < 16; index++) {

        generateChart('production_output_machine_' + index)
        generateChart('defect_rate_machine_' + index)
        resizeChart('production_output_machine_' + index)
        resizeChart('defect_rate_machine_' + index)
    }

    function generateChart(id) {
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
                        show: true,
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
                        show: true
                    }
                }
            },
            legend: {
                data: ['Plan', 'Actual', 'Diff']
            },
            xAxis: [{
                type: 'category',
                data: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
                axisPointer: {
                    type: 'shadow'
                }
            }],
            yAxis: [
                {
                    type: 'value',
                    name: '',
                    min: 0,
                    max: 250,
                    interval: 50,
                    axisLabel: {
                        formatter: '{value} pcs'
                    }
                },
            ],
            // color : ['#4908B6','#F78642','#A2D3C6'],
            series: [
                {
                    name: 'Plan',
                    type: 'bar',
                    data: [2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3],
                    itemStyle: {
                        color: '#4908B6'
                    }
                },
                {
                    name: 'Plan',
                    type: 'line',
                    data: [2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3],
                    itemStyle: {
                        color: '#B45C62'
                    }
                },
                {
                    name: 'Actual',
                    type: 'bar',
                    data: [2.6, 5.9, 9.0, 26.4, 28.7, 70.7, 175.6, 182.2, 48.7, 18.8, 6.0, 2.3],
                    itemStyle: {
                        color: '#F78642'
                    }
                },
                {
                    name: 'Diff',
                    type: 'bar',
                    data: [2.0, 2.2, 3.3, 4.5, 6.3, 10.2, 20.3, 23.4, 23.0, 16.5, 12.0, 6.2],
                    itemStyle: {
                        color: '#A2D3C6'
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
@section('content')
<div class="row ">
    <div class="col-xl-12">
        <div class="white_card mb_30 shadow ">
            <div id="main"></div>

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

                    @for ($i = 0; $i < 16; $i++) <div class="col-12">
                        <table class="table table-bordered">
                            <thead>
                                <th colspan="4">Machine {{$i}}</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td width="50%">
                                        <span class="tags-overview text-center">Stock FG</span>
                                        <div style="text-align: center;">
                                            <div class="chart-container mg-b-20"
                                                style="position: relative; margin: auto; height:400px; width: 100%;">
                                                <div id="production_output_machine_{{$i}}"
                                                    style="width:100%; height:400px;"></div>
                                            </div>

                                        </div>
                                    </td>
                                    <td width="50%">
                                        <span class="tags-overview text-center">Stock Material</span>
                                        <div style="text-align: center;">
                                            <div class="chart-container mg-b-20"
                                                style="position: relative; margin: auto; height:400px; width: 100%;">
                                                <div id="defect_rate_machine_{{$i}}" style="width:100%; height:400px;">
                                                </div>
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
