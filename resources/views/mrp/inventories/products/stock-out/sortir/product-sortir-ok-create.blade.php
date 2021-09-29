@extends('mrp')

@section('title', $page_title)

@section('content')
    <div class="row ">
        <div class="col-xl-6">
            <div class="white_card mb_30 shadow pt-4">
                <div class="white_card_body">
                    <div class="QA_section">
                        <div>
                            <form action="{{ route('mrp.product-sortir-store-sortir-ok') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label>Part Name</label>
                                     
                                    <select class="form-control @error('inventory_product_list_id') is-invalid @enderror" name="inventory_product_list_id"
                                        id="inventory_product_list_id">
                                        <option disabled selected>Choose Product</option>
                                        @foreach ($inven_products as $product)
                                        <option value="{{ $product->id }}"
                                                {{ old('inventory_product_list_id') == $product->id ? 'selected' : '' }}>
                                                {{ $product->product->product_code }} | {{ $product->product->part_name }} | {{ $product->product->part_number }}</option>
                                        @endforeach
                                    </select>
                                    @error('inventory_product_list_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Qty Ok</label>
                                    <input type="number" min="0" value="" id="qty_ok"
                                        onkeyup="changeStock()"
                                        class="form-control @error('qty_ok') is-invalid @enderror"
                                        name="qty_ok">
                                    @error('qty_ok')
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
                                    <label for="">Current Stock</label>
                                    <input type="number" min="0"
                                        class="form-control"id="current_stock" readonly name="current_stock"  autocomplete=" off">
                                    @error('current_stock')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                {{-- {{ dd() }} --}}
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
                    <a href="{{ route('mrp.product-sortir-list-sortir-ok') }}">
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
        let current_stock = 0;
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

        $('#inventory_product_list_id').change(function(){
        axios.get("/mrp/product-sortir/api/" + $(this).val())
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
        let incoming = $('#qty_ok').val()
        let stock = $('#current_stock').val()
        // let sortir = $('#sortir').val();


        $('#current_stock').val(current_stock + Number(incoming))
            
    }

        // function sortir() {
        //     let sortir = $('#sortir').val();

        //     let stock = $('#current_stock').val()

        //     if (sortir >= stock) {
        //         $('#current_stock').val(Number(sortir)) + Number(current_stock))
                
        //     } else {
        //         $('#current_stock').val(Number(current_stock) + Number(sortir))
        //     }

        

        // function setIdPDL(e) {
        //     let pdlid = $(e.target).find('option:selected').data('pdlid');
        //     $('#pdl_id').val(pdlid)
        // }
    </script>
@endpush


                                
                                