@extends('mrp')
@section('title', $page_title)
@section('content')
    <div class="row ">
        <div class="col-xl-12">
            <div class="white_card mb_30 shadow pt-4">
                <div class="white_card_body">
                    <div class="QA_section">
                        <div>
                            <form action="{{ route('mrp.machine-update', $machine->id) }}" method="post">
                                @method('patch')
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Machine Code</label>
                                            <input type="text" value="{{ $machine->machine_code }}"
                                                class="form-control @error('machine_code') is-invalid @enderror"
                                                name="machine_code">
                                            @error('machine_code')
                                                <span class="text-danger">*Machine Code Wajib Diisi!</span>
                                            @enderror
                                            <br>
                                            <label for="">Machine Name</label>
                                            <input type="text" value="{{ $machine->machine_name }}"
                                                class="form-control @error('machine_name') is-invalid @enderror"
                                                name="machine_name">
                                            @error('machine_name')
                                                <span class="text-danger">*Machine Name Wajib Diisi!</span>
                                            @enderror
                                            <br>
                                            <label for="">Type</label>
                                            <input type="text" value="{{ $machine->type }}"
                                                class="form-control @error('type') is-invalid @enderror" name="type">
                                            @error('type')
                                                <span class="text-danger">*Type Wajib Diisi</span>
                                            @enderror
                                            <br>
                                            <label for="">Brand</label>
                                            <input type="text" value="{{ $machine->brand }}"
                                                class="form-control @error('brand') is-invalid @enderror" name="brand">
                                            @error('brand')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                            <br>
                                            <label for="">Capacity</label>
                                            <input type="number" min="0" value="{{ $machine->capacity }}"
                                                class="form-control @error('capacity') is-invalid @enderror"
                                                name="capacity">
                                            @error('capacity')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                            <br>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Unit </label>
                                            <select class="form-control @error('unit_id') is-invalid @enderror" name="unit_id">
                                                <option disabled selected>Choose Unit</option>
                                                @foreach ($units as $unit)
                                                    <option value="{{ $unit->id ?? '' }}"
                                                        {{ (old('unit_id') ?? $machine->unit->id ?? '') == $unit->id ? 'selected' : '' }}>
                                                        {{ $unit->unit_code ?? '' }} | {{ $unit->unit_name ?? '' }}</option>
                                                @endforeach
                                            </select>
                                            @error('unit_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <br>
                                            <label>Place </label>
                                            <select class="form-control @error('place_id') is-invalid @enderror" name="place_id">
                                                <option disabled selected>Choose Place</option>
                                                @foreach ($places as $place)
                                                    <option value="{{ $place->id ?? '' }}"
                                                        {{ (old('place_id') ?? $machine->place->id ?? '') == $place->id ? 'selected' : '' }}>
                                                        {{ $place->place_code ?? '' }} | {{ $place->place_name ?? '' }}</option>
                                                @endforeach
                                            </select>
                                            @error('place_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <br>
                                            <label>Supplier </label>
                                            <select class="form-control @error('supplier_id') is-invalid @enderror" name="supplier_id">
                                                <option disabled selected>Choose Supplier</option>
                                                @foreach ($suppliers as $supplier)
                                                    <option value="{{ $supplier->id ?? '' }}"
                                                        {{ (old('supplier_id') ?? $machine->supplier->id ?? '') == $supplier->id ? 'selected' : '' }}>
                                                        {{ $supplier->supplier_code ?? '' }} | {{ $supplier->supplier_name ?? '' }}</option>
                                                @endforeach
                                            </select>
                                            @error('supplier_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <br>
                                            <label for="">Description <small>(Optional)</small></label>
                                            <textarea class="form-control @error('description') is-invalid @enderror"
                                                name="description">{{ $machine->description }}</textarea>
                                            @error('description')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <a href="{{ route('mrp.machine-list') }}">
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
