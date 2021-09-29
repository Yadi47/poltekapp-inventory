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
                        <h4>Select Date </h4>
                    </div>
                    <div>
                        <form action="{{ route('mrp.report_inventory_product-list') }}" method="post">
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


    <div class="row">
        <div class="col-lg-12">
            <div class="white_card mb_30 shadow pt-4">
                <div class="white_card_body">
                    <div class="QA_section">
                        <div class="table-responsice">
                           
                            <div>
                                <table class="table report_product">
                                    <thead>
                                        <tr>
                                            <td scope="col">No</td>
                                            <td scope="col">Date</td>
                                            <td scope="col">Part Name </td>
                                            <td scope="col">Part Number </td>
                                             <td scope="col">Qty </td>
                                            <td scope="col">PIC</td> 
                                            <td scope="col">From</td> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($allinvenproduct as $items)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $items['date'] }}</td>
                                            <td>{{ $items['product_name'] }}</td>
                                            <td>{{ $items['part_number'] }}</td>
                                            <td>{{ $items['qty'] }}</td>
                                            <td>{{ $items['pic'] }}</td>
                                            <td>{{ $items['from'] }}</td>
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

<script src="{{asset('assets')}}/vendors/datatable/js/jquery.dataTables.min.js"></script>
<script src="{{asset('assets')}}/vendors/datatable/js/dataTables.responsive.min.js"></script>
<script src="{{asset('assets')}}/vendors/datatable/js/dataTables.buttons.min.js"></script>
<script src="{{asset('assets')}}/vendors/datatable/js/dataTables.buttons.min.js"></script>
<script src="{{asset('assets')}}/vendors/datatable/js/buttons.flash.min.js"></script>
<script src="{{asset('assets')}}/vendors/datatable/js/jszip.min.js"></script>
<script src="{{asset('assets')}}/vendors/datatable/js/pdfmake.min.js"></script>
<script src="{{asset('assets')}}/vendors/datatable/js/vfs_fonts.js"></script>
<script src="{{asset('assets')}}/vendors/datatable/js/buttons.html5.min.js"></script>
<script src="{{asset('assets')}}/vendors/datatable/js/buttons.print.min.js"></script>

    <script src="{{ asset('assets') }}/vendors/datepicker/datepicker.js"></script>
    <script src="{{ asset('assets') }}/vendors/datepicker/datepicker.en.js"></script>
    <script src="{{ asset('assets') }}/vendors/datepicker/datepicker.custom.js"></script>


    <script>
        if ($('.report_product').length) {
        $('.report_product').DataTable({
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
            paging: true,
            dom: 'Bfrtip',
            buttons: ['csv', 'excel', 'pdf']
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
