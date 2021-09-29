@extends('oee')

@section('title', $page_title)

@section('content')
<div class="row ">
    <form action="{{ route('oee.alarm-setting.update',$alarmMaster->id) }}" method="post" class="col-12 row">
        @csrf
        @method('patch')

        <div class="col-xl-5">
            <div class="white_card mb_30 shadow pt-4">
                <div class="white_card_body">
                    <div class="form-group">
                        <label for="">Machine Name</label>
                        <select name="machine_name" class="form-control" id="">
                            <option disabled selected>Choose Unit</option>
                            
                            @foreach ($machines as $machine)
                            <option value="{{ $machine->id }}"
                                {{ ($alarmMaster->machine_id == $machine->id) ? 'selected' : '' }}>
                                {{ $machine->ident }}</option>
                            @endforeach
                        </select>
                        
                        @error('machine_id')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="">Alarm Name</label>

                        <input type="text" value="{{ $alarmMaster->alarm_name }}" class="form-control @error('alarm_name') is-invalid @enderror" name="alarm_name">
                        
                        @error('alarm_name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="">Alarm Tag</label>

                        <input type="text" value="{{ $alarmMaster->alarm_tag }}" class="form-control @error('alarm_tag') is-invalid @enderror" name="alarm_tag">
                        
                        @error('alarm_tag')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-7">
            <div class="white_card mb_30 shadow pt-4">
                <div class="white_card_body">
                    <div class="form-group increment document">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <div class="test">
                                    <div class="row">
                                        <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                                            <div class="form-group text-center">
                                                <label for="" class="text-center">Array Index</label>
                                                
                                                <input type="number" value="{{old('array_index')}}" class="form-control @error('array_index') is-invalid @enderror" placeholder="input array index..." name="array_index[]">
                                                    
                                                    @error('array_index')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                            </div> 
                                        </div>
                                        <div class="col-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                                            <div class="form-group text-center">
                                                <label for="">Text</label>
                                                <textarea class="form-control @error('text') is-invalid @enderror" name="text[]" style="height:2.4rem;" placeholder="Input Text Alarm...">{{old('text')}}</textarea>
                                                
                                                @error('text')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"> 
                                            <label for="">Action</label>
                                            <div class="input-group-append">
                                                <button type="button"  class="btn btn-outline-primary btn-add">
                                                    <i class="fas fa-plus-square"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                        </div>

                        {{-- Check old values --}}
                        @foreach (($alarmMaster->alarms) as $detail)
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <div class="test">
                                    <div class="row">
                                        <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                                            <div class="form-group text-center">
                                                <label for="" class="text-center">Array Index</label>
                                                <input type="hidden" name="id[]" value="{{$detail->id}}">
                                                <input type="number" value="{{ $detail->index_array }}" class="form-control @error('array_index') is-invalid @enderror" placeholder="input array index..." name="array_index[]">
                                                    
                                                    @error('array_index')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                            </div> 
                                        </div>
                                        <div class="col-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                                            <div class="form-group text-center">
                                                <label for="">Text</label>
                                                <textarea class="form-control @error('text') is-invalid @enderror" name="text[]" style="height:2.4rem;" placeholder="Input Text Alarm...">{{ $detail->text }}</textarea>
                                                
                                                @error('text')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"> 
                                            <label for="">Action</label>
                                            <div class="input-group-append">
                                                <button type="button"  class="btn btn-outline-danger btn-remove">
                                                    <i class="fas fa-minus-square"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="clone invisible d-none">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <div class="test">
                                    <div class="row">
                                        <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                                            <div class="form-group text-center">
                                                <label for="" class="text-center">Array Index</label>
                                                
                                                <input type="number" value="{{old('array_index')}}" class="form-control @error('array_index') is-invalid @enderror" placeholder="input array index..." name="array_index[]">
                                                    
                                                    @error('array_index')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                            </div> 
                                        </div>
                                        <div class="col-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                                            <div class="form-group text-center">
                                                <label for="">Text</label>
                                                <textarea class="form-control @error('text') is-invalid @enderror" name="text[]" style="height:2.4rem;" placeholder="Input Text Alarm...">{{old('text')}}</textarea>
                                                
                                                @error('text')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"> 
                                            <label for="">Action</label>
                                            
                                            <div class="input-group-append">
                                                <button type="button"  class="btn btn-outline-danger btn-remove">
                                                    <i class="fas fa-minus-square"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                        
                    <a href="{{ route('oee.alarm-setting.index') }}">
                        <button type="button" class="btn btn-warning btn-sm">
                            <i class="ti-back-left"></i>
                            Back
                        </button>
                    </a>

                    <button class="btn btn-success btn-sm">
                        <i class="ti-save"></i>
                        Save
                    </button>
                </div>
            </div>
        </div>
    </form>
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

    $(document).ready(function () {
        $(".btn-add").click(function () {
            let markup = $(".invisible").html();
            $(".increment").append(markup);
        });
        $("body").on("click", ".btn-remove", function () {
            $(this).parents(".test").remove();
        })
    });

</script>
@endpush
