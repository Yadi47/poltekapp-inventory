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
        color: #ffffff;
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

    .diff-colomn {
        border: 1px #DEE2E6 solid;
        padding: 3px 10px;
        font-weight: 800;
        font-size: 12px;
        width: 12.5%;
    }

    td {
        border: 1px solid #ddd;
        padding: 8px;
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
    });

    for (let index = 0; index < 16; index++) {
        generateDefectRateChart('defect_rate_machine_' + index)
    }



    function generateDefectRateChart(divId) {
        var chartDom = document.getElementById(divId);
        var myChart = echarts.init(chartDom);
        var option;

        option = {
            tooltip: {
                trigger: 'axis',
                axisPointer: { // Use axis to trigger tooltip
                    type: 'line' // 'shadow' as default; can also be 'line' or 'shadow'
                }
            },
            legend: {
                data: ['S1','S2'],
                textStyle: {
                    color: "#ffffff"
                }
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            xAxis: {
                type: 'category',
                max: function (value) {
                    return value.max + 0.05;
                },
                axisLabel: {
                    color: '#ffffff'
                },
                data: [1, 2, 3, 4, 5, 6, 7, 8, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26,
                    27, 28, 29, 30
                ],

                splitLine: {
                    show: true,
                    onGap: null,
                    // Garis Pebatas
                    lineStyle: {
                        color: 'rgba(245, 245, 245, 0.10)',
                        type: 'solid',
                        width: 1,
                        shadowColor: 'rgba(245, 245, 245, 0.10)',
                        shadowBlur: 5,
                        shadowOffsetX: 3,
                        shadowOffsetY: 3,
                    },

                },
            },
            yAxis: {
                axisLabel: {
                    color: "#ffffff"
                },
                type: 'value',
                data: ['Actual'],
                splitLine: {
                    show: true,
                    onGap: null,
                    // Garis Pebatas
                    lineStyle: {
                        color: 'rgba(245, 245, 245, 0.10)',
                        type: 'solid',
                        width: 1,
                        shadowColor: 'rgba(245, 245, 245, 0.10)',
                        shadowBlur: 5,
                        shadowOffsetX: 3,
                        shadowOffsetY: 3,
                    },

                },
            },
            series: [{
                name: 'S1',
                type: 'bar',
                // barWidth: 30,
                label: {
                    show: true
                },
                emphasis: {
                    focus: 'series'
                },
                data: [9, 2, 3, 4, 5, 6, 7, 8, 10, 8, 10, 13, 14, 15, 5, 17, 8, 19, 20, 11, 14, 8, 7,
                    8, 6, 10, 18, 15, 13
                ],
                itemStyle: {
                    color: '#F89C15'
                },
            },
            {
                name: 'S2',
                type: 'bar',
                // barWidth: 30,
                label: {
                    show: true
                },
                emphasis: {
                    focus: 'series'
                },
                data: [9, 2, 3, 4, 5, 6, 7, 8, 10, 8, 10, 13, 14, 15, 5, 17, 8, 19, 20, 11, 14, 8, 7,
                    8, 6, 10, 18, 15, 13
                ],
                itemStyle: {
                    color: '#27968D'
                },
                markLine: {
                    symbol: 'none',
                    data: [{
                        xAxis: 0.1,
                        label: {
                            fontSize: 12,
                            color: '#FFFFFF',
                            formatter: function (d) {
                                return 'Target ' + d.value + '%';
                            }
                        },

                        lineStyle: {
                            normal: {
                                type: 'solid',
                                color: '#AF324F',
                            }
                        },
                    }],
                }
            },
            {
                name: 'Plan',
                type: 'line',
                // barWidth: 30,
                label: {
                    show: true
                },
                emphasis: {
                    focus: 'series'
                },
                data: [9, 2, 3, 4, 5, 6, 7, 8, 10, 8, 10, 13, 14, 15, 5, 17, 8, 19, 20, 11, 14, 8, 7,
                    8, 6, 10, 18, 15, 13
                ],
                itemStyle: {
                    color: 'red'
                },
                markLine: {
                    symbol: 'none',
                    data: [{
                        xAxis: 0.1,
                        label: {
                            fontSize: 12,
                            color: '#FFFFFF',
                            formatter: function (d) {
                                return 'Target ' + d.value + '%';
                            }
                        },

                        lineStyle: {
                            normal: {
                                type: 'solid',
                                color: '#AF324F',
                            }
                        },
                    }],
                }
            }]
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
                        <table class="table " style="background: #1A293E;color:white;border-radius:20px">
                            <thead>
                                <th colspan="4">Machine {{$i}}</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td width="100%">
                                        <span class="tags-overview text-center"></span>
                                        <div style="text-align: center;">
                                            <div class="chart-container mg-b-20"
                                                style="position: relative; margin: auto; height:350px; width: 100%;">
                                                <div id="defect_rate_machine_{{$i}}" style="width:100%; height:350px;">
                                                </div>
                                            </div>
                                        </div>
                                        <div style="width:100%;text-align:right">
                                            <span class="diff-colomn" style="margin-right:-4px">DIFF</span>
                                            <span class="diff-colomn">-5</span>
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
