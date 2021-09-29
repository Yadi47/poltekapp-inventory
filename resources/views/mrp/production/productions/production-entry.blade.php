@extends('mrp')

@section('title', $page_title)

@section('content')
<style>
        .document {
            width: 100%;
            height: 18rem;
            overflow-y: scroll;
            padding-right: .5rem;
            margin-bottom: 1rem;
        }
        .hidden{
            display: none;
        }
        #preloader2 {
    z-index: 999999;
    position: fixed;
    top: 0;
    left: 0;
    background: #ffffffeb;
    width: 100%;
    height: 100%;
}
#loader2 {
    display: block;
    position: relative;
    left: 50%;
    top: 50%;
    width: 150px;
    height: 150px;
    margin: -75px 0 0 -75px;
    border-radius: 50%;
    border: 3px solid transparent;
    border-top-color: #9370DB;
    -webkit-animation: spin 2s linear infinite;
    animation: spin 2s linear infinite;
}

#loader2:before {
            content: "";
            position: absolute;
            top: 5px;
            left: 5px;
            right: 5px;
            bottom: 5px;
            border-radius: 50%;
            border: 3px solid transparent;
            border-top-color: #BA55D3;
            -webkit-animation: spin 3s linear infinite;
            animation: spin 3s linear infinite;
        }

        #loader2:after {
            content: "";
            position: absolute;
            top: 15px;
            left: 15px;
            right: 15px;
            bottom: 15px;
            border-radius: 50%;
            border: 3px solid transparent;
            border-top-color: #FF00FF;
            -webkit-animation: spin 1.5s linear infinite;
            animation: spin 1.5s linear infinite;
        }
@-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
        .processtable:hover{
            color:red;
        }
        .readonly{
            pointer-events: none;
            touch-action: none;
        }
    </style>
<div class="row ">
    <div class="col-xl-12">
        <div class="white_card mb_30 shadow pt-4">
            <div class="white_card_body">
                <div class="QA_section">
                    <div>
                    <form action="{{ route('mrp.production.production-update', $productions->id) }}" method="post">
                            @method('patch')
                            @csrf
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Production Code</label>
                                    <input readonly type="text" value="{{ $productions->production_code }}"
                                        class="form-control @error('production_code') is-invalid @enderror" name="production_code">
                                    @error('production_code')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                <br>
                            </div>
                        </div>   

                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Production Name</label>
                                    <input readonly type="text" value="{{ $productions->production_name }}"
                                        class="form-control @error('production_name') is-invalid @enderror" name="production_name">
                                    @error('production_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Planning Code</label>
                                    <select readonly class="form-control readonly" name="planning_id">
                                        @foreach ($plannings as $planning)
                                            <option value="{{ $planning->id ?? '' }}"
                                                {{ (old('planning_id') ?? ($planning->planning->id ?? '')) == $planning->id ?? '' ? 'selected' : '' }}>
                                                {{ $planning->plan_name ?? '' }}</option>
                                        @endforeach
                                    </select>
                            </div> 
                        </div>

                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Bom Name</label>
                                    <input readonly type="text" value="{{ $productions->bom_id }}" class="form-control @error('bom_id') is-invalid @enderror" name="bom_id">
                                    @error('bom_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="">Shift Code</label>
                                    <select readonly class="form-control readonly " name="shift_id">
                                        @foreach ($shifts as $shift)
                                            <option value="{{ $shift->id }}" {{($productions->shift_id == $shift->id) ? "selected" : "" }}>{{ $shift->shift_name ?? '' }}</option>
                                        @endforeach
                                    </select>
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="">Qty Plan</label>
                                    <input readonly type="text" value="{{ $productions->qty_plan }}"
                                        class="form-control @error('qty_plan') is-invalid @enderror" name="qty_plan" id="qty_plan">
                                    @error('qty_plan')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="">Qty Actual</label>
                                    <input readonly type="text" value="{{ $total_receive }}"
                                        class="form-control @error('qty_entry') is-invalid @enderror" name="qty_entry" id="qty_actual">
                                    @error('qty_entry')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div> 
                        </div>

                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="">Qty Reject</label>
                                    <input type="number" value="{{ $total_reject }}" onkeyup="changeActual()" 
                                        class="form-control @error('qty_reject') is-invalid @enderror" name="qty_reject" id="qty_reject">
                                    @error('qty_reject')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div> 
                        </div>

                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="">Qty Good</label>
                                    <input readonly type="text" value="{{ $total_good }}" id="qty_good"
                                        class="form-control @error('qty_good') is-invalid @enderror" name="qty_good">
                                    @error('qty_good')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div>  
                        </div>

                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Date Start</label>
                                    <input readonly type="date" value="{{ $productions->date_start }}"
                                        class="form-control @error('date_start') is-invalid @enderror" name="date_start">
                                    @error('date_start')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div>  
                        </div>

                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Date Finish</label>
                                <input readonly type="date" value="{{ $productions->date_finish }}"
                                        class="form-control @error('date_finish') is-invalid @enderror" name="date_finish">
                                    @error('date_finish')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div> 
                        </div>

                        <div class="col-lg-3">
                            <div class="form-group">
                                    <label for="">Process </label>
                                    <select class="form-control process" name="process_id">
                                        <option selected disabled>Choose Process</option>
                                        @foreach ($process as $proces)
                                            <option value="{{ $proces->id }}" {{ (old('proces_id') == $proces->id) ? 'selected' : '' }}>{{ $proces->process_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('proces_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>
                        </div>
                        
                        <div class="col-lg-3">
                            <div class="form-group">
                                    <label for="">Machine Code</label>
                                    <select class="form-control machine" name="machine_id">
                                        <option selected disabled>Choose Machine</option>
                                        @foreach ($machines as $machine)
                                            <option value="{{ $machine->id }}" {{ (old('machine_id') == $machine->id) ? 'selected' : '' }}>{{ $machine->machine_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('machine_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Product</label>
                                    <select class="form-control" name="product_id">
                                        @foreach ($products as $product)
                                            <option readonly value="{{ $product->id ?? '' }}"
                                                {{ (old('product_id') ?? ($product->id ?? '')) == $product->id ?? '' ? 'selected' : '' }}>
                                                {{ $product->product_name ?? '' }}</option>
                                        @endforeach
                                    </select>
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="">Recovery Plan</label>
                                <input type="text" value="{{ $productions->recovery_plan }}"
                                        class="form-control @error('recovery_plan') is-invalid @enderror" name="recovery_plan">
                                    @error('recovery_plan')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div> 
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="">Problem</label>
                                    <select class="form-control" name="problem_id">
                                        @foreach ($problems as $problem)
                                            <option value="{{ $problem->id ?? '' }}"
                                                {{ (old('problem_id') ?? ($problem->problem->id ?? '')) == $problem->id ?? '' ? 'selected' : '' }}>
                                                {{ $problem->problem_name ?? '' }}</option>
                                        @endforeach
                                    </select>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Total Defect Rect</label>
                                <input type="text" value="{{ $productions->target_defect_rate }}"
                                        class="form-control @error('target_defect_rate') is-invalid @enderror" name="target_defect_rate">
                                    @error('target_defect_rate')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div> 
                        </div>

                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Total Diffectifity</label>
                                <input type="text" value="{{ $productions->target_effeciency }}"
                                        class="form-control @error('target_effeciency') is-invalid @enderror" name="target_effeciency">
                                    @error('target_effeciency')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div> 
                        </div>

                        
                        

                        </div>
                        <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="QA_table mb_30">
                                        <!-- table-responsive -->
                                        <table class="table lms_table_active3 ">
                                            <thead>
                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Process Name</th>
                                                <th scope="col">Machine</th>
                                                <th scope="col">Receive</th>
                                                <th scope="col">Reject</th>
                                                <th scope="col">Good</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            <!-- @foreach ($process as $process_data)

                                            <tr>
                                                <th scope="row">{{$loop->iteration}}</th>
                                                <td onClick="processClick({{$process_data->id}})" class="process">{{$process_data->process_name}}
                                                
                                                </td>
                                                
                                                <td>{{$process_data->machine->machine_name}}</td>      

                                                @if($productions->problem_id == $process_data->id)
                                                <td>{{$productions->qty_entry}}</td>                                                
                                                <td>{{$productions->qty_reject}}</td>                                                
                                                <td>{{$productions->qty_good}}</td>                                                
                                                @endif
                                            
                                            </tr>
                                             @endforeach -->
                                             
                                             @foreach ($process_wip as $pw)
                                            <tr>
                                                <th scope="row">{{$loop->iteration}}</th>
                                                <td>{{$pw->process_name}}</td>
                                                <td>{{$pw->process_name}}</td>
                                                
                                                <td>
                                                <input type="number" class="form-control-sm" name ="qty_receive_oee">    
                                                <span class="d-block">{{$pw->receive}}</span>
                                                </td>

                                                <td>
                                                <input type="number" class="form-control-sm" name ="qty_reject_oee">    
                                                <span class="d-block">{{$pw->reject}}</span>
                                                </td>

                                                <td>
                                                <input type="number" class="form-control-sm" name = "qty_good_oee">    
                                                <span class="d-block">{{$pw->good}}</span>    
                                                </td>
                                            
                                            </tr>
                                             @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div> 
                                
                            </div>
                    </div>  
                           
                                 
                    <a href="{{ route('mrp.production.production-list') }}">
                        <button type="button" class="btn btn-warning btn-sm">
                    <i class="ti-back-left"></i>
                    Back</button>
                    </a>
                    <button class="btn btn-success btn-sm">
                <i class="ti-save"></i>
                Save</button>
                        </form>
                    </div>

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
<script>
    $(document).ready(function() {
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

        $(function(){
            bdCustomFile.init();
        });

        $(document).ready(function(){
            $(".btn-add").click(function(){
                let markup = $(".invisible").html();
                $(".increment").append(markup);
            });
            $("body").on("click",".btn-remove", function(){
                $(this).parents(".test").remove();
            })
        })

</script>

<script>
    
    if ($('.lms_table_active3').length) {
        $('.lms_table_active3').DataTable({
        });
    }

// planning Quantity
    $('#process_id').change(function(){
        axios.get("/mrp/planning/api/" + $(this).val())
            .then(function (response) {
                // handle success
                $('#qty_plan').val(response.data.plan_qty)
                $('#qty_actual').val(response.data.plan_qty)
                $('#qty_reject').val(0)
                $('#qty_good').val(response.data.plan_qty)
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            })
            .then(function () {
                // always executed
            });
    })

    function changeActual() {
        let reject = $('#qty_reject').val()
        let good = $('#qty_good').val()
        
        $('#qty_actual').val(Number(reject) + Number(good))
    }


    // process click
    function processClick(id){
        $('#preloader').css('display','inline')
        axios.get("/mrp/production/api/process/" + id)
            .then(function (response) {
                // handle success
                let selectMachine = `.machine option[value="${response.data.machine_id}"]`;
                $(selectMachine).prop('selected', true);
                
                let selectProcessCode = `.process option[value="${response.data.id}"]`;
                $(selectProcessCode).prop('selected', true);
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            })
            .then(function () {
                // always executed
            $('#preloader').css('display','none')
            });
    }
    
    

</script>
@endpush
