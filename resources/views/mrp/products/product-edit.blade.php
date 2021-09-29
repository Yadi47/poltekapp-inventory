@extends('mrp')
@section('title', $page_title)
@section('content')
    <div class="row ">
        <div class="col-xl-12">
            <div class="white_card mb_30 shadow pt-4">
                <div class="white_card_body">
                    <div class="QA_section">
                        <div>
                            <form action="{{ route('mrp.product-update', $product->id) }}" method="post">
                                @method('patch')
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label for="">Product Code</label>
                                        <input type="text" value="{{ $product->product_code }}"
                                            class="form-control @error('product_code') is-invalid @enderror"
                                            name="product_code">
                                        @error('product_code')
                                            <span class="text-danger">*Product Code Wajib Diisi!</span>
                                        @enderror
                                        <br>
                                    </div>

                                    <div class="col-lg-6">
                                        <label for="">Model</label>
                                        <input type="text" value="{{ $product->product_name }}"
                                            class="form-control @error('product_name') is-invalid @enderror"
                                            name="product_name">
                                        @error('product_name')
                                            <span class="text-danger">*Model Wajib Diisi!</span>
                                        @enderror
                                        <br>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Part Name</label>
                                            <input type="text" value="{{ $product->part_name }}"
                                                class="form-control @error('part_name') is-invalid @enderror"
                                                name="part_name">
                                            @error('part_name')
                                                <span class="text-danger">*Part Name Wajib Diisi!</span>
                                            @enderror
                                            <br>
                                            <label for="">Part Number</label>
                                            <input type="text" value="{{ $product->part_number }}"
                                                class="form-control @error('part_number') is-invalid @enderror"
                                                name="part_number">
                                            @error('part_number')
                                                <span class="text-danger">*Part Number Wajib Diisi!</span>
                                            @enderror
                                            <br>
                                            <label>BOM</label>
                                            <select class="form-control @error('bom_id') is-invalid @enderror" name="bom_id">
                                                <option disabled selected>Choose BOM</option>
                                                @foreach ($boms as $bom)
                                                    <option value="{{ $bom->id ?? '' }}"
                                                        {{ (old('bom_id') ?? ($product->bom->id ?? '')) == $bom->id ?? '' ? 'selected' : '' }}>
                                                        {{ $bom->bom_name ?? '' }} </option>
                                                @endforeach
                                            </select>
                                            @error('bom_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <br>
                                            <label for="">Dimension Long</label>
                                            <input type="number" min="0" value="{{ $product->dim_long }}"
                                                class="form-control @error('dim_long') is-invalid @enderror"
                                                name="dim_long">
                                            @error('dim_long')
                                                <span class="text-danger">*Dimmension Long Wajib Diisi!</span>
                                            @enderror
                                            <br>
                                            <label for="">Dimension Width</label>
                                            <input type="number" min="0" value="{{ $product->dim_width }}"
                                                class="form-control @error('dim_width') is-invalid @enderror"
                                                name="dim_width">
                                            @error('dim_width')
                                                <span class="text-danger">*Dimmension Width Wajib Diisi!</span>
                                            @enderror
                                            <br>
                                            <label for="">Dimension Height</label>
                                            <input type="number" min="0" value="{{ $product->dim_height }}"
                                                class="form-control @error('dim_height') is-invalid @enderror"
                                                name="dim_height">
                                            @error('dim_height')
                                                <span class="text-danger">*Dimmension Height Wajib Diisi!</span>
                                            @enderror
                                            <br>
                                            <label for="">Dimension Weight <small> <b>(Gram)</b> </small></label>
                                            <input type="text" value="{{ $product->dim_weight }}"
                                                class="form-control @error('dim_weight') is-invalid @enderror"
                                                name="dim_weight">
                                            @error('dim_weight')
                                                <span class="text-danger">*Dimmension Weight Wajib Diisi!</span>
                                            @enderror
                                            <br>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <!-- <label for="">Colour</label>
                                            <input type="text" value="{{ $product->colour }}"
                                                class="form-control @error('colour') is-invalid @enderror" name="colour">
                                            @error('colour')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                            <br> -->
                                            
                                            <br>
                                            <!-- <label for="">Price</label>
                                            <input type="number" min="0" value="{{ $product->price }}"
                                                class="form-control @error('price') is-invalid @enderror" name="price">
                                            @error('price')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                            <br> -->
                                            <label>Unit</label>
                                            <select class="form-control @error('unit_id') is-invalid @enderror" name="unit_id">
                                                <option disabled selected>Choose Unit</option>
                                                @foreach ($units as $unit)
                                                    <option value="{{ $unit->id ?? '' }}"
                                                        {{ (old('unit_id') ?? ($product->unit->id ?? '')) == $unit->id ?? '' ? 'selected' : '' }}>
                                                        {{ $unit->unit_code ?? '' }} | {{ $unit->unit_name ?? '' }}</option>
                                                @endforeach
                                            </select>
                                            @error('unit_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>*Unit Wajib Diisi!</strong>
                                                </span>
                                            @enderror
                                            <br>
                                            <label>Customer</label>
                                            <select class="form-control @error('customer_id') is-invalid @enderror" name="customer_id">
                                                <option disabled selected>Choose customer</option>
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->id }}"
                                                        {{ (old('customer_id') ?? $product->customer->id) == $customer->id ? 'selected' : '' }}>
                                                        {{ $customer->customer_code }} | {{ $customer->customer_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('customer_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <br>
                                            <label for="">Description <small>(Optional)</small></label>
                                            <textarea class="form-control @error('description') is-invalid @enderror"
                                                name="description">{{ $product->description }}</textarea>
                                            @error('description')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                            
                                </div>
                                <a href="{{ route('mrp.product-list') }}">
                                    <button type="button" class="btn btn-warning btn-sm">
                                    <i class="ti-back-left"></i>
                                    Back</button>
                                </a>
                                <button class="btn btn-success btn-sm">
                                <i class="ti-save"></i>
                                Save</button>
                            </form>
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
    
