@extends('mrp')

@section('title', $page_title)

@section('content')
    <div class="row ">
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
                                action="{{ route('mrp.delivery.delivery_planning.delivery_planning-update', $planning->id) }}"
                                method="post">
                                @method('patch')
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">DO Code</label>
                                            <input type="text" value="{{ $planning->do_code }}"
                                                class="form-control @error('do_code') is-invalid @enderror" name="do_code">
                                            @error('do_code')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Do Date</label>
                                            <input type="date" value="{{ $planning->do_date }}"
                                                class="form-control @error('do_date') is-invalid @enderror" name="do_date">
                                            @error('do_date')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Delivery Date</label>
                                            <input type="date" value="{{ $planning->delivery_date }}"
                                                class="form-control @error('delivery_date') is-invalid @enderror"
                                                name="delivery_date">
                                            @error('delivery_date')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Customer</label>
                                            <select class="form-control @error('customer_id') is-invalid @enderror" name="customer_id">
                                                <option disabled selected>Choose Unit</option>
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->id }}"
                                                        {{ old('customer_id') ?? $planning->customer_id == $customer->id ? 'selected' : '' }}>
                                                        {{ $customer->customer_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('cust_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Description <small>(Optional)</small></label>
                                            <textarea class="form-control @error('description') is-invalid @enderror"
                                                name="description">{{ $planning->description }}</textarea>
                                            @error('description')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                </div>

                        </div>
                        <a href="{{ route('mrp.delivery.delivery_planning.delivery_planning-list') }}">
                            <button type="button" class="btn btn-warning btn-sm">
                                <i class="ti-back-left"></i>
                                Back</button>

                        </a>
                        <button class="btn btn-success btn-sm"><i class="ti-save"></i> Save</button>

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
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <i class="ti-close  f_s_14"></i>
                                    </button>
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
                                                <select name="inventory_product_list_id" id="inventory_product_list_id"
                                                    class="form-control @error('inventory_product_list_id') is-invalid @enderror">
                                                    <option value="">Select Product</option>
                                                    @foreach ($inventory_products as $inventory_product)
                                                        <option value="{{ $inventory_product->id }}"
                                                            {{ old('inventory_product_list_id') == $inventory_product->id ? 'selected' : '' }}>
                                                            {{$inventory_product->product->product_name }}
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
                                                    class="form-control @error('quantity') is-invalid @enderror"
                                                    name="quantity">
                                                @error('quantity')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </td>

                                            <td>
                                                <select name="unit_id" id="unit_id" class="form-control @error('unit_id') is-invalid @enderror">
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
                                                    class="form-control @error('po_code') is-invalid @enderror"
                                                    name="po_code">
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
                                        @foreach ($inventory_plannings as $inventory_planning)
                                            <tr>
                                                <th scope="row" style="text-align:center">{{ $loop->iteration }}</th>
                                                <td style="text-align:center">
                                                    {{ $inventory_planning->inventoryProductList->product->product_name }}
                                                </td>
                                                <td style="text-align:center">{{ $inventory_planning->quantity }}</td>
                                                <td style="text-align:center">{{ $inventory_planning->unit->unit_name }}
                                                </td>
                                                <td style="text-align:center">{{ $inventory_planning->po_code }}</td>
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
        // $('.row-permission').click(function () {
        //     let data = $(this).find('td input:checkbox');
        //     console.log(data.prop('checked', !data.is(':checked')));
        // });
        // $('#checkAll').click(function (e) {
        //     // var table= $(e.target).closest('.table');
        //     let find = $('.lms_table_active3').find('tr td input:checkbox').prop('checked', true);
        //     console.log(find);
        // });
        // $('#uncheckAll').click(function (e) {
        //     // var table= $(e.target).closest('.table');
        //     let find = $('.lms_table_active3').find('tr td input:checkbox').prop('checked', false);
        //     console.log(find);
        // });

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
    </script>
@endpush
