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
                                @if (auth()->user()->can('inventory_material_incoming-create'))
                                <a href="{{ route('mrp.material-incoming-create') }}">
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
                            <table class="table lms_table_active3 ">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Tanggal Masuk Conveyor</th>
                                        <th scope="col">Shift</th>
                                        <th scope="col">Part Name</th>
                                        <th scope="col">Part Number</th>
                                        <th scope="col">Incoming</th> 
                                        <th scope="col">Lot Material</th> 
                                        {{-- <th scope="col">Sortir</th>  --}}
                                        <th scope="col">PIC</th>
                                        {{-- <th scope="col">Part Name</th> --}}
                                        <!-- <th scope="col">Dim. Long</th>
                                        <th scope="col">Dim. Widht</th>
                                        <th scope="col">Dim. Height</th>
                                        <th scope="col">Dim. Weight</th> -->
                                        <th scope="col">Description</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                     @foreach ($material_incomings as $material_incoming)
                                     {{-- {{ dd($material_incoming) }} --}}
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$material_incoming->tanggal_masuk_convetor ?? "N/A"}}</td>
                                    <td>{{$material_incoming->employee->shift->shift_name ?? "N/A"}}</td>
                                    <td>{{$material_incoming->inventoryMaterialList->material->material_name ?? "N/A"}}</td>
                                    <td>{{$material_incoming->inventoryMaterialList->material->part_number ?? "N/A"}}</td>
                                    <td>{{$material_incoming->material_incoming ?? "N/A"}}</td>
                                    <td>{{$material_incoming->lot_material ?? "N/A"}}</td>
                                    {{-- <td>{{$material_incoming->sortir ?? "0"}}</td> --}}
                                    <td>{{$material_incoming->employee->employee_name ?? "N/A"}}</td>
                                    <!-- <td>{{$material_incoming->inventoryMaterialList->material->dim_long ?? "N/A"}}</td>
                                    <td>{{$material_incoming->inventoryMaterialList->material->dim_width ?? "N/A"}}</td>
                                    <td>{{$material_incoming->inventoryMaterialList->material->dim_height ?? "N/A"}}</td>
                                    <td>{{$material_incoming->inventoryMaterialList->material->dim_weight ?? "N/A"}}</td> -->
                                    <td>{{$material_incoming->description}}</td>
                                    <td>
                                        <div class="action_btns d-flex"> 
                                            @if (auth()->user()->can('inventory_material_incoming-edit'))
                                            <a href="{{route('mrp.material-incoming-edit',$material_incoming->id)}}" data-toggle="tooltip" title="Edit" class="action_btn mr_10" > <i class="far fa-edit"></i> </a>
                                            @endif
                                            @if (auth()->user()->can('inventory_material_incoming-delete'))
                                            <a href="" onclick="deleteData(event,{{$material_incoming->id}},'{{$material_incoming->material_id}}')" data-toggle="tooltip" title="Delete" class="action_btn mr_10"> <i class="fas fa-trash"></i> </a>
                                            {{-- <a href="{{route('mrp.inventory_material-add-stock',$material_incoming->id)}}" data-toggle="tooltip" title="Add Stock" class="action_btn "> <i class="fas fa-plus"></i> </a> --}}
                                            @endif
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

        var urlDelete = `{{ route('mrp.material-incoming-delete') }}`

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
