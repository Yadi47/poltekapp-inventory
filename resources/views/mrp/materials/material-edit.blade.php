@extends('mrp')
@section('title', $page_title)
@section('content')
    <div class="row ">
        <div class="col-xl-12">
            <div class="white_card mb_30 shadow pt-4">
                <div class="white_card_body">
                    <div class="QA_section">
                        <div>
                            <form action="{{ route('mrp.material-update', $material->id) }}" method="post">
                                @method('patch')
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6">

                                        <div class="form-group">
                                            <label for="">Material Code</label>
                                            <input type="text" value="{{ $material->material_code }}"
                                                class="form-control @error('material_code') is-invalid @enderror"
                                                name="material_code">
                                            @error('material_code')
                                                <span class="text-danger">*Material Code Wajib Diisi!</span>
                                            @enderror
                                            <br>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Part Name</label>
                                            <input type="text" value="{{ $material->material_name }}"
                                                class="form-control @error('material_name') is-invalid @enderror"
                                                name="material_name">
                                            @error('material_name')
                                                <span class="text-danger">*Part Name Wajib Diisi!</span>
                                            @enderror
                                            <br>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Part Number</label>
                                            <input type="text" value="{{ $material->part_number }}"
                                                class="form-control @error('part_number') is-invalid @enderror"
                                                name="part_number">
                                            @error('part_number')
                                                <span class="text-danger">Part Number Wajib Diisi!</span>
                                            @enderror
                                            <br>
                                            <label for="">Dimension Long</label>
                                            <input type="number" min="0" value="{{ $material->dim_long }}"
                                                class="form-control @error('dim_long') is-invalid @enderror"
                                                name="dim_long">
                                            @error('dim_long')
                                                <span class="text-danger">*Dimension Long Wajib Diisi!</span>
                                            @enderror
                                            <br>
                                            <label for="">Dimension Width</label>
                                            <input type="number" min="0" value="{{ $material->dim_width }}"
                                                class="form-control @error('dim_width') is-invalid @enderror"
                                                name="dim_width">
                                            @error('dim_width')
                                                <span class="text-danger">*Dimension Width Wajib Diisi!</span>
                                            @enderror
                                            <br>
                                            <label for="">Dimension Height </label>
                                            <input type="number" min="0" value="{{ $material->dim_height }}"
                                                class="form-control @error('dim_height') is-invalid @enderror"
                                                name="dim_height">
                                            @error('dim_height')
                                                <span class="text-danger">*Dimension Height Wajib Diisi!</span>
                                            @enderror
                                            <br>
                                            <label for="">Dimension Weight <small> <b>(Gram)</b> </small></label>
                                            <input type="number" min="0" value="{{ $material->dim_weight }}"
                                                class="form-control @error('dim_weight') is-invalid @enderror"
                                                name="dim_weight">
                                            @error('dim_weight')
                                                <span class="text-danger">*Dimension Weight Wajib Diisi!</span>
                                            @enderror
                                            <br>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <!-- <label for="">Currency</label>
                                            <input type="text" value="{{ $material->colour }}"
                                                class="form-control @error('colour') is-invalid @enderror" name="colour">
                                            @error('colour')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                            <br>
                                            <label for="">Price</label>
                                            <input type="number" min="0" step="0.1" value="{{ $material->price }}"
                                                class="form-control @error('price') is-invalid @enderror" name="price">
                                            @error('price')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                            <br> -->
                                            <label>Supplier</label>
                                            <select class="form-control @error('supplier_id') is-invalid @enderror" name="supplier_id">
                                                <option disabled selected>Choose Supplier</option>
                                                
                                                @foreach ($suppliers as $supplier)
                                                    <option value="{{ $supplier->id ?? '' }}"
                                                        {{ (old('supplier_id') ?? ($material->supplier->id ?? '')) == $supplier->id ?? '' ? 'selected' : '' }}>
                                                        {{ $supplier->supplier_code ?? '' }} | {{ $supplier->supplier_name ?? '' }}</option>
                                                @endforeach
                                            </select>
                                            @error('supplier_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                            <br>
                                            <label>Unit</label>
                                            <select class="form-control @error('unit_id') is-invalid @enderror" name="unit_id">
                                                @foreach ($units as $unit)
                                                    <option value="{{ $unit->id ?? '' }}"
                                                        {{ (old('unit_id') ?? ($material->unit->id ?? '')) ==  $unit->id ?? '' ? 'selected' : '' }}>
                                                        {{ $unit->unit_code ?? '' }} | {{ $unit->unit_name ?? '' }}</option>
                                                @endforeach
                                            </select>
                                            @error('unit_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <br>
                                            <label for="">Description <small>(Optional)</small></label>
                                            <textarea class="form-control @error('description') is-invalid @enderror"
                                                name="description">{{ $material->description }}</textarea>
                                            @error('description')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <a href="{{ route('mrp.material-list') }}">
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
