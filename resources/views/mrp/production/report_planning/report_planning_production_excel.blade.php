
<style>
    .document {
        width: 100%;
        height: 18rem;
        overflow-x: scroll;
        padding-right: .5rem;
        margin-bottom: 1rem;
    }

    /* CSS REPORT  */
    .report {
        table-layout: fixed;
    }

    .report td {
        padding: 1px 5px;
        border: 1px solid black;
    }

    .date-head {
        font-size: 9px;
        font-weight: bold;
        text-align: center;
        width: 50px;
        /* padding: 2px 7px !important; */
    }

    .pan {
        font-size: 7px;
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
        border: 1px solid #84757F !important;
    }


    /* SCROLL STYLE */
    /*
                                 *  STYLE 1
                                 */

    #style-1::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
        border-radius: 10px;
        background-color: #F5F5F5;

    }

    #style-1::-webkit-scrollbar {
        width: 12px;
        background-color: #F5F5F5;
    }

    #style-1::-webkit-scrollbar-thumb {
        border-radius: 10px;
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
        background-color: #555;
    }

</style>

<table class="report table" style="font-size: 11px;">

    <tbody style="border: 1px solid #84757F !important;">
        <tr>
            {{--  --}}
            <td rowspan="6" style="width: 40px">
            </td>
            {{--  --}}
            <td style="width: 10px">Nama  Proses </td>
            <td>: <span style="font-weight: 800 width: 40px">ALL PROCESS </span></td>

            {{--  --}}
            <td rowspan='2' style="text-align: center width: 60px">
                <span style="font-weight: 800;font-size:15px">CHECK SHEET</span>
            </td>

            {{--  --}}
            <td style="width: 40px">No.Dokumen </td>
            <td style="width: 40px">: <span style="font-weight: ">01-PR-FM-085 </span></td>

            {{--  --}}
            <td rowspan="3" style="text-align: left width: 20px">
                <span style="font-size:15px;font-weight: 800">PLAN </span>
            </td>

            {{--  --}}
            <td style="text-align: center width: 40px">Mengetahui</td>

            {{--  --}}
            <td style="text-align: center width: 40px">Diperiksa</td>

            {{--  --}}
            <td style="text-align: center width: 40px">Dibuat</td>


            {{--  --}}
            <td rowspan="4" colspan="3" style="vertical-align: top;width: 10px">
                <span style="display: block">Bulan Produksi</span>
                <br>
                <span style="font-size: 22px;display: block;text-align: center;margin-top: 10px;">{{$month_year}}</span>
            </td>
        </tr>
        <tr>
            {{--  --}}
            <td style="width: 10px">No  Proses </td>
            <td>: <span style="font-weight: 800">2 OF 5 </span></td>

            {{--  --}}
            <td style="width: 40px">Tgl Pembuatan </td>
            <td style="width: 20px">: <span style="font-weight: ">2-Feb-2015 </span></td>


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
            <td style="width: 10px">Nama Mesin </td>
            <td>: <span style="font-weight: 800">NR#7 </span></td>

            {{--  --}}
            <td rowspan='4' style="text-align: center width: 60px">
                <span style="font-weight: 800;font-size:17px">PLANNING PRODUCTION PLAN</span>
            </td>

            {{--  --}}
            <td style="width: 40px">No.Revisi </td>
            <td style="width: 40px">: <span style="font-weight: ">00 </span></td>


        </tr>
        <tr>
            {{--  --}}
            <td style="width: 20px">No Mesin </td>
            <td>: <span style="font-weight: 800">MSN001 </span></td>

            {{--  --}}
            <td style="width: 40px">Tgl Revisi </td>
            <td>: <span style="font-weight: ">- </span></td>

            {{--  --}}
            <td rowspan="3" style="text-align: left width: 20px">
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
            <td style="width: 20px">Nama Part </td>
            <td>: <span style="font-weight: 800">NOZZLE SUB <br> ASSY.OIL</span></td>

            {{--  --}}
            <td style="width: 40px">Halaman </td>
            <td style="width: ">: <span style="font-weight: s">1/4 </span></td>

            {{--  --}}
            <td style="width: 15px" rowspan="2">Tgl :</td>
            <td style="width: 15px" rowspan="2">{!! $date !!}</td>
            <td style="width: 15px" rowspan="2">Rev : 00</td>
        </tr>

        <tr>
            {{--  --}}
            <td style="width: 10px">No Part </td>
            <td>: <span style="font-weight: 800">ALL MODEL</span></td>

            {{--  --}}
            <td style="width: 40px">Departemen </td>
            <td style="width: 40px">: <span style="font-weight: ">Produksi </span></td>

            {{--  --}}
            <td style="text-align: center width: 40px">Division Head</td>
            <td style="text-align: center" colspan="2">Dept.Head</td>

        </tr>
    </tbody>
</table>
{{-- REPORT SHIFT --}}
<div class="table-responsive" style="padding-bottom:10px;" id="style-1">
    <table style="font-size: 11px; table-layout: auto !important;">
    <tbody>
        <tr>
            <td style="width: 40px">00</td>
            <td style="width: 10px">Press</td>
            <td style="text-align: center; width:15px">Shift</td>
            {!! $head_date !!}
            <td style="width: 20px">Sum</td>

        </tr>
        <tr>
            <td rowspan="4">APR #01</td>
            <td style=" " rowspan="2"> 15262-2323 <br> PRESS PLATE</td>
            <td style="text-align: center;white-space:nowrap;">Actual Shift 1</td>
            {!! $body_date !!}
            <td style="width: 5px"></td>

        </tr>
        <tr>
            <td style="text-align: center;white-space:nowrap;">Actual Shift 2</td>
            {!! $body_date !!}
            <td style="width: 5px"></td>
        </tr>
        <tr>
            <td rowspan="2">15262-2323 <br> PRESS PLATE</td>
            <td style="text-align: center;white-space:nowrap;">Actual Shift 1</td>
            {!! $body_date !!}
            <td style="width: 5px"></td>


        </tr>
        <tr>
            <td style="text-align: center;white-space:nowrap;">Actual Shift 2</td>
            {!! $body_date !!}
            <td style="width: 5px"></td>
        </tr>
    </tbody>
</table>

@foreach ($column as $data)
<table style="font-size: 11px;table-layout:fixed;margin-top:20px">
    <tbody>
        @foreach ($data['product_name']['name'] as $key => $item)
        @if ($key == 0)
        <tr>
            <td style="width: 10px">10</td>
            <td colspan="2" style="width:10px;white-space:nowrap">{{$data['process_name']}}</td>
             <td style="text-align: center; width: 18px">Item</td>

             {!! $head_date !!}
            <td style="width: 10px">Sum</td>
            <td style="width: 10px">Plan</td>
            <td style="width: 10px">Actual</td>
            <td style="width: 10px">NG</td>
        </tr>
        @endif

            {{-- MESIN 1 --}}
            <tr>
                <td rowspan="4" style="font-size: 7px"> UP#{{ $loop->index }}</td>
                <td style="width: 15px" rowspan="4">
                    <span style="display: block">
                        15262-OYO040
                    </span>
                    <br>
                    <span style="font-size: 25px"> {{$item}} #{{  $loop->index }}</span>
                </td>
                <td rowspan="1" style="white-space:nowrap;font-size:9px">Shift 1</td>
                <td rowspan="1"><span> Plan </span></td>
                {!! $data['td']['plan']['shift_1'] !!}
                <td>
                    {{ $data['sum_value']['plan']['shift_1'] }}
                </td>
                <td rowspan="1">
                {{ $data['sum_value']['plan']['shift_1'] + $data['sum_value']['plan']['shift_2'] }}
                </td>
                <td rowspan="1">

                </td>
                <td rowspan="1">

                </td>
                <td rowspan="1">

                </td>

            </tr>
    

            <tr>
                <td rowspan="1" style="white-space:nowrap;font-size:9px">Shift 2</td>
                <td rowspan="1"><span> Plan </span></td>
                {!! $data['td']['plan']['shift_2'] !!}
                <td>
                {{ $data['sum_value']['plan']['shift_2'] }}
                </td>

            </tr>
            <tr>
                {{-- <td><span> Actual </span></td>
                {!! $data['td']['actual']['shift_2'] !!}
                <td>
                    {{ $data['sum_value']['actual']['shift_2'] }}
                </td> --}}
            </tr>
            <tr>
                {{-- <td><span> NG </span></td>
                {!! $data['td']['ng']['shift_2'] !!}
                <td>
                {{$data['sum_value']['ng']['shift_2'] }}
                </td> --}}
            </tr>
            @endforeach
        </tbody>
    </table>
    @endforeach
</div>
