@extends('mrp')
@section('title', $page_title)
@section('content')
<style>
    #td1{
        cursor: pointer;
    }
    #td1:hover{
        background-color: rgba(233, 229, 229, 0.541);
    }
</style>

<!-- <div class="col-sm-6">
    <div class="box">
        <div class="box-header">
            <h4 class="box-title">Import data from excel</h4>  
        </div>

        <form action="{{ route('import.inventory-material') }}" method="POST" enctype="multipart/form-data">
            @csrf
        
            <div class="card-body">
                <div class="form-group @error('import_file') error @enderror">
                    <label class="form-label">File Excel </label>

                    <input class="form-control form-control-sm" type="file" id="formFile" name="import_file">

                    @error('import_file')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="box-footer">        
                <button type="submit" class="btn btn-sm btn-success">
                    <i class="ti-upload"></i> Upload
                </button>
            </div>
        </form> 
    </div>
</div>  -->

<div class="row ">
    <div class="col-xl-12">
        <div class="white_card mb_30 shadow pt-4">
            <div class="white_card_body">
                <div class="QA_section">
                    <div class="white_box_tittle list_header">
                        <h4>{{ $page_title }}</h4>

                    <div class="box_right d-flex lms_block">
                        <a href="{{ route('mrp.inventory-index') }}">
                            <div class="btn btn-warning btn-sm ml-10">
                                <i class="ti-back-left"></i>
                                Back
                            </div>
                        </a>
                        <a href="{{ route('mrp.inventory_product-create') }}">
                            <div class="btn btn-primary btn-sm ml-10">
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
                                <th scope="col">Part Name</th>
                                <th scope="col">Part Number</th>
                                <th scope="col">Begin Stock</th>
                                <th scope="col">Total Stock</th>
                                <th scope="col">Target Qty (day)</th>
                                <th scope="col">Target Qty</th>
                                <th scope="col">Target (day)</th>
                                <th scope="col">Stock Available For (day)</th>
                                <th scope="col">Description</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inven_products as $inventory_product)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                    
                                <td>{{date('Y-m-d', strtotime($inventory_product->created_at)) ?? "N/A"}}</td>
                                <td id="td1" onclick="stock('{{ $inventory_product->id ?? 'N/A' }}','{{ $inventory_product->product->part_name ?? 'N/A' }}','{{ $inventory_product->stock }}')">
                                    {{ $inventory_product->product->part_name ?? 'N/A' }}
                                </td>
                                <td>{{ $inventory_product->product->part_number ?? 'N/A' }}</td>
                                <td>{{ $inventory_product->initial_stock ?? 'N/A' }}</td>
                                <td>{{ $inventory_product->stock ?? 'N/A' }}</td>
                                <td>{{$inventory_product->total_target_day ?? "N/A"}}</td>
                                <td>{{$inventory_product->qty_target ?? "N/A"}}</td>
                                <td>{{$inventory_product->target_day ?? "N/A"}}</td>
                                <td>{{ $inventory_product->totalStock() }}</td>
                                <!-- <td>{{$inventory_product->product->dim_long ?? "N/A"}}</td>
                                        <td>{{$inventory_product->product->dim_width ?? "N/A"}}</td>
                                        <td>{{$inventory_product->product->dim_height ?? "N/A"}}</td>
                                        <td>{{$inventory_product->product->dim_weight ?? "N/A"}}</td> -->
                                <td>{{ $inventory_product->description }}</td>
                                <td>
                                    <div class="action_btns d-flex">
                                        <a href="{{route('mrp.inventory_product-edit',$inventory_product->id)}}"
                                            data-toggle="tooltip" title="Edit" class="action_btn mr_10"> <i
                                                class="far fa-edit"></i> </a>
                                        <a href="" onclick="deleteData(event,{{ $inventory_product->id }},'')"
                                            data-toggle="tooltip" title="Delete" class="action_btn mr_10"> <i
                                                class="fas fa-trash"></i> </a>
                                        {{-- <a href="{{route('mrp.inventory_product-add-stock',$inventory_product->id)}}"
                                        data-toggle="tooltip" title="Add Stock" class="action_btn "> <i
                                            class="fas fa-plus"></i> </a> --}}

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

@endsection

@push('css')
<!-- datatable CSS -->
<link rel="stylesheet" href="{{ asset('assets') }}/vendors/datatable/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="{{ asset('assets') }}/vendors/datatable/css/responsive.dataTables.min.css" />
<link rel="stylesheet" href="{{ asset('assets') }}/vendors/datatable/css/buttons.dataTables.min.css" />
<link rel="stylesheet" href="{{ asset('assets') }}/css/animate.min.css" />
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

    var urlDelete = `{{ route('mrp.inventory_product-delete') }}`

    function deleteData(event, id, textData) {
        event.preventDefault();
        $.confirm({
            title: 'Are you sure for delete data ?',
            content: textData,
            buttons: {
                confirm: {
                    btnClass: 'btn-red',
                    keys: ['enter'],
                    action: function () {
                        axios.delete(urlDelete, {
                                params: {
                                    id: id,
                                    text: textData
                                }
                            })
                            .then(function (response) {
                                // handle success
                                location.reload();
                            })
                            .catch(function (error) {
                                // handle error
                                console.log(error);
                            })
                            .then(function () {
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

    function stock(id,name,stock) {
        Swal.fire({
            title: 'PRODUCT ' + name,
            showDenyButton: true,
            confirmButtonText: 'Stock In',
            denyButtonText: `Stock Out Delivery`,
            showClass: {
                popup: 'animate__animated animate__zoomIn animate__delay-0.3s'
            },
                hideClass: {
                popup: 'animate__animated animate__zoomOut animate__delay-0.3s'
            }
            }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.confirm({
                    title: 'Create Stock In',
                    content: 'URL:/api/product-incoming-create',
                    columnClass: 'small',
                    type: 'blue',
                    animation: 'zoom',
                    animationSpeed: 800,
                    buttons: {
                        formSubmit: {
                            text: 'Submit',
                            btnClass: 'btn-blue',
                            action: function() {
                                let product_incoming, employee_id, machine_id, description,product_list_id, current_stock;
                                product_incoming = this.$content.find('#product_incoming').val();
                                employee_id = this.$content.find('#employee_id').val();
                                machine_id = this.$content.find('#machine_id').val();
                                description = this.$content.find('#description').val();
                                product_list_id =  btn-sm;
                                current_stock = (Number(stock) + Number(this.$content.find('#product_incoming').val()));
                                
                                if (!product_incoming || !employee_id || !machine_id) {
                                    this.close();
                                    Swal.fire({
                                        title: 'Failed!',
                                        icon: 'error',
                                        html: 'Insert failed : Product Incoming, PIC, or Machine still empty!',
                                        showClass: {
                                            popup: 'animate__animated animate__zoomIn'
                                        },
                                        hideClass: {
                                            popup: 'animate__animated animate__zoomOut'
                                        },
                                        confirmButtonText: 'Ok',
                                        
                                    })
                                    return false;
                                }

                                $.ajax({
                                    type: 'POST',
                                    url: '/api/product-incoming-store',
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        product_incoming,
                                        employee_id,
                                        machine_id,
                                        description,
                                        product_list_id,
                                        current_stock,
                                    },
                                    async: false,
                                    success: function(data) {
                                        console.log(data);
                                        Swal.fire({
                                            title: 'Success Insert!!',
                                            icon: 'success',
                                            html: name,
                                            confirmButtonText: 'Ok',
                                            showClass: {
                                                popup: 'animate__animated animate__zoomIn'
                                            },
                                            hideClass: {
                                                popup: 'animate__animated animate__zoomOut'
                                            }
                                            }).then((result) => {
                                            /* Read more about isConfirmed, isDenied below */
                                            if (result.isConfirmed) {
                                                location.reload();
                                            }
                                        })
                                        // location.reload();
                                    },
                                    error: function(data) {
                                        Swal.fire({
                                            title: 'Failed!',
                                            icon: 'error',
                                            html: data.responseJSON.message,
                                            showClass: {
                                                popup: 'animate__animated animate__zoomIn'
                                            },
                                            hideClass: {
                                                popup: 'animate__animated animate__zoomOut'
                                            },
                                            confirmButtonText: 'Ok',
                                            }).then((result) => {
                                            /* Read more about isConfirmed below */
                                            if (result.isConfirmed) {
                                                location.reload();
                                            }
                                        })
                                        // $.alert(data.responseJSON.message);
                                    }
                                });
                            }
                        },
                        cancel: function() {
                            //close
                        },
                    },
                    onContentReady: function() {
                        // bind to events
                        var jc = this;
                        this.$content.find('form').on('submit', function(e) {
                            // if the user submits the form by pressing enter in the field.
                            e.preventDefault();
                            jc.$$formSubmit.trigger('click'); // reference the button and click it
                        });
                    }
                });
            } else if (result.isDenied) {
                $.confirm({
                    title: 'Create Stock Out Delivery',
                    content: 'URL:/api/product-out-create',
                    columnClass: 'small',
                    type: 'blue',
                    animation: 'zoom',
                    animationSpeed: 800,
                    buttons: {
                        formSubmit: {
                            text: 'Submit',
                            btnClass: 'btn-blue',
                            action: function() {
                                let product_outgoing, employee_id,  description,product_list_id, current_stock, delivery_shipment_id;
                                product_outgoing = this.$content.find('#product_outgoing').val();
                                employee_id = this.$content.find('#employee_id').val();
                                description = this.$content.find('#description').val();
                                delivery_shipment_id = this.$content.find('#delivery_shipment_id').val();
                                product_list_id = id;
                                current_stock = (Number(stock) - Number(this.$content.find('#product_outgoing').val()));
                                
                                if (!product_outgoing || !employee_id || !delivery_shipment_id) {
                                    this.close();
                                    Swal.fire({
                                        title: 'Failed!',
                                        icon: 'error',
                                        html: 'Insert failed : Product Outgoing, PIC, or Delivery still empty!',
                                        showClass: {
                                            popup: 'animate__animated animate__zoomIn'
                                        },
                                        hideClass: {
                                            popup: 'animate__animated animate__zoomOut'
                                        },
                                        confirmButtonText: 'Ok',
                                    })
                                    return false;
                                }

                                $.ajax({
                                    type: 'POST',
                                    url: '/api/product-out-store',
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        product_outgoing,
                                        employee_id,
                                        description,
                                        product_list_id,
                                        delivery_shipment_id,
                                        current_stock
                                    },
                                    async: false,
                                    success: function(data) {
                                        console.log(data);
                                        Swal.fire({
                                            title: 'Success Insert!!',
                                            icon: 'success',
                                            html: name,
                                            confirmButtonText: 'Ok',
                                            showClass: {
                                                popup: 'animate__animated animate__zoomIn'
                                            },
                                            hideClass: {
                                                popup: 'animate__animated animate__zoomOut'
                                            }
                                            }).then((result) => {
                                            /* Read more about isConfirmed, isDenied below */
                                            if (result.isConfirmed) {
                                                location.reload();
                                            }
                                        })
                                        // location.reload();
                                    },
                                    error: function(data) {
                                        Swal.fire({
                                            title: 'Failed!',
                                            icon: 'error',
                                            html: data.responseJSON.message,
                                            showClass: {
                                                popup: 'animate__animated animate__zoomIn'
                                            },
                                            hideClass: {
                                                popup: 'animate__animated animate__zoomOut'
                                            },
                                            confirmButtonText: 'Ok',
                                            }).then((result) => {
                                            /* Read more about isConfirmed below */
                                            if (result.isConfirmed) {
                                                location.reload();
                                            }
                                        })
                                        // $.alert(data.responseJSON.message);
                                    }
                                });
                            }
                        },
                        cancel: function() {
                            //close
                        },
                    },
                    onContentReady: function() {
                        // bind to events
                        var jc = this;
                        this.$content.find('form').on('submit', function(e) {
                            // if the user submits the form by pressing enter in the field.
                            e.preventDefault();
                            jc.$$formSubmit.trigger('click'); // reference the button and click it
                        });
                    }
                });
            }
        })
    }

</script>
@endpush
