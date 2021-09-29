@extends('oee')

@section('title', $page_title)

@push('css')
<!-- datatable CSS -->
<link rel="stylesheet" href="{{asset('assets')}}/vendors/datatable/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="{{asset('assets')}}/vendors/datatable/css/responsive.dataTables.min.css" />
<link rel="stylesheet" href="{{asset('assets')}}/vendors/datatable/css/buttons.dataTables.min.css" />
<link rel="stylesheet" href="{{ asset('assets') }}/vendors/datepicker/date-picker.css">
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
        bottom: 11px;
        position: absolute;
        border-radius: 100%;
        border: 2px solid #fff;
        width: 15px;
        height: 15px;
        border-radius: 50%;
    }


    .white_card .white_card_body {
        padding: 5px 30px 45px 30px !important;
    }
</style>
@endpush
@push('js')
<script src="{{asset('assets')}}/js/jquery.easypiechart.min.js"></script>
<script src="{{asset('assets')}}/vendors/apex_chart/apex-chart2.js"></script>
<script src="{{ asset('assets') }}/vendors/datepicker/datepicker.js"></script>
<script src="{{ asset('assets') }}/vendors/datepicker/datepicker.en.js"></script>
<script src="{{ asset('assets') }}/vendors/datepicker/datepicker.custom.js"></script>

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
            <div class="white_card_header" style="padding:22px 30px 8px 30px !important;">
                <div class="row align-items-center justify-content-between flex-wrap mb-2">
                    <div class="col-lg-4">
                        <div class="main-title">
                            <h3 class="m-0">{{$page_title}}</h3>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="main-title text-center">
                            <span style="font-size: 18px; color:red;">{{$machine->ident}}</span>
                        </div>
                    </div>
                    <div class="col-lg-4 text-right d-flex justify-content-end">
                        <select class="nice_Select2 max-width-220" onchange="selectType(event)" id="type_interval">
                            <option class="realtime" value="realtime">Realtime</option>
                            <option value="daily">Daily</option>
                            <option value="monthly">Monthly</option>
                        </select>
                        <input type="year" class="hilang input-year" name="interval" id="interval_month" value="{{date('Y')}}">
                        <input type="date" class="hilang input-date" name="interval" id="interval_date" value="{{date('m/d/Y')}}">
                        <input type="date" class="hilang input-date2" name="interval" id="interval_date2" value="{{date('m/d/Y')}}">
                        <button class="button btn-sm btn-primary" onclick="getApiTrending()">SUBMIT</button>
                    </div>
                </div>
                <div class="row align-items-center justify-content-between flex-wrap">
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4 text-right d-flex justify-content-end">
                        <button class="btn-sm btn-success mb-2 float-right" onclick="screenShoot('screen', '{{$machine->ident}}')">Download <i class="fa fa-download" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card_box position-relative mb_30 white_bg  shadow bd-0 rounded-20 " id="screen">
            <div class="white_box_tittle" style="padding:10px">
                <div class="main-title2 text-center pt-1">
                    
                    <h6 class="mb-2 nowrap" style="font-size: 18px;">
                        <span class="range-waktu">{{date('Y-m-d')}}</span>
                        <span class="type-daily hilang">Daily</span>
                        <span class="type-monthly hilang">Monthly</span>
                        <span class="type-realtime">Realtime</span>
                         Effeciency <span style="font-size: 18px; color:red;">{{$machine->ident}}</span></h6>
                </div>
            </div>
            <div class="card-body text-center" style="padding:15px 0px 15px 30px">
                <!-- <div id="main-trending" style="height: 500px"></div> -->
                <div id="main-trending2" style="height: 500px"></div>
            </div><!-- card-body -->
        </div><!-- card -->
    </div>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="white_card mb_50 shadow pt-4">
            <div class="float-right d-flex lms_block pr-4">
                <button class="btn btn-primary btn-sm float-right" onclick="addTrouble()">
                    <i class="ti-plus"></i>
                    &nbsp;Add New
                </button>
            </div>
            <div class="white_card_body">
                <div class="QA_section">
                    <!-- <div class="white_box_tittle list_header">
                        <h4>{{$page_title}}</h4>
                    </div> -->

                    <!-- <form action="{{ route('oee.alarm-setting.store') }}" method="post" class="col-12 row"> -->
                    <div class="QA_table mb_60">
                        <!-- table-responsive -->
                        <table class="table lms_table_active3 ">
                            <thead>
                                <tr>
                                    <th scope="col">DATE</th>
                                    <th scope="col">TROUBLE</th>
                                    <th scope="col">CAUSE</th>
                                    <th scope="col">ACTION</th>
                                    <th scope="col">STATUS</th>
                                </tr>
                            </thead>
                            <tbody id="effeciencyBody">
                                <!-- <tr>
                                        <td><input type="date" value="" class="form-control @error('date') is-invalid @enderror" name="date" id="date"></td>
                                        <td><input type="text" value="" class="form-control @error('trouble') is-invalid @enderror" name="trouble" id="trouble"></td>
                                        <td><input type="text" value="" class="form-control @error('cause') is-invalid @enderror" name="cause" id="cause"></td>
                                        <td><input type="text" value="" class="form-control @error('action') is-invalid @enderror" name="action" id="action"></td>
                                        <td><input type="text" value="" class="form-control @error('status') is-invalid @enderror" name="status" id="status"></td>
                                    </tr> -->
                            </tbody>
                        </table>
                    </div>
                    <button class="btn btn-success btn-sm float-right" onclick="storeEffeciency()">
                        <i class="ti-save"></i>
                        &nbsp;Save
                    </button>
                    <!-- </form> -->
                </div>
            </div>
        </div>
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
    let machine = @JSON($machine);

    function screenShoot(id, machine) {
        html2canvas($("#"+id), {
            onrendered: function (canvas) {
                theCanvas = canvas;


                canvas.toBlob(function (blob) {
                    saveAs(blob, "Detail-Effeciency-"+machine+".png");
                });
            }
        });
    }

    //  console.log(machine);
    function addTrouble() {
        $.confirm({
            title: 'Create Trouble',
            content: 'URL:/oee/create-effeciency',
            columnClass: 'medium',
            type: 'blue',
            typeAnimated: true,
            buttons: {
                formSubmit: {
                    text: 'Submit',
                    btnClass: 'btn-blue',
                    action: function() {
                        let date, cause, trouble, action, status, machine_id;
                        date = this.$content.find('#date').val();
                        cause = this.$content.find('#cause').val();
                        trouble = this.$content.find('#trouble').val();
                        action = this.$content.find('#action').val();
                        status = this.$content.find('#status').val();
                        machine_id = machine.id;

                        $.ajax({
                            type: 'POST',
                            url: '/oee/store-effeciency',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                "_token": "{{ csrf_token() }}",
                                date,
                                cause,
                                trouble,
                                action,
                                status,
                                machine_id
                            },
                            async: false,
                            success: function(data) {
                                // console.log(data);
                                alert("Succes Insert " + trouble);
                                location.reload();
                            },
                            error: function(data) {
                                // console.log(data);
                                $.alert(data.responseJSON.message);
                            }
                        });
                    }
                },
                cancel: function() {
                    //close
                },
            },
            onContentReady: function() {
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function(e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    }
    if ($('.lms_table_active3').length) {
        var tableLms = $('.lms_table_active3').DataTable({
            bLengthChange: false,
            "bDestroy": false,
            language: {
                paginate: {
                    next: "<i class='ti-arrow-right'></i>",
                    previous: "<i class='ti-arrow-left'></i>"
                }
            },
            columnDefs: [{
                visible: false
            }],
            responsive: true,
            searching: false,
            info: true,
            paging: true,
            dom: 'Bfrtip',
            buttons: ['csv', 'excel']
        });
    }

    getEffeciency();
    async function getEffeciency(startDate = null, endDate = null, type = null) {
        const resp = await axios.get("{{ route('get-effeciency') }}", {
            params: {
                startDate,
                endDate,
                type,
            }
        });
        if (resp.data.status == 200) {
            tableLms.clear().draw();
            $(".delete").remove();
            resp.data.defect.forEach(d => {
                // console.log(d.machine_id);
                if (d.machine_id == machine.id) {
                    tr = $(
                        `<tr onclick="deleteData(event,${d.id},'${d.trouble}')" class="delete"><td>${d.date}</td><td>${d.trouble}</td><td>${d.cause}</td><td>${d.action}</td><td>${d.status}</td></tr>`
                    )

                    tableLms.row.add(tr[0]).draw();
                }
            });


            // $("#effeciencyBody").append(tr);
        }

        // console.log(resp.data.message);
    }

    var urlDelete = `{{ route('delete-effeciency') }}`

    function deleteData(event, id, textData) {
        event.preventDefault();
        $.confirm({
            title: 'Are you sure for delete data ?',
            content: textData,
            buttons: {
                confirm: {
                    btnClass: 'btn-red',
                    keys: ['enter'],
                    action: function() {
                        axios.delete(urlDelete, {
                                params: {
                                    id: id,
                                    text: textData
                                }
                            })
                            .then(function(response) {
                                // handle success
                                alert(response.data.message + ' ' + textData);
                                // console.log(response.data.message + ' ' + textData);
                                location.reload();
                            })
                            .catch(function(error) {
                                // handle error
                                console.log(error);
                            })
                            .then(function() {
                                // always executed
                            });

                    }
                },
                cancel: {
                    btnClass: 'btn-dark',
                    keys: ['esc'],

                },

            }
        });
    }


    // --- Trending Data
    // ./CHART
    console.log(machine.ident.slice(0, 2));
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
            'Efficiency',
            'Productivity',
            'Target',
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
            'Efficiency',
            'Productivity',
            'Target',
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
        '#000000',
        '#0070C0',
        'red',
    ];

    // buat nyimpen configuration series, yg nanti nya di pake di atribut series buat chart nya
    configSeries = [];
        configSeries.push({
            data: [],
            type: 'line',
            name: 'Efficiency',
            yAxisIndex:1,
            label: {
                fontSize: 12,
                color: 'black',
                show: true,
                position : 'top'
            },
            itemStyle: {
                color: '#000000'
            },
        })
        configSeries.push({
            data: [],
            type: 'line',
            name: 'Productivity',
            yAxisIndex:1,
            label: {
                fontSize: 12,
                color: 'black',
                show: true,
                position : 'top'
            },
            itemStyle: {
                color: '#0070C0'
            },
        })
        configSeries.push({
            data: [],
            type: 'line',
            name: 'Target',
            symbol: 'line',
            yAxisIndex:1,
            label: {
                fontSize: 12,
                color: 'black',
                show: true,
                position : 'top'
            },
            itemStyle: {
                color: 'red'
            },
        })

    // looping variable station yg udah di set berdasarkan ident
    station.forEach((s, i) => {
        // set variable configseries
        configSeries.push({
            name: s,
            stack: 'effeciency',
            data: [],
            type: 'bar',
            yAxisIndex: 0,
            itemStyle: {
                color: colors[i]
            },
        });
    });

    // CHART
    var option;
    option = {
        legend: {
            data: station // get variable station
        },
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'cross',
                crossStyle: {
                    color: '#999'
                }
            }
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
        toolbox: {
            
        },
        xAxis: {
            type: 'category',
            boundaryGap: true,
            data: []
        },
        grid: {
            left: 40,
            right: 40,
            bottom: '10%',
            top: '23%',
            containLabel: true
        },
        // yAxis: {
        //     type: 'value',
        //     axisLabel: {
        //         formatter: '{value} %'
        //     },
        //     max: 100,
        //     interval: 20
        // },
        yAxis: [{
                type: 'value',
                name: 'Abnormal Count',
                min: 0,
                max: function (value) {
                    return Math.ceil(Number(value.max) *1.2);
                },
                // interval: 1,
                axisLabel: {
                    // formatter: '{value} ml'
                },
            },
            {
                type: 'value',
                name: 'Efficiency',
                min: 0,
                max: function (value) {
                    return Math.ceil(Number(value.max) *1.1);
                },
                // interval: 10,
                axisLabel: {
                    formatter: '{value} %'
                },
            }
        ],
        series: configSeries,
    };
    var myChart = echarts.init(document.getElementById('main-trending2'));
    myChart.setOption(option);
    option && myChart.setOption(option);


    // console.log(station);
    // console.log(configSeries);

   let type_interval = $('#type_interval').val();
    $('.input-date').on('change',function(){
            if($('.input-date').val() === $('.input-date2').val()){
                $('.range-waktu').text($('.input-date').val());
            }else{
                $('.range-waktu').text($('.input-date').val() +' - '+$('.input-date2').val());
            }
    })

    $('.input-date2').on('change',function(){   
             if($('.input-date').val() === $('.input-date2').val()){
                $('.range-waktu').text($('.input-date').val());
            }else{
                $('.range-waktu').text($('.input-date').val() +' - '+$('.input-date2').val());
            }

    })
    $('.input-year').on('change',function(){
            let dt = $('.input-year').val();

            $('.range-waktu').text(dt);

    })

    function selectType(e) {
        let type = $(e.target).find("option:selected").val();
        if (type === 'daily') {
            $('#interval_date').removeClass('hilang');
            $('#interval_date2').removeClass('hilang');
            $('#interval_month').addClass('hilang');
            $('.type-daily').removeClass('hilang');
            $('.type-monthly').addClass('hilang');
            $('.type-realtime').addClass('hilang');
            
            let dt = $('.input-date').val();
            $('.range-waktu').text(dt);
            
        } else if (type === 'monthly') {
            $('#interval_date').addClass('hilang');
            $('#interval_date2').addClass('hilang');
            $('#interval_month').removeClass('hilang');
            $('.type-daily').addClass('hilang');
            $('.type-monthly').removeClass('hilang');
            $('.type-realtime').addClass('hilang');
            let dt = $('.input-year').val();
            $('.range-waktu').text(dt);
        } else if (type === 'realtime') {
            $('#interval_date').addClass('hilang');
            $('#interval_date2').addClass('hilang');
            $('#interval_month').addClass('hilang');
            $('.type-daily').addClass('hilang');
            $('.type-monthly').addClass('hilang');
            $('.type-realtime').removeClass('hilang');
            let dt =  `{{date('Y-m-d')}}`;
            $('.range-waktu').text(dt);
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
            date2 = `{{date('Y-m-d')}}`
        }
        console.log(date)
        console.log(date2)
        try {
            getEffeciency(date, date, type);
            const resp = await axios.post(base_url + '/api/oee/production-performance-detail-effeciency', {
                'name': machine.name,
                'type': type,
                'date_from': date,
                'date_to': date2,
            });
            // -- generate chart
            let datetimes = [];
            let groupXaxis = [];
            let production_efficiency_target = [];
            let production_efficiency = [];
            let production_productivity = [];
            let st1 = [];
            let st2 = [];
            let st3_height = [];
            let st3_noball = [];
            let st3_twoball = [];
            let st5_height = [];
            let st5_high = [];
            let st5_low = [];
            let st8_high = [];
            let st8_low = [];
            let st9_interface = [];
            let st10_high = [];
            let st10_low = [];
            let st10_direction = [];
            let st10_presshigh = [];
            let st10_presslevel = [];
            let st11_presslow = [];
            let st11_presslevel = [];
            let st1up = []
            let st3_high = []
            let st3_low = []
            let st3up_height = []
            let st6_high = []
            let st6_low = []
            resp.data.all_values.forEach(vlues => {
                vlues.data.forEach(dts => {
                    console.log(dts.shift_name)
                    dts.forEach(dtl => {
                        groupXaxis.push(dtl.shift_name)
                        var vll = dtl.values;
                     
                        
                        production_efficiency.push(vll.production_efficiency ?? 0)
                        production_productivity.push(vll.production_productivity ?? 0)
                        production_efficiency_target.push(vll.production_efficiency_target)
                        if (machine.ident.slice(0, 2) == 'MA') {
                            st1.push(vll.st1)
                            st2.push(vll.st2)
                            st3_height.push(vll.st3_height)
                            st3_noball.push(vll.st3_noball)
                            st3_twoball.push(vll.st3_twoball)
                            st5_height.push(vll.st5_height)
                            st5_high.push(vll.st5_high)
                            st5_low.push(vll.st5_low)
                            st8_high.push(vll.st8_high)
                            st8_low.push(vll.st8_low)
                            st9_interface.push(vll.st9_interface)
                            st10_high.push(vll.st10_high)
                            st10_low.push(vll.st10_low)
                            st10_direction.push(vll.st10_direction)
                            st10_presshigh.push(vll.st10_presshigh)
                            st10_presslevel.push(vll.st10_presslevel)
                            st11_presslow.push(vll.st11_presslow)
                            st11_presslevel.push(vll.st11_presslevel)
                        }else{
                            st1up.push(vll.st1up)
                            st3_high.push(vll.st3_high)
                            st3_low.push(vll.st3_low)
                            st3up_height.push(vll.st3up_height)
                            st6_high.push(vll.st6_high)
                            st6_low.push(vll.st6_low)
                        }
                    });
                });
            });
            var emphasisStyle = {
                itemStyle: {
                    shadowBlur: 10,
                    shadowColor: 'rgba(0,0,0,0.3)'
                }
            };


            option.xAxis = [{
                    position: "bottom",
                    data: groupXaxis
                },
                {
                    position: "bottom",
                    data: resp.data.datetime,
                    interval: 1,
                    axisLine: {
                        show: false
                    },
                    axisTick: {
                        alignWithLabel: false,
                        length: 40,
                        align: "left",
                        interval: function(index, value) {
                            return value ? true : false;
                        }
                    },
                    axisLabel: {
                        margin: 30
                    },
                    splitLine: {
                        show: true,
                        interval: function(index, value) {
                            return value ? true : false;
                        }
                    }
                }
            ];

            console.log('DEBUGG')
            // console.log(resp.data)
            // option.xAxis.data = resp.data.times

            if (machine.ident.slice(0, 2) == 'MA') {
                option.series[0].data = fixValArray(production_efficiency, 1)
                option.series[1].data = fixValArray(production_productivity, 1)
                option.series[2].data = production_efficiency_target
                option.series[3].data = st1
                option.series[4].data = st2
                option.series[5].data = st3_height
                option.series[6].data = st3_noball
                option.series[7].data = st3_twoball
                option.series[8].data = st5_height
                option.series[9].data = st5_high
                option.series[10].data = st5_low
                option.series[11].data = st8_high
                option.series[12].data = st8_low
                option.series[13].data = st9_interface
                option.series[14].data = st10_high
                option.series[15].data = st10_low
                option.series[16].data = st10_direction
                option.series[17].data = st10_presshigh
                option.series[18].data = st10_presslevel
                option.series[19].data = st11_presslow
                option.series[20].data = st11_presslevel
                

            } else if (machine.ident.slice(0, 2) == 'UP') {
                option.series[0].data = fixValArray(production_efficiency, 1)
                option.series[1].data = fixValArray(production_productivity, 1)
                option.series[2].data = production_efficiency_target
                option.series[3].data = st1up
                option.series[4].data = st3_high
                option.series[5].data = st3_low
                option.series[6].data = st3up_height
                option.series[7].data = st6_high
                option.series[8].data = st6_low

            }

            myChart.setOption(option);
            // console.log("SERIESNYA");
            // console.log(option.series);


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
    }, 109000);

    function fixValArray(data, del = 2) {
        value = [];
        data.forEach(element => {
            value.push(element.toFixed(del));
        });
        return value;
    }


    function fix_val(val, del = 2) {
        if (val != undefined || val != null) {
            var rounded = val.toFixed(del).toString().replace('.', ","); // Round Number
            return this.numberWithCommas(rounded); // Output Result
        }

    }

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "");
    }
</script>
@endpush