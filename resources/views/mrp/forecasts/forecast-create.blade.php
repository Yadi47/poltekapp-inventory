@extends('mrp')

@section('title', $page_title)

@section('content')
    <div class="row ">
        <div class="col-xl-12">
            <div class="white_card mb_30 shadow pt-4">
                <div class="white_card_body">
                    <div class="QA_section">
                        <div>
                            <form action="{{ route('mrp.forecast-store') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label>Customer</label>
                                        <select class="form-control @error('customer_id') is-invalid @enderror" name="customer_id">
                                            <option disabled selected>Choose Customer</option>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}"
                                                    {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                                    {{$customer->customer_code}} | {{ $customer->customer_name }} </option>
                                            @endforeach
                                        </select>
                                        @error('customer_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <br>
                                    </div>
                                   
                                    {{-- <div class="col-lg-6">
                                        <label for="">Forecast Date</label>
                                        <input autocomplete="off" class="datepicker-here form-control digits @error('forecast_date') is-invalid @enderror" 
                                        type="text" data-language="en" data-min-view="months" data-view="months" data-date-format="MM yyyy" name="forecast_date">
                                        @error('forecast_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div> --}}
                                    <div class="col-lg-6">
                                        <label for="">Quantity</label>
                                        <input type="number" min="0" value="{{ old('qty_forecast') }}"
                                            class="form-control @error('qty_forecast') is-invalid @enderror"
                                            name="qty_forecast">
                                        @error('qty_forecast')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <br>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Part Name</label>
                                        <select class="form-control @error('product_id') is-invalid @enderror" name="product_id">
                                            <option disabled selected>Choose Part Name</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}"
                                                    {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                                    {{ $product->part_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('product_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <br>
                                        <label>Part No</label>
                                        <select class="form-control @error('product_id') is-invalid @enderror" name="product_id">
                                            <option disabled selected>Choose Part No</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}"
                                                    {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                                    {{ $product->part_number }}</option>
                                            @endforeach
                                        </select>
                                        @error('product_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <br>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Forecast Date</label>
                                            <input type="text" class="form-control digits minMaxExample
                                                @error('forecast_date') is-invalid @enderror" id="" name="forecast_date"
                                                autocomplete="off" required>
                                            @error('forecast_date')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                            <br>
                                        </div>
                                    </div>
                                    {{-- <div class="col-lg-6">
                                        <label for="">Forecast Date</label>
                                        <input autocomplete="off" class="datepicker-here form-control digits @error('forecast_date') is-invalid @enderror" 
                                        type="text" data-language="en" data-min-view="months" data-view="months" data-date-format="MM yyyy" name="forecast_date">
                                        @error('forecast_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div> --}}
                                    



                                        </div>
                                    </div>
                                            
                                </div>
                                <a href="{{ route('mrp.forecast-list') }}">
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

    </script>
@endpush
