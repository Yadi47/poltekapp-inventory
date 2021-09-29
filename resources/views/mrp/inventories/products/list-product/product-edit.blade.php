@extends('mrp')
@section('title', $page_title)
@section('content')

<div class="white_card mb_30 shadow pt-4">
    <div class="white_card_body">
        <div class="QA_section">
            <div class="row ">
                <div class="col-xl-6">
                    <form action="{{route('mrp.inventory_product-update',$inven_product->id)}}" method="post">
                        @method('patch')
                        @csrf
                        <div class="form-group">
                            <label>Part Name</label>
                            <select class="form-control @error('product_id') is-invalid @enderror" name="product_id">
                                <option disabled selected>Choose Part Name</option>
                                @foreach ($products as $product)
                                <option value="{{ $product->id }}"
                                    {{ ((old('product_id') ?? $inven_product->product->id) == $product->id) ? 'selected' : '' }}>
                                    {{ $product->product_code }} | {{ $product->part_name }} | {{ $product->part_number }}</option>
                                @endforeach
                            </select>
                            @error('product_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Begin Stock </label>
                            <input type="number" min="0" value="{{ $inven_product->initial_stock }}"
                                class="form-control @error('initial_stock') is-invalid @enderror" name="initial_stock">
                            @error('initial_stock')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Target <small>/day</small></label>
                            <input type="number" min="0" value="{{ $inven_product->target_day }}" id="target_day"
                                class="form-control @error('target_day') is-invalid @enderror" name="target_day">
                            @error('target_day')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Target Qty <small>(pcs)</small></label>
                            <input type="number" min="0" onkeyup="changeTarget()" value="{{ $inven_product->qty_target }}"
                                id="qty_target" class="form-control @error('qty_target') is-invalid @enderror"
                                name="qty_target">
                            @error('qty_target')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="">Target Qty <small>/day</small></label>
                            <input type="number" min="0" readonly value="{{ $inven_product->total_target_day }}" id="total_target_day"
                                class="form-control @error('total_target_day') is-invalid @enderror"
                                name="total_target_day">
                            @error('total_target_day')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control @error('status') is-invalid @enderror" name="status">
                                <option disabled>Choose Status</option>
                                <option value="OK" @if ($inven_product->status == "OK") selected @endif>Oke masuk stock
                                    aman</option>
                                <option value="Not OK" @if ($inven_product->status == "Not OK") selected @endif>NG masuk
                                    stock minimal</option>
                            </select>
                        </div>
                </div>

                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="">Target Min</label>
                        <input type="number" min="0" value="{{ $inven_product->target_min }}" id="target_min"
                            class="form-control @error('target_min') is-invalid @enderror" name="target_min">
                        @error('target_min')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Target Max</label>
                        <input type="number" min="0" value="{{ $inven_product->target_max }}" id="target_max"
                            class="form-control @error('target_max') is-invalid @enderror" name="target_max">
                        @error('target_max')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    
                        <div class="form-group">
                            <label for="">Description <small>(Optional)</small></label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                name="description">{{$inven_product->description}}</textarea>
                            @error('description')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                </div>
            </div>
                <a href="{{ route('mrp.inventory_product-list') }}">
                    <button type="button" class="btn btn-warning btn-sm">Back</button>
                </a>
                <button type="submit" class="btn btn-success btn-sm">Save</button>
                </form>

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
