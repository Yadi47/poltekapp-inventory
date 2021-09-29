@extends('mrp')
@section('title', $page_title)
@section('content')
<div class="row ">
    <div class="col-xl-6">
        <div class="white_card mb_30 shadow pt-4">
            <div class="white_card_body">
                <div class="QA_section">
                    <div>
                        <form action="{{route('mrp.supplier-update',$supplier->id)}}" method="post">
                            @method('patch')
                            @csrf
                            <div class="form-group">
                                <label for="">Supplier Code</label>
                                <input type="text" value="{{$supplier->supplier_code}}"
                                    class="form-control @error('code') is-invalid @enderror" name="supplier_code">
                                @error('supplier_code')
                                <span class="text-danger">*Supplier Code Wajib Diisi!</span>
                                @enderror
                                <br>
                                <label for="">Supplier Name</label>
                                <input type="text" value="{{$supplier->supplier_name}}"
                                    class="form-control @error('name') is-invalid @enderror" name="supplier_name">
                                @error('supplier_name')
                                <span class="text-danger">*Supplier Name Wajib Diisi!</span>
                                @enderror
                                <br>
                                <label for="">Address</label>
                                <input type="text" value="{{$supplier->address}}"
                                    class="form-control @error('address') is-invalid @enderror" name="address">
                                @error('address')
                                <span class="text-danger">*Address Wajib Diisi!</span>
                                @enderror
                                <br>
                                <label for="">Phone</label>
                                <input type="number" min="0" value="{{$supplier->phone}}"
                                    class="form-control @error('phone') is-invalid @enderror" name="phone">
                                @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <br>
                                <label for="">Email</label>
                                <textarea 
                                    class="form-control @error('email') is-invalid @enderror" name="email">{{$supplier->email}}</textarea>
                                {{-- <input type="email" value="{{$supplier->email}}"
                                    class="form-control @error('email') is-invalid @enderror" name="email"> --}}
                                @error('email')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <br>
                                <label for="">Website</label>
                                <input type="text" value="{{$supplier->website}}"
                                    class="form-control @error('website') is-invalid @enderror" name="website">
                                @error('website')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <br>
                                <label for="">Description <small>(Optional)</small></label>
                                <textarea 
                                    class="form-control @error('description') is-invalid @enderror" name="description">{{$supplier->description}}</textarea>
                                @error('description')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                           
                            </div>
                            <a href="{{ route('mrp.supplier-list') }}">
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
