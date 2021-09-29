@extends('mrp')

@section('title', $page_title)

@section('content')
<style>
    .document {
        width: 100%;
        height: 30rem;
        overflow-y: scroll;
        padding-right: .5rem;
        margin-bottom: 1rem;
    }

    .table tr {
        cursor: auto;
    }

</style>
<div class="row ">
    <div class="col-xl-12">
        <div class="white_card mb_30 shadow pt-4">
            <form action="{{route('mrp.production.production-store')}}" method="post">
                <div class="white_card_body">
                    <div class="QA_section">
                        @csrf
                        <h4 style="color: chocolate">Planning Details</h4>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Choose Planning </label>
                                    <select class="form-control @error('planning_id') is-invalid @enderror" onchange="setPlanning()" id="planning_id"
                                        name="planning_id" required>
                                        <option value="">Choose Planning</option>
                                        @foreach ($plannings as $planning)
                                        @if ($planning->status)
                                            <option value="{{ $planning->id }}"
                                                {{ old('planning_id') == $planning->id ? 'selected' : '' }}>
                                                {{ $planning->plan_code }} | {{ $planning->plan_name }}</option>
                                        @endif

                                        @endforeach
                                    </select>
                                    @error('planning_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Planning Name</label>
                                    <input type="text" value="{{old('planning_name')}}"
                                        class="form-control @error('planning_name') is-invalid @enderror"
                                        id="planning_name" name="planning_name" disabled>
                                    @error('planning_name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <br>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Planning Code</label>
                                    <input type="text" value="{{old('planning_code')}}"
                                        class="form-control @error('planning_code') is-invalid @enderror"
                                        name="planning_code" id="planning_code" disabled>
                                    @error('planning_code')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <br>
                                </div>
                            </div>
                        </div>
                        <h4 style="color: chocolate">Production Details</h4>
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">Production Code</label>
                                    <input type="text" value="{{old('production_code')}}"
                                        class="form-control @error('production_code') is-invalid @enderror"
                                        id="production_code" name="production_code">
                                    @error('production_code')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <br>
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">Production Name</label>
                                    <input type="text" value="{{old('production_name')}}"
                                        class="form-control @error('production_name') is-invalid @enderror"
                                        id="production_name" name="production_name" required>
                                    @error('production_name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <br>
                                </div>
                            </div>

                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="">Date Start</label>
                                    <input type="text" class="form-control digits minMaxExample
                                        @error('date_start') is-invalid @enderror" id="" name="date_start"
                                        autocomplete="off" required>
                                    @error('date_start')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <br>
                                </div>
                            </div>

                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="">Date Finish</label>
                                    <input type="text" class="form-control digits minMaxExample
                                        @error('date_finish') is-invalid @enderror" id="" name="date_finish"
                                        autocomplete="off" required>
                                    @error('date_finish')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <br>
                                </div>
                            </div>

                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="">Recovery Plan</label>
                                    <input type="number" min="0" value="{{old('recovery_plan')}}"
                                        class="form-control @error('recovery_plan') is-invalid @enderror"
                                        name="recovery_plan" id="recovery_plan" required>
                                    @error('recovery_plan')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <br>
                                </div>
                            </div>


                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="">Target Defect Rate</label>
                                    <input type="number" min="0" value="{{old('target_defect_rate')}}"
                                        class="form-control @error('target_defect_rate') is-invalid @enderror"
                                        name="target_defect_rate" id="target_defect_rate" required>
                                    @error('target_defect_rate')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <br>
                                </div>
                            </div>

                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="">Target Effectifity</label>
                                    <input type="number" min="0" value="{{old('target_effeciency')}}"
                                        class="form-control @error('target_effeciency') is-invalid @enderror"
                                        name="target_effeciency" id="target_effeciency" required>
                                    @error('target_effeciency')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <br>
                                </div>
                            </div>

                        </div>

                        <h4 style="color: chocolate">Process Details</h4>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="table-responsive ">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Process Name</th>
                                                <th>Machines</th>
                                            </tr>
                                        </thead>
                                        <tbody id="detailProcess">

                                        </tbody>

                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>


                    <a href="{{ route('mrp.production.production-list') }}">
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
    });

    $(function () {
        bdCustomFile.init();
    });

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

    // --- initial page
    setPlanning();
    $(document).ready(function () {
        $('.js-example-basic-multiple').select2();
    });


    // --- detail process
    function rowProcess(ip, process) {
        let trProcess = `<tr> 
                    <td>${ip}</td>
                    <td>${process.process_name}</td>
                    <td>
                        <table class="table table-bordered">
                           `;
        process.process_machines.forEach(procesMachine => {
            trProcess += rowMachine(procesMachine, process)
        });
        trProcess += `
                        </table>
                    </td>
                </tr>`;

        return trProcess;
    }

    function rowMachine(machine, process) {
        return `<tr>
                    <td>${machine.machine_name}</td>
                    <td>
                        <div class="form-group">
                            <select placeholder="CHOOSE PRODUCT" class="form-control js-example-basic-multiple" name="product[${process.id}_${machine.id}][]"
                                multiple="multiple" required>
                                <option disabled >CHOOSE PRODUCT</option>
                                @foreach ($products as $product)
                                <option  value="{{ $product->id }}"  {{ (old('product') == $product->id) ? 'selected' : '' }}>
                                    
                                    {{ $product->product_code }} | {{ $product->product_name }} | {{ $product->part_name }}</option>
                                @endforeach
                            </select>
                             
                        </div>
                    </td>
                </tr>`
    }

    // --- planning
    async function setPlanning() {
        $('#detailProcess').html("");
        let planning_id = $('#planning_id').val();
        // alert(planning_id);

        try {
            let resp = await axios.get("/mrp/planning/api/" + planning_id);
            let data = resp.data;
            let planning = data.planning_detail;
            // --- set planning detail
            console.log('SET PLANNING DETAIL')
            $('#planning_name').val(planning.plan_name);
            $('#planning_code').val(planning.plan_code);

            // --- set process
            let processTable = '';
            let ip = 0;
         
            console.log(data.process)
            data.process.forEach(prcs => {
                ip++;
                processTable += rowProcess(ip, prcs);
            });

            $('#detailProcess').html(processTable);
            $('.js-example-basic-multiple').select2();




        } catch (error) {
            console.log(error)
        }
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


    function changeActual() {
        let reject = $('#qty_reject').val()
        let good = $('#qty_good').val()

        $('#qty_actual').val(Number(reject) + Number(good))
    }

</script>
@endpush
