{{-- <table style="font-size: 11px;">

    <tbody>
        <tr>
            
            <td rowspan="6">
            </td>
    
            
            <td style="width: 40px">Nama Proses </td>
            <td> <span style="font-weight: 800 width: 40px">ALL PROCESS </span></td>
    
            
            <td rowspan='2' style="text-align: center width: 160px">
                <span style="font-weight: 800;font-size:15px">CHECK SHEET</span>
            </td>
    
            
            <td style="width: 20px">No.Dokumen </td>
            <td style="width: 20px">: <span style="font-weight: ">01-PR-FM-085 </span></td>
    
            
            <td rowspan="3" style="text-align: left width: 40px">
                <span style="font-size:15px;font-weight: 800">PLAN </span>
            </td>
    
            
            <td style="text-align: center width: 40px">Mengetahui</td>
    
            
            <td style="text-align: center width: 40px">Diperiksa</td>
    
            
            <td style="text-align: center width: 40px">Dibuat</td>
    
    
            
            <td rowspan="4" colspan="1" style="vertical-align: top; width: 10px">
                <span style="display: block">Bulan Produksi</span>
                <span style="font-size: 22px;display: block;text-align: center;margin-top: 10px;">April 2021</span>
            </td>
        </tr>
        <tr>
            
            <td>No Proses </td>
            <td>: <span style="font-weight: 800"> - </span></td>
    
            
            <td style="width: ">Tgl Pembuatan </td>
            <td style="width: 20px ">: <span style="font-weight: ">2-Feb-2015 </span></td>
    
    
            
            <td rowspan="2">
            </td>
            <td rowspan="2">
            </td>
            <td rowspan="2">
            </td>
    
        </tr>
        <tr>
            
            <td>Nama Mesin </td>
            <td>: <span style="font-weight: 800"> - </span></td>
    
            
            <td rowspan='4' style="text-align: center width: 60px">
                <span style="font-weight: 800;font-size:17px">PRODUCTION PLAN</span>
            </td>
    
            
            <td style="width: 40px">No.Revisi </td>
            <td style="width: 40px">: <span style="font-weight: ">00 </span></td>
    
    
        </tr>
        <tr>
            
            <td>No Mesin </td>
            <td>: <span style="font-weight: 800"> - </span></td>
    
            
            <td style="width: ">Tgl Revisi </td>
            <td style="width: ">: <span style="font-weight: "> - </span></td>
    
            
            <td rowspan="3" style="text-align: left width: 40px">
                <span style="font-size:15px;font-weight: 800">RESULT </span>
            </td>
    
            
            <td rowspan="2">
    
            </td>
            <td rowspan="2"></td>
            <td rowspan="2"></td>
    
        </tr>
        <tr>
            
            <td>Nama Part </td>
            <td>: <span style="font-weight: 800">UNION</span></td>
    
            
            <td style="width: ">Halaman </td>
            <td style="width: ">: <span style="font-weight: s">5/6 </span></td>
    
            
            <td style="width: 40px" rowspan="2">Tgl :</td>
            <td style="width: 40px" rowspan="2">{!! $date !!}</td>
            <td style="width: 40px" rowspan="2">Rev : 00</td>
        </tr>
    
        <tr>
            
            <td>No Part </td>
            <td>: <span style="font-weight: 800">ALL MODEL</span></td>
    
            
            <td style="width: 40px">Departemen </td>
            <td style="width: 40px">: <span style="font-weight: ">Produksi </span></td>
    
            
            <td style="text-align: center">Division Head</td>
            <td style="text-align: center" colspan="2">Dept.Head</td>
    
        </tr>
    </tbody>
    </table> --}}
    
    <div class="row">
        <div class="col-lg-12">
            <div class="white_card mb_30 shadow pt-4">
                <div class="white_card_body">
                    <div class="QA_section">
                        <div class="white_box_tittle list_header">
                            <h4 style="text-align: center">Report Wip</h4>
                        </div>
                        <div>
                            <div class="table-responsive">
                                <table class="table lms_table_active3">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Date</th>
                                            <th>Product</th>
                                            <th>Process</th>
                                            <th>Machine</th>
                                            <th>Shift</th>
                                            <th>Qty Total</th>
                                            <th>Qty Actual</th>
                                            <th>Qty Plan</th>
                                            <th>Qty Good</th>
                                            <th>Qty Reject</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($wips as $wip)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $wip->date }}</td>
                                                <td>{{ $wip->ProcessMachineProduct->product->product_name }}</td>
                                                <td>{{ $wip->ProcessMachineProduct->process->process_name }}</td>
                                                <td>{{ $wip->ProcessMachineProduct->machine->machine_name }}</td>
                                                <td>{{ $wip->shift->shift_name }}</td>
                                                <td>{{ $wip->qty_total }}</td>
                                                <td>{{ $wip->qty_plan }}</td>
                                                <td>{{ $wip->qty_total }}</td>
                                                <td>{{ $wip->qty_good }}</td>
                                                <td>{{ $wip->qty_reject }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <br>
                                {{-- @foreach ($report_wip as $product => $machines)
                                <h3 style="background:#2B453F;color:white;">{{ $product }}</h3>
                                <table class="report table-bordered" style=" margin-bottom:25px;">
                                    <thead>
                                        <tr>
                                            <th>Machine</th>
                                            <th>Process</th>
                                            <th>Shift</th>
                                            <th>Item</th>
                                            <th>1</th>
                                            <th>2</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($machines as $machine => $process)
                                            @foreach ($process as $proc => $shifts)
                                                @foreach ($shifts as $shift => $dataWip)
                                                    <tr>
                                                        <td>{{ $proc  }}</td>
                                                        <td>{{ $machine }}</td>
                                                        <td>{{ $shift }}</td>
                                                        <td style="padding:0px;">
                                                            <table class="" style="width:100%">
                                                                <tr>
                                                                    <td>Actual</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Plan</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Good</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Reject</td>
                                                                </tr>
                                                            </table>
                                                        </td>

                                                        @php
                                                            $dateBefore = 0;
                                                        @endphp
                                                        @foreach ($dataWip as $dw)

                                                            @php
                                                                $dateBefore = $dw['dateIndex']
                                                            @endphp
                                                            <td style="padding:0px;">
                                                                <table class="" style="width:100%">

                                                                    <tr>
                                                                        <td>{{ $dw['qty_good'] }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>{{ $dw['qty_plan'] }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>{{ $dw['qty_good'] }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>{{ $dw['qty_reject'] }}</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                            
                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                            
                                            @endforeach
                                           
                                        @endforeach
                                       
                                        <tr></tr>
                                    </tbody>

                                </table>
                                @endforeach --}}
                                

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>