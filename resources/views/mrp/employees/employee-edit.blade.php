@extends('mrp')
@section('title', $page_title)
@section('content')
    <div class="row ">
        <div class="col-xl-12">
            <div class="white_card mb_30 shadow pt-4">
                <div class="white_card_body">
                    <div class="QA_section">
                        <div>
                            <form action="{{ route('mrp.employee-update', $employee->id) }}" method="post">
                                @method('patch')
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">NIK</label>
                                            <input type="text" value="{{ $employee->nik }}"
                                                class="form-control @error('nik') is-invalid @enderror" name="nik">
                                            @error('nik')
                                                <span class="text-danger">*NIK Wajib Diisi!</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Employee Name</label>
                                            <input type="text" value="{{ $employee->employee_name }}"
                                                class="form-control @error('employee_name') is-invalid @enderror"
                                                name="employee_name">
                                            @error('employee_name')
                                                <span class="text-danger">*Employee Name Wajib Diisi!</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Departement</label>
                                            <input type="text" value="{{ $employee->departement }}"
                                                class="form-control @error('departement') is-invalid @enderror"
                                                name="departement">
                                            @error('departement')
                                                <span class="text-danger">*Departement Wajib Diisi!</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Section</label>
                                            <input type="text" value="{{ $employee->section }}"
                                                class="form-control @error('section') is-invalid @enderror" name="section">
                                            @error('section')
                                                <span class="text-danger">*Section Wajib Diisi!</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Title</label>
                                            <input type="text" value="{{ $employee->title }}"
                                                class="form-control @error('title') is-invalid @enderror" name="title">
                                            @error('title')
                                                <span class="text-danger">*Title Wajib Diisi!</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Grade</label>
                                            <input type="text" value="{{ $employee->grade }}"
                                                class="form-control @error('grade') is-invalid @enderror" name="grade">
                                            @error('grade')
                                                <span class="text-danger">*Grade Wajib Diisi!</span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6 ml-20">
                                        <div class="form-group">
                                            <label>Shift</label>
                                            <select class="form-control @error('shift_id') is-invalid @enderror" name="shift_id">
                                                <option disabled selected>Choose Shift</option>
                                                @foreach ($shifts as $shift)
                                                    <option value="{{ $shift->id ?? '' }}"
                                                        {{ (old('shift_id') ?? ($employee->shift->id ?? '')) == $shift->id ?? '' ? 'selected' : '' }}>
                                                        {{ $shift->shift_name ?? '' }}</option>
                                                @endforeach
                                            </select>
                                            @error('shift_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>*Shift Wajib Diisi!</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label for="">Place</label>
                                            <select class="form-control form-control-sm js-example-basic-multiple @error('place_id') is-invalid @enderror" name="place_id[]"
                                                multiple="multiple">
                                                @foreach ($places as $place)
                                                <option value="{{ $place->id }}"
                                                    {{ in_array($place->id, old('place_id') ?? $employee->places->pluck('id')->toArray()) ? 'selected' : '' }}>
                                                    {{ $place->place_name }} </option>
                                                @endforeach
                                            </select>
                                            @error('place_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Description <small>(Optional)</small></label>
                                            <textarea class="form-control @error('description') is-invalid @enderror"
                                                name="description">{{ $employee->description }}</textarea>
                                            @error('description')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    
                                </div>
                        </div>

                    </div>
                    <a href="{{ route('mrp.employee-list') }}">
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

        // Place
        $(document).ready(function () {
        $('.js-example-basic-multiple').select2();
    });

    </script>
@endpush
