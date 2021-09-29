@extends('mrp')

@section('title', $page_title)

@section('content')
    <div class="row ">
        <div class="col-xl-6">
            <div class="white_card mb_30 shadow pt-4">
                <div class="white_card_body">
                    <div class="QA_section">
                        <div>
                            <form action="{{ route('mrp.material-sortir-store-sortir-ng') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label>Material</label>
                                    <select class="form-control @error('inventory_material_list_id') is-invalid @enderror" name="inventory_material_list_id">
                                        <option disabled selected>Choose Material</option>
                                        @foreach ($inven_materials as $material)
                                                <option value="{{ $material->id }}"
                                                    {{ old('inventory_material_list_id') == $material->id ? 'selected' : '' }}>
                                                    {{ $material->material->material_code }} | {{ $material->material->material_name }} | {{ $material->material->part_number }}</option>
                                                </option>
                                            @endforeach
                                    </select>
                                    @error('inventory_material_list_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="">Qty NG</label>
                                    <input  type="number" min="0" value="{{ old('qty_ng') }}" id="qty_ng"
                                        class="form-control @error('qty_ng') is-invalid @enderror" name="qty_ng">
                                    @error('qty_ng')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="">Date</label>
                                    <input type="text" value="{{ old('date') }}" class="form-control digits minMaxExample
                                        @error('date') is-invalid @enderror" id="" name="date"
                                        autocomplete="off">
                                    @error('date')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>PIC</label>  
                                    <select class="form-control @error('employee_id') is-invalid @enderror" name="employee_id">
                                        <option disabled selected>Choose PIC</option>
                                        @foreach ($employees as $employee)
                                                <option value="{{ $employee->id }}"
                                                    {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                                    {{ $employee->employee_name }}</option>
                                            @endforeach
                                    </select>
                                    @error('employee_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                
                                
                                <div class="form-group">
                                    <label for="">Description <small>(Optional)</small></label>
                                    <textarea class="form-control @error('description') is-invalid @enderror"
                                        name="description">{{ old('description') }}</textarea>
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                        </div>

                    </div>
                    <a href="{{ route('mrp.material-sortir-list-sortir-ng') }}">
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
    <link rel="stylesheet" href="{{ asset('assets') }}/vendors/datepicker/date-picker.css"> 

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

    
    </script>
@endpush
