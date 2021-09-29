@extends('mrp')

@section('title', $page_title)

@section('content')
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




    <div class="row">
        <div class="col-lg-6">
            <div class="white_card mb_30 shadow pt-4">
                <div class="white_card_body">
                    <div class="QA_section">
                        <div class="white_box_tittle list_header">
                            <h4>Date Picker Report Initial Export</h4>
                        </div>
                        <div>
                            <form action="{{ route('mrp.report_initial-list') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Start Date</label>
                                            <input autocomplete="off"
                                                class="datepicker-here  digits @error('start_date') is-invalid @enderror"
                                                type="text" data-language="en" data-min-view="months" data-view="months"
                                                data-date-format="MM yyyy" name="start_date">
                                            @error('start_date')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        
                                        <div class="form-group">
                                            <button class="btn btn-success btn-group-lg">
                                                <i class="fas fa-cog fa-lg"></i>
                                                Generate
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @if (isset($status))
        <div class="col-xl-12">
            <div class="white_card mb_30 shadow pt-1">
                <div class="white_card_body" style="padding: 5px 10px 15px 15px !important;">
                    <div class="QA_section">
                        <div class="white_box_tittle list_header">
                            <h4>{{ $page_title }}</h4>

                            <div class="box_right d-flex lms_block">
                                <a href="{{ route('mrp.report_initial-export', $start_date) }}">
                                    <div class="btn btn-success ml-10 btn-sm">
                                        <i class="fas fa-file-excel"></i>
                                        Excel
                                    </div>
                                </a>
                                <!-- <a href="{{ route('mrp.production.production-create') }}">
                                    <div class="btn btn-danger ml-10 btn-sm">
                                        <i class="fas fa-file-pdf"></i>
                                        PDF
                                    </div>
                                </a> -->
                        
                            </div>
                        </div>
                        @if (Session::has('message'))
                            <div class="alert  {{ Session::get('alert-class', 'alert-info') }} d-flex align-items-center justify-content-between"
                                role="alert">
                                <div class="alert-text">
                                    <p>{{ Session::get('message') }}</p>
                                </div>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <i class="ti-close  f_s_14"></i>
                                </button>
                            </div>
                        @endif
                        <div class=" mb_30 ">
                            <!-- table-responsive -->
                            {{-- REPORT HEADER --}}
                            <table class="report table-bordered " style="font-size: 11px;">

                                <tbody>
                                    <tr>
                                        {{--  --}}
                                        <td rowspan="6">
                                            <img style="width: 100px;height: 51px;"
                                                src="{{ asset('assets') }}/img/itokin.png" alt="">

                                        </td>

                                        {{--  --}}
                                        <td width="100px">Nama Proses </td>
                                        <td width="170px">: <span style="font-weight: 800">ALL PROCESS </span></td>

                                        {{--  --}}
                                        <td rowspan='2' width="180px" style="text-align: center">
                                            <span style="font-weight: 800;font-size:15px">CHECK SHEET</span>
                                        </td>

                                        {{--  --}}
                                        <td width="100px">No.Dokumen </td>
                                        <td width="130px">: <span style="font-weight: ">01-PR-FM-085 </span></td>

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
                                                style="font-size: 22px;display: block;text-align: center;margin-top: 10px;">April
                                                2021</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        {{--  --}}
                                        <td>No Proses </td>
                                        <td>: <span style="font-weight: 800">2 OF 5 </span></td>

                                        {{--  --}}
                                        <td width="">Tgl Pembuatan </td>
                                        <td width="">: <span style="font-weight: ">2-Feb-2015 </span></td>


                                        {{--  --}}
                                        <td rowspan="2">
                                            <img style="width: 100px;height: 51px;"
                                                src="{{ asset('assets') }}/img/signature2.svg" alt="">
                                        </td>
                                        <td rowspan="2">
                                            <img style="width: 100px;height: 51px;"
                                                src="{{ asset('assets') }}/img/signature3.svg" alt="">
                                        </td>
                                        <td rowspan="2">
                                            <img style="width: 100px;height: 51px;"
                                                src="{{ asset('assets') }}/img/signature4.svg" alt="">
                                        </td>

                                    </tr>
                                    <tr>
                                        {{--  --}}
                                        <td>Nama Mesin </td>
                                        <td>: <span style="font-weight: 800">NR#7 </span></td>

                                        {{--  --}}
                                        <td rowspan='4' width="200px" style="text-align: center">
                                            <span style="font-weight: 800;font-size:17px">INITIAL PRODUCT</span>
                                        </td>

                                        {{--  --}}
                                        <td width="">No.Revisi </td>
                                        <td width="">: <span style="font-weight: ">00 </span></td>


                                    </tr>
                                    <tr>
                                        {{--  --}}
                                        <td>No Mesin </td>
                                        <td>: <span style="font-weight: 800">MSN001 </span></td>

                                        {{--  --}}
                                        <td width="">Tgl Revisi </td>
                                        <td width="">: <span style="font-weight: ">- </span></td>

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
                                        <td>: <span style="font-weight: 800">NOZZLE SUB ASSY.OIL</span></td>

                                        {{--  --}}
                                        <td width="">Halaman </td>
                                        <td width="">: <span style="font-weight: s">1/4 </span></td>

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
                            <br>
                            {{-- REPORT SHIFT --}}
                            <div class="table-responsive" style="padding-bottom:10px;" id="style-1">
                                <table class="report table-bordered"
                                    style="font-size: 11px; table-layout: auto !important;">
                                    <tbody>
                                        <tr>
                                            <td width="10px">00</td>
                                            <td>Press</td>
                                            <td width="100px" style="text-align: center;width:150px">Shift</td>

                                            {!! $head_date !!}
                                            <td style="width: 60px">Sum</td>

                                        </tr>
                                        <tr>
                                            <td rowspan="4">APR #01</td>
                                            <td style=" " rowspan="2">
                                                15262-2323
                                                PRESS PLATE</td>

                                            <td style="text-align: center;white-space:nowrap;">Actual Shift 1</td>
                                            {!! $body_date !!}
                                            <td style="width: 60px"></td>

                                        </tr>
                                        <tr>
                                            <td style="text-align: center;white-space:nowrap;">Actual Shift 2</td>
                                            {!! $body_date !!}
                                            <td style="width: 60px"></td>
                                        </tr>
                                        <tr>
                                            <td rowspan="2">15262-2323 PRESS PLATE</td>
                                            <td style="text-align: center;white-space:nowrap;">Actual Shift 1</td>
                                            {!! $body_date !!}
                                            <td style="width: 60px"></td>


                                        </tr>
                                        <tr>
                                            <td style="text-align: center;white-space:nowrap;">Actual Shift 2</td>
                                            {!! $body_date !!}
                                            <td style="width: 60px"></td>



                                        </tr>
                                    </tbody>
                                </table>
                                {{-- REPORT SHIFT 2 --}}

                                <table class="report table-bordered"
                                    style="font-size: 11px;table-layout:fixed;margin-top:20px">
                                    <tbody>
                                        <tr>
                                            <td width="10px">10</td>
                                            <td colspan="2" width="90px" style="width:150px;white-space:nowrap">Final Inspection</td>
                                            <td width="30px" style="text-align: center;">Item</td>
                                            

                                            {!! $head_date !!}
                                            <td style="width: 60px">Sum</td>
                                            <td style="width: 60px">Plan</td>
                                            <td style="width: 60px">Actual</td>
                                            <td style="width: 60px">NG</td>
                                            <td width="900">Diff</td>
                                        </tr>

                                            {{-- MESIN 1 --}}
                                            <tr>
                                                <td rowspan="6" style="font-size: 7px"> UP#</td>
                                                
                                                <td width="90px" rowspan="6">
                                                    <span style="display: block">
                                                        15262-OYO040
                                                    </span>
                                                    <span style="font-size: 25px">Mr1</span>
                                                </td>
                                                <td rowspan="3" style="white-space:nowrap;font-size:9px">Shift 1</td>
                                                <td><span class="pan plan"> Plan </span></td>
                                            {!! $body_date !!}

                                                <td>
                                                </td>
                                                <td rowspan="6">
                                                </td>
                                                <td rowspan="6">
                                                    0
                                                </td>
                                                <td rowspan="6">
                                                    0
                                                </td>
                                                <td rowspan="6">
                                                    0
                                                </td>

                                            </tr>
                                            <tr>
                                                <td><span class="pan actual"> Actual </span></td>
                                            {!! $body_date !!}
                                                <td>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><span class="pan ng"> NG </span></td>
                                            {!! $body_date !!}

                                                <td>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td rowspan="3" style="white-space:nowrap;font-size:9px">Shift 2</td>
                                                <td><span class="pan plan"> Plan </span></td>
                                            {!! $body_date !!}
                                                <td>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td><span class="pan actual"> Actual </span></td>
                                            {!! $body_date !!}
                                                <td>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><span class="pan ng"> NG </span></td>
                                            {!! $body_date !!}
                                                <td>
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
                                            {{-- MESIN 1 END --}}
                                    </tbody>
                                </table>
                                
                            </div>
                            <div class="table-responsive" style="padding-bottom:10px;" id="style-1">
                                    <table class="report table-bordered" style="font-size: 11px; table-layout: auto !important;">
                                        <thead>
                                            <tr>
                                            <td>No</td>
                                            <td width="120px">Tanggal</td>
                                            <td width="140px">Keterangan</td>
                                            <td>No</td>
                                            <td width="120px">Tanggal</td>
                                            <td width="140px">Keterangan</td>
                                            <td>No</td>
                                            <td width="120px">Tanggal</td>
                                            <td width="140px">Keterangan</td>
                                            <td>No</td>
                                            <td width="120px">Tanggal</td>
                                            <td width="140px">Keterangan</td>
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
                                </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        </div>
    @endif

@endsection

@push('css')
    <!-- datatable CSS -->
    <link rel="stylesheet" href="{{ asset('assets') }}/vendors/datatable/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendors/datatable/css/responsive.dataTables.min.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendors/datatable/css/buttons.dataTables.min.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendors/datepicker/date-picker.css">

@endpush
@push('js')

    <script src="{{ asset('assets') }}/vendors/datatable/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('assets') }}/vendors/datatable/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('assets') }}/vendors/datatable/js/dataTables.buttons.min.js"></script>

    <script src="{{ asset('assets') }}/vendors/datepicker/datepicker.js"></script>
    <script src="{{ asset('assets') }}/vendors/datepicker/datepicker.en.js"></script>
    <script src="{{ asset('assets') }}/vendors/datepicker/datepicker.custom.js"></script>


    <script>
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

        var urlDelete = `{{ route('mrp.product-delete') }}`

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

        $('#theButton').click(function() {
            $('#theDiv').css({
                position: 'fixed',
                top: 0,
                right: 0,
                bottom: 0,
                left: 0,
                zIndex: 999999999
            });
        });
    </script>
@endpush
