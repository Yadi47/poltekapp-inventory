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
        <div class="col-lg-12">
            <div class="white_card mb_30 shadow pt-4">
                <div class="white_card_body">
                    <div class="QA_section">
                        {{-- <div class="white_box_tittle list_header">
                            <h4>Date Picker Planning Production Export</h4>
                        </div> --}}
                        <div style="background: #ebebeb;padding:20px;border-radius:20px;margin-bottom:20px;">
                        <form action="" class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Select Month</label>
                                    <input autocomplete="off"  class="form-control datepicker-here  digits @error('start_date') is-invalid @enderror"
                                    type="text" data-language="en" data-min-view="months" data-view="months"
                                    data-date-format="yyyy-mm" name="start_date">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">_</label>
                                    <button class="btn btn-success form-control">SUBMIT</button>
                                </div>
                            </div>
                        </form>
                        </div>
                        <div class="table-responsice">
                            <div>
                                <table class="table report_planning">
                                    <thead>
                                        <tr>
                                            <td>No</td>
                                            <td>Date Start </td>
                                            <td>Date Finish </td>
                                            <td>Planning </td>
                                            <td>Production</td>
                                            <td>Action</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($productions as $production)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$production->date_start}}</td>
                                                <td>{{$production->date_finish}}</td>
                                                <td>{{$production->planning->plan_code}} | {{$production->planning->plan_name}}</td>
                                                <td>{{$production->production_code}} | {{$production->production_name}}</td>
                                                <td>
                                                    <a href="{{route('mrp.report_planning-detail',$production->id)}}">View Detail Report</a>
                                                </td>
                                            </tr>
                                            
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

 

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
        $(".report_planning").DataTable({});
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
