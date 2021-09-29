@extends('mrp')

@section('title', $page_title)

@section('content')
<div class="row ">
    <div class="col-xl-6">
        <div class="white_card mb_30 shadow pt-4">
            <div class="white_card_body">
                <div class="QA_section">
                    <div>
                        <form action="{{route('mrp.process-store')}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="">Process Code</label>
                                <input type="text" value="{{old('process_code')}}"
                                    class="form-control @error('process_code') is-invalid @enderror" name="process_code">
                                @error('process_code')
                                <span class="text-danger">*Process Code Wajib Diisi!</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Process Name</label>
                                <input type="text" value="{{old('process_name')}}"
                                    class="form-control @error('process_name') is-invalid @enderror" name="process_name">
                                @error('process_name')
                                <span class="text-danger">*Process Name Wajib Diisi!</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Process Time <small> <b>(s)</b> </small></label>
                                <input type="number" min="0" value="{{old('process_time')}}"
                                    class="form-control @error('process_time') is-invalid @enderror" name="process_time">
                                @error('process_time')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">                                
                                <label>Machine </label>
                                <select class="form-control js-example-basic-multiple @error('machine_id') is-invalid @enderror" name="machine_id[]"
                                                multiple="multiple">
                                                @foreach ($machines as $machine)
                                                <option value="{{ $machine->id }}">
                                                    {{ (old('machine_id') == $machine->id) ? 'selected' : '' }}
                                                    {{ $machine->machine_code }} | {{ $machine->machine_name }}</option>
                                                @endforeach
                                            </select>
                                @error('machine_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Description <small>(Optional)</small></label>
                                <textarea
                                    class="form-control @error('description') is-invalid @enderror" name="description">{{old('description')}}</textarea>
                                @error('description')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                            
                               
                            </div>
                            <a href="{{ route('mrp.process-list') }}">
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
    $(document).ready(function () {
        $('.js-example-basic-multiple').select2();
    });
  
</script>


@endpush
