@extends('mrp')

@section('title', $page_title)

@section('content')
<div class="white_card mb_30 shadow pt-4">
    <div class="white_card_body">
        <div class="QA_section">
            <div class="row">
                <div class="col-xl-6">
                    <form action="{{ route('mrp.inventory_material-store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label>Part Name</label>
                            <select class="form-control @error('material_id') is-invalid @enderror" name="material_id">
                                <option disabled selected>Choose Part Name</option>
                                @foreach ($materials as $material)
                                <option value="{{ $material->id }}"
                                    {{ old('material_id') == $material->id ? 'selected' : '' }}>
                                    {{$material->material_code}} | {{ $material->material_name }} | {{ $material->part_number }}</option>
                                @endforeach
                            </select>
                            @error('material_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Begin Stock</label>
                            <input type="number" min="0" value="{{ old('initial_stock') }}" id="initial_stock"
                                class="form-control @error('initial_stock') is-invalid @enderror" name="initial_stock">
                            @error('initial_stock')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="">Date Begin</label>
                            <input type="text" class="form-control datepicker-here  digits   
                                        @error('lot_material') is-invalid @enderror" data-language="en" id=""
                                name="lot_material" autocomplete="off">
                            @error('lot_material')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Target <small>/day</small></label>
                            <input type="number" min="0" value="{{ old('target_day') }}" id="target_day"
                                class="form-control @error('target_day') is-invalid @enderror" name="target_day">
                            @error('target_day')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Target Qty <small>(pcs)</small></label>
                            <input type="number" min="0" onkeyup="changeTarget()" value="{{ old('qty_target') }}"
                                id="qty_target" class="form-control @error('qty_target') is-invalid @enderror"
                                name="qty_target">
                            @error('qty_target')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="">Target Qty Pcs <small>/day</small></label>
                            <input type="number" min="0" readonly value="{{ old('total_target_day') }}" id="total_target_day"
                                class="form-control @error('total_target_day') is-invalid @enderror"
                                name="total_target_day">
                            @error('total_target_day')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                </div>

                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="">Target Min</label>
                        <input type="number" min="0" value="{{ old('target_min') }}" id="target_min"
                            class="form-control @error('target_min') is-invalid @enderror" name="target_min">
                        @error('target_min')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Target Max</label>
                        <input type="number" min="0" value="{{ old('target_max') }}" id="target_max"
                            class="form-control @error('target_max') is-invalid @enderror" name="target_max">
                        @error('target_max')
                        <span class="text-danger">{{ $message }}</span>
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

                <a href="{{ route('mrp.inventory_material-list') }}">
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

    function changeTarget() {
        let target = $('#qty_target').val()
        let targetday = $('#target_day').val()
        let totaltargetday = $('#total_target_day').val()
        let initstock = $('#initial_stock').val()

        $('#total_target_day').val(Math.round(Number(target) / Number(targetday)));
    }

</script>
@endpush
