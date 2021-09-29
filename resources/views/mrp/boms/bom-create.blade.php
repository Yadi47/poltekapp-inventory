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
                        <form action="{{ route('mrp.bom-store') }}" method="post">
                            @csrf
                            <!-- <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">BOM Code</label>
                                            <input type="text" value="{{ old('bom_code') }}"
                                                class="form-control @error('bom_code') is-invalid @enderror" name="bom_code">
                                            @error('bom_code')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        

                                        <div class="form-group">
                                            <label for="">Description <small>(Optional)</small></label>
                                            <textarea 
                                                class="form-control @error('description') is-invalid @enderror" name="description">{{ old('description') }}</textarea>
                                            @error('description')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="">BOM Name</label>
                                                    <input type="text" value="{{ old('bom_name') }}"
                                                        class="form-control @error('bom_name') is-invalid @enderror" name="bom_name">
                                                    @error('bom_name')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="">Material Code</label>
                                                    <select class="js-example-basic-multiple form-control" name="material_id[]" multiple="multiple">
                                                        {{-- @foreach ($materials as $material) --}}
                                                        {{-- <option value="{{ $material->id }}" {{ old('material') == $material->id ? 'selected' : '' }}>{{ $material->material_name }}</option>
                                                        @endforeach --}}
                                                    </select>
                                                    {{-- <input type="text" value="{{old('material_code')}}"
                                                    class="form-control @error('material_code') is-invalid @enderror" name="material_code">
                                                @error('material_code')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror --}}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group increment" >
                                            <div class="test">
                                                <label for="" >Composisi </label>
                                                <div class="input-group" >
                                                    <input placeholder="Material" class="form-control mt-1 {{ $errors->has('file_name') ? 'is-invalid' : '' }}" type="text" name="file_name[]" value="{{ old('file_name') }}">
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-outline-primary btn-add">
                                                            <i class="fas fa-plus-square"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="input-group" >
                                                    <input placeholder="Quantity" class="form-control mt-1 " type="text">
                                                </div>
                                            </div>
                                        </div>
                                            
                                        <div class="clone invisible">
                                            <div class="test">
                                                <div class="input-group mt-3">
                                                    <input placeholder="Material" class="form-control mt-1 {{ $errors->has('file_name') ? 'is-invalid' : '' }}" type="text" name="file_name[]" value="{{ old('file_name') }}">
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-outline-danger btn-remove">
                                                            <i class="fas fa-minus-square"></i>
                                                        </button>
                                                    </div>
                                                    <div class="input-group" >
                                                        <input placeholder="Quantity" class="form-control mt-1 " type="text">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->


                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">BOM Code</label>
                                        <input type="text" value="{{ old('bom_code') }}"
                                            class="form-control @error('bom_code') is-invalid @enderror"
                                            name="bom_code">
                                        @error('bom_code')
                                        <span class="text-danger">*BOM Code Wajib Diisi!</span>
                                        @enderror
                                        <br>
                                        <label for="">BOM Name</label>
                                        <input type="text" value="{{ old('bom_name') }}"
                                            class="form-control @error('bom_name') is-invalid @enderror"
                                            name="bom_name">
                                        @error('bom_name')
                                        <span class="text-danger">*BOM Name Wajib Diisi!</span>
                                        @enderror
                                    </div>
                                    <!-- <div class="form-group">
                                        <label for="">Products</label>
                                        <select class="form-control js-example-basic-multiple @error('product_id') is-invalid @enderror" name="product_id[]"
                                                multiple="multiple">
                                                @foreach ($products as $product)
                                                <option value="{{ $product->id }}"
                                                {{ in_array($product->id,old('product_id') ?? []) ? 'selected' :''  }}    
                                                >
                                                    {{ $product->product_code }} | {{ $product->product_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('product_id')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div> -->
                                    <div class="form-group">
                                        <label for="">Description <small>(Optional)</small></label>
                                        <textarea class="form-control @error('description') is-invalid @enderror"
                                            name="description">{{ old('description') }}</textarea>
                                        @error('description')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group increment document">
                                        <div class="test">
                                            <label for="">Composisi </label>
                                            <button type="button" class="btn btn-outline-primary btn-add">
                                                <i class="fas fa-plus-square"></i>
                                            </button>
                                        </div>



                                    </div>

                                    <!-- remove -->
                                    <div class="clone invisible">
                                        <div class="test">
                                            <div class="input-group mt-4">
                                                {{-- {{ dd($inventory_materials ) }} --}}
                                                <select class="form-control material_id @error('material_id') is-invalid @enderror" onchange="selectMaterial(event)" name="material_id[]"
                                                id="material_id">
                                                    <option disabled selected>Choose Material</option>
                                                    @foreach ($inventory_materials as $material)
                                                    <option value="{{ $material->id }}" data-unitid="{{$material->unit_id}}"
                                                        {{ (old('material_id') ? old('material_id')[0]: '') == $material->id ? 'selected' : '' }}>
                                                        {{ $material->material->material_code }} | {{ $material->material->material_name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('material_id')
                                                <span class="invalid-feedback" role="alert">
                                                    *Material Wajib Diisi!
                                                </span>
                                                @enderror

                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-outline-danger btn-remove">
                                                        <i class="fas fa-minus-square"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="input-group mt-1">
                                                <input placeholder="Quantity" type="number" min="0"
                                                    value="{{ (old('qty_material') ? old('qty_material')[0] : '') }}"
                                                    class="form-control @error('qty_material') is-invalid @enderror qty_material"
                                                    name="qty_material[]">
                                                @error('qty_material')
                                                <span class="text-danger">*Qty Wajib Diisi!</span>
                                                @enderror
                                            </div>

                                            <div class="form-group mt-1">
                                                <select class="form-control unit_id @error('unit_id') is-invalid @enderror" name="unit_id[] id=" unit">
                                                    <option disabled selected>Choose Unit</option>
                                                    @foreach ($units as $unit)
                                                    <option value="{{ $unit->id }}"
                                                        {{ (old('unit_id') ? old('unit_id')[0] : '') == $unit->id ? 'selected' : '' }}>
                                                        {{ $unit->unit_code }} | {{ $unit->unit_name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('unit_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>*Unit Wajib Diisi</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
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

    // $("select").on("select2:select", function (evt) {
    //     var element = evt.params.data.element;
    //     var $element = $(element);
    //     $element.detach();
    //     $(this).append($element);
    //     $(this).trigger("change");
    //     // alert(333);
    // });

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
@endpush
