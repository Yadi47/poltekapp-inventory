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
        bottom: 11px;
        position: absolute;
        border-radius: 100%;
        border: 2px solid #fff;
        width: 15px;
        height: 15px;
        border-radius:50%;
    }

    
    .white_card .white_card_body {
        padding: 5px 30px 45px 30px !important;
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
                    <div class="col-lg-6 ">
                        <div class="main-title">
                            <h3 class="m-0">{{$page_title}}</h3>
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
    <div class="col-xl-12">
        <div class="card_box position-relative mb_30 white_bg  shadow bd-0 rounded-20  ">
            <div class="white_box_tittle" style="padding:10px">
                <div class="main-title2 text-center pt-1">
                    <h6 class="mb-2 nowrap">Trending Detail Effeciency ( {{$machine->ident}} )</h6>
                </div>
            </div>
            <div class="card-body text-center" style="padding:15px 0px 15px 30px">
                <div id="main-trending" style="height: 500px"></div>
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
                                <thead >
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

<script>
     let machine = @JSON($machine);
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
                        action: function () {
                            let date, cause, trouble, action, status, machine_id;
                            date = this.$content.find('#date').val();
                            cause = this.$content.find('#cause').val();
                            trouble = this.$content.find('#trouble').val();
                            action = this.$content.find('#action').val();
                            status = this.$content.find('#status').val();
                            machine_id = machine.name;

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
                                success: function (data) {
                                    console.log(data);
                                    alert("Succes Insert " + trouble);
                                    location.reload();
                                },
                                error: function (data) {
                                    console.log(data);
                                    $.alert(data.responseJSON.message);
                                }
                            });
                        }
                    },
                    cancel: function () {
                        //close
                    },
                },
                onContentReady: function () {
                    // bind to events
                    var jc = this;
                    this.$content.find('form').on('submit', function (e) {
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
                const resp = await axios.get("{{ route('get-effeciency') }}",{
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
                        if(d.machine_id == machine.name){
                            tr = $(`<tr onclick="deleteData(event,${d.id},'${d.trouble}')" class="delete"><td>${d.date}</td><td>${d.trouble}</td><td>${d.cause}</td><td>${d.action}</td><td>${d.status}</td></tr>`)
                            
                            tableLms.row.add(tr[0]).draw();
                        }
                    });


                    $("#effeciencyBody").append(tr);
                }

            console.log(resp.data.message);
        }

    // async function storeEffeciency() {
    //     const resp = await axios.post("{{ route('store-effeciency') }}", {
    //         date: $("#date").val(),
    //         cause: $("#cause").val(),
    //         trouble: $("#trouble").val(),
    //         action: $("#action").val(),
    //         status: $("#status").val(),
    //     });

    //     if (resp.data.status == 200) {
    //         alert(resp.data.message);
    //         $("#date").val("")
    //         $("#cause").val("")
    //         $("#trouble").val("")
    //         $("#action").val("")
    //         $("#status").val("")
            
    //         getEffeciency();
    //     }

    //     console.log(resp.data);
    // }
    
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
    // if ($('.lms_table_active3').length) {
    //     $('.lms_table_active3').DataTable({
    //         bLengthChange: false,
    //         "bDestroy": false,
    //         language: {
    //             search: "<i class='ti-search'></i>",
    //             searchPlaceholder: 'Quick Search',
    //             paginate: {
    //                 next: "<i class='ti-arrow-right'></i>",
    //                 previous: "<i class='ti-arrow-left'></i>"
    //             }
    //         },
    //         columnDefs: [{
    //             visible: false
    //         }],
    //         responsive: true,
    //         searching: true,
    //         info: true,
    //         paging: true,
    //     });
    // }
    
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
            stack: 'effeciency',
            data: [],
            type: 'bar',
            itemStyle: {
                color: colors[i]
            },
            symbol: "pin",
        });
    });

    console.log(station);
    console.log(configSeries);

    // CHART
    var option;
    option = {
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
            left: 20,
            right: 80,
            bottom: '10%',
            top: '20%',
            containLabel: true
        },
        xAxis: {
            type: 'category',
            boundaryGap: false,
            data: []
        },
        yAxis: {
            type: 'value',
            axisLabel: {
                formatter: '{value} %'
            },
            max: 100,
            interval: 20
        },
        series: configSeries,
    };
    var myChart = echarts.init(document.getElementById('main-trending'));
    myChart.setOption(option);
    option && myChart.setOption(option);
   
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
            console.log(resp.data)
            option.xAxis.data = resp.data.times

            if (machine.ident.slice(0, 2) == 'MA') {
                option.series[0].data = fixValArray(resp.data.st1, 1)
                option.series[1].data = fixValArray(resp.data.st2, 1)
                option.series[2].data = fixValArray(resp.data.st3_height, 1)
                option.series[3].data = fixValArray(resp.data.st3_noball, 1)
                option.series[4].data = fixValArray(resp.data.st3_twoball, 1)
                option.series[5].data = fixValArray(resp.data.st5_height, 1)
                option.series[6].data = fixValArray(resp.data.st5_high, 1)
                option.series[7].data = fixValArray(resp.data.st5_low, 1)
                option.series[8].data = fixValArray(resp.data.st8_high, 1)
                option.series[9].data = fixValArray(resp.data.st8_low, 1)
                option.series[10].data = fixValArray(resp.data.st9_interface, 1)
                option.series[11].data = fixValArray(resp.data.st10_high, 1)
                option.series[12].data = fixValArray(resp.data.st10_low, 1)
                option.series[13].data = fixValArray(resp.data.st10_direction, 1)
                option.series[14].data = fixValArray(resp.data.st10_presshigh, 1)
                option.series[15].data = fixValArray(resp.data.st10_presslevel, 1)
                option.series[16].data = fixValArray(resp.data.st11_presslow, 1)
                option.series[17].data = fixValArray(resp.data.st11_presslevel, 1)

            } else if (machine.ident.slice(0, 2) == 'UP') {
                option.series[0].data = fixValArray(resp.data.st1up, 1)
                option.series[1].data = fixValArray(resp.data.st3_high, 1)
                option.series[2].data = fixValArray(resp.data.st3_low, 1)
                option.series[3].data = fixValArray(resp.data.st3up_height,1) 
                option.series[4].data = fixValArray(resp.data.st6_high,1) 
                option.series[5].data = fixValArray(resp.data.st6_low,1) 

            } 

            myChart.setOption(option);
            // console.log(resp.data);


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

    function fixValArray(data, del = 2){
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

