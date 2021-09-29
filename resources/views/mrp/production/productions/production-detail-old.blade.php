@extends('mrp')

@section('title', $page_title)

@section('content')
<style>
    .document {
        width: 100%;
        height: 30rem;
        overflow-y: scroll;
        padding-right: .5rem;
        margin-bottom: 1rem;
    }

    .table tr {
        cursor: auto;
        border: solid 1px #DEE2E6;
    }

    /* CSS REPORT  */
    .report {
        table-layout: fixed;
        text-align: center
    }

    .report td {
        padding: 5px 15px;
    }


    .pan {
        font-size: 11px;
    }



    .actual {
        color: #697AAB;
        font-weight: bold
    }

    .ng {
        color: #A94147;
        font-weight: bold
    }



    table.table-bordered>tbody>tr>td {
        border: 0.5px solid #84757F !important;
        border-width: 0px;
    }
/*    
    .report tbody>td{
        border:1px dotted #000000;
        padding:5px;
    }
    .report tbody>td:first-child{
        border-left:0px solid #000000;
    } */
    .report thead>tr>th{
        border:0.5px solid #84757F;
    }
    
    .value-report{
            font-weight: 900;
        font-size: 11px;
        display: block;
    }

</style>
<div class="row ">
    <div class="col-xl-12">
        <div class="white_card mb_30 shadow pt-4">
            {{-- <form action="{{route('mrp.production.production-store')}}" method="post"> --}}
                <div class="white_card_body">
                    <div class="QA_section">
                        @csrf
                        <div class="row">
                        <div class="form-group">
                        <a href="{{ route('mrp.production.production-list') }}">
                            <button type="button" class="btn btn-warning btn-sm">
                                <i class="ti-back-left"></i>
                                Back</button>
                        </a>
                    </div>
                </div>
                        <h4 style="color: chocolate">Planning Details</h4>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Choose Planning </label>
                                    <select class="form-control @error('planning_id') is-invalid @enderror" onchange="setPlanning()" id="planning_id"
                                        name="planning_id" required>
                                        <option value="{{$production->planning_id}}">
                                            {{ $production->planning->plan_code }} |
                                            {{ $production->planning->plan_name }}</option>

                                    </select>
                                    @error('planning_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Planning Name</label>
                                    <input type="text" value="{{old('planning_name')}}"
                                        class="form-control @error('planning_name') is-invalid @enderror"
                                        id="planning_name" name="planning_name" disabled>
                                    @error('planning_name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <br>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Planning Code</label>
                                    <input type="text" value="{{old('planning_code')}}"
                                        class="form-control @error('planning_code') is-invalid @enderror"
                                        name="planning_code" id="planning_code" disabled>
                                    @error('planning_code')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <br>
                                </div>
                            </div>
                        </div>
                        <h4 style="color: chocolate">Production Details</h4>
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">Production Code</label>
                                    <input type="text" value="{{$production->production_code}}" readonly
                                        class="form-control @error('production_code') is-invalid @enderror"
                                        id="production_code" name="production_code">
                                    @error('production_code')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <br>
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">Production Name</label>
                                    <input type="text" value="{{$production->production_name}}" readonly
                                        class="form-control @error('production_name') is-invalid @enderror"
                                        id="production_name" name="production_name" required>
                                    @error('production_name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <br>
                                </div>
                            </div>





                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="">Date Start</label>
                                    <input type="text" readonly class="form-control digits minMaxExample
                                        @error('date_start') is-invalid @enderror" value="{{ $production->date_start }}" id="" name="date_start"
                                        autocomplete="off" required>
                                    @error('date_start')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <br>
                                </div>
                            </div>

                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="">Date Finish</label>
                                    <input type="text" readonly class="form-control digits minMaxExample
                                        @error('date_finish') is-invalid @enderror" id="" value="{{ $production->date_finish }}" name="date_finish"
                                        autocomplete="off" required>
                                    @error('date_finish')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <br>
                                </div>
                            </div>

                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="">Recovery Plan</label>
                                    <input type="number" min="0" value="{{ $production->recovery_plan}}"
                                        class="form-control @error('recovery_plan') is-invalid @enderror"
                                        name="recovery_plan" id="recovery_plan" required readonly>
                                    @error('recovery_plan')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <br>
                                </div>
                            </div>


                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="">Target Defect Rate</label>
                                    <input type="number" min="0" value="{{ $production->target_defect_rate }}"
                                        class="form-control @error('target_defect_rate') is-invalid @enderror"
                                        name="target_defect_rate" id="target_defect_rate" required readonly>
                                    @error('target_defect_rate')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <br>
                                </div>
                            </div>

                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="">Target Effectifity</label>
                                    <input type="number" min="0" value="{{ $production->target_effeciency }}"
                                        class="form-control @error('target_effeciency') is-invalid @enderror"
                                        name="target_effeciency" id="target_effeciency" required readonly>
                                    @error('target_effeciency')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <br>
                                </div>
                            </div>
                        </div>

                        <h4 style="color: chocolate">Process WIP</h4>
                       
                        <div class="row" >
                            <div class="col-lg-12">
                                
                                <div class=" responsive" style="display: none">
                                    <table class="table datatable-wip" style="width: 100%;text-align:left ;">
                                        
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Process Name</th>
                                                <th>Machine Name</th>
                                                <th>Product Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($production_process_machine as $ppm)
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$ppm->process->process_name}}</td>
                                                    <td>{{$ppm->machine->machine_name}}</td>
                                                    <td>
                                                        <span style="display: block;font-weight:bold;margin-bottom:5px">
                                                            {{$ppm->product->product_name}}
                                                        </span>
                                                        <form method="post" action="{{route('mrp.production.production-wip-save',$ppm->id)}}">
                                                            @csrf
                                                            <input type="date" required  name="date" min="{{$production->date_start}}" max="{{$production->date_finish}}">
                                                            <select id="" required  name="shift_id">
                                                                @foreach ($shifts as $sfts)
                                                                    <option value="{{$sfts->id}}">{{$sfts->shift_name}}</option>
                                                                @endforeach
                                                            </select>
                                                            <select id="" required  name="bom_id">
                                                                <option value="">-- Select Bom</option>
                                                                @foreach ($boms as $bom)
                                                                    <option value="{{$bom->id}}">{{$bom->bom_code}} |  {{$bom->bom_name}}</option>
                                                                @endforeach
                                                            
                                                            </select>
                                                            <select id="" required  name="type">
                                                                <option value="">-- Select Type</option>
                                                                <option value="WIP">WIP</option>
                                                                <option value="FINISH GOOD">FINISH GOOD</option>
                                                            
                                                            </select>

                                                            <input type="number" min="0"  required name="qty_plan" placeholder="Qty Plan">
                                                            <input type="number" min="0"  required name="qty_total" placeholder="Qty Actual">
                                                            <input type="number" min="0"  required name="qty_good" placeholder="Qty Good">
                                                            <input type="number" min="0"  required name="qty_reject" placeholder="Qty Reject">
                                                            <button type="submit">Add WIP</button>
                                                        </form>
                                                    </td>
                                                    
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                 @if(Session::has('message'))
                                    <div class="alert  {{ Session::get('alert-class', 'alert-info') }} d-flex align-items-center justify-content-between" role="alert">
                                        <div class="alert-text">
                                            <span>{!! Session::get('message') !!}</span>
                                        </div>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <i class="ti-close  f_s_14"></i>
                                        </button>
                                    </div>
                                @endif
                                <div style="border: solid 1px black;border-radius:20px;margin-top:15px;margin-bottom:15px;padding:20px;">
                                    <form method="post" action="{{route('mrp.production.production-wip-save',0)}}">
                                        @csrf
                                        <h5 for="">Input WIP</h5>
                                        <div class="form-group">
                                            <label for="" >Select Process :</label>
                                            <select class="form-control" name="processId" id="">
                                                @foreach ($production_process_machine as $ppm)
                                                    <option value="{{$ppm->id}}">{{$ppm->process->process_name}} | {{$ppm->machine->machine_name}} | {{$ppm->product->product_name}}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Select Date :</label>
                                            <input class="form-control" type="date" required  name="date" min="{{$production->date_start}}" max="{{$production->date_finish}}">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Select Shift :</label>
                                            <select id="" class="form-control" required  name="shift_id">
                                                @foreach ($shifts as $sfts)
                                                    <option value="{{$sfts->id}}">{{$sfts->shift_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Select Bom :</label> 
                                            <select id="" required class="form-control" name="bom_id">
                                                <option value="">-- Select Bom</option>
                                                @foreach ($boms as $bom)
                                                    <option value="{{$bom->id}}">{{$bom->bom_code}} |  {{$bom->bom_name}}</option>
                                                @endforeach
                                            
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Select Type :</label> 
                                            <select id="" required class="form-control" name="type">
                                                <option value="">-- Select Type</option>
                                                <option value="WIP">WIP</option>
                                                <option value="FINISH GOOD">FINISH GOOD</option>
                                            
                                            </select>
                                        </div>
                                        <div class="">
                                            <label for="">WIP </label>
                                            <input type="number" min="0"  required name="qty_plan" placeholder="Qty Plan">
                                            <input type="number" min="0"  required name="qty_total" placeholder="Qty Actual">
                                            <input type="number" min="0"  required name="qty_good" placeholder="Qty Good">
                                            <input type="number" min="0"  required name="qty_reject" placeholder="Qty Reject">
                                            <input type="number" min="0"  required name="qty_recovery_plan" placeholder="Recovery Plan">
                                        </div>
                                        <button class="btn btn-sm btn-success " style="margin-top: 50px;">SAVE WIP</button>
                                    </form>
                                    
                                </div>
                            </div>


                        </div>
                        
                        <h4 id="report_detail" style="color: chocolate">Report Details</h4>
                        
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="table-responsive ">

                                    @foreach ($list_process as $process_name => $lp)
                                    <table class="report table-bordered " style="font-size: 11px;margin-bottom:20px;">
                                        <thead>
                                            <tr>
                                                <th width="20px">No</th>
                                                <th colspan="2">{{$process_name}}</th>
                                                <th>Item</th>
                                                @foreach ($date_list_header as $dlh)
                                                <th width="30" style="width: 50px !important;">{{$dlh}}</th>
                                                @endforeach
                                                
                                            </tr>
                                        </thead>
                                    


                                        @foreach ($lp as $machine_name => $item)
                                        @php
                                        $isR = 0;
                                        @endphp
                                        @foreach ($item as $key => $v)
                                        @php
                                        if(count($item)>1){
                                        $rowSpan = count($item);
                                        $isGenerate = false;
                                        $isR++;
                                        }else{
                                        $rowSpan = '';
                                        $isGenerate = true;
                                        $isR = 0;
                                        }
                                        
                                        @endphp
                                        
                                        <tr>
                                            {{-- machine name --}}
                                            @if ($rowSpan>1)
                                            @if ($isR == 1)
                                            <td rowSpan="{{($rowSpan*3) *$shifts->count() }}">{{$machine_name}}</td>
                                            @endif
                                            @else
                                            <td rowSpan="{{3*$shifts->count()}}">{{$machine_name}}</td>
                                            @endif
                                            {{-- part name --}}
                                            @foreach ($v as $k => $v2)
                                            <td width="10px" rowspan="{{3*$shifts->count()}}">
                                                <span class="d-block" style="font-size: 20px;width:50px;font-weight:bold;word-wrap: break-word">{{$k}}</span>
                                            </td>
                                            @endforeach

                                        @foreach ($shifts as $shift)

                                            
                                            @if ($loop->iteration == 1)
                                            
                                                    <!-- SHIFT FIRST -->
                                                    <td rowspan="3">{{$shift->shift_name}}</td>
                                                    <td>
                                                        <span class="pan plan">Plan</span>
                                                    </td>
                                                    @foreach ($v2['from_wip'] as $kp => $dataProcess)
                                                    
                                                        @foreach ($dataProcess as $dp => $dataProc)
                                                            @if ($dataProc['shift_id'] === $shift->id)
                                                                <td style="background: {{$dataProc['type'] === 'WIP' ? '#d9dee1' : '#2CA44C'}}">
                                                                    <span class="value-report " style="color:black" > 
                                                                        {{$dataProc['qty_plan']}}
                                                                    </span>

                                                                    @foreach ($v2['from_oee'][$kp] as $ddp)
                                                                        {{-- chek dari oee --}}
                                                                        @if ($ddp['shift_id'] === $shift->id)
                                                                            <span class="value-report" style="color:green" > 
                                                                                {{$ddp['qty_plan']}}
                                                                                
                                                                            </span>
                                                                        @endif
                                                                    @endforeach
                                                                </td>
                                                            @else
                                                                
                                                                @if (count($dataProcess) <= 1)
                                                                    <td>
                                                                        <span class="value-report " style="color:black" > 
                                                                            {{$dataProc['qty_plan']}}
                                                                        </span>
                                                                        <span class="value-report">-</span>
                                                                        @foreach ($v2['from_oee'][$kp] as $ddp)
                                                                            {{-- chek dari oee --}}
                                                                            @if ($ddp['shift_id'] === $shift->id)
                                                                                <span class="value-report" style="color:green" > 
                                                                                    {{$ddp['qty_plan']}}
                                                                                </span>
                                                                            @endif
                                                                        
                                                                        @endforeach
                                                                    </td>  
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    @endforeach
                                                   
                                                   
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <span class="pan actual">Actual</span>
                                                    </td>
                                                    @foreach ($v2['from_wip'] as $kp =>$dataProcess)
                                                        @foreach ($dataProcess as $dp => $dataProc)
                                                            @if ($dataProc['shift_id'] === $shift->id)
                                                                <td style="background: {{$dataProc['type'] === 'WIP' ? '#d9dee1' : '#2CA44C'}}">
                                                                    <span class="value-report " style="color:black" > 
                                                                        {{$dataProc['qty_total']}}
                                                                    </span>

                                                                    @foreach ($v2['from_oee'][$kp] as $ddp)
                                                                        {{-- chek dari oee --}}
                                                                        @if ($ddp['shift_id'] === $shift->id)
                                                                            <span class="value-report" style="color:green" > 
                                                                                {{$ddp['qty_total']}}
                                                                            </span>
                                                                        @endif
                                                                    @endforeach
                                                                </td>
                                                            @else
                                                                @if (count($dataProcess) <= 1)
                                                                    <td>
                                                                        <span class="value-report">-</span>
                                                                        @foreach ($v2['from_oee'][$kp] as $ddp)
                                                                            {{-- chek dari oee --}}
                                                                            @if ($ddp['shift_id'] === $shift->id)
                                                                                <span class="value-report" style="color:green" > 
                                                                                    {{$ddp['qty_good']}}
                                                                                </span>
                                                                            @endif
                                                                        
                                                                        @endforeach
                                                                    </td>  
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    @endforeach
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <span class="pan ng">NG</span>
                                                    </td>
                                                    @foreach ($v2['from_wip'] as $kp =>$dataProcess)
                                                        @foreach ($dataProcess as $dataProc)
                                                            @if ($dataProc['shift_id'] === $shift->id)
                                                                <td style="background: {{$dataProc['type'] === 'WIP' ? '#d9dee1' : '#2CA44C'}}">
                                                                    <span class="value-report " style="color:black" > 
                                                                        {{$dataProc['qty_reject']}}
                                                                    </span>

                                                                    {{-- chek dari oee --}}
                                                                    @foreach ($v2['from_oee'][$kp] as $ddp)
                                                                        <span class="value-report" style="color:green" > 
                                                                            @if ($ddp['shift_id'] === $shift->id)
                                                                            {{$ddp['qty_reject']}}
                                                                            @endif
                                                                        </span>
                                                                    @endforeach
                                                                </td>
                                                            @else
                                                                @if (count($dataProcess) <= 1)
                                                                    <td>
                                                                        <span class="value-report">-</span>
                                                                        @foreach ($v2['from_oee'][$kp] as $ddp)
                                                                            {{-- chek dari oee --}}
                                                                            @if ($ddp['shift_id'] === $shift->id)
                                                                                <span class="value-report" style="color:green" > 
                                                                                    {{$ddp['qty_reject']}} 
                                                                                </span>
                                                                            @endif
                                                                        
                                                                        @endforeach
                                                                    </td>  
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    @endforeach
                                                    
                                                </tr>
                                            <!-- -->
                                                
                                            @else
                                                {{-- SHIFT 2 --}}
                                                <div class="shift2">
                                                    <tr>
                                                        <td rowspan="3">{{$shift->shift_name}}</td>
                                                        <td>
                                                            <span class="pan plan">Plan</span>
                                                        </td>
                                                        @foreach ($v2['from_wip'] as $kp =>$dataProcess)
                                                            @foreach ($dataProcess as $dataProc)
                                                                @if ($dataProc['shift_id'] === $shift->id)
                                                                    <td>
                                                                        <span class="value-report " style="color:black" > 
                                                                            {{$dataProc['qty_plan']}}
                                                                        </span>
                                                                         {{-- chek dari oee --}}
                                                                        @foreach ($v2['from_oee'][$kp] as $ddp)
                                                                            <span class="value-report" style="color:green" > 
                                                                                @if ($ddp['shift_id'] === $shift->id)
                                                                                {{$ddp['qty_plan']}}
                                                                                @endif
                                                                            </span>
                                                                            @endforeach
                                                                    </td>
                                                                @else
                                                                    @if (count($dataProcess) <= 1)
                                                                        <td>
                                                                            <span class="value-report"> {{$dataProc['qty_plan']}}</span>
                                                                            
                                                                            @foreach ($v2['from_oee'][$kp] as $ddp)
                                                                                {{-- chek dari oee --}}
                                                                                <span class="value-report" style="color:green" > 
                                                                                    @if($ddp['shift_id'] === $shift->id)
                                                                                        <span class="value-report" style="color:green" > 
                                                                                            {{$ddp['qty_plan']}} 
                                                                                        </span>
                                                                                    @endif
                                                                                </span>
                                                                            @endforeach
                                                                        </td>  
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        @endforeach
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <span class="pan actual">Actual</span>
                                                        </td>
                                                        @foreach ($v2['from_wip'] as $kp =>$dataProcess)
                                                            @foreach ($dataProcess as $dataProc)
                                                                @if ($dataProc['shift_id'] === $shift->id)
                                                                    <td>
                                                                        <span class="value-report " style="color:black" > 
                                                                            {{$dataProc['qty_good']}}
                                                                        </span>{{-- chek dari oee --}}
                                                                        @foreach ($v2['from_oee'][$kp] as $ddp)
                                                                            <span class="value-report" style="color:green" > 
                                                                                @if ($ddp['shift_id'] === $shift->id)
                                                                                {{$ddp['qty_good']}}
                                                                                @endif
                                                                            </span>
                                                                            @endforeach
                                                                    </td>
                                                                @else
                                                                    @if (count($dataProcess) <= 1)
                                                                        <td>
                                                                            <span class="value-report">-</span>
                                                                            
                                                                            @foreach ($v2['from_oee'][$kp] as $ddp)
                                                                                {{-- chek dari oee --}}
                                                                                <span class="value-report" style="color:green" > 
                                                                                    @if($ddp['shift_id'] === $shift->id)
                                                                                        <span class="value-report" style="color:green" > 
                                                                                            {{$ddp['qty_good']}} 
                                                                                        </span>
                                                                                    @endif
                                                                                </span>
                                                                            @endforeach
                                                                        </td>  
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        @endforeach
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <span class="pan ng">NG</span>
                                                        </td>
                                                        @foreach ($v2['from_wip'] as $kp =>$dataProcess)
                                                            @foreach ($dataProcess as $dataProc)
                                                                @if ($dataProc['shift_id'] === $shift->id)
                                                                    <td>
                                                                        <span class="value-report " style="color:black" > 
                                                                            {{$dataProc['qty_reject']}}
                                                                        </span>
                                                                        {{-- chek dari oee --}}
                                                                        @foreach ($v2['from_oee'][$kp] as $ddp)
                                                                            <span class="value-report" style="color:green" > 
                                                                                @if ($ddp['shift_id'] === $shift->id)
                                                                                {{$ddp['qty_reject']}}
                                                                                @endif
                                                                            </span>
                                                                            @endforeach
                                                                    </td>
                                                                @else
                                                                    @if (count($dataProcess) <= 1)
                                                                        <td>
                                                                            <span class="value-report">-</span>
                                                                            
                                                                            @foreach ($v2['from_oee'][$kp] as $ddp)
                                                                                {{-- chek dari oee --}}
                                                                                <span class="value-report" style="color:green" > 
                                                                                    @if($ddp['shift_id'] === $shift->id)
                                                                                        <span class="value-report" style="color:green" > 
                                                                                            {{$ddp['qty_reject']}} 
                                                                                        </span>
                                                                                    @endif
                                                                                </span>
                                                                            @endforeach
                                                                        </td>  
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        @endforeach
                                                    </tr>
                                                </div>
                                            @endif

                                        @endforeach

                                        


                                        @endforeach
                                        @endforeach
                                    </table>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>


                    
                    
                </div>
            {{-- </form> --}}
        </div>
    </div>
</div>
</div>
</div>
@endsection

@push('css')
<!-- datatable CSS -->
<link rel="stylesheet" href="{{asset('assets')}}/vendors/datatable/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="{{asset('assets')}}/vendors/datatable/css/responsive.dataTables.min.css" />
<link rel="stylesheet" href="{{asset('assets')}}/vendors/datatable/css/buttons.dataTables.min.css" />
<!-- datepicker  -->
<link rel="stylesheet" href="{{ asset('assets') }}/vendors/datepicker/date-picker.css">

<style>
    .table tr {
        cursor: pointer;
    }

    .table-hover-custom>tbody>tr:hover {
        background-color: #d1cfcfda !important;
    }

</style>
@endpush
@push('js')
<script src="{{asset('assets')}}/vendors/datatable/js/jquery.dataTables.min.js"></script>
<script src="{{asset('assets')}}/vendors/datatable/js/dataTables.responsive.min.js"></script>
<script src="{{asset('assets')}}/vendors/datatable/js/dataTables.buttons.min.js"></script>
<!-- date picker  -->
<script src="{{ asset('assets') }}/vendors/datepicker/datepicker.js"></script>
<script src="{{ asset('assets') }}/vendors/datepicker/datepicker.en.js"></script>
<script src="{{ asset('assets') }}/vendors/datepicker/datepicker.custom.js"></script>
<script>
    $(document).ready(function () {
        $('.js-example-basic-multiple').select2();
    });
    $("#e1").select2();
    $("#checkbox").click(function () {
        if ($("#checkbox").is(':checked')) {
            $("#e1 > option").prop("selected", "selected");
            $("#e1").trigger("change");
        } else {
            $("#e1 > option").removeAttr("selected");
            $("#e1").val("");
            $("#e1").trigger("change");
        }
    });

    $("#button").click(function () {
        alert($("#e1").val());
    });

    $("select").on("select2:select", function (evt) {
        var element = evt.params.data.element;
        var $element = $(element);
        $element.detach();
        $(this).append($element);
        $(this).trigger("change");
    });

    $(function () {
        bdCustomFile.init();
    });

    $(document).ready(function () {
        $(".btn-add").click(function () {
            let markup = $(".invisible").html();
            $(".increment").append(markup);
        });
        $("body").on("click", ".btn-remove", function () {
            $(this).parents(".test").remove();
        })
    })

</script>

<script>
    // $('.row-permission').click(function () {
    //     let data = $(this).find('td input:checkbox');
    //     console.log(data.prop('checked', !data.is(':checked')));
    // });
    // $('#checkAll').click(function (e) {
    //     // var table= $(e.target).closest('.table');
    //     let find = $('.lms_table_active3').find('tr td input:checkbox').prop('checked', true);
    //     console.log(find);
    // });
    // $('#uncheckAll').click(function (e) {
    //     // var table= $(e.target).closest('.table');
    //     let find = $('.lms_table_active3').find('tr td input:checkbox').prop('checked', false);
    //     console.log(find);
    // });

    // --- initial page
    setPlanning();
    $(document).ready(function () {
        $('.js-example-basic-multiple').select2();
    });


    // --- detail process
    function rowProcess(ip, process) {
        let trProcess = `<tr> 
                    <td>${ip}</td>
                    <td>${process.process_name}</td>
                    <td>
                        <table class="table table-bordered">
                           `;
        process.process_machines.forEach(procesMachine => {
            trProcess += rowMachine(procesMachine, process)
        });
        trProcess += `
                        </table>
                    </td>
                </tr>`;

        return trProcess;
    }

    function rowMachine(machine, process) {
        return `<tr>
                    <td>MACHINE 2</td>
                    <td>
                        <div class="form-group">
                            <select placeholder="CHOOSE PRODUCT" class="form-control js-example-basic-multiple" name="product[${process.id}_${machine.id}][]"
                                multiple="multiple" required>
                                <option disabled >CHOOSE PRODUCT</option>
                                @foreach ($products as $product)
                                <option  value="{{ $product->id }}"  {{ (old('product') == $product->id) ? 'selected' : '' }}>
                                    
                                    {{ $product->product_code }} | {{ $product->product_name }} | {{ $product->part_name }}</option>
                                @endforeach
                            </select>
                             
                        </div>
                    </td>
                </tr>`
    }

    // --- planning
    async function setPlanning() {
        $('#detailProcess').html("");
        let planning_id = $('#planning_id').val();

        try {
            let resp = await axios.get("/mrp/planning/api/" + planning_id);
            let data = resp.data;
            console.log(data)
            let planning = data.planning_detail;
            // --- set planning detail
            console.log('SET PLANNING DETAIL')
            $('#planning_name').val(planning.plan_name);
            $('#planning_code').val(planning.plan_code);

            // --- set process
            let processTable = '';
            let ip = 0;
            data.process.forEach(prcs => {
                ip++;
                processTable += rowProcess(ip, prcs);
            });

            $('#detailProcess').html(processTable);
            $('.js-example-basic-multiple').select2();




        } catch (error) {
            console.log(error)
        }
    }

    $('.datatable-wip').DataTable({
         "pageLength": 3
    });

    
    if ($('.lms_table_active3').length) {
        $('.lms_table_active3').DataTable({
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
            paging: true
        });
    }


    function changeActual() {
        let reject = $('#qty_reject').val()
        let good = $('#qty_good').val()

        $('#qty_actual').val(Number(reject) + Number(good))
    }

</script>
@endpush
