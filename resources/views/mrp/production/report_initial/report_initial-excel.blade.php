<table style="font-size: 11px;">

    <tbody>
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
            <td style="width: 60px">No.Dokumen </td>
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
                <span style="font-size: 22px;display: block;text-align: center;margin-top: 10px;">April 2021</span>
            </td>
        </tr>
        <tr>
            {{--  --}}
            <td style="width: 10px">No  Proses </td>
            <td>: <span style="font-weight: 800">2 OF 5 </span></td>

            {{--  --}}
            <td style="width: 60px">Tgl Pembuatan </td>
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
                <span style="font-weight: 800;font-size:17px">PRODUCTION PLAN</span>
            </td>

            {{--  --}}
            <td style="width: 60px">No.Revisi </td>
            <td style="width: 40px">: <span style="font-weight: ">00 </span></td>


        </tr>
        <tr>
            {{--  --}}
            <td style="width: 20px">No Mesin </td>
            <td>: <span style="font-weight: 800">MSN001 </span></td>

            {{--  --}}
            <td style="width: 60px">Tgl Revisi </td>
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
            <td style="width: 60px">Halaman </td>
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
            <td style="width: 60px">Departemen </td>
            <td style="width: 40px">: <span style="font-weight: ">Produksi </span></td>

            {{--  --}}
            <td style="text-align: center width: 40px">Division Head</td>
            <td style="text-align: center" colspan="2">Dept.Head</td>

        </tr>
    </tbody>
</table>
{{-- REPORT SHIFT --}}
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

<table style="font-size: 11px;table-layout:fixed;margin-top:20px">
    <tbody>
        <tr>
            <td style="width: 10px">10</td>
            <td colspan="2" style="width:10px;white-space:nowrap">Driving {{'&'}} Powder</td>
             <td style="text-align: center; width: 18px">Item</td>

             {!! $head_date !!}
            <td style="width: 10px">Sum</td>
            <td style="width: 10px">Plan</td>
            <td style="width: 10px">Actual</td>
            <td style="width: 10px">NG</td>
        </tr>

            {{-- MESIN 1 --}}
        @foreach ($column as $data)
            <tr>
                <td rowspan="6" style="font-size: 7px"> UP#{{ $loop->index }}</td>
                <td style="width: 15px" rowspan="6">
                    <span style="display: block">
                        15262-OYO040
                    </span>
                    <br>
                    <span style="font-size: 25px">{{$data['machine_name']}} <br> #{{  $loop->index }}</span>
                </td>
                <td rowspan="3" style="white-space:nowrap;font-size:9px">Shift 1</td>
                <td><span> Plan </span></td>
                {!! $data['td']['plan']['shift_1'] !!}
                <td>
                    {{ $data['sum_value']['plan']['shift_1'] }}
                </td>
                <td rowspan="1">
                {{ $data['sum_value']['plan']['shift_1'] + $data['sum_value']['plan']['shift_2'] }}
                </td>
                <td rowspan="1">
                    7777
                </td>
                <td rowspan="1">
                    1000
                </td>
                <td rowspan="1">
                    900
                </td>

            </tr>
            <tr>
                <td><span > Actual </span></td>
                {!! $data['td']['actual']['shift_1'] !!}
                <td>
                {{ $data['sum_value']['actual']['shift_1'] }}
                </td>
            </tr>
            <tr>
                <td><span> NG </span></td>
                {!! $data['td']['ng']['shift_1'] !!}
                <td>
                {{ $data['sum_value']['ng']['shift_1'] }}
                </td>
            </tr>

            <tr>
                <td rowspan="3" style="white-space:nowrap;font-size:9px">Shift 2</td>
                <td><span> Plan </span></td>
                {!! $data['td']['plan']['shift_2'] !!}
                <td>
                {{ $data['sum_value']['plan']['shift_2'] }}
                </td>

            </tr>
            <tr>
                <td><span> Actual </span></td>
                {!! $data['td']['actual']['shift_2'] !!}
                <td>
                    {{ $data['sum_value']['actual']['shift_2'] }}
                </td>
            </tr>
            <tr>
                <td><span> NG </span></td>
                {!! $data['td']['ng']['shift_2'] !!}
                <td>
                {{$data['sum_value']['ng']['shift_2'] }}
                </td>
            </tr>
            <tr>
                <td colspan="4" class="text-center">Total Per Day</td>
                {!! $body_date !!}
                <td>
                    0
                </td>
                <td>
                    0
                </td>
                <td>
                    0
                </td>
                <td>
                    0
                </td>
                <td>
                    0
                </td>
            </tr>
             @endforeach
            {{-- MESIN 1 END --}}
            
        </tbody>
    </table>

        <table style="font-size: 11px;">
            <thead>
                <tr>
                <td>No</td>
                <td style="width: 20px">Tanggal</td>
                <td style="width: 40px">Keterangan</td>
                <td>No</td>
                <td style="width: 20px">Tanggal</td>
                <td style="width: 40px">Keterangan</td>
                <td>No</td>
                <td style="width: 20px">Tanggal</td>
                <td style="width: 40px">Keterangan</td>
                <td>No</td>
                <td style="width: 20px">Tanggal</td>
                <td style="width: 40px">Keterangan</td>
                </tr>

            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td></td>
                    <td></td>
                    <td>6</td>
                    <td></td>
                    <td></td>
                    <td>11</td>
                    <td></td>
                    <td></td>
                    <td>16</td>
                    <td></td>
                    <td></td>

                </tr>

                <tr>
                    <td>2</td>
                    <td></td>
                    <td></td>
                    <td>7</td>
                    <td></td>
                    <td></td>
                    <td>12</td>
                    <td></td>
                    <td></td>
                    <td>17</td>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <td>3</td>
                    <td></td>
                    <td></td>
                    <td>8</td>
                    <td></td>
                    <td></td>
                    <td>13</td>
                    <td></td>
                    <td></td>
                    <td>18</td>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <td>4</td>
                    <td></td>
                    <td></td>
                    <td>9</td>
                    <td></td>
                    <td></td>
                    <td>14</td>
                    <td></td>
                    <td></td>
                    <td>19</td>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <td>5</td>
                    <td></td>
                    <td></td>
                    <td>10</td>
                    <td></td>
                    <td></td>
                    <td>15</td>
                    <td></td>
                    <td></td>
                    <td>20</td>
                    <td></td>
                    <td></td>
                </tr>


            </tbody>
        </table>