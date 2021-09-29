@extends('mrp')
@section('title', $page_title)
@section('content')
    <div class="row ">
        <div class="col-xl-12">
            <div class="white_card mb_30 shadow pt-4">
                <div class="white_card_body">
                    <div class="QA_section">
                        <div class="white_box_tittle list_header">
                            <h4>{{ $page_title }}</h4>

                            <div class="box_right d-flex lms_block">
                                <a href="{{ route('mrp.inventory-index') }}">
                                    <div class="btn btn-warning ml-10">
                                        <i class="ti-back-left"></i>
                                        Back
                                    </div>
                                </a>
                                @if (auth()->user()->can('inventory_product_incoming-create'))
                                <a href="{{ route('mrp.product-incoming-create') }}">
                                    <div class="btn btn-primary ml-10">
                                        <i class="ti-plus"></i>
                                        Add New
                                    </div>
                                </a>
                                @endif
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
                        <div class="QA_table mb_30">
                            <!-- table-responsive -->
                            <table class="table lms_table_active3 " style="">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Part Name</th>
                                        <th scope="col">Part Number</th>
                                        <th scope="col">Model</th>
                                        <th scope="col">Incoming</th>
                                        <th scope="col">PIC</th>
                                        <th scope="col">Shift</th>
                                        <!-- <th scope="col">Dim. Long</th>
                                        <th scope="col">Dim. Width</th>
                                        <th scope="col">Dim. Height</th>
                                        <th scope="col">Dim. Weight</th> -->
                                        <!-- <th scope="col">Date</th> -->
                                        <th scope="col">Description</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($product_incomings as $product_incoming)
                            
                                        <tr>
                                            
                                            <td>{{ $loop->iteration }}</td>
                                        <td>{{date('Y-m-d', strtotime($product_incoming->created_at)) ?? "N/A"}}</td>
                                            <td>{{$product_incoming->inventoryProductList->product->part_name ?? "N/A"}}</td>
                                            <td>{{$product_incoming->inventoryProductList->product->part_number ?? "N/A"}}</td>
                                            <td>{{ $product_incoming->inventoryProductList->product->product_name ?? 'N/A' }}</td>
                                            <td>{{ $product_incoming->product_incoming ?? 'N/A' }}</td>
                                            <td>{{ $product_incoming->employee->employee_name ?? 'N/A' }}</td>
                                            <td>{{ $product_incoming->employee->shift->shift_name ?? 'N/A' }}</td>
                                            <!-- <td>{{$product_incoming->inventoryProductList->product->dim_long ?? "N/A"}}</td>
                                            <td>{{$product_incoming->inventoryProductList->product->dim_width ?? "N/A"}}</td>
                                            <td>{{$product_incoming->inventoryProductList->product->dim_height ?? "N/A"}}</td>
                                            <td>{{$product_incoming->inventoryProductList->product->dim_weight ?? "N/A"}}</td> -->
                                            <!-- <td>{{date('Y-m-d', strtotime($product_incoming->created_at)) ?? "N/A"}}</td> -->
                                            <td>{{ $product_incoming->description }}</td>
                                            <td>
                                                <div class="action_btns d-flex">
                                                    <a href="{{route('mrp.product-incoming-edit',$product_incoming->id)}}" data-toggle="tooltip" title="Edit" class="action_btn mr_10" > <i class="far fa-edit"></i> </a>
                                                    <a href="" onclick="deleteData(event,{{ $product_incoming->id }},'')"
                                                        data-toggle="tooltip" title="Delete" class="action_btn mr_10"> <i
                                                            class="fas fa-trash"></i> </a>

                                                </div>
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
@endsection

@push('css')
    <!-- datatable CSS -->
    <link rel="stylesheet" href="{{ asset('assets') }}/vendors/datatable/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendors/datatable/css/responsive.dataTables.min.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendors/datatable/css/buttons.dataTables.min.css" />
@endpush
@push('js')

    <script src="{{ asset('assets') }}/vendors/datatable/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('assets') }}/vendors/datatable/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('assets') }}/vendors/datatable/js/dataTables.buttons.min.js"></script>
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

        var urlDelete = `{{ route('mrp.product-incoming-delete') }}`

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
    </script>
@endpush
