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

</style>
@endpush
@push('js')
<script src="{{asset('assets')}}/js/jquery.easypiechart.min.js"></script>
<script src="{{asset('assets')}}/vendors/apex_chart/apex-chart2.js"></script>
<script>




</script>
@endpush
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="white_card mb_30 shadow ">
            <div class="white_card_header">
                <div class="row align-items-center justify-content-between flex-wrap">
                    <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                        <div class="main-title">
                            <h3 class="m-0">Dashboard</h3>
                        </div>
                    </div>
                    <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 text-center">
                        <h5 style="font-weight:800;">{{ $shift[0]['shift'] ?? $shift[1]['shift'] ?? 'SHIFT -' }}</h5>
                    </div>
                    <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 text-right d-flex justify-content-end">
                        <select class="nice_Select2 max-width-220">
                            <option value="1">Realtime</option>
                            <!-- <option value="1">Daily</option> -->
                            <!-- <option value="1">Monthly</option> -->
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    @foreach ($oee_machines as $machine)
    <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3" id="machine-{{$machine->name}}">
        <a href="{{route('oee.dashboard.detail',$machine->name)}}">
            <div class="card_box position-relative mb_30 white_bg card__one shadow bd-0 rounded-20  ">
                <div class="white_box_tittle" style="padding:10px">
                    <div class="main-title2 ">
                        <div class="machine-{{$machine->name}}"></div>
                        <h6 class="mb-2 nowrap " style="display:inline;">{{$machine->ident}}</h6>
                    </div>
                </div>

                <div class="card-body text-center" style="padding:15px">
                    <span class="tags-overview text-center">OEE</span>
                    <div style="text-align: center;">
                        <div class="chart chart-oee machine-{{$machine->id}}-oee mb_20" data-percent="">
                            <span class="percent machine-{{$machine->id}}-percent-oee">- %</span>
                            <p class="percent-simbol">%</p>
                            <canvas height="200" width="200"></canvas>
                        </div>
                        <div class="progress-group">
                            <span class="tags-overview">Availability</span>
                            <span class="tags-percent-a float-right" id="avail-machine-{{$machine->id}}-index">-
                                %</span>
                            <div class="progress a mb_10">
                                <div class="progress-bar progress-bar-a" aria-valuenow="0" aria-valuemin="0"
                                    id="avail-machine-{{$machine->id}}" role="progressbar">
                                </div>
                            </div>


                            <span class="tags-overview">Performance</span>
                            <span class="tags-percent-p float-right" id="perform-machine-{{$machine->id}}-index">-
                                %</span>
                            <div class="progress p mb_10">
                                <div class="progress-bar progress-bar-p " id="perform-machine-{{$machine->id}}"
                                    role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>

                            <span class="tags-overview">Quality</span>
                            <span class="tags-percent-q float-right" id="quality-machine-{{$machine->id}}-index">-
                                %</span>
                            <div class="progress q mb_10">
                                <div class="progress-bar progress-bar-q " id="quality-machine-{{$machine->id}}"
                                    role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- card-body -->
            </div><!-- card -->
        </a>
    </div>
    @endforeach

    @endsection

    @push('js')
    <!-- <script src="https://cdn.socket.io/3.1.3/socket.io.min.js"
        integrity="sha384-cPwlPLvBTa3sKAgddT6krw0cJat7egBga3DJepJyrLl4Q9/5WLra3rrnMcyTyOnh" crossorigin="anonymous">
    </script> -->

        <!-- Socket -->
        <script src="{{asset('assets/js/socket.io.js')}}"></script>

    <script>
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

            // // loop data machine
            // let machines = @json($oee_machines);
            // machines.forEach(m => {

            // });

            const oee_machines = @json($oee_machines);
            console.log(oee_machines);
            socket.on('toClientRealtimeValuesResults', (data) => {
                oee_machines.forEach(machine => {
                    data.forEach(d => {
                        if (d.TagGroupName === machine.name) {


                            let quality = getQuality(getValue("ProductionQuantity", d
                                    .values),
                                getValue(
                                    "PassQuantity", d.values), getValue(
                                    "FailQuantity", d
                                    .values))

                            let performance = getPerformance(getValue(
                                "ProductionQuantity", d.values),
                                getValue("RunningTimeSecond", d.values), machine.cycle_time)

                            let availability = getAvailability(getValue(
                                "RunningTimeSecond", d.values) / 60, getValue(
                                "AbnormalyTimeSecond",d.values) / 60);

                            let oee = ((quality / 100) * (performance / 100) * (availability / 100)) * 100;

                            if(isNaN(oee)){
                                $('.machine-' + machine.name).html(`<span class="square-10 bg-danger"></span>`)
                            }else{
                                $('.machine-' + machine.name).html(`<span class="square-10 bg-success animated fadeIn"></span>`)
                            }

                            if(isNaN(oee)) oee = 0;
                            
                            $('.machine-' + machine.id + '-oee').data('easyPieChart')
                                .update(fix_val(oee)), 1;
                                
                            $('.machine-' + machine.id + '-percent-oee').text(fix_val(oee,1));
                                
                            if(isNaN(availability)) availability = 0;
                            $('#avail-machine-' + machine.id).width(fix_val(
                                availability, 0) + '%');
                            $('#avail-machine-' + machine.id + '-index').text(fix_val(
                                availability, 1) + '%');

                            if(isNaN(performance)) performance = 0;
                            $('#perform-machine-' + machine.id).width(fix_val(
                                performance, 0) + '%');
                            $('#perform-machine-' + machine.id + '-index').text(fix_val(
                                performance, 1) + '%');

                            if(isNaN(quality)) quality = 0;
                            $('#quality-machine-' + machine.id).width(fix_val(quality,
                                0) + '%');
                            $('#quality-machine-' + machine.id + '-index').text(fix_val(
                                quality, 1) + '%');
                        }
                    });
                });
                // console.log(data)
            })

        });

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
