@extends('mrp')

@section('title', $page_title)

@section('content')
<form action="{{route('mrp.customer-store')}}" method="post">
    @csrf
<div class="row ">
    <div class="col-xl-6">
        <div class="white_card mb_30 shadow pt-4">
            <div class="white_card_body">
                <div class="QA_section">
                    <div>
                            <div class="form-group">
                                <label for="">Customer Code</label>
                                <input type="text" value="{{old('customer_code')}}"
                                    class="form-control @error('customer_code') is-invalid @enderror" name="customer_code">
                                @error('customer_code')
                                <span class="text-danger">*Customer Code Wajib Diisi!</span>
                                @enderror
                                <br>
                                <label for="">Customer Name</label>
                                <input type="text" value="{{old('customer_name')}}"
                                    class="form-control @error('customer_name') is-invalid @enderror" name="customer_name">
                                @error('customer_name')
                                <span class="text-danger">*Customer Name Wajib Diisi!</span>
                                @enderror
                                <br>
                                {{-- <label for="">DOCK-CD</label>
                                <input type="text" value="{{old('dock_cd')}}"
                                    class="form-control @error('dock_cd') is-invalid @enderror" name="dock_cd">
                                @error('dock_cd')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <br> --}}
                                <label for="">Address</label>
                                <input type="text" value="{{old('address')}}"
                                    class="form-control @error('address') is-invalid @enderror" name="address">
                                @error('address')
                                <span class="text-danger">*Address Wajib Diisi!</span>
                                @enderror
                                <br>
                                <label for="">Phone</label>
                                <input type="number" min="0"  id="phone" value="{{old('phone')}}"
                                    class="form-control @error('phone') is-invalid @enderror" name="phone">
                                @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <br>
                                <label for="">Email</label>
                                <input type="email" value="{{old('email')}}"
                                    class="form-control @error('email') is-invalid @enderror" name="email">
                                @error('email')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <br>
                                <label for="">Website</label>
                                <input type="text" value="{{old('website')}}"
                                    class="form-control @error('website') is-invalid @enderror" name="website">
                                @error('website')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <br>
                                <label for="">Description <small>(Optional)</small></label>
                                <textarea 
                                    class="form-control @error('description') is-invalid @enderror" name="description">{{old('description')}}</textarea>
                                @error('description')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            </div>
                            <a href="{{ route('mrp.customer-list') }}">
                                <button type="button" class="btn btn-warning btn-sm">
                                    <i class="ti-back-left"></i>
                                    Back</button>
                            </a>
                            <button class="btn btn-success btn-sm">
                                <i class="ti-save"></i>
                                Save</button>
                    </div>

                </div>
            </div>
        </div>
        {{-- <div class="col-xl-6">
            <div class="white_card mb_30 shadow pt-4">
                <div class="white_card_body">
                    <div class="QA_section">
                        <div class="col-lg-12">

                            <div class="form-group increment document">
                                <div class="test">
                                    <label for="">DOCK-CD </label>
                                    <button type="button" class="btn btn-outline-primary btn-add">
                                        <i class="fas fa-plus-square"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- remove -->
                            <div class="clone invisible">
                                <div class="test">
                                    <div class="input-group mt-4">
                                        <input placeholder="DOCK-CD " type="text"
                                            value="{{ (old('dock_cd') ? old('dock_cd')[0] : '') }}"
                                            class="form-control @error('dock_cd') is-invalid @enderror dock_cd"
                                            name="dock_cd[]">
                                        @error('dock_cd')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    @error('dock_cd')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-outline-danger btn-remove">
                                                <i class="fas fa-minus-square"></i>
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
    
                    </div>
                </div>
            </div>
        </div> --}}
        
    </div>
</div>
</form>
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

    // button
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
@endpush
