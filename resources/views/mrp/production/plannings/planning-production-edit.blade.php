@extends('mrp')

@section('title', $page_title)

@section('content')
<style>
    .document {
            width: 100%;
            height: 17rem;
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
                        <form action="{{ route('mrp.production.planning-update', $planning->id) }}" method="post">
                            @method('put')
                            @csrf
                            <div class="row">
                                <div class="col-lg-3">
                                    <label for="">Planning Code</label>
                                    <input type="text" value="{{ $planning->plan_code }}"
                                        class="form-control @error('plan_code') is-invalid @enderror" name="plan_code">
                                    @error('plan_code')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <br>
                                </div>
                                <div class="col-lg-3">
                                    <label for="">Planning Name</label>
                                    <input type="text" value="{{ $planning->plan_name }}"
                                        class="form-control @error('plan_name') is-invalid @enderror" name="plan_name">
                                    @error('plan_name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <br>
                                </div>
                                    {{-- <label>Bom</label>
                                    <select class="form-control js-example-basic-multiple" name="bom_id[]"
                                        multiple="multiple">
                                        @foreach ($boms as $bom)
                                        <option value="{{ $bom->id }}"
                                            {{ in_array($bom->id, old('bom_id') ?? $planning->boms->pluck('id')->toArray()) ? 'selected' : '' }}>
                                            {{ $bom->bom_code }} | {{ $bom->bom_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('bom_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror --}}
                                    {{-- <br>
                                    <label>Part Name(product)</label>
                                    <select class="form-control" name="product_id">
                                        <option disabled selected>Choose Part Name</option>
                                        @foreach ($products as $product)
                                        <option value="{{ $product->id }}"
                                            {{ (old('product_id') ?? ($product->id ?? '')) == $product->id ?? '' ? 'selected' : '' }}>
                                            {{ $product->part_name ?? '' }} </option>
                                        @endforeach
                                    </select>
                                    @error('part_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    <br>
                                    <label>Part Number(product)</label>
                                    <select class="form-control" name="product_id">
                                        <option disabled selected>Choose Part Number</option>
                                        @foreach ($products as $product)
                                        <option value="{{ $product->id }}"
                                            {{ (old('product_id') ?? ($product->id ?? '')) == $product->id ?? '' ? 'selected' : '' }}>
                                            {{ $product->part_number ?? '' }} </option>
                                        @endforeach
                                    </select>
                                    @error('part_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    <br>
                                    <label for="">Plan Qty</label>
                                    <input type="number" value="{{ $planning->plan_qty }}"
                                        class="form-control @error('plan_qty') is-invalid @enderror" name="plan_qty">
                                    @error('plan_qty')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <br> --}}

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="">Customer</label>
                                        <select class="form-control form-control-sm js-example-basic-multiple @error('customer_id') is-invalid @enderror" name="customer_id[]"
                                            multiple="multiple">
                                            @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}"
                                                {{ in_array($customer->id, old('process_id') ?? $planning->customers->pluck('id')->toArray()) ? 'selected' : '' }}>
                                                {{ $customer->customer_code }} | {{ $customer->customer_name }}</option>
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
                                            {{ (old('unit_id') ?? ($unit->id ?? '')) == $unit->id ?? '' ? 'selected' : '' }}>
                                            {{ $unit->unit_code }} | {{ $unit->unit_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('unit_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="">Process</label>
                                            <select class="form-control form-control-sm js-example-basic-multiple @error('process_id') is-invalid @enderror" name="process_id[]"
                                                multiple="multiple">
                                                @foreach ($process as $processs)
                                                <option value="{{ $processs->id }}"
                                                    {{ in_array($processs->id, old('process_id') ?? $planning->process->pluck('id')->toArray()) ? 'selected' : '' }}>
                                                    {{ $processs->process_code }} | {{ $processs->process_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('process_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                <div class="col-lg-3 ml-5">
                                    <div class="form-group">
                                        <label for="">Start Date</label>
                                        <input type="text" class="form-control digits minMaxExample
                                        @error('start_date') is-invalid @enderror" value="{{ $planning->start_date }}"
                                            name="start_date" autocomplete="off" readonly>
                                        @error('start_date')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                        {{-- <label for="">Finish Date</label>
                                        <input type="text" readonly  class="form-control digits minMaxExample
                                        @error('finish_date') is-invalid @enderror" value="{{ $planning->finish_date }}"
                                        name="finish_date" autocomplete="off" >
                                        @error('finish_date')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <br> --}}
                                <div class="col-lg-3">
                                    <label for="">Target Date</label>
                                    <input type="text" class="form-control digits minMaxExample
                                    @error('target_date') is-invalid @enderror"
                                        value="{{ $planning->target_date }}" name="target_date" autocomplete="off"
                                        readonly>
                                    @error('target_date')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-lg-1">
                                        <div class="form-group">
                                            <label for="">Batch</label>
                                            <input type="text" class="form-control 
                                        @error('batch') is-invalid @enderror" id="" readonly
                                                value="{{ $planning->batch }}" name="batch" autocomplete="off">
                                            @error('batch')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="">Date</label>
                                        <input type="text" class="form-control 
                                            @error('date') is-invalid @enderror" id="" readonly
                                            value="{{ $planning->date }}" name="date" autocomplete="off">
                                        @error('date')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="">Description <small>(Optional)</small></label>
                                        <textarea class="form-control @error('description') is-invalid @enderror"
                                            name="description">{{ $planning->description }}</textarea>
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
                                                <label for="">Product </label>
                                                <button type="button" class="btn btn-outline-primary btn-add">
                                                    <i class="fas fa-plus-square"></i>
                                                </button>
                                                @foreach($planning_products as $plan_product)
                                                {{-- {{dd($product)}} --}}
                                                <div class="test">
                                                    <div class="input-group mt-4">
                                                        <input type="hidden" name="id[]" value="{{$plan_product->id}}">
                                                        {{-- <input type="hidden" name="qty_old[]"
                                                            value="{{$plan_product->quantity}}">
                                                        <input type="hidden" name="unit_id_old[]"
                                                            value="{{$plan_product->product->bom_id}}"> --}}
                                                        <input type="hidden" name="action[]"
                                                            value="update">
        
                                                        <select class="form-control product_id @error('product_id') is-invalid @enderror" name="array_product_id[]" id="product_id">
                                                            <option disabled selected>Choose Product</option>
                                                            @foreach ($products as $product)
                                                            <option value="{{ $product->id }}"
                                                                {{ $plan_product->product_id == $product->id ? 'selected' : '' }}>
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
        
                                                        {{-- <label for="" class="form-label">Quantity</label>
                                                        <input type="text" name="" value="{{$plan_product->quantity}}" id=""> --}}
                                                    
        
                                                        <div class="input-group mt-1">
                                                            <input class="form-control" type="text" name="array_quantity[]" value="{{$plan_product->quantity}}" id="">
                                                            @error('quantity')
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
        
                                                        
                                                    </div>
                                                    
                                                </div>
                                                @endforeach
                                            </div>
        
                                            <!-- remove -->
                                            <div class="clone invisible">
                                                <div class="test">
                                                    <div class="input-group mt-4">
                                                        <input type="hidden" name="action[]"
                                                            value="insert">
                                                        
                                                            <select class="form-control product_id @error('product_id') is-invalid @enderror" name="array_product_id[]" id="product_id">
                                                                <option disabled selected>Choose Product</option>
                                                                @foreach ($products as $product)
                                                                <option value="{{ $product->id }}"
                                                                    {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                                                    {{ $product->product_code }} | {{ $product->part_number }}</option>
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

<script>
    $(document).ready(function () {
        $('.js-example-basic-multiple').select2();
    });

</script>
<script>
    $('.row-permission').click(function () {
        let data = $(this).find('td input:checkbox');
        console.log(data.prop('checked', !data.is(':checked')));
    });
    $('#checkAll').click(function (e) {
        // var table= $(e.target).closest('.table');
        let find = $('.lms_table_active3').find('tr td input:checkbox').prop('checked', true);
        console.log(find);
    });
    $('#uncheckAll').click(function (e) {
        // var table= $(e.target).closest('.table');
        let find = $('.lms_table_active3').find('tr td input:checkbox').prop('checked', false);
        console.log(find);
    });

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

    // button
    $("#button").click(function () {
        alert($("#e1").val());
    });

    $("select").on("select2:select", function (evt) {
        var element = evt.params.data.element;
        var $element = $(element);
        $element.detach();
        $(this).append($element);
        $(this).trigger("change");
    });

        $(function(){
            bdCustomFile.init();
        });

        $(document).ready(function(){
            $(".btn-add").click(function(){
                let markup = $(".invisible").html();
                $(".increment").append(markup);
            });
            $("body").on("click",".btn-remove", function(){
                $(this).parents(".test").remove();
            })
        })

</script>
@endpush
