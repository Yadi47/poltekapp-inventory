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
        /* padding: 3px ​7px; */
        padding: 5px 6px;
    }


    .pan {
        font-size: 10px;
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
        font-size: 10px;
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
                        <a href="{{ route('mrp.report_planning-list') }}">
                            <button type="button" class="btn btn-warning btn-sm">
                                <i class="ti-back-left"></i>
                                Back</button>
                            
                        </a>
                        <button type="button" onclick="getPDF()" class="btn btn-danger btn-sm">
                                <i class=""></i>
                                Download PDF</button>
                    </div>
                </div>
                         
                        
                        <h4 id="report_detail" style="color: chocolate">Report Details</h4>
                        <div></div>
                        <div class="row canvas_div_pdf">
                            <div class="col-lg-12">
                                <div class="table-responsive ">
                                    <table class="report table-bordered" style="font-size: 11px;">

                                <tbody>
                                    <tr>
                                        {{--  --}}
                                        <td rowspan="6">
                                            <img style="width: 100px;height: 51px;"
                                                src="{{ asset('assets') }}/img/itokin.png" alt="">

                                        </td>

                                        {{--  --}}
                                        <td width="100px">Nama Proses </td>
                                        <td width="170px">: <span style="font-weight: 800">{{$production->production_name}}</span></td>

                                        {{--  --}}
                                        <td rowspan='2' width="180px" style="text-align: center">
                                            <span style="font-weight: 800;font-size:15px">CHECK SHEET</span>
                                        </td>

                                        {{--  --}}
                                        <td width="100px">No.Dokumen </td>
                                        <td width="130px">: <span style="font-weight: ">{{$production->production_code}} </span></td>

                                        {{--  --}}
                                        <td rowspan="3" width="70px" style="text-align: left">
                                            <span style="font-size:15px;font-weight: 800">PLAN </span>
                                        </td>

                                        {{--  --}}
                                        <td width="90px" style="text-align: center">Mengetahui</td>

                                        {{--  --}}
                                        <td width="90px" style="text-align: center">Diperiksa</td>

                                        {{--  --}}
                                        <td width="90px" style="text-align: center">Dibuat</td>


                                        {{--  --}}
                                        <td rowspan="4" colspan="3" width="170px" style="vertical-align: top;">
                                            <span style="display: block">Bulan Produksi</span>
                                            <span
                                                style="font-size: 22px;display: block;text-align: center;margin-top: 10px;"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        {{--  --}}
                                        <td>No Proses </td>
                                        <td>: <span style="font-weight: 800"> </span></td>

                                        {{--  --}}
                                        <td width="">Tgl Pembuatan </td>
                                        <td width="">: <span style="font-weight: "> </span></td>


                                        {{--  --}}
                                        <td rowspan="2">
                                            
                                        </td>
                                        <td rowspan="2">
                                        </td>
                                        <td rowspan="2">
                                        </td>

                                    </tr>
                                    <tr>
                                        {{--  --}}
                                        <td>Nama Mesin </td>
                                        <td>: <span style="font-weight: 800"> </span></td>

                                        {{--  --}}
                                        <td rowspan='4' width="200px" style="text-align: center">
                                            <span style="font-weight: 800;font-size:17px">PLANNING PRODUCTION </span>
                                        </td>

                                        {{--  --}}
                                        <td width="">No.Revisi </td>
                                        <td width="">: <span style="font-weight: ">00 </span></td>


                                    </tr>
                                    <tr>
                                        {{--  --}}
                                        <td>No Mesin </td>
                                        <td>: <span style="font-weight: 800"> </span></td>

                                        {{--  --}}
                                        <td width="">Tgl Revisi </td>
                                        <td width="">: <span style="font-weight: "> </span></td>

                                        {{--  --}}
                                        <td rowspan="3" width="70px" style="text-align: left">
                                            <span style="font-size:15px;font-weight: 800">RESULT </span>
                                        </td>

                                        {{--  --}}
                                        <td rowspan="2">

                                        </td>
                                        <td rowspan="2"></td>
                                        <td rowspan="2"></td>

                                    </tr>
                                    <tr>
                                        {{--  --}}
                                        <td>Nama Part </td>
                                        <td>: <span style="font-weight: 800"> </span></td>

                                        {{--  --}}
                                        <td width="">Halaman </td>
                                        <td width="">: <span style="font-weight: s"> </span></td>

                                        {{--  --}}
                                        <td width="10px" rowspan="2">Tgl :</td>
                                        <td width="56px" rowspan="2">{!! $date !!}</td>
                                        <td width="56px" rowspan="2">Rev : 00</td>
                                    </tr>

                                    <tr>
                                        {{--  --}}
                                        <td>No Part </td>
                                        <td>: <span style="font-weight: 800">ALL MODEL</span></td>

                                        {{--  --}}
                                        <td width="">Departemen </td>
                                        <td width="">: <span style="font-weight: ">Produksi </span></td>

                                        {{--  --}}
                                        <td style="text-align: center">Division Head</td>
                                        <td style="text-align: center" colspan="2">Dept.Head</td>

                                    </tr>


                                </tbody>
                            </table>
                                    @foreach ($list_process as $process_name => $lp)
                                    <table class="report table-bordered " style="font-size: 11px;margin-bottom:20px;">
                                        <thead>
                                            <tr>
                                                <th width="20px">No</th>
                                                <th colspan="2">{{$process_name}}</th>
                                                <th>Item</th>
                                                @foreach ($date_list_header as $key => $dlh)
                                                <th width="30" style="width: 50px !important; background:{{$date_list_color[$key]}}">{{$dlh}}</th>
                                                @endforeach
                                                <th>Sum</th>
                                                
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
                                            <td rowSpan="{{($rowSpan*1) *$shifts->count() }}">{{$machine_name}}</td>
                                            @endif
                                            @else
                                            <td rowSpan="{{1*$shifts->count()}}">{{$machine_name}}</td>
                                            @endif
                                            {{-- part name --}}
                                            @foreach ($v as $k => $v2)
                                            <td width="10px" rowspan="{{1*$shifts->count()}}">
                                                <span class="d-block" style="font-size: 20px;width:50px;font-weight:bold;word-wrap: break-word">{{$k}}</span>
                                            </td>
                                            @endforeach
                                             
                                        @foreach ($shifts as $shift)

                                            @php
                                                $sum1 = 0;
                                                $sum2 = 0;
                                            @endphp
                                            @if ($loop->iteration == 1)
                                            
                                                    <!-- SHIFT FIRST -->
                                                   
                                                    <td rowspan="1">{{$shift->shift_name}}</td>
                                                    <td>
                                                        <span class="pan plan">Plan</span>
                                                    </td>
                                                   
                                                    @foreach ($v2['from_wip'] as $kp => $dataProcess)
                                                    
                                                        @foreach ($dataProcess as $dp => $dataProc)
                                                            
                                                            @if ($dataProc['shift_id'] === $shift->id)
                                                                @php
                                                                    $sum1 += ($dataProc['qty_plan'] === '-') ? 0 :$dataProc['qty_plan'];
                                                                @endphp
                                                                {{-- @php
                                                                    $sum1 = $dataProc['sum_plan'];
                                                                @endphp --}}
                                                                <td style="background: {{$dataProc['color'] != '' ? $dataProc['color'] : (($dataProc['type'] === 'WIP' ? '#d9dee1' : '#2CA44C'))}} ">
                                                                {{-- <td style="background: {{$dataProc['type'] === 'WIP' ? '#d9dee1' : '#2CA44C'}}"> --}}
                                                                    <span class="value-report " style="color:black" > 
                                                                        {{$dataProc['qty_plan']}}
                                                                    </span>
                                                               
                                                                    @foreach ($v2['from_oee'][$kp] as $ddp)
                                                                        {{-- chek dari oee --}}
                                                                        @if ($ddp['shift_id'] === $shift->id)
                                                                            <span class="value-report" style="color:green" > 
                                                                                {{$ddp['qty_plan']->pivot->quantity}}
                                                                            </span>
                                                                        @endif
                                                                    @endforeach
                                                                </td>
                                                            @else
                                                                
                                                                @if (count($dataProcess) <= 1)
                                                                <td style="background: {{$dataProc['color'] != '' ? $dataProc['color'] : (($dataProc['type'] === 'WIP' ? '#d9dee1' : '#2CA44C'))}} ">
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
                                                    <td class="">
                                                        {{$sum1  }}
                                                    </td>
                                                    
                                                   
                                                   
                                                </tr>
                                             
                                            <!-- -->
                                                
                                            @else
                                                {{-- SHIFT 2 --}}
                                          
                                                <div class="shift2">
                                                    <tr>
                                                        <td rowspan="1">{{$shift->shift_name}}</td>
                                                        <td>
                                                            <span class="pan plan">Plan</span>
                                                        </td>
                                                        @foreach ($v2['from_wip'] as $kp =>$dataProcess)
                                                        
                                                            @foreach ($dataProcess as $dataProc)
                                                               
                                                                @if ($dataProc['shift_id'] === $shift->id)
                                                                    @php
                                                                        $sum2 += ($dataProc['qty_plan'] === '-') ? 0 :$dataProc['qty_plan'];
                                                                    @endphp
                                                                    <td style="background: {{$dataProc['color'] != '' ? $dataProc['color'] : (($dataProc['type'] === 'WIP' ? '#d9dee1' : '#2CA44C'))}} ">
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
                                                                    @php
                                                                        $sum2 += ($dataProc['plan_all'] === '-') ? 0 :$dataProc['plan_all'];
                                                                    @endphp
                                                                    @if (count($dataProcess) <= 1)
                                                                        <td style="background: {{$dataProc['color'] != '' ? $dataProc['color'] : (($dataProc['type'] === 'WIP' ? '#d9dee1' : '#2CA44C'))}} ">
                                                                            <span class="value-report">
                                                                                {{$dataProc['plan_all']}}
                                                                            </span>
                                                                            
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
                                                        <td>{{$sum2}}</td>
                                                        
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

{{-- DOM TO PDF --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.min.js"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
<script>

    function getPDF(){

		var HTML_Width = $(".canvas_div_pdf").width();
		var HTML_Height = $(".canvas_div_pdf").height();
		var top_left_margin = 15;
		var PDF_Width = HTML_Width+(top_left_margin*2);
		var PDF_Height = (PDF_Width*1.5)+(top_left_margin*2);
		var canvas_image_width = HTML_Width;
		var canvas_image_height = HTML_Height;
		
		var totalPDFPages = Math.ceil(HTML_Height/PDF_Height)-1;
		

		html2canvas($(".canvas_div_pdf")[0],{allowTaint:true}).then(function(canvas) {
			canvas.getContext('2d');
			
			console.log(canvas.height+"  "+canvas.width);
			
			
			var imgData = canvas.toDataURL("image/jpeg", 1.0);
			var pdf = new jsPDF('p', 'pt',  [PDF_Width, PDF_Height]);
		    pdf.addImage(imgData, 'JPG', top_left_margin, top_left_margin,canvas_image_width,canvas_image_height);
			
			
			for (var i = 1; i <= totalPDFPages; i++) { 
				pdf.addPage(PDF_Width, PDF_Height);
				pdf.addImage(imgData, 'JPG', top_left_margin, -(PDF_Height*i)+(top_left_margin*4),canvas_image_width,canvas_image_height);
			}
			
		    pdf.save("HTML-Document.pdf");
        });
	};
    
    $(document).ready(function () {
        $('.js-example-basic-multiple').select2();
         // initial
        $('.no-gutters').hide();
        // $('.main_content_iner').css('padding', '0px');
        $('.main_content').addClass('full_main_content');
        $('.dark_sidebar').addClass('mini_sidebar');
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
