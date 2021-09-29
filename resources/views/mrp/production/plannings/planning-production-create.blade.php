@extends('mrp')

@section('title', $page_title)

@section('content')
<div class="row ">
    <div class="col-xl-12">
        <div class="white_card mb_30 shadow pt-4">
            <div class="white_card_body">
                <div class="QA_section">
                    <div>
                        <form action="{{ route('mrp.production.planning-store') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-lg-3">
                                    <label for="">Planning Code</label>
                                    <input type="text" value="{{ old('plan_code') }}"
                                        class="form-control @error('plan_code') is-invalid @enderror" name="plan_code">
                                    @error('plan_code')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-3">
                                    <label for="">Planning Name</label>
                                    <input type="text" value="{{ old('plan_name') }}"
                                        class="form-control @error('plan_name') is-invalid @enderror" name="plan_name">
                                    @error('plan_name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                {{-- <div class="col-lg-3">
                                    <label for="">Shift Code</label>
                                    <select class="form-control" name="shift_id">
                                        <option disabled selected>Choose Shift</option>
                                        @foreach ($shifts as $shift)
                                        <option value="{{ $shift->id }}"
                                            {{ old('shift_id') == $shift->id ? 'selected' : '' }}>
                                            {{ $shift->shift_code }} | {{ $shift->shift_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('shift_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div> --}}
                                    
                                    {{-- <label for="">Plan Qty</label>
                                    <input type="number" value="{{ old('plan_qty') }}"
                                        class="form-control @error('plan_qty') is-invalid @enderror" name="plan_qty">
                                    @error('plan_qty')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <br> --}}
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="">Customer</label>
                                            <select class="form-control js-example-basic-multiple @error('customer_id') is-invalid @enderror" name="customer_id[]"
                                                multiple="multiple">
                                                @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}">
                                                    {{ (old('customer_id') == $customer->id) ? 'selected' : '' }}
                                                    {{ $customer->customer_name }} 
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('customer_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                <div class="col-lg-3">
                                    <label for="">Unit</label>
                                    <select class="form-control @error('unit_id') is-invalid @enderror" name="unit_id">
                                        <option disabled selected>Choose Unit</option>
                                        @foreach ($units as $unit)
                                        <option value="{{ $unit->id }}"
                                            {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                                            {{ $unit->unit_code }} | {{ $unit->unit_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('unit_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-lg-3">
                                    <label for="">Start Date</label>
                                    <input type="text" class="form-control digits minMaxExample
                                        @error('start_date') is-invalid @enderror" id="" name="start_date"
                                        autocomplete="off">
                                    @error('start_date')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                    {{-- <label for="">Finish Date</label>
                                        <input type="text" class="form-control digits minMaxExample 
                                        @error('finish_date') is-invalid @enderror" id=""
                                        name="finish_date" autocomplete="off">
                                        @error('finish_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <br> --}}
                                <div class="col-lg-3">
                                    <label for="">Target Date</label>
                                    <input type="text" class="form-control digits minMaxExample
                                        @error('target_date') is-invalid @enderror" id="" name="target_date"
                                        autocomplete="off">
                                    @error('target_date')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="">Process</label>
                                        <select class="form-control js-example-basic-multiple @error('process_id') is-invalid @enderror" name="array_process_id[]"
                                            multiple="multiple">
                                            @foreach ($process as $processs)
                                            <option value="{{ $processs->id }}">
                                                {{ (old('process_id') == $processs->id) ? 'selected' : '' }}
                                                {{ $processs->process_name }} 
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('process_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="">Batch</label>
                                        <input type="text" class="form-control 
                                        @error('batch') is-invalid @enderror" id="" readonly name="batch"
                                            autocomplete="off">
                                        @error('batch')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                    <div class="col-lg-3">
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

                                
                                <div class="row ">
                                    <div class="col-xl-12">
                                        <div class="white_card mb_30 shadow pt-7">
                                            <div class="col-lg-12">
                                                <div class="form-group increment document">
                                                    <div class="test">
                                                        <label for="">Product </label>
                                                        <button type="button" class="btn btn-outline-primary btn-add">
                                                            <i class="fas fa-plus-square"></i>
                                                        </button>
                                                    </div>
                                                </div>

                                                <!-- remove -->
                                                <div class="clone invisible">
                                                    <div class="test">
                                                        <div class="input-group mt-4">
                                                            <select class="form-control product_id @error('product_id') is-invalid @enderror" name="array_product_id[]" id="product_id">
                                                                <option disabled selected>Choose Product</option>
                                                                @foreach ($products as $product)
                                                                <option value="{{ $product->id }}"
                                                                    {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                                                    {{ $product->product_code }} | {{$product->part_name}} | {{$product->product_name}} | {{ $product->part_number }}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('product_id')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror

                                                            <div class="input-group-append">
                                                                <button type="button" class="btn btn-outline-danger btn-remove">
                                                                    <i class="fas fa-minus-square"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="input-group mt-1">
                                                            <input placeholder="Quantity" type="number"
                                                                value="{{ (old('quantity') ? old('quantity')[0] : '') }}"
                                                                class="form-control @error('quantity') is-invalid @enderror quantity"
                                                                name="array_quantity[]">
                                                            @error('quantity')
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                <a href="{{ route('mrp.production.planning-list') }}">
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
<!-- datepicker  -->
<link rel="stylesheet" href="{{ asset('assets') }}/vendors/datepicker/date-picker.css">
{{-- datepicker --}}
{{-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css"> --}}
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

<!-- date picker  -->
<script src="{{ asset('assets') }}/vendors/datepicker/datepicker.js"></script>
<script src="{{ asset('assets') }}/vendors/datepicker/datepicker.en.js"></script>
<script src="{{ asset('assets') }}/vendors/datepicker/datepicker.custom.js"></script>
{{-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> --}}

<script>
    $(document).ready(function () {
        $('.js-example-basic-multiple').select2();
    });

</script>
<script>
    $(document).ready(function () {
        $('.js-example-basic-multiple').select2();
    });
    $("#e1").select2();
    $("#checkbox").click(function () {
        if ($("#checkbox").is(':checked')) {
            $("#e1 > option").prop("selected", "selected");
            $("#e1").trigger("change");
        } else {
            $("#e1 > option").removeAttr("selected");
            $("#e1").val("");
            $("#e1").trigger("change");
        }
    });

    $("#button").click(function () {
        alert($("#e1").val());
    });

    $("select").on("select2:select", function (evt) {
        var element = evt.params.data.element;
        var $element = $(element);
        $element.detach();
        $(this).append($element);
        $(this).trigger("change");
        // alert(333);
    });

    // $(function() {
    //     bdCustomFile.init();
    // });

    function selectMaterial(e){
        var target = event.target;
        var parent = target.parentElement.parentElement;//parent of "target"
        let unitid = $(event.target).parent().parent().find('.material_id option:selected').attr('data-unitid');
        $(event.target).parent().parent().find('.unit_id').val(unitid)
    }

    
    $(document).ready(function () {
        $(".btn-add").click(function () {
            let markup = $(".invisible").html();
            $(".increment").append(markup);
        });
        $("body").on("click", ".btn-remove", function () {
            $(this).parents(".test").remove();
        })
        
    })



    //Ajax Dynamic Dropdown Part Number 
    $(document).ready(function () {
		$('#product_id').on('change',function(e) {
			var planning_id = e.target.value;
			$.ajax({
				url:"{{ route('mrp.production.planning-ajaxProductPartNumber') }}",
				type:"POST",
				data: {
					"_token": "{{ csrf_token() }}",
					planning_id: planning_id
				},
				success:function (data) {
                    console.log(data.product);
					$('.part_number').empty();
					$.each(data.product,function(index,product){
						$('.part_number').append('<option value="'+product.id+'">'+product.part_number+'</option>');
						// $('#process_id').append('<option value="test value">Test value</option>');
					})
				}
			})
		});
	});

</script>
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

<script>
    $(function () {
        $("#startdate").datepicker();
    });

</script>
@endpush