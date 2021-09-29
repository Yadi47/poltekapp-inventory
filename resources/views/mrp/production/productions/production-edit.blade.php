@extends('mrp')
@section('title', $page_title)
@section('content')
<style>
        .document {
            width: 100%;
            height: 18rem;
            overflow-y: scroll;
            padding-right: .5rem;
            margin-bottom: 1rem;
        }
    </style>
<div class="row ">
    <div class="col-xl-12">
        <div class="white_card mb_30 shadow pt-4">
            <div class="white_card_body">
                <div class="QA_section">
                    <div>
                    <form action="{{ route('mrp.production.production-update', $production->id) }}" method="post">
                            @method('patch')
                            @csrf

                            <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="">Production Code</label>
                                                <input type="text" value="{{ $production->production_code }}"
                                                    class="form-control @error('production_code') is-invalid @enderror" name="production_code" >
                                                @error('production_code')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            <br>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Planning Code</label>
                                            <select class="form-control @error('planning_id') is-invalid @enderror" name="planning_id">
                                                <option disabled selected>Choose Planning</option>
                                                @foreach ($plannings as $planning)
                                                    <option value="{{ $planning->id ?? '' }}"
                                                        {{ (old('planning_id') ?? ($planning->planning->id ?? '')) == $planning->id ?? '' ? 'selected' : '' }}>
                                                        {{ $planning->plan_name ?? '' }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="">Production Name </label>
                                            <input type="text" value="{{ $production->production_name }}" class="form-control @error('production_name') is-invalid @enderror" name="production_name">
                                            @error('production_name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                            <br>
                                        </div>
                                    </div>

                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label>Shift Code</label>
                                            <select class="form-control @error('shift_id') is-invalid @enderror" name="shift_id">
                                                <option disabled selected>Choose Shift</option>
                                                @foreach ($shifts as $shift)
                                                    <option value="{{ $shift->id ?? '' }}"
                                                        {{ (old('shift_id') ?? ($shift->shift->id ?? '')) == $shift->id ?? '' ? 'selected' : '' }}>
                                                        {{ $shift->shift_name ?? '' }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="">Qty Plan </label>
                                            <input type="number" min="0" value="{{ $production->qty_plan }}" class="form-control @error('qty_plan') is-invalid @enderror" name="qty_plan" id="qty_actual">
                                            @error('qty_plan')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                            <br>
                                        </div>
                                    </div>

                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="">Qty Entry </label>
                                            <input type="number" min="0" value="{{ $production->qty_entry }}" class="form-control @error('qty_entry') is-invalid @enderror" name="qty_entry" id="qty_entry">
                                            @error('qty_entry')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                            <br>
                                        </div>
                                    </div>

                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="">Qty Reject </label>
                                            <input type="number" min="0" value="{{ $production->qty_reject }}" class="form-control @error('qty_reject') is-invalid @enderror" name="qty_reject" id="qty_reject" >
                                            @error('qty_reject')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                            <br>
                                        </div>
                                    </div>

                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="">Qty Good </label>
                                            <input type="number" min="0" value="{{ $production->qty_good }}" class="form-control @error('qty_good') is-invalid @enderror" name="qty_good" id="qty_good">
                                            @error('qty_good') 
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                            <br>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="">Date Start </label>
                                            <input type="text" class="form-control digits minMaxExample
                                        @error('date_start') is-invalid @enderror" value="{{ $production->date_start }}"
                                        name="date_start" autocomplete="off" readonly> 
                                            @error('date_start')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                            <br>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="">Date Finish </label>
                                            <input type="text" class="form-control digits minMaxExample
                                        @error('date_finish') is-invalid @enderror" value="{{ $production->date_finish }}"
                                        name="date_finish" autocomplete="off" readonly> 
                                            @error('date_finish')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                            <br>
                                        </div>
                                    </div>
                            
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Problem Code</label>
                                            <select class="form-control @error('problem_id') is-invalid @enderror" name="problem_id">
                                                @foreach ($problems as $problem)
                                                    <option value="{{ $problem->id ?? '' }}"
                                                        {{ (old('problem_id') ?? ($problem->problem->id ?? '')) == $problem->id ?? '' ? 'selected' : '' }}>
                                                        {{ $problem->problem_name ?? '' }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div> 

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Counter_measure</label>
                                            <select class="form-control @error('counter_measure_id') is-invalid @enderror" name="counter_measure_id">
                                                @foreach ($counter_measures as $counter_measure)
                                                    <option value="{{ $counter_measure->id ?? '' }}"
                                                        {{ (old('counter_measure_id') ?? ($counter_measure->counter_measure->id ?? '')) == $counter_measure->id ?? '' ? 'selected' : '' }}>
                                                        {{ $counter_measure->cm_code ?? '' }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div> 

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                        <label>Process Code</label>
                                            <select class="form-control @error('process_id') is-invalid @enderror" name="proces_id">
                                                @foreach ($planning_process as $planning_proces)
                                                    <option value="{{ $planning_proces->id ?? '' }}"
                                                        {{ (old('planning_proces_id') ?? ($planning_proces->planning_proces->id ?? '')) == $planning_proces->id ?? '' ? 'selected' : '' }}>
                                                        {{ $planning_proces->process->process_name ?? '' }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div> 
                                    
                                    
                            </div>
                                    <a href="{{ route('mrp.bom-list') }}">
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
<link rel="stylesheet" href="{{asset('assets')}}/vendors/datatable/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="{{asset('assets')}}/vendors/datatable/css/responsive.dataTables.min.css" />
<link rel="stylesheet" href="{{asset('assets')}}/vendors/datatable/css/buttons.dataTables.min.css" />
<!-- datepicker  -->
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
<script src="{{asset('assets')}}/vendors/datatable/js/jquery.dataTables.min.js"></script>
<script src="{{asset('assets')}}/vendors/datatable/js/dataTables.responsive.min.js"></script>
<script src="{{asset('assets')}}/vendors/datatable/js/dataTables.buttons.min.js"></script>
<!-- date picker  -->
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
</script>
@endpush
