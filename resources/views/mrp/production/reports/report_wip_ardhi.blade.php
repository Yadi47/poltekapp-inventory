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
   
    .report thead>tr>th{
        border:0.5px solid #84757F;
    }


    /* SCROLL STYLE */
    /*
 *  STYLE 1
 */

#style-1::-webkit-scrollbar-track
{
	-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
	border-radius: 10px;
	background-color: #F5F5F5;

}

#style-1::-webkit-scrollbar
{
	width: 12px;
	background-color: #F5F5F5;
}

#style-1::-webkit-scrollbar-thumb
{
	border-radius: 10px;
	-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
	background-color: #555;
}

    </style>
    {{-- <div class="row " id="theDiv"> --}}
        
    {{-- <div class="row">
        <div class="col-lg-6">
            <div class="white_card mb_30 shadow pt-4">
                <div class="white_card_body">
                    <div class="QA_section">
                        <div class="white_box_tittle list_header">
                            <h4>Date Picker WIP Export</h4>
                        </div>
                        <div>
                            <form action="{{ route('mrp.report.report_wip-list') }}" method="post">
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
        <div class="col-lg-12">
            <div class="white_card mb_30 shadow pt-4">
                <div class="white_card_body">
                    <div class="QA_section">
                        <div class="white_box_tittle list_header">
                            <h4>Report Wip</h4>
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
