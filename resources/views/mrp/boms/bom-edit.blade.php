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
                        <form action="{{route('mrp.bom-update',$bom->id)}}" method="post">
                            @method('patch')
                            @csrf

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">BOM Code</label>
                                        <input type="text" value="{{$bom->bom_code}}"
                                            class="form-control @error('bom_code') is-invalid @enderror"
                                            name="bom_code">
                                        @error('bom_code')
                                        <span class="text-danger">*BOM Code Wajib Diisi!</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">BOM Name</label>
                                        <input type="text" value="{{$bom->bom_name}}"
                                            class="form-control @error('bom_name') is-invalid @enderror"
                                            name="bom_name">
                                        @error('bom_name')
                                        <span class="text-danger">*BOM Name Wajib Diisi!</span>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="">Description <small>(Optional)</small></label>
                                        <textarea class="form-control @error('description') is-invalid @enderror"
                                            name="description">{{$bom->description}}</textarea>
                                        @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>

                                <div class="col-lg-5">
                                    <div class="form-group increment document">
                                        <button type="button" class="btn btn-outline-primary btn-add">
                                            <i class="fas fa-plus-square"></i>
                                        </button>
                                        @foreach($bom_materials as $bom_material)
                                        <div class="test">
                                            <div class="input-group mt-4">
                                                <input type="hidden" name="id[]" value="{{$bom_material->id}}">
                                                <input type="hidden" name="qty_old[]"
                                                    value="{{$bom_material->qty_material}}">
                                                <input type="hidden" name="unit_id_old[]"
                                                    value="{{$bom_material->unit_id}}">
                                                <input type="hidden" name="action[]" value="update">

                                                <select class="form-control material_id @error('material_id') is-invalid @enderror" name="material_id[]"
                                                    onchange="selectMaterial(event)">
                                                    <option disabled selected>Choose Material {{$bom_material->id}}
                                                    </option>
                                                    @foreach ($inventory_materials as $material)
                                                    <option value="{{ $material->id }}"
                                                        data-unitid="{{$material->unit_id}}"
                                                        {{ ($bom_material->material_id == $material->id) ? 'selected' : '' }}>
                                                        {{ $material->material->material_code }} |
                                                        {{ $material->material->material_name }} </option>
                                                    @endforeach
                                                </select>
                                                @error('material_id')
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
                                                    value="{{$bom_material->qty_material}}"
                                                    class="form-control @error('qty_material') is-invalid @enderror"
                                                    name="qty_material[]">
                                                @error('qty_material')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="form-group mt-1">
                                                <select class="form-control unit_id @error('unit_id') is-invalid @enderror" name="unit_id[]">
                                                    <option disabled selected>Choose Unit</option>
                                                    @foreach ($units as $unit)
                                                    <option value="{{ $unit->id }}"
                                                        {{ ($bom_material->unit_id == $unit->id) ? 'selected' : '' }}>
                                                        {{ $unit->unit_code }} | {{ $unit->unit_name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('unit_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>

                                    <!-- remove -->
                                    <div class="clone invisible">
                                        <div class="test">
                                            <div class="input-group mt-4">
                                                <input type="hidden" name="action[]" value="insert">
                                                <select class="form-control material_id"
                                                    onchange="selectMaterial(event)" name="material_id[]">
                                                    <option disabled selected>Choose Material</option>
                                                    @foreach ($inventory_materials as $material)
                                                    <option value="{{ $material->id }}"
                                                        data-unitid="{{$material->unit_id}}">
                                                        {{ $material->material->material_code }} |
                                                        {{ $material->material->material_name }}</option>
                                                    @endforeach
                                                </select>


                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-outline-danger btn-remove">
                                                        <i class="fas fa-minus-square"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="input-group mt-1">
                                                <input placeholder="Quantity " type="number" value="" min="0"
                                                    class="form-control @error('qty_material') is-invalid @enderror"
                                                    name="qty_material[]">

                                            </div>

                                            <div class="form-group mt-1">
                                                <select class="form-control unit_id" name="unit_id[]">
                                                    <option disabled selected>Choose Unit</option>
                                                    @foreach ($units as $unit)
                                                    <option value="{{ $unit->id }}">
                                                        {{ $unit->unit_code }} | {{ $unit->unit_name }}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <!-- <label for="">Quantity Material</label>
                                        <input type="text" value="{{$bom->qty_material}}"
                                            class="form-control @error('qty_material') is-invalid @enderror" name="qty_material">
                                        @error('qty_material')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror -->


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
            </div>
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
<script>
    $('.js-example-basic-multiple').select2();
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
    function selectMaterial(e) {
        var target = event.target;
        var parent = target.parentElement.parentElement; //parent of "target"
        let unitid = $(event.target).parent().parent().find('.material_id option:selected').attr('data-unitid');
        $(event.target).parent().parent().find('.unit_id').val(unitid)
    }
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


    // Button

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
    });

    // $(function(){
    //     bdCustomFile.init();
    // });

    $(document).ready(function () {
        $(".btn-add").click(function () {
            let markup = $(".invisible").html();
            $(".increment").append(markup);
        });

        // loop material

        $("body").on("click", ".btn-remove", function () {
            $(this).parents(".test").remove();
        })
    })

</script>
@endpush
