@extends('mrp')

@section('title', $page_title)

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="white_card mb_30 shadow pt-4">
                <div class="white_card_body">
                    @if (Session::has('entry-message'))
                        <div class="alert  {{ Session::get('alert-class', 'alert-info') }} d-flex align-items-center justify-content-between"
                            role="alert">
                            <div class="alert-text">
                                <p>{{ Session::get('entry-message') }}</p>
                            </div>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="ti-close  f_s_14"></i>
                            </button>
                        </div>
                    @endif
                    <div class="QA_section">
                        <div>
                            <form
                                action="{{ route('mrp.delivery.delivery_shipment.delivery_shipment-update', $shipment->id) }}"
                                method="post">
                                @method('patch')
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4">
                                        <input type="hidden" name="shipment_id">
                                        <div class="form-group">
                                            <label for="">DN Code</label>
                                            <input type="text" value="{{ $shipment->dn_code }}"
                                                class="form-control @error('dn_code') is-invalid @enderror" name="dn_code"
                                                readonly>
                                            @error('dn_code')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Delivery Date</label>
                                            <input type="date" value="{{ $shipment->delivery_date }}"
                                                class="form-control @error('delivery_date') is-invalid @enderror"
                                                name="delivery_date" readonly>
                                            @error('delivery_date')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Vehicle No</label>
                                            <select class="form-control @error('vehicle_id') is-invalid @enderror" name="vehicle_id" readonly>
                                                <option disabled selected>Choose Vehicle</option>
                                                @foreach ($vehicles as $vehicle)
                                                    <option value="{{ $vehicle->id }}"
                                                        {{ (old('unit_id') ?? $shipment->vehicle->id) == $vehicle->id ? 'selected' : '' }}>
                                                        {{ $vehicle->car_code }} </option>
                                                @endforeach
                                            </select>
                                            @error('cust_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Customer</label>
                                            <select class="form-control @error('cust_id') is-invalid @enderror" name="cust_id" readonly>
                                                <option disabled selected>Choose Customer</option>
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->id }}"
                                                        {{ old('cust_id') ?? $shipment->customer->id == $customer->id ? 'selected' : '' }}>
                                                        {{ $customer->customer_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('cust_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        {{-- {{ dd($shipment->deliveryPlanning[0]) }} --}}
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="">Delivery Planning Code</label>
                                            <select class="form-control @error('planning_id') is-invalid @enderror" name="planning_id" readonly>
                                                <option disabled selected>-</option>
                                                @foreach ($plannings as $planning)
                                                    <option value="{{ $planning->id }}"
                                                        {{ old('planning_id') ?? $shipment->deliveryPlanning->id == $planning->id ? 'selected' : '' }}>
                                                        {{ $planning->do_code }}</option>
                                                @endforeach
                                            </select>
                                            @error('planning_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label for="">Description <small>(Optional)</small></label>
                                                <textarea class="form-control @error('description') is-invalid @enderror"
                                                    name="description">{{ $shipment->description }}</textarea>
                                                @error('description')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <a href="{{ route('mrp.delivery.delivery_shipment.delivery_shipment-list') }}">
                        <button type="button" class="btn btn-warning btn-sm">
                            <i class="ti-back-left"></i>
                            Back</button>
                    </a>
                    <button class="btn btn-success btn-sm">
                        <i class="ti-save"></i>
                        Save</button>
                </div>
            </div>

        </div>
    </div>
    </div>


    <div class="row">
        <div class="col-xl-12">
            <div class="white_card mb_30 shadow pt-4">
                <div class="white_card_body">
                    @if (Session::has('message'))
                        <div class="alert  {{ Session::get('alert-class', 'alert-info') }} d-flex align-items-center justify-content-between"
                            role="alert">
                            <div class="alert-text">
                                <p>{{ Session::get('message') }}</p>
                            </div>
                        </div>
                    @endif
                    <div class="QA_table mb_30">
                        <!-- table-responsive -->
                        <table class="table">
                            <thead class="table">
                                @if ($errors->has('inventory_product_list_id') || $errors->has('quantity') || $errors->has('unit_id') || $errors->has('po_code'))
                                    <div class="alert alert-danger">
                                        <ul>
                                            @error('inventory_product_id')
                                                <li>{{ $message }}</li>
                                            @enderror
                                            @error('quantity')
                                                <li>{{ $message }}</li>
                                            @enderror
                                            @error('unit_id')
                                                <li>{{ $message }}</li>
                                            @enderror
                                            @error('po_code')
                                                <li>{{ $message }}</li>
                                            @enderror
                                        </ul>
                                    </div>
                                @endif
                                <tr>
                                    <th scope="col" style="text-align:center" width="5">No</th>
                                    <th scope="col" style="text-align:center">Product</th>
                                    <th scope="col" style="text-align:center" width="15%">Quantity</th>
                                    <th scope="col" style="text-align:center">Unit</th>
                                    <th scope="col" style="text-align:center" width="20%">PO Code</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">
                                        <span class="text-dark">

                                        </span>
                                    </td>
                                    <td>
                                        {{-- {{ dd($inventory_products[0]->production->product) }} --}}
                                        <select name="inventory_product_list_id" id="inventory_product_list_id"
                                            class="form-control">
                                            <option value="">Select Product</option>

                                            @foreach ($inventory_products as $inventory_product)
                                                <option value="{{ $inventory_product->id }}"
                                                    {{ old('inventory_product_list_id') == $inventory_product->id ? 'selected' : '' }}>
                                                    {{ $inventory_product->product->product_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('inventory_product_list_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </td>

                                    <td>
                                        <input type="number" min="0" value="{{ old('quantity') }}"
                                            class="form-control @error('quantity') is-invalid @enderror" name="quantity">
                                        @error('quantity')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </td>

                                    <td>
                                        <select name="unit_id" id="unit_id" class="form-control">
                                            <option value="">Select Unit</option>
                                            @foreach ($units as $unit)
                                                <option value="{{ $unit->id }}"
                                                    {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                                                    {{ $unit->unit_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('unit_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </td>

                                    <td>
                                        <input type="text" value="{{ old('po_code') }}"
                                            class="form-control @error('po_code') is-invalid @enderror" name="po_code">
                                        @error('po_code')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </td>

                                    <td>
                                        <center>
                                            <button class="btn btn-success btn-sm">
                                                <i class="ti-plus"></i>
                                                Add Item</button>
                                        </center>
                                    </td>
                                </tr>
                                </form>
                                        {{-- {{ dd($inventory_shipments[0]->inventoryProductList) }} --}}
                                @foreach ($inventory_shipments as $inventory_shipment)
                                    <tr>
                                        <th scope="row" style="text-align:center">{{ $loop->iteration }}</th>
                                        <td style="text-align:center">
                                            {{ $inventory_shipment->inventoryProductList->product->product_name }}
                                        </td>
                                        <td style="text-align:center">{{ $inventory_shipment->quantity }}</td>
                                        <td style="text-align:center">{{ $inventory_shipment->unit->unit_name }}</td>
                                        <td style="text-align:center">{{ $inventory_shipment->po_code }}</td>
                                        <td>
                                            <div class="action_btns d-flex">
                                                <a href=""
                                                    onclick="deleteData(event,{{ $inventory_shipment->id }},'{{ $inventory_shipment->po_code }}')"
                                                    class="action_btn"> <i class="fas fa-trash"></i> </a>
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
    </div>
    </div>
@endsection

@push('css')
    <!-- datatable CSS -->
    <link rel="stylesheet" href="{{ asset('assets') }}/vendors/datatable/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendors/datatable/css/responsive.dataTables.min.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendors/datatable/css/buttons.dataTables.min.css" />
    <style>
        .table tr {
            cursor: pointer;
        }

        .table-hover-custom>tbody>tr:hover {
            background-color: #d1cfcfda !important;
        }

    </style>
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

        $('#planning_id').change(function() {
            axios.get("/mrp/planning/api/" + $(this).val())
                .then(function(response) {
                    // handle success
                    $('#qty_plan').val(response.data.plan_qty)
                    $('#qty_actual').val(response.data.plan_qty)
                    $('#qty_reject').val(0)
                    $('#qty_good').val(response.data.plan_qty)
                })
                .catch(function(error) {
                    // handle error
                    console.log(error);
                })
                .then(function() {
                    // always executed
                });
        })

        var urlInvntoryShipmentDelete =
            `{{ route('mrp.delivery.delivery_shipment.delivery_shipment-inventoryShipmentDelete') }}`

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
                            axios.delete(urlInvntoryShipmentDelete, {
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
