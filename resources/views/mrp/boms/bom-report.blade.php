@extends('mrp')

@section('title', $page_title)

@section('content')
    <div class="row ">
        <div class="col-xl-12">
            <div class="white_card mb_30 shadow pt-4">
                <div class="white_card_body">
                    <div class="QA_section">
                        <div class="white_box_tittle list_header">
                            <div class="row">
                                <h4>{{ $page_title }}</h4>
                            </div>

                            <div class="box_right d-flex lms_block">
                                <a href="{{ route('production.index') }}">
                                    <div class="btn btn-warning ml-10">
                                    <i class="ti-back-left"></i>
                                        Back
                                    </div>
                                </a>
                                <a href="{{ route('mrp.production.production-create') }}">
                                    <div class="btn btn-success ml-10">
                                        <i class="fas fa-file-excel"></i>
                                Excel
                                    </div>
                                </a>
                                <a href="{{ route('mrp.production.production-create') }}">
                                    <div class="btn btn-danger ml-10">
                                        <i class="fas fa-file-pdf"></i>
                                PDF
                                    </div>
                                </a>
                            </div>
                        </div>
                        @if (Session::has('message'))
                        <div class="alert  {{ Session::get('alert-class', 'alert-info') }} d-flex align-items-center justify-content-between"
                            role="alert">
                            <div class="alert-text">
                                <p>{{ Session::get('message') }}</p>
                            </div>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="ti-close  f_s_14"></i>
                            </button>
                        </div>
                    @endif
                    <div class="QA_table mb_30">
                        <!-- table-responsive -->
                        <table class="table lms_table_active3 ">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Bom Code</th>
                                    <th scope="col">Bom Name</th>
                                    <th scope="col">Material</th>
                                    <th scope="col">Unit</th>
                                    <th scope="col">Qty</th>
                                    {{-- <th scope="col" width="8%">Action</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                            {{-- @foreach ($productions as $production) --}}
                            <tr>
                                <td>1</td>
                                <td>BOM01</td>
                                <td>FELT ADT 01</td>
                                <td>Low melt ht</td>
                                <td>KG</td>
                                <td>2880</td>

                                {{-- <td>
                                    <div class="action_btns d-flex ">
                                        <a href= class="action_btn mr_10"> <i class="far fa-edit"></i> </a>
                                        <a href=""class="action_btn"> <i class="fas fa-trash"></i> </a>
                                    </div>
                                </td> --}}
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>BOM02</td>
                                <td>FELT ADT 02</td>
                                <td>Low melt ht</td>
                                <td>KG</td>
                                <td>1880</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>BOM03</td>
                                <td>FELT ADT 03</td>
                                <td>Low melt ht</td>
                                <td>KG</td>
                                <td>1580</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>BOM04</td>
                                <td>FELT ADT 04</td>
                                <td>Low melt ht</td>
                                <td>KG</td>
                                <td>1880</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>BOM05</td>
                                <td>FELT ADT 05</td>
                                <td>POLY-CYCLE</td>
                                <td>KG</td>
                                <td>2880</td>
                            </tr>
                            {{-- @endforeach  --}}
                            </tbody>
                        </table>
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
@endpush
@push('js')

<script src="{{ asset('assets') }}/vendors/datatable/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('assets') }}/vendors/datatable/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('assets') }}/vendors/datatable/js/dataTables.buttons.min.js"></script>

<script>
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

    var urlDelete = `{{ route('mrp.product-delete') }}`

    function deleteData(event, id, textData) {
        event.preventDefault();
        $.confirm({
            title: 'Are you sure for delete data ?',
            content: textData,
            buttons: {
                confirm: {
                    btnClass: 'btn-red',
                    keys: ['enter'],
                    action: function() {
                        axios.delete(urlDelete, {
                                params: {
                                    id: id,
                                    text: textData
                                }
                            })
                            .then(function(response) {
                                // handle success
                                location.reload();
                            })
                            .catch(function(error) {
                                // handle error
                                console.log(error);
                            })
                            .then(function() {
                                // always executed
                            });

                    }
                },
                cancel: {
                    btnClass: 'btn-dark',
                    keys: ['esc'],

                },

            }
        });
    }

</script>
@endpush
