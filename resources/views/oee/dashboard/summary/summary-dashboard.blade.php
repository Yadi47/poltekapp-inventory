@extends('oee')

@section('title', $page_title)

@push('css')
<style>

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
<script>

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
                            <h3 class="m-0">Summary</h3>
                        </div>
                    </div>
                    <div class="col-lg-4 text-right d-flex justify-content-end">
                        <select class="nice_Select2 max-width-220">
                            <option value="1">Realtime</option>
                            <!-- <option value="1">Daily</option>
                            <option value="1">Monthly</option> -->
                        </select>
                    </div>
                </div>


            </div>

        </div>
    </div>
</div>

<div class="row">
    @foreach ($oee_machines as $oee_machine)
    <div class="col-xl-3 hilang" id="machine-{{$oee_machine->name}}">
        <div class="card_box p-1 position-relative mb_30 white_bg card__one shadow bd-0 rounded-20  ">
            <div class="white_box_tittle " style="padding:10px">
                <div class="main-title2 ">
                    <div class="machine-{{$oee_machine->name}}"></div>
                    <h6 class="mb-0 nowrap ">{{$oee_machine->ident}}</h6>
                </div>
            </div>

            <div class="card-body  text-center" style="padding:15px">
                <div style="text-align: left;">
                    <div class="progress-group">
                        <span class="tags-overview">Total Quantity </span>
                        <span class="float-right" id="{{$oee_machine->name}}totalQuantity">-</span>
                    </div>
                    <div class="progress-group">
                        <span class="tags-overview">Finish Good </span>
                        <span class="float-right" id="{{$oee_machine->name}}finishGood">-</span>
                    </div>
                    <div class="progress-group">
                        <span class="tags-overview">Reject </span>
                        <span class="float-right" id="{{$oee_machine->name}}reject">-</span>
                    </div>
                    <br>

                    <div class="progress-group">
                        <span class="tags-overview">Runtime Second </span>
                        <span class="float-right" id="{{$oee_machine->name}}runningSecond">-</span>
                    </div>
                    <div class="progress-group">
                        <span class="tags-overview">Runtime Minute </span>
                        <span class="float-right" id="{{$oee_machine->name}}runningMinute">-</span>
                    </div>
                    
                    <br>

                    <div class="progress-group">
                        <span class="tags-overview">Downtime Second </span>
                        <span class="float-right" id="{{$oee_machine->name}}abnormalySecond">-</span>
                    </div>
                    <div class="progress-group">
                        <span class="tags-overview">Downtime Minute </span>
                        <span class="float-right" id="{{$oee_machine->name}}abnormalyMinute">-</span>
                    </div>
                    
                    <br>

                    <div class="progress-group">
                        <span class="tags-overview">OEE </span>
                        <span class="float-right" id="{{$oee_machine->name}}oee">-</span>
                    </div>
                    <div class="progress-group">
                        <span class="tags-overview">Quality </span>
                        <span class="float-right" id="{{$oee_machine->name}}quality">-</span>
                    </div>
                    <div class="progress-group">
                        <span class="tags-overview">Performance </span>
                        <span class="float-right" id="{{$oee_machine->name}}performance">-</span>
                    </div>
                    <div class="progress-group">
                        <span class="tags-overview">Availability </span>
                        <span class="float-right" id="{{$oee_machine->name}}availability">-</span>
                    </div>

                </div>
            </div><!-- card-body -->
        </div><!-- card -->
    </div>
    @endforeach

</div>




@endsection

@push('js')
<script>
    socket.on('toClientRealtimeValuesResults', (data) => {
        oee_machines.forEach(machine => {
            console.log(machine.name)
            data.forEach(d => {
                if (d.TagGroupName === machine.name) {
                    $('#' + machine.name + 'totalQuantity').text(getValue("ProductionQuantity", d
                        .values))
                    $('#' + machine.name + 'finishGood').text(getValue("PassQuantity", d.values))
                    $('#' + machine.name + 'reject').text(getValue("FailQuantity", d.values))

                    $('#' + machine.name + 'runningSecond').text(getValue("RunningTimeSecond", d
                        .values))
                    $('#' + machine.name + 'runningMinute').text(fix_val(getValue(
                        "RunningTimeSecond", d.values) / 60, 2))
                    // $('#' + machine.name + 'runningHour').text(
                    //     fix_val(getValue("RunningTimeHour", d.values), 0)
                    // )
                    $('#' + machine.name + 'abnormalySecond').text(getValue("AbnormalyTimeSecond", d.values))
                    $('#' + machine.name + 'abnormalyMinute').text(fix_val(getValue(
                        "AbnormalyTimeSecond", d.values) / 60, 2))
                    // $('#' + machine.name + 'abnormalyHour').text(
                    //     fix_val(getValue("AbnormalyTimeSecond", d.values)/3600, 0)
                    // )
                    console.log(getValue("RunningTimeSecond", d.values) / 60)
                    let quality = getQuality(getValue("ProductionQuantity", d.values), getValue(
                        "PassQuantity", d.values), getValue("FailQuantity", d.values))
                    
                    let performance = getPerformance(getValue("ProductionQuantity", d.values),
                        getValue("RunningTimeSecond", d.values), 1)

                    let availability = getAvailability(getValue("RunningTimeSecond", d.values) / 60, getValue("AbnormalyTimeSecond", d.values) / 60);

                    let oee = ((quality / 100) * (performance / 100) * (availability / 100)) *
                        100;

                    if(isNaN(oee)){
                        $('.machine-' + machine.name).html(`<span class="square-10 bg-danger"></span>`)
                    }else{
                        $('.machine-' + machine.name).html(`<span class="square-10 bg-success animated fadeIn"></span>`)
                    }

                    if(isNaN(quality)) quality = 0;
                    $('#' + machine.name + 'quality').text(fix_val(quality) + '%')
                    if(isNaN(performance)) performance = 0;
                    $('#' + machine.name + 'performance').text(fix_val(performance) + '%')
                    if(isNaN(availability)) availability = 0;
                    $('#' + machine.name + 'availability').text(fix_val(availability) + '%')
                    if(isNaN(oee)) oee = 0;
                    $('#' + machine.name + 'oee').text(fix_val(oee) + '%')

                }
            });
        });
        // console.log(data)
    })

   

</script>
@endpush
