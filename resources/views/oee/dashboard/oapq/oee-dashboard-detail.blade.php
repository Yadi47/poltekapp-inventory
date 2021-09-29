@extends('oee')

@section('title', $page_title)

@push('css')
<!-- datatable CSS -->
<link rel="stylesheet" href="{{asset('assets')}}/vendors/datatable/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="{{asset('assets')}}/vendors/datatable/css/responsive.dataTables.min.css" />
<link rel="stylesheet" href="{{asset('assets')}}/vendors/datatable/css/buttons.dataTables.min.css" />
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
    
    .square-10 {
        right: 12px;
        bottom: 17px;
        position: absolute;
        border-radius: 100%;
        border: 2px solid #fff;
        width: 15px;
        height: 15px;
        border-radius:50%;
    }

</style>
@endpush
@push('js')
<script src="{{asset('assets')}}/js/jquery.easypiechart.min.js"></script>
<script src="{{asset('assets')}}/vendors/apex_chart/apex-chart2.js"></script>

<script src="{{asset('assets')}}/vendors/datatable/js/jquery.dataTables.min.js"></script>
<script src="{{asset('assets')}}/vendors/datatable/js/dataTables.responsive.min.js"></script>
<script src="{{asset('assets')}}/vendors/datatable/js/dataTables.buttons.min.js"></script>
<script src="{{asset('assets')}}/vendors/datatable/js/dataTables.buttons.min.js"></script>
<script src="{{asset('assets')}}/vendors/datatable/js/buttons.flash.min.js"></script>
<script src="{{asset('assets')}}/vendors/datatable/js/jszip.min.js"></script>
<script src="{{asset('assets')}}/vendors/datatable/js/pdfmake.min.js"></script>
<script src="{{asset('assets')}}/vendors/datatable/js/vfs_fonts.js"></script>
<script src="{{asset('assets')}}/vendors/datatable/js/buttons.html5.min.js"></script>
<script src="{{asset('assets')}}/vendors/datatable/js/buttons.print.min.js"></script>

@endpush
@section('content')
<div class="row ">
    <div class="col-xl-12">
        <div class="white_card mb_30 shadow ">
            <div class="white_card_header">
                <div class="row align-items-center justify-content-between flex-wrap">
                    <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                        <div class="main-title">
                            <h3 class="m-0 font-weight-bold">{{$page_title}}</h3>
                        </div>
                    </div>
                    <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 text-center">
                        <h5 style="font-weight:800;">{{ $shift[0]['shift'] ?? $shift[1]['shift'] ?? 'SHIFT -' }}</h5>
                    </div>
                    <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 text-right d-flex justify-content-end">
                        <select class="nice_Select2 max-width-220" onchange="selectType(event)" id="type_interval">
                            <option value="realtime">Realtime</option>
                            <option value="daily">Daily</option>
                            <option value="monthly">Monthly</option>
                        </select>
                        
                        <input type="month" class="hilang" name="interval" id="interval_month"
                            value="{{date('Y-m-d')}}">
                        <input type="date" class="hilang" name="interval" id="interval_date" value="{{date('Y-m')}}">
                        <input type="date" class="hilang" name="interval" id="interval_date2" value="{{date('Y-m')}}">
                        <button class="button btn-sm btn-primary" onclick="getApiTrending()">SUBMIT</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-3" id="machine-{{$machine->name}}">
        <div class="card_box position-relative mb_30 white_bg  shadow bd-0 rounded-20  ">
            <div class="white_box_tittle" style="padding:10px">
                <div class="main-title2 ">
                    <h5 class="mb-2 nowrap font-weight-bold d-inline">{{$machine->ident}}</h5>
                    <div class="machine-{{$machine->name}}"></div>
                </div>
            </div>

            <div class="card-body  text-center" style="padding:15px">
                <span class="tags-overview text-center">OEE</span>
                <div style="text-align: center;">
                    <div class="chart chart-oee machine-{{$machine->name}}-oee mb_20" data-percent="">
                        <span class="percent machine-{{$machine->name}}-percent-oee">- %</span>
                        <p class="percent-simbol">%</p>
                        <canvas height="200" width="200"></canvas>
                    </div>
                    <div class="progress-group">
                        <span class="tags-overview">Availability</span>
                        <span class="tags-percent-a float-right" id="avail-machine-{{$machine->name}}-index">-
                            %</span>
                        <div class="progress a mb_10">
                            <div class="progress-bar progress-bar-a" aria-valuenow="0" aria-valuemin="0"
                                id="avail-machine-{{$machine->name}}" role="progressbar">
                            </div>
                        </div>


                        <span class="tags-overview">Performance</span>
                        <span class="tags-percent-p float-right" id="perform-machine-{{$machine->name}}-index">-
                            %</span>
                        <div class="progress p mb_10">
                            <div class="progress-bar progress-bar-p " id="perform-machine-{{$machine->name}}"
                                role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>


                        <span class="tags-overview">Quality</span>
                        <span class="tags-percent-q float-right" id="quality-machine-{{$machine->name}}-index">-
                            %</span>
                        <div class="progress q mb_10">
                            <div class="progress-bar progress-bar-q " id="quality-machine-{{$machine->name}}"
                                role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>

                    </div>
                    <table class="text-left">
                        <tr>
                            <td width="50%" class="tags-overview">Total Product </td>
                            <td width="50%" class="tags-overview"> : <span id="total-qty-{{$machine->name}}"> - </span> pcs</td>
                        </tr>
                        <tr>
                            <td class="tags-overview">Good Product </td>
                            <td class="tags-overview"> : <span id="total-good-{{$machine->name}}"> - </span> pcs</td>
                        </tr>
                        <tr>
                            <td class="tags-overview">Reject Product </td>
                            <td class="tags-overview"> : <span id="total-reject-{{$machine->name}}"> - </span> pcs</td>
                        </tr>
                        <tr>
                            <td class="tags-overview">Runtime </td>
                            <td class="tags-overview"> : <span id="running-second-{{$machine->name}}"> - </span> s</td>
                        </tr>
                        <tr>
                            <td class="tags-overview">Downtime </td>
                            <td class="tags-overview"> : <span id="abnormal-second-{{$machine->name}}"> - </span> s</td>
                        </tr>
                    </table>

                </div>
            </div><!-- card-body -->
        </div><!-- card -->
    </div>
    
    <div class="col-12 col-sm-12 col-md-8 col-lg-8 col-xl-9">
        <div class="card_box position-relative mb_30 white_bg  shadow bd-0 rounded-20  ">
            <div class="white_box_tittle" style="padding:10px">
                <button class="btn-sm btn-success mb-2 float-right" onclick="screenShoot('main-trending', '{{$machine->ident}}')"><i class="fa fa-download" aria-hidden="true"></i></button>
                <div class="main-title2 text-center pt-1">
                    <h4 class="mt-2 nowrap font-weight-bold">Trending Data</h4>
                </div>
            </div>

            <div class="card-body  text-center" style="padding:15px">
                <div id="main-trending" style="height: 400px"></div>
            </div><!-- card-body -->
        </div><!-- card -->
    </div>

    <div class="col-12">
        <div class="card_box position-relative mb_30 white_bg  shadow bd-0 rounded-20  ">
            <div class="white_box_tittle" style="padding:10px">
                <button class="btn-sm btn-success mb-2 float-right" onclick="screenShoot('reject-trending', '{{$machine->ident}}-Reject')"><i class="fa fa-download" aria-hidden="true"></i></button>
                <div class="main-title2 text-center pt-2">
                    <h4 class="mb-2 nowrap font-weight-bold">Detail Reject {{ $machine->ident }}</h4>
                </div>
            </div>

            <div class="card-body  text-center" style="padding:15px">
                <div id="reject-trending" style="height: 500px"></div>
            </div><!-- card-body -->
        </div><!-- card -->
    </div>

    <div class="col-12">
        <div class="card_box position-relative mb_30 white_bg  shadow bd-0 rounded-20  ">
            <div class="white_box_tittle" style="padding:10px">
                <div class="main-title2 text-center pt-2">
                    <h4 class="mb-2 nowrap font-weight-bold">Detail Data</h4>
                </div>
            </div>

            <div class="card-body QA_section  text-center" style="padding:15px">
                <div class="table-wrapper QA_table mb_30">
                    <table class="table lms_table_active3">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Datetime</th>
                                <th>Runtime</th>
                                <th>Downtime</th>

                                <th>Qty Total</th>
                                <th>Qty Good</th>
                                <th>Qty Reject</th>
                                <th>OEE &nbsp; &nbsp;</th>
                                <th>Availability</th>
                                <th>Performance</th>
                                <th>Quality</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div><!-- card-body -->
        </div><!-- card -->
    </div>
</div>

@endsection

@push('js')
<!-- <script src="https://cdn.socket.io/3.1.3/socket.io.min.js"
    integrity="sha384-cPwlPLvBTa3sKAgddT6krw0cJat7egBga3DJepJyrLl4Q9/5WLra3rrnMcyTyOnh" crossorigin="anonymous">
</script> -->

    <!-- Socket -->
    <script src="{{asset('assets/js/socket.io.js')}}"></script>
    <script src="{{asset('assets')}}/js/html2canvas.js"></script>
    <script src="{{asset('assets')}}/js/fileSaver.js"></script>
<script>
    function screenShoot(id, machine) {
        html2canvas($("#"+id), {
                onrendered: function (canvas) {
                    theCanvas = canvas;


                    canvas.toBlob(function (blob) {
                        saveAs(blob, machine+"-detail-trending.png");
                    });
                }
            });
    }

    // if ($('.lms_table_active3').length) {
    let table = $('.lms_table_active3').DataTable({
        bLengthChange: false,
        "bDestroy": false,
        language: {
            search: "<i class='ti-search'></i>",
            searchPlaceholder: 'Quick Search',
            paginate: {
                next: "<i class='ti-arrow-right'></i>",
                previous: "<i class='ti-arrow-left'></i>"
            }
        },
        columnDefs: [{
            visible: false
        }],
        responsive: true,
        searching: true,
        info: true,
        paging: true,
        dom: 'Bfrtip',
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print']


    });
    // }
    // --- Trending Data
    // CHART
    var option;
    option = {
        legend: {
            data: ['Oee', 'Availability', 'Performance', 'Quality']
        },
        tooltip: {
            trigger: 'axis',
            // position: function (pt) {
            //     return [pt[0], '10%'];
            // }
        },
        dataZoom: [{
                type: 'inside',
                start: 0,
            },
            {
                start: 0,
                handleSize: '100%',
                handleStyle: {
                    color: '#fff',
                    shadowBlur: 10,
                    shadowColor: 'rgba(0, 0, 0, 0.6)',
                    shadowOffsetX: 2,
                    shadowOffsetY: 2
                }
            }
        ],
        grid: {
            left: 0
        },

        xAxis: {
            type: 'category',
            boundaryGap: true,
            data: []
        },
        yAxis: {
            type: 'value',
            axisLabel: {
                formatter: '{value} %'
            },
            max: 100,
            interval: 10
        },
        series: [{
                name: 'Oee',
                data: [],
                type: 'line',
                itemStyle: {
                    color: "#D90165"
                },
                symbol: "pin",
            },
            {
                name: 'Availability',
                data: [],
                type: 'line',
                itemStyle: {
                    color: "#319EC9"
                },
                symbol: "pin",
            },
            {
                name: 'Performance',
                data: [],
                type: 'line',
                itemStyle: {
                    color: "#F29200"
                },
                symbol: "pin",
            },
            {
                name: 'Quality',
                data: [],
                type: 'line',
                itemStyle: {
                    color: "#94C120"
                },
                symbol: "pin",
            },
        ]
    };
    var myChart = echarts.init(document.getElementById('main-trending'));
    myChart.setOption(option);
    option && myChart.setOption(option);
    // ./CHART

    let machine = @JSON($machine);

    // variable for save station
    station = [];

    // pengecekan ident machine
    // slice buat ngambil string 
    // parameter 1 posisi karakter pertama yang mau dipotong
    // parameter 2 panjang karakter yang mau di potong
    if (machine.ident.slice(0, 2) == 'MA') {
        // jika 2 karakter di awal mesin adalah MA, maka station akan berisi:
        station = [ 
            'ST-1',
            'ST-2',
            'ST-3(height)',
            'ST-3(noball)',
            'ST-3(twoball)',
            'ST-5(height)',
            'ST-5(high)',
            'ST-5(low)',
            'ST-8(high)',
            'ST-8(low)',
            'ST-9(interface)',
            'ST-10(high)',
            'ST-10(low)',
            'ST-10(direction)',
            'ST-10(presshigh)',
            'ST-10(presslevel)',
            'ST-11(presslow)',
            'ST-11(presslevel)',
        ];
    } else if (machine.ident.slice(0, 2) == 'UP') {
        // jika 2 karakter di awal mesin adalah UP, maka station akan berisi:
        station = [
            'ST-1(UP)',
            'ST-3(high)',
            'ST-3(low)',
            'ST-3(UP-height)',
            'ST-6(high)',
            'ST-6(low)',
        ];
    } 
    
    // buat nyimpen color
    colors = [
        '#493323',
        '#319EC9',
        '#F29200',
        '#000000',
        'green',
        '#FAFF00',
        '#B05B3B',
        '#001E6C',
        '#28FFBF',
        '#AA2EE6',
        '#D8AC9C',
        '#9EDE73',
        '#D90165',
        '#61B15A',
        '#D35D6E',
        '#FCF876',
        '#9BA4B4',
        '#F56A79',
    ];

    // buat nyimpen configuration series, yg nanti nya di pake di atribut series buat chart nya
    configSeries = [];
    
    // looping variable station yg udah di set berdasarkan ident
    station.forEach((s, i) => {
        // set variable configseries
        configSeries.push({
            name: s,
            data: [],
            type: 'bar',
            stack: 'reject',
            itemStyle: {
                color: colors[i]
            },
            symbol: "pin",
        });
    });

    console.log(station);
    console.log(configSeries);

    // CHART
    var option2;
    option2 = {
        legend: {
            data: station // get variable station
        },
        tooltip: {
            trigger: 'axis',
            // position: function (pt) {
            //     return [pt[0], '10%'];
            // }
        },
        dataZoom: [{
                type: 'inside',
                start: 0,
            },
            {
                start: 0,
                handleSize: '100%',
                handleStyle: {
                    color: '#fff',
                    shadowBlur: 10,
                    shadowColor: 'rgba(0, 0, 0, 0.6)',
                    shadowOffsetX: 2,
                    shadowOffsetY: 2
                }
            }
        ],
        grid: {
            left: 0,
            right: 0,
            bottom: '13%',
            top: '15%',
            containLabel: true
        },

        xAxis: {
            type: 'category',
            boundaryGap: true,
            data: []
        },
        yAxis: {
            type: 'value',
            axisLabel: {
                formatter: '{value} '
            },
            max: function (value) 
            {
                return Math.ceil(Number(value.max) / 10) * 10;
            },
            interval: 5
        },
        series: configSeries,
    };
    var myChart2 = echarts.init(document.getElementById('reject-trending'));
    myChart2.setOption(option2);
    option2 && myChart.setOption(option2);

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
    const getApiTrending = async () => {
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
        }
        console.log(date)
        console.log(date2)
        try {
            const resp = await axios.post(base_url + '/api/oee/production-trend', {
                'name': machine.name,
                'type': type,
                'date_from': date,
                'date_to': date2,
            });
            // -- generate chart
            console.log(resp.data)
            option.xAxis.data = resp.data.times
            option.series[0].data = resp.data.oee
            option.series[1].data = resp.data.a
            option.series[2].data = resp.data.p
            option.series[3].data = resp.data.q
            myChart.setOption(option);
            // generat chart reject
            option2.xAxis.data = resp.data.times
            
            if (machine.ident.slice(0, 2) == 'MA') {
                option2.series[0].data = resp.data.st1
                option2.series[1].data = resp.data.st2
                option2.series[2].data = resp.data.st3_height
                option2.series[3].data = resp.data.st3_noball
                option2.series[4].data = resp.data.st3_twoball
                option2.series[5].data = resp.data.st5_height
                option2.series[6].data = resp.data.st5_high
                option2.series[7].data = resp.data.st5_low
                option2.series[8].data = resp.data.st8_high
                option2.series[9].data = resp.data.st8_low
                option2.series[10].data = resp.data.st9_interface
                option2.series[11].data = resp.data.st10_high
                option2.series[12].data = resp.data.st10_low
                option2.series[13].data = resp.data.st10_direction
                option2.series[14].data = resp.data.st10_presshigh
                option2.series[15].data = resp.data.st10_presslevel
                option2.series[16].data = resp.data.st11_presslow
                option2.series[17].data = resp.data.st11_presslevel

            } else if (machine.ident.slice(0, 2) == 'UP') {
                option2.series[0].data = resp.data.st1up
                option2.series[1].data = resp.data.st3_high
                option2.series[2].data = resp.data.st3_low
                option2.series[3].data = resp.data.st3up_height 
                option2.series[4].data = resp.data.st6_high 
                option2.series[5].data = resp.data.st6_low 

            } 
            myChart2.setOption(option2);
            table.clear()

            resp.data.times.forEach((d, i) => {
                table.row.add([
                    i + 1,
                    d,
                    resp.data.running[i] + ' s',
                    resp.data.downtime[i] + ' s',
                    
                    resp.data.production_output[i] + ' pcs',
                    resp.data.production_good[i] + ' pcs',
                    resp.data.production_fail[i] + ' pcs',
                    resp.data.oee[i] + ' %',
                    resp.data.a[i] + ' %',
                    resp.data.p[i] + ' %',
                    resp.data.q[i] + ' %',
                ])
            });

            table.draw()
            console.log(table)

        } catch (err) {
            // Handle Error Here
            console.error(err);
        }
    };
    getApiTrending();
    setInterval(() => {
        type_interval = $('#type_interval').val();
        if (type_interval === 'realtime') {
            getApiTrending();
            console.log("Data Updated");
        }
    }, 19000);




    $(function () {
        $('.chart-oee').easyPieChart({
            // The color of the curcular bar. You can pass either a css valid color string like rgb, rgba hex or string colors. But you can also pass a function that accepts the current percentage as a value to return a dynamically generated color.
            // easing: 'easeOutBounce',
            barColor: '#D90165',
            scaleColor: false,
            // The color of the track for the bar, false to disable rendering.
            trackColor: '#e5e5e5',
            rotate: 180,

            lineWidth: 10,
            // Size of the pie chart in px. It will always be a square.
            size: 150,
            // Time in milliseconds for a eased animation of the bar growing, or false to deactivate.
            animate: 1000,
            // Callback function that is called at the start of any animation (only if animate is not false).
            onStart: $.noop,
            // Callback function that is called at the end of any animation (only if animate is not false).
            onStop: $.noop
        });


        let machine = @json($machine);
        const oee_machines = @json($oee_machines);
        socket.on('toClientRealtimeValuesResults', (data) => {
            data.forEach(d => {
                if (d.TagGroupName.toString() === machine.name.toString()) {

                    $('#total-qty-' + machine.name).text(getValue("ProductionQuantity", d.values));
                    $('#total-good-' + machine.name).text(getValue("PassQuantity", d
                        .values));
                    $('#total-reject-' + machine.name).text(getValue("FailQuantity", d.values));
                    $('#abnormal-second-' + machine.name).text(getValue("AbnormalyTimeSecond", d.values));
                    $('#running-second-' + machine.name).text(getValue("RunningTimeSecond", d.values));
                    let quality = getQuality(getValue("ProductionQuantity", d.values),
                        getValue(
                            "PassQuantity", d.values), getValue(
                            "FailQuantity", d
                            .values))

                    let performance = getPerformance(getValue(
                            "ProductionQuantity", d
                            .values),
                        getValue("RunningTimeSecond", d.values), machine.cycle_time)
                    
                    let availability = getAvailability(getValue(
                        "RunningTimeSecond", d.values) / 60, getValue(
                        "AbnormalyTimeSecond",
                        d
                        .values) / 60);

                    let oee = ((quality / 100) * (performance / 100) * (
                            availability /
                            100)) * 100;

                    if(isNaN(oee)){
                        $('.machine-' + machine.name).html(`<span class="square-10 bg-danger"></span>`)
                    }else{
                        $('.machine-' + machine.name).html(`<span class="square-10 bg-success animated fadeIn"></span>`)
                    }

                    if(isNaN(oee)) oee = 0;
                    $('.machine-' + machine.name + '-oee').data('easyPieChart').update(fix_val(oee, 1));
                    $('.machine-' + machine.name + '-percent-oee').text(fix_val(
                        oee, 1));

                    if(isNaN(availability)) availability = 0;
                    $('#avail-machine-' + machine.name).width(fix_val(
                        availability, 0) + '%');
                    $('#avail-machine-' + machine.name + '-index').text(fix_val(
                        availability, 1) + '%');

                    if(isNaN(performance)) performance = 0;
                    $('#perform-machine-' + machine.name).width(fix_val(
                        performance, 0) + '%');
                    $('#perform-machine-' + machine.name + '-index').text(fix_val(
                        performance, 1) + '%');

                    if(isNaN(quality)) quality = 0;
                    $('#quality-machine-' + machine.name).width(fix_val(quality,
                        0) + '%');
                    $('#quality-machine-' + machine.name + '-index').text(fix_val(
                        quality, 1) + '%');
                }
            });
        })

    });

    function fix_val(val, del = 2) {
        if (val != undefined || val != null) {
            var rounded = val.toFixed(del).toString().replace('.', ","); // Round Number
            return this.numberWithCommas(rounded); // Output Result
        }

    }

    function fixValArray(data, del = 2) {
        value = [];
        data.forEach(element => {
            value.push(element.toFixed(del));
        });
        return value;
    }

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "");
    }

</script>
@endpush
