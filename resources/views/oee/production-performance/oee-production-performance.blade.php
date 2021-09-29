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

@section('content')
<div class="row ">
    <div class="col-xl-12">
        <div class="white_card mb_30 shadow ">
            <div class="white_card_header">
                <div class="row align-items-center justify-content-between flex-wrap">
                    <div class="col-lg-5 ">
                        <div class="main-title">
                            <h3 class="m-0 d-inline">{{$page_title}}</h3>
                        </div>
                    </div>

                    <div class="col-lg-4 text-right d-flex justify-content-end">
                        <select class="nice_Select2 max-width-220" onchange="selectType(event)" id="type_interval">
                            <option value="realtime">Realtime</option>
                            <option value="daily">Daily</option>
                            <option value="monthly">Monthly</option>
                        </select>
                        
                        <input type="month" class="hilang" name="interval" id="interval_month"
                            value="{{date('Y-m-d')}}">
                        <input type="date" name="interval" class="hilang" id="interval_date" value="{{date('Y-m')}}">
                        <input type="date" name="interval" class="hilang" id="interval_date2" value="{{date('Y-m')}}">
                        <button class="button btn-sm btn-primary" onclick="getApiPerformance()">SUBMIT</button>
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

                    @foreach ($oee_machines as $oee_machine)
                    <div class="col-12"  >
                        <button class="btn-sm btn-success mb-2 float-right" onclick="screenShoot('machine-{{$oee_machine->name}}', '{{$oee_machine->ident}}')"><i class="fa fa-download" aria-hidden="true"></i> Download PNG {{$oee_machine->ident}}</button>
                        <table class="table table-bordered " id="machine-{{$oee_machine->name}}">
                            <thead>
                                <th colspan="4" style="font-size: 18px;">Machine-<span style="font-size: 18px; color:red;">{{$oee_machine->ident}}</span></th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td width="30%">
                                        <span class="tags-overview text-center">Production Output (pcs)</span>
                                        <div style="text-align: center;">
                                            <div class="mg-b-20" data-percent="">
                                                <div style="width: auto;height:250px;"
                                                    id="production_output_machine_{{$oee_machine->name}}"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td width="30%">
                                        <a href="{{route('oee.production-performance-defect',$oee_machine->name)}}">
                                            <span class="tags-overview text-center">Defect Rate (%)</span>
                                        </a>
                                        <div style="text-align: center;">
                                            <div class="mg-b-20" data-percent="">
                                                <div style="width: auto;height:250px;"
                                                    id="defect_rate_machine_{{$oee_machine->name}}"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td width="30%">
                                        <a href="{{route('oee.production-performance-effeciency',$oee_machine->name)}}">
                                            <span class="tags-overview text-center">Efficiency (%)</span>
                                         </a>
                                        <div style="text-align: center;">
                                            <div class="mg-b-20" data-percent="">
                                                <div style="width: auto;height:250px;"
                                                id="efficiency_machine_{{$oee_machine->name}}"></div>
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
<script src="{{asset('assets')}}/js/jquery.easypiechart.min.js"></script>
<script src="{{asset('assets')}}/vendors/apex_chart/apex-chart2.js"></script>
<script src="{{asset('assets')}}/js/html2canvas.js"></script>
<script src="{{asset('assets')}}/js/fileSaver.js"></script>
<script>
    $(function () {
        $("#btnSave").click(function () {
            html2canvas($("#widget"), {
                onrendered: function (canvas) {
                    theCanvas = canvas;


                    canvas.toBlob(function (blob) {
                        saveAs(blob, "Production-Performance.png");
                    });
                }
            });
        });
    });

    function screenShoot(id, machine) {
        html2canvas($("#"+id), {
                onrendered: function (canvas) {
                    theCanvas = canvas;


                    canvas.toBlob(function (blob) {
                        saveAs(blob, machine+"-Production-Performance.png");
                    });
                }
            });
    }

</script>
<script>

    // -- Generate Chart
    function generateProductionChart(divId, data) {
        plan = [];
        diff = [];
        defect = [];
        efficiency = [];
        data.production_plan.forEach(element => {
            // console.log(element);
            val = fix_val(element, 0);
            plan.push(val);
        });
        data.production_diff.forEach(element => {
            // console.log(element);
            val = fix_val(element, 0);
            diff.push(val);
        });
        data.production_defect_rate.forEach(element => {
            // console.log(element);
            val = fix_val(element, 1);
            defect.push(val);
        });
        data.production_efficiency.forEach(element => {
            // console.log(element);
            val = fix_val(element, 1);
            efficiency.push(val);
        });
        option = {
            legend: {
                data: ['Plan', 'Actual', 'Diff'],
            },
            tooltip: {
                trigger: 'axis',
                axisPointer: {
                    type: 'shadow'
                }
            },
            dataZoom: [{
                type: 'inside'
            }, {
                type: 'slider'
            }],
            xAxis: {
                type: 'category',
                data: data.times
            },
            grid: {
                left: 50
            },
            yAxis: [{
                type: 'value',
                max: function (value) {
                    return Math.ceil(Number(value.max) / 10) * 13;
                },
            }],
            series: [{
                    symbol: 'line',
                    name: 'Plan',
                    data: plan,
                    type: 'line',
                    itemStyle: {
                        color: "#4908B6"
                    }
                },
                {
                    name: 'Actual',
                    data: data.production_output,
                    type: 'line',
                    itemStyle: {
                        color: "#F78642"
                    }
                },
                {
                    name: 'Diff',
                    data: diff,
                    type: 'line',
                    itemStyle: {
                        color: "#A2D3C6"
                    }
                }
            ]
        };
        var myChart = echarts.init(document.getElementById("production_output_machine_" + divId));
        myChart.setOption(option);
        option && myChart.setOption(option);
    }


    function generateDefectChart(divId, data) {
        var option;
        option = {
            legend: {
                data: ['Target', 'Actual']
            },
            tooltip: {
                trigger: 'axis',
                axisPointer: {
                    type: 'shadow'
                }
            },
            dataZoom: [{
                type: 'inside'
            }, {
                type: 'slider'
            }],
            xAxis: {
                type: 'category',
                data: data.times
            },
            grid: {
                left: 50
            },
            yAxis: [{
                type: 'value',
                max: function (value) {
                    return Math.ceil(Number(value.max) / 10) * 13;
                },
            }],
            series: [{
                    symbol: 'none',
                    name: 'Target',
                    data: data.production_defect_rate_target,
                    type: 'line',
                    itemStyle: {
                        color: "#C2185B"
                    },
                },{
                    name: 'Actual',
                    data: defect,
                    type: 'line',
                    itemStyle: {
                        color: "#F78642"
                    }
                },
            ]
        };
        var myChart = echarts.init(document.getElementById("defect_rate_machine_" + divId));
        myChart.setOption(option);
        option && myChart.setOption(option);
    }

    function generateEfficiencyChart(divId, data) {
        var option;
        option = {
            legend: {
                data: ['Target', 'Actual']
            },
            tooltip: {
                trigger: 'axis',
                axisPointer: {
                    type: 'shadow'
                }
            },
            dataZoom: [{
                type: 'inside'
            }, {
                type: 'slider'
            }],
            xAxis: {
                type: 'category',
                data: data.times
            },
            grid: {
                left: 50
            },
            yAxis: [{
                type: 'value',
                max: function (value) {
                    return Math.ceil(Number(value.max) / 10) * 10;
                },
            }],
            series: [{
                    symbol: 'none',
                    name: 'Target',
                    data: data.production_efficiency_target,
                    type: 'line',
                    itemStyle: {
                        color: "#C2185B"
                    },
                } ,{
                    name: 'Actual',
                    data: efficiency,
                    type: 'line',
                    itemStyle: {
                        color: "#F78642"
                    }
                },


            ]
        };
        var myChart = echarts.init(document.getElementById("efficiency_machine_" + divId));
        myChart.setOption(option);
        option && myChart.setOption(option);
    }

    // Apex Chart
    /* -------------------------------------------------------------------------- */
    /*                                     chart                                    */
    /* -------------------------------------------------------------------------- */

    let type_interval = $('#type_interval').val();

    function selectType(e) {
        let type = $(e.target).find("option:selected").val();
        if (type === 'daily') {
            $('#interval_date').removeClass('hilang');
            $('#interval_date2').removeClass('hilang');
            $('#interval_month').addClass('hilang');
        } else if (type === 'monthly') {
            $('#interval_date').addClass('hilang');
            $('#interval_date2').addClass('hilang');
            $('#interval_month').removeClass('hilang');
        } else {
            $('#interval_date').addClass('hilang');
            $('#interval_date2').addClass('hilang');
            $('#interval_month').addClass('hilang');
        }
    }

    // Make a request for a user with a given ID
    const getApiPerformance = async () => {
        let date;
        let date2;
        let type = $('#type_interval').val();

        if (type === 'daily') {
            date = $('#interval_date').val();
            date2 = $('#interval_date2').val();
        } else if (type === 'monthly') {
            date = $('#interval_month').val();
        } else {
            date = `{{date('Y-m-d')}}`
            date2 = `{{date('Y-m-d')}}`
        }
        console.log(date)
        console.log(date2)
        try {
            const resp = await axios.post(base_url + '/api/oee/production-performance',{
                'type': type,
                'date_from': date,
                'date_to': date2,
            });
                
            // -- generate chart
            console.log(resp.data);
            oee_machines.forEach(om => {
                if (resp.data[om.name].times.length) {
                    generateProductionChart(om.name, resp.data[om.name]);
                    generateDefectChart(om.name, resp.data[om.name]);
                    generateEfficiencyChart(om.name, resp.data[om.name]);
                }

                // console.log(om.target_defect_rate)
            });
        } catch (err) {
            // Handle Error Here
            console.error(err);
        }
    };
    getApiPerformance();

    setInterval(() => {
        type_interval = $('#type_interval').val();
        if (type_interval === 'realtime') {
            getApiPerformance();
            console.log("Data Updated");
        }
    }, 60000);

   
</script>
@endpush
