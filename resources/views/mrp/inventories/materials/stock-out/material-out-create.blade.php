@extends('mrp')

@section('title', $page_title)

@section('content')
    <div class="row ">
        <div class="col-xl-6">
            <div class="white_card mb_30 shadow pt-4">
                <div class="white_card_body">
                    <div class="QA_section">
                        <div>
                            <form action="{{ route('mrp.material-out-store') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label>Part Name</label>
                                    <select class="form-control @error('inventory_material_list_id') is-invalid @enderror" name="inventory_material_list_id" id="inventory_material_list_id">
                                        <option disabled selected>Choose Part Name</option>
                                        @foreach ($inven_material_list as $material)
                                                <option value="{{ $material->id }}"
                                                    {{ old('inventory_material_list_id') == $material->id ? 'selected' : '' }}>
                                                    {{ $material->material->material_code }} | {{ $material->material->material_name }} | {{ $material->material->part_number }}</option>
                                            @endforeach
                                    </select>
                                    @error('inventory_material_list_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                {{-- <div class="form-group">
                                    <label>Machine</label>
                                    <select class="form-control @error('machine_id') is-invalid @enderror" name="machine_id">
                                        <option disabled selected>Choose Machine</option>
                                        @foreach ($machines as $machine)
                                                <option value="{{ $machine->id }}"
                                                    {{ old('machine_id') == $machine->id ? 'selected' : '' }}>
                                                    {{ $machine->machine_name }}</option>
                                            @endforeach
                                    </select>
                                    @error('machine_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div> --}}

                                <div class="form-group">
                                    <label for="">Qty Out</label>
                                    <input  type="number" min="0" value="{{ old('material_outgoing') }}" onkeyup="changeStock()" id="material_outgoing"
                                        class="form-control @error('material_outgoing') is-invalid @enderror" name="material_outgoing">
                                    @error('material_outgoing')
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
                                    <label for="">Current Stock</label>
                                        <input type="number" min="0" class="form-control  
                                        @error('current_stock') is-invalid @enderror"  id="current_stock"
                                        readonly name="current_stock"  autocomplete="off">
                                        @error('current_stock')
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

                    </div>
                    <a href="{{ route('mrp.material-out-list') }}">
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
        // let tytd;
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

        $('#inventory_material_list_id').change(function(){
        axios.get("/mrp/material-out/api/" + $(this).val())
            .then(function (response) {
                // handle success
                current_stock = response.data.stock
                $('#current_stock').val(response.data.stock)
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            })
            .then(function () {
                // always executed
            });
    })
    
    function changeStock() {
        let outgoing = $('#material_outgoing').val()
        let stock = $('#current_stock').val()


        $('#current_stock').val(current_stock - Number(outgoing))
            
    }

    

    // function sortir() {
    //         let sortir = $('#sortir').val();
    //         let stock = $('#current_stock').val()

    //         if (sortir >= stock) {
    //             $('#current_stock').val(Number(sortir)) + Number(current_stock))
                
    //         } else {
    //             $('#current_stock').val(Number(current_stock) + Number(sortir))
    //         }
    </script>
@endpush
