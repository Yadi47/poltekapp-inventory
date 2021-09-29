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
                                @if (auth()->user()->can('mrp.material-out-create'))
                                @endif
                                <a href="{{ route('mrp.material-out-create') }}">
                                    <div class="btn btn-primary ml-10">
                                <i class="ti-plus"></i>
                                Add New
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
                        <div class="QA_table mb_30">
                            <!-- table-responsive -->
                            <table class="table lms_table_active3 ">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Date</th> 
                                        <th scope="col">Shift</th>
                                        <th scope="col">Part Name</th>
                                        <th scope="col">Part Number</th>
                                        {{-- <th scope="col">Machine</th>  --}}
                                        <th scope="col">Qty Out</th> 
                                        <th scope="col">PIC</th>
                                        <!-- <th scope="col">Dim. Long</th>
                                        <th scope="col">Dim. Width</th>
                                        <th scope="col">Dim. Height</th>
                                        <th scope="col">Dim. Weight</th> -->
                                        <th scope="col">Description</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                     @foreach ($material_outs as $material_out)
                                     {{-- {{ dd($material_out) }} --}}
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{date('Y-m-d', strtotime($material_out->created_at)) ?? "N/A"}}</td>
                                    <td>{{$material_out->employee->shift->shift_name ?? "N/A"}}</td>
                                    <td>{{$material_out->inventoryMaterialList->material->material_name ?? "N/A"}}</td>
                                    <td>{{$material_out->inventoryMaterialList->material->part_number ?? "N/A"}}</td>
                                    {{-- <td>{{$material_out->machine->machine_name ?? "N/A"}}</td> --}}
                                    <td>{{$material_out->material_outgoing ?? "N/A"}}</td>
                                    <td>{{$material_out->employee->employee_name ?? "N/A"}}</td>
                                    <!-- <td>{{$material_out->inventoryMaterialList->material->dim_long ?? "N/A"}}</td>
                                    <td>{{$material_out->inventoryMaterialList->material->dim_width ?? "N/A"}}</td>
                                    <td>{{$material_out->inventoryMaterialList->material->dim_height ?? "N/A"}}</td>
                                    <td>{{$material_out->inventoryMaterialList->material->dim_weight ?? "N/A"}}</td> -->
                                    <td>{{$material_out->description}}</td>
                                    <td>
                                        <div class="action_btns d-flex"> 
                                            @if (auth()->user()->can('inventory_material_out-edit'))
                                            @endif
                                            <a href="{{route('mrp.material-out-edit',$material_out->id)}}" data-toggle="tooltip" title="Edit" class="action_btn mr_10" > <i class="far fa-edit"></i> </a>
                                            @if (auth()->user()->can('inventory_material_out-delete'))
                                            @endif
                                            <a href="" onclick="deleteData(event,{{$material_out->id}},'{{$material_out->material_id}}')" data-toggle="tooltip" title="Delete" class="action_btn mr_10"> <i class="fas fa-trash"></i> </a>
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

        var urlDelete = `{{ route('mrp.material-out-delete') }}`

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
