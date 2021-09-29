@extends('mrp')
@section('title', $page_title)
@section('content')
<div class="row ">
    <div class="col-xl-6">
        <div class="white_card mb_30 shadow pt-4">
            <div class="white_card_body">
                <div class="QA_section">
                    <div>
                        <form action="{{route('mrp.shift-update',$shift->id)}}" method="post">
                            @method('patch')
                            @csrf
                            <div class="form-group">
                                <label for="">Shift Code</label>
                                <input type="text" value="{{$shift->shift_code}}"
                                    class="form-control @error('shift_code') is-invalid @enderror" name="shift_code">
                                @error('shift_code')
                                <span class="text-danger">*Shift Code Wajib Diisi!</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Shift Name</label>
                                <input type="text" value="{{$shift->shift_name}}"
                                    class="form-control @error('shift_name') is-invalid @enderror" name="shift_name">
                                @error('shift_name')
                                <span class="text-danger">*Shift Name Wajib Diisi!</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Time From</label>
                                <input type="time" value="{{$shift->time_from}}" id="time_from"
                                    class="form-control @error('time_from') is-invalid @enderror" name="time_from">
                                @error('time_from')
                                <span class="text-danger">*Time From Wajib Diisi!</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Time To</label>
                                <input type="time" value="{{$shift->time_to}}" id="time_to"
                                    class="form-control @error('time_to') is-invalid @enderror" name="time_to">
                                @error('time_to')
                                <span class="text-danger">*Time To Wajib Diisi!</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Total Time <small>(Minute)</small></label>
                                <input type="text" value="{{$shift->total_time}}" readonly id="total_time"
                                    class="form-control @error('total_time') is-invalid @enderror" name="total_time">
                                @error('total_time')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Over Night <small></small></label>
                                <input type="text" value="{{$shift->over_night}}"
                                    id="over_night" readonly class="form-control @error('over_night') is-invalid @enderror" name="over_night">@error('over_night')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <small id="detail_over_night"></small>
                            </div>
                            <div class="form-group">
                                <label for="">Running Operation <small>(Minute)</small></label>
                                <input type="number" min="0" value="{{$shift->running_operation}}"
                                    class="form-control @error('running_operation') is-invalid @enderror"
                                    name="running_operation">
                                @error('running_operation')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control @error('status') is-invalid @enderror" name="status">
                                    <option disabled>Choose Status</option>
                                    <option value="1" @if ($shift->status == "1") selected @endif>Active</option>
                                    <option value="0" @if ($shift->status == "0") selected @endif>Non Active</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Description <small>(Optional)</small></label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                    name="description">{{$shift->description}}</textarea>
                                @error('description')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                    </div>
                    <a href="{{ route('mrp.shift-list') }}">
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
@endpush
