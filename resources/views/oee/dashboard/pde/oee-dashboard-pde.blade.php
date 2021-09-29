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
        /* color: #ffffff; */
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

    .table td {
        border: 1px solid #ddd;
        padding: 8px;
    }

    .square-10 {
        right: 2.5rem;
        top: 0.8rem;
        position: absolute;
        border-radius: 100%;
        border: 2px solid #fff;
        width: 15px;
        height: 15px;
        border-radius: 50%;
    }

</style>
@endpush
@push('js')
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/5.0.1/echarts.min.js"></script> --}}
<script src="{{asset('assets')}}/vendors/echart/echarts.min.js"></script>
<script src="{{asset('assets')}}/vendors/echart/ResizeSensor.js"></script>
<script src="{{asset('assets')}}/vendors/dom-to-image.min.js"></script>
<script>
    $(window).on('resize', function () {
        if (chart != null && chart != undefined) {
            chart.resize();
        }
    });


    socket.on('toClientRealtimeValuesResults', (data) => {
        oee_machines.forEach(machine => {
            if (typeof data != 'string') {
                data.forEach(d => {
                    if (d.TagGroupName === machine.name) {
                        //    console.log(machine);
                        let quality = getQuality(getValue("ProductionQuantity", d.values),
                            getValue(
                                "PassQuantity", d.values), getValue("FailQuantity", d
                                .values))
                        let performance = getPerformance(getValue("ProductionQuantity", d
                                .values,machine.cycle_time),
                            getValue("RunningTimeSecond", d.values), 1)
                        let availability = getAvailability(480, getValue("AbnormalyTimeSecond",
                            d
                            .values) / 60);
                        let oee = ((quality / 100) * (performance / 100) * (availability /
                                100)) *
                            100;

                        if (isNaN(oee)) {
                            $('.machine-' + machine.name).html(
                                `<span class="square-10 bg-danger"></span>`)
                        } else {
                            $('.machine-' + machine.name).html(
                                `<span class="square-10 bg-success"></span>`)
                        }

                        $('#diff-product-output-' + machine.name).text(getValue("PassQuantity",
                            d
                            .values) - fix_val((getValue("RunningTimeSecond", d
                                .values) /
                            machine.cycle_time), 0));
                        
                            if ($('#diff-product-output-' + machine.name).text() < 0) {
                                $('#diff-product-output-' + machine.name).addClass('text-danger')
                            }else if ($('#diff-product-output-' + machine.name).text() > 0){
                                $('#diff-product-output-' + machine.name).addClass('text-success')
                            }

                        $('#diff-defect-rate-' + machine.name).text(fix_val((getRejectPercent(
                                getValue("ProductionQuantity", d.values), getValue(
                                    "FailQuantity", d.values)) - machine.target_defect_rate)* -1 ,
                            2));

                            if ($('#diff-defect-rate-' + machine.name).text() < 0) {
                                $('#diff-defect-rate-' + machine.name).addClass('text-danger')
                            }else if ($('#diff-defect-rate-' + machine.name).text() > 0){
                                $('#diff-defect-rate-' + machine.name).addClass('text-success')
                            }

                        $('#diff-efficiency-' + machine.name).text(fix_val((getValue(
                                "PassQuantity",
                                d.values) / getValue("ProductionQuantity", d
                                .values)) *
                            100 - machine.target_effeciency, 1));

                            if ($('#diff-efficiency-' + machine.name).text() < 0) {
                                $('#diff-efficiency-' + machine.name).addClass('text-danger')
                            }else if ($('#diff-efficiency-' + machine.name).text() > 0){
                                $('#diff-efficiency-' + machine.name).addClass('text-success')
                            }

                        generateProductOutputChart('product_output_machine_' + machine.name,
                            getValue("PassQuantity", d.values), fix_val((getValue(
                                "RunningTimeSecond", d.values) / machine.cycle_time), 0))
                        generateDefectRateChart('defect_rate_machine_' + machine.name, fix_val(
                                getRejectPercent(getValue("ProductionQuantity", d.values),
                                    getValue("FailQuantity", d.values)), 2), machine
                            .target_defect_rate)
                        generateEfficiencyChart('efficiency_machine_' + machine.name, fix_val((
                                getValue("PassQuantity", d.values) / getValue(
                                    "ProductionQuantity", d.values)) * 100, 1), machine
                            .target_effeciency)
                    }
                });
            }
        });

        // console.log(data)
    })

    function generateProductOutputChart(divId, actualValue, setPoint) {
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
                show: false,
                data: ['Actual'],
                textStyle: {
                    // color: "#ffffff"
                },
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            xAxis: {
                type: 'value',
                max: function (value) {
                    return value.max + (setPoint * 1.2);
                },
                axisLabel: {
                    fontSize: 13,
                    // color: '#ffffff'
                },

                splitLine: {
                    show: true,
                    onGap: null,
                    // Garis Pebatas
                    lineStyle: {
                        color: 'black',
                        // type: 'solid',
                        width: 1,
                        // shadowColor: 'rgba(245, 245, 245, 0.10)',
                        // shadowBlur: 5,
                        // shadowOffsetX: 3,
                        // shadowOffsetY: 3,
                    },

                },
            },
            yAxis: {
                axisLabel: {
                    fontSize: 15,
                    // color: "#ffffff"
                },
                type: 'category',
                data: ['Actual'],
                splitLine: {
                    show: true,
                    onGap: null,
                    // Garis Pebatas
                    lineStyle: {
                        color: 'black',
                        // type: 'solid',
                        width: 1,
                        // shadowColor: 'rgba(245, 245, 245, 0.10)',
                        // shadowBlur: 5,
                        // shadowOffsetX: 3,
                        // shadowOffsetY: 3,
                    },

                },
            },
            series: [{
                name: 'Actual',
                type: 'bar',
                barWidth: 30,
                label: {
                    fontSize: 13,
                    show: true
                },
                emphasis: {
                    focus: 'series'
                },
                data: [actualValue],
                itemStyle: {
                    color: '#8DC94D'
                },
                markLine: {
                    symbol: 'none',
                    data: [{
                        xAxis: setPoint,
                        label: {
                            fontSize: 14,
                            // color: '#FFFFFF',
                            formatter: function (d) {
                                return 'Target ' + d.value;
                            }
                        },
                        lineStyle: {
                            type: 'solid',
                            width: '3',
                            color: '#AF324F',
                        },
                    }],
                }
            }]
        };
        option && myChart.setOption(option);
    }


    function generateDefectRateChart(divId, actualValue, setPoint) {
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
                show: false,

                data: ['Actual'],
                textStyle: {
                    // color: "#ffffff"
                }
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            xAxis: {
                type: 'value',
                max: function (value) {
                    return value.max + (setPoint * 1.2);
                },
                axisLabel: {
                    fontSize: 13,
                    // color: '#ffffff'
                },

                splitLine: {
                    show: true,
                    onGap: null,
                    // Garis Pebatas
                    lineStyle: {
                        color: 'black',
                        // type: 'solid',
                        width: 1,
                        // shadowColor: 'rgba(245, 245, 245, 0.10)',
                        // shadowBlur: 5,
                        // shadowOffsetX: 3,
                        // shadowOffsetY: 3,
                    },

                },
            },
            yAxis: {
                axisLabel: {
                    fontSize: 15,
                    // color: "#ffffff"
                },
                type: 'category',
                data: ['Actual'],
                splitLine: {
                    show: true,
                    onGap: null,
                    // Garis Pebatas
                    lineStyle: {
                        color: 'black',
                        // type: 'solid',
                        width: 1,
                        // shadowColor: 'rgba(245, 245, 245, 0.10)',
                        // shadowBlur: 5,
                        // shadowOffsetX: 3,
                        // shadowOffsetY: 3,
                    },

                },
            },
            series: [{
                name: 'Actual',
                type: 'bar',
                barWidth: 30,
                label: {
                    fontSize: 14,
                    show: true
                },
                emphasis: {
                    focus: 'series'
                },
                data: [actualValue],
                itemStyle: {
                    color: '#AF324F'
                },
                markLine: {
                    symbol: 'none',
                    data: [{
                        xAxis: setPoint,
                        label: {
                            fontSize: 14,
                            // color: '#FFFFFF',
                            formatter: function (d) {
                                return 'Target ' + d.value + '%';
                            }
                        },
                        lineStyle: {
                            type: 'solid',
                            width: '3',
                            color: '#AF324F',
                        },
                    }],
                }
            }]
        };

        option && myChart.setOption(option);

    }

    function generateEfficiencyChart(divId, actualValue, setPoint) {
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
                show: false,

                data: ['Actual'],
                textStyle: {
                    // color: "#ffffff"
                }
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            xAxis: {
                type: 'value',
                axisLabel: {
                    fontSize: 13,
                    // color: '#ffffff'
                },
                max: function (value) {
                    return 100;
                },
                splitLine: {
                    show: true,
                    onGap: null,
                    // Garis Pebatas
                    lineStyle: {
                        color: 'black',
                        // type: 'solid',
                        width: 1,
                        // shadowColor: 'rgba(245, 245, 245, 0.10)',
                        // shadowBlur: 5,
                        // shadowOffsetX: 3,
                        // shadowOffsetY: 3,
                    },

                },
            },
            yAxis: {
                axisLabel: {
                    fontSize: 15,
                    // color: "#ffffff"
                },
                type: 'category',
                data: ['Actual'],
                splitLine: {
                    show: true,
                    onGap: null,
                    // Garis Pebatas
                    lineStyle: {
                        color: 'black',
                        // type: 'solid',
                        width: 1,
                        // shadowColor: 'rgba(245, 245, 245, 0.10)',
                        // shadowBlur: 5,
                        // shadowOffsetX: 3,
                        // shadowOffsetY: 3,
                    },

                },
            },   
            series: [{
                name: 'Actual',
                type: 'bar',
                barWidth: 30,
                label: {
                    fontSize: 14,
                    show: true
                },
                emphasis: {
                    focus: 'series'
                },
                data: [actualValue],
                itemStyle: {
                    color: '#F7C700'
                },
                markLine: {
                    symbol: 'none',
                    nameGap: 50,
                    data: [{
                        xAxis: setPoint,
                        label: {
                            fontSize: 14,
                            // color: '#FFFFFF',
                            formatter: function (d) {
                                return 'Target ' + d.value + '%';
                            },
                            padding: [0, 60, 0, 0],
                        },
                        lineStyle: {
                            type: 'solid',
                            width: '3',
                            color: '#AF324F',
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

    function downloadImage(el, name) {
        domtoimage.toBlob(document.getElementById(el))
            .then(function (blob) {
                window.saveAs(blob, name + '.png');
            });
    }

</script>
@endpush
@section('content')

<div class="row" style="margin-left: -1rem; margin-right:0;">
    <div class="col-12">
        <div class="white_card mb_30 shadow pt-4">
            <div class="white_card_body" style="border-radius: 0;">
                <div class="row">
                    @foreach ($oee_machines as $machine)
                    <div class="col-12" id="machine-scroll-{{ $machine->name }}">
                        <table class="table">
                            <thead>
                                <!-- <button data-toggle="tooltip" title="save images" class="btn btn-sm btn-info right" onclick="downloadImage('','s')" type="button">
                                        <i class="fa fa-floppy-o tx-20"></i>
                                    </button> -->
                                <div class="machine-{{$machine->name}}"></div>
                                <!-- <th colspan="4">{{$machine->ident}}</th> -->
                            </thead>
                            <tbody>
                                <tr>
                                    <td width="30%">
                                        <p class=" font-weight-bold" style="font-size:16px; color: #38A3A5;">REALTIME-<span style="font-size: 18px; color:red;">{{$machine->ident}}</span></p>
                                        <span class="tags-overview text-center">PRODUCTION OUTPUT
                                            (pcs)</span>
                                        <div style="text-align: center;">
                                            <div class="chart-container mg-b-20"
                                                style="position: relative; margin: auto; height:200px; width: 100%;">
                                                <div id="product_output_machine_{{$machine->name}}"
                                                    style="width:100%; height:200px;"></div>
                                            </div>
                                        </div>
                                        <div style="width:100%;text-align:right">
                                            <span class="diff-colomn" style="margin-right:-4px">DIFF</span>
                                            <span class="diff-colomn" id="diff-product-output-{{$machine->name}}"></span>
                                        </div>
                                    </td>
                                    <td width="30%">
                                        <p>&nbsp;</p>
                                        <span class="tags-overview text-center">DEFECT RATE (%)</span>
                                        <div style="text-align: center;">
                                            <div class="chart-container mg-b-20"
                                                style="position: relative; margin: auto; height:200px; width: 100%;">
                                                <div id="defect_rate_machine_{{$machine->name}}"
                                                    style="width:100%; height:200px;">
                                                </div>
                                            </div>
                                        </div>
                                        <div style="width:100%;text-align:right">
                                            <span class="diff-colomn" style="margin-right:-4px">DIFF</span>
                                            <span class="diff-colomn" id="diff-defect-rate-{{$machine->name}}"></span>
                                        </div>
                                    </td>
                                    <td width="30%">
                                        <p>&nbsp;</p>
                                        <span class="tags-overview text-center">EFFICIENCY (%)</span>
                                        <div style="text-align: center;">
                                            <div class="chart-container mg-b-20"
                                                style="position: relative; margin: auto; height:200px; width: 100%;">
                                                <div style="text-align: center;">
                                                    <div class="chart-container mg-b-20"
                                                        style="position: relative; margin: auto; height:200px; width: 100%;">
                                                        <div id="efficiency_machine_{{$machine->name}}"
                                                            style="width:100%; height:200px;">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div style="width:100%;text-align:right">
                                                    <span class="diff-colomn" style="margin-right:-4px">DIFF</span>
                                                    <span class="diff-colomn"
                                                        id="diff-efficiency-{{$machine->name}}"></span>
                                                </div>
                                            </div>

                                        </div>
                                    </td>


                                </tr>
                            </tbody>
                        </table>
                    </div>

                    @endforeach
                </div>
            </div>
        </div>
    </div>




    @endsection

    @push('js')
    <script>
        // initial
        $('.no-gutters').hide();
        $('.main_content_iner').css('padding', '0px');
        $('.main_content').addClass('full_main_content');
        $('.dark_sidebar').addClass('mini_sidebar');
        $('.set-production').hide();
        // AutoScroll();

        // function AutoScroll(){
        //     $('html, body').animate({ scrollTop: $(document).height() - $(window).height() }, 5000, function() {
        //         $(this).animate({ scrollTop: 0 }, 5000,function(){
        //             AutoScroll();
        //         });
        //     });
        // }
        

        const main = $('html');

        // The scrollTop function
        // scrolls to the top
        function scrollTop() {
            main.animate().stop();
            console.log('scrolling to top')
            main.animate({
                    scrollTop: 0
                }, 55000, "linear",
                scrollBottom /* this is a callback it means when we are done scrolling to the top, scroll to the bottom */
            )
        }

        function scrollBottom() {
            main.animate().stop();
            console.log('scrolling to bottom')
            main.animate({
                    scrollTop: document.body.offsetHeight
                }, 55000, "linear",
                scrollTop /* this is a callback it means when we are done scrolling to the bottom, scroll to the top */
            )
        }


        // this kicks it off
        // again only running $(document).ready once to increase performance.
        // Once scrollTop completes, it calls scrollBottom, which in turn calls scrollTop and so on
        // $(document).ready(scrollTop);

        var isAutoAcroll = false;
        let scrollSiDv;
        $(document).on('dblclick', function () {
            
            isAutoAcroll = !isAutoAcroll;
            if (isAutoAcroll) {
                     alert('Start Scroll')
                    //  scrollBottom()
                    let id =1;
                    scrollSiDv = setInterval(() => {
                        id+=3;
                        if(id>14){
                            id = 1;
                        }
                        window.location.replace("#machine-scroll-"+id);
                    
                    }, 3000);
                     
            } else {
                alert('Stopped')
                // main.animate().stop();
                clearInterval(scrollSiDv);
            }
        });

    </script>
    @endpush
