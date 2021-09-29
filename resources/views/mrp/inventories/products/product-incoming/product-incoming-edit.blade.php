@extends('mrp')
@section('title', $page_title)
@section('content')
<div class="row ">
    <div class="col-xl-6">
        <div class="white_card mb_30 shadow pt-4">
            <div class="white_card_body">
                <div class="QA_section">
                    <div>
                        <form action="{{route('mrp.product-incoming-update',$product_incoming->id)}}" method="post">
                            @method('patch')
                            @csrf
                            <div class="form-group">
                                <label>Product</label>
                                <select class="form-control @error('product_id') is-invalid @enderror" name="product_id" id="inventory_product_list_id">
                                    <option disabled selected>Choose Product</option>
                                    @foreach ($inven_product_list as $product)
                                        <option value="{{ $product->id }}" 
                                            {{ ((old('product_id') ?? $product_incoming->inventoryProductList->product->id) == $product->product->id) ? 'selected' : '' }}>
                                            {{ $product->product->product_code }} | {{ $product->product->part_name }} | {{ $product->product->part_number }}</option>
                                    @endforeach
                                </select>
                                @error('product_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Product Incoming</label>
                                <input type="number" min="0" value="{{$product_incoming->product_incoming}}"  onkeyup="changeStock()"
                                    class="form-control @error('product_incoming') is-invalid @enderror" name="product_incoming" id="product_incoming"
                                    >
                                @error('product_incoming')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label>PIC</label>
                                <select class="form-control @error('employee_id') is-invalid @enderror" name="employee_id">
                                    <option disabled selected>Choose PIC</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id ?? '' }}" {{ ((old('employee_id') ?? $product_incoming->employee->id ?? '') == $employee->id ?? '') ? 'selected' : '' }}>{{ $employee->employee_name ?? ''}}</option>
                                    @endforeach
                                </select>
                                @error('employee_id')
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
                                        <option value="{{ $machine->id ?? '' }}" {{ ((old('machine_id') ?? $product_incoming->machine->id ?? '') == $machine->id ?? '') ? 'selected' : '' }}>{{ $machine->machine_name ?? ''}}</option>
                                    @endforeach
                                </select>
                                @error('machine_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div> --}}

                                <div class="form-group">
                                    <label for="">Current Stock</label>
                                    <input type="text" value="{{ $product_incoming->current_stock }}" readonly class="form-control 
                                        @error('current_stock') is-invalid @enderror"  data-language="en"
                                        name="current_stock" id="current_stock" autocomplete="off">
                                        @error('current_stock')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                </div>
                                <div class="form-group">
                                <label for="">Description <small>(Optional)</small></label>
                                <textarea 
                                    class="form-control @error('description') is-invalid @enderror" name="description">{{$product_incoming->description}}</textarea>
                                @error('description')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            </div>
                            <a href="{{ route('mrp.product-incoming-list') }}">
                                <button type="button" class="btn btn-warning btn-sm">Back</button>
                            </a>
                            <button class="btn btn-success btn-sm">Save</button>
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
    let current_stock = $('#current_stock').val();

    // let current_stock = $('#current_stock').val();
    // console.log(current_stock);

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
        axios.get("/mrp/product-incoming/api/" + $(this).val())
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
        let incoming = $('#product_incoming').val()
        let stock = $('#current_stock').val()
        // let sortir = $('#sortir').val();


        $('#current_stock').val(Number(current_stock) + Number(incoming))
            
    }
</script>
@endpush
