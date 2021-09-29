@extends('mrp')

@section('title', $page_title)

@section('content')
    <style>
        .document {
            width: 100%;
            height: 18rem;
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

        .td-style {
            background-color: #FE7802;
            font-weight: bold;
            text-align: center;
        }

        .date-head {
            font-size: 9px;
            font-weight: bold;
            text-align: center;
            width: 50px;
            /* padding: 2px 7px !important; */
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

    {{-- <div class="row">
        <div class="col-lg-6">
            <div class="white_card mb_30 shadow pt-4">
                <div class="white_card_body">
                    <div class="QA_section">
                        <div class="white_box_tittle list_header">
                            <h4>Date Picker Summary Forecast Customer Export</h4>
                        </div>
                        <div>
                            <form action="{{ route('mrp.report_smc-list') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Start Date</label>
                                            <input type="date" value="{{ old('start_date') }}"
                                                class="form-control digits minMaxExample @error('start_date') is-invalid @enderror"
                                                name="start_date">
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
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">End Date</label>
                                            <input type="date" value="{{ old('end_date') }}"
                                                class="form-control digits minMaxExample @error('end_date') is-invalid @enderror"
                                                name="end_date">
                                            @error('end_date')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="row">
        <div class="col-lg-6">
            <div class="white_card mb_30 shadow pt-4">
                <div class="white_card_body">
                    <div class="QA_section">
                        <div class="white_box_tittle list_header">
                            <h4>Date Picker Production Export</h4>
                        </div>
                        <div>
                            <form action="{{ route('mrp.report_smc-list') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label for="">Start Date</label>
                                            <input type="text" class="datepicker-here form-control digits
                                            @error('start_date') is-invalid @enderror" data-language="en" id="" name="start_date" autocomplete="off">
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
                                    {{-- <input autocomplete="off"
                                    class="datepicker-here form-control digits @error('start_date') is-invalid @enderror"
                                    type="text" data-language="en" data-min-view="months" data-view="months"
                                    data-date-format="MM yyyy" name="start_date"> --}}

                                    <div class="col-lg-2">
                                        <br>
                                        <span>To</span>
                                    </div>
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label for="">End Date</label>
                                            <input type="text" class="datepicker-here form-control digits
                                            @error('end_date') is-invalid @enderror" data-language="en" id="" name="end_date" autocomplete="off">
                                            @error('end_date')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- <input autocomplete="off"
                                    class="datepicker-here form-control digits @error('end_date') is-invalid @enderror"
                                    type="text" data-language="en" data-min-view="months" data-view="months"
                                    data-date-format="MM yyyy" name="end_date"> --}}
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @if (isset($status))
        {{-- EXAMPLE --}}
        <div class="row" id="theDiv">
            <div class="col-xl-12">
                <div class="white_card mb_30 shadow pt-1">
                    <div class="white_card_body" style="padding: 5px 10px 15px 15px !important;">
                        <div class="QA_section">

                            <div class="white_box_tittle list_header">
                                <h4></h4>

                                <div class="box_right d-flex lms_block">
                                    <a href="{{ route('mrp.report_smc-excel', [$start_date, $end_date]) }}">
                                        <div class="btn btn-success ml-10 btn-sm">
                                            <i class="fas fa-file-excel"></i>
                                            Excel
                                        </div>
                                    </a>
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
                            <h3 class="text-center">SUMMARY FORECAST
                                CUSTOMER</h3>
                            <div class="QA_table mb_30 document">
                                <!-- table-responsive -->
                                <div class="row">
                                    <div class="col-lg-1"></div>
                                    <div class="col-lg-10">
                                        <div class="table-responsive" style="padding-bottom:10px;" id="style-1">
                                            <table class="report table-bordered">
                                                <tbody>
                                                <tr>
                                                        <td width="200px" class="text-center">CUSTOMER</td>
                                                        <td width="20px" class="td-style"><span
                                                            style="font-weight: 800;font-size:15px">DOCK-CD</span>
                                                        </td>
                                                        {{-- <td><button onclick="detailCustomer({{$month_name->id[0]}})"
                                                            class="btn btn-info btn-sm"><i class="ti-eye"></i> View DOCK CD </button></td> --}}
                                                        <td width="250px" class="td-style"><span
                                                                style="font-weight: 800;font-size:15px">PART_NAME</span>
                                                        </td>
                                                        <td width="200px" class="td-style"><span
                                                                style="font-weight: 800;font-size:15px">PART_NO</span>
                                                        </td>
                                                        {{-- @foreach ($header_month as $month)
                                                        <td class="text-center" width="100px">
                                                            {{ $month }}</td>
                                                            @endforeach --}}
                                                            {{-- <td rowspan="{{ $rowspan }}">data</td> --}}

                                                        @foreach ($header_date as $date)
                                                        <td class="text-center" width="200px"> {{ $date }} </td>
                                                        {{-- <td class="text-center" width="100px">{{ date('d M', strtotime($date)) }}</td> --}}
                                                        @endforeach
                                                
                                                        </tr>
                                                    {{-- Forecast Table looping in controller --}}
                                                    {!! $sum['col'] !!}
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>

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

        // var urlDelete = `{{ route('mrp.product-delete') }}`

        // function deleteData(event, id, textData) {
        //     event.preventDefault();
        //     $.confirm({
        //         title: 'Are you sure for delete data ?',
        //         content: textData,
        //         buttons: {
        //             confirm: {
        //                 btnClass: 'btn-red',
        //                 keys: ['enter'],
        //                 action: function () {
        //                     axios.delete(urlDelete, {
        //                             params: {
        //                                 id: id,
        //                                 text: textData
        //                             }
        //                         })
        //                         .then(function (response) {
        //                             // handle success
        //                             location.reload();
        //                         })
        //                         .catch(function (error) {
        //                             // handle error
        //                             console.log(error);
        //                         })
        //                         .then(function () {
        //                             // always executed
        //                         });

        //                 }
        //             },
        //             cancel: {
        //                 btnClass: 'btn-dark',
        //                 keys: ['esc'],

        //             },

        //         }
        //     });
        // }

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
