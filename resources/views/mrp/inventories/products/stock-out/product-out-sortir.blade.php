@extends('mrp')

@section('title', $page_title)

@section('content')
<div class="row ">
    <div class="col-xl-12">
        <div class="white_card mb_30 shadow pt-4">
            <div class="white_card_body">
                <div class="QA_section">
                    <div class="white_box_tittle list_header">
                        <h4>{{$page_title}}</h4>

                        {{-- <div class="box_right d-flex lms_block">
                            <a href="{{route('mrp.master-data-index')}}">
                                <div class="btn btn-warning ml-10">
                                    <i class="ti-back-left"></i>
                                    Back
                                </div>
                            </a>
                            <a href="{{route('mrp.bom-create')}}" >
                            <div class="btn btn-primary ml-10">
                                <i class="ti-plus"></i>
                                Add New
                            </div>
                            </a>
                        </div> --}}
                    </div>
                    @if(Session::has('message'))
                    <div class="alert  {{ Session::get('alert-class', 'alert-info') }} d-flex align-items-center justify-content-between" role="alert">
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
                                    <th scope="col" >No</th>
                                    <th scope="col">Product</th>
                                    <th scope="col">Part Number</th>
                                    <th scope="col">Part Name</th>
                                    <th scope="col">Sortir</th>
                                    <th scope="col">Dim. Long</th>
                                    <th scope="col">Dim. Width</th>
                                    <th scope="col">Dim. Height</th>
                                    <th scope="col">Dim. Weight</th>
                                    <th scope="col">Description</th>
                                </tr>
                            </thead>
                            {{-- {{ dd($boms) }} --}}
                            <tbody>
                                @foreach ($inventory_product_incomings as $product_out_sortir)
                                
                                <tr>
                                    <th scope="row">{{$loop->iteration}}</th>
                                    <td>{{ $product_out_sortir->product->product_name ?? 'N/A' }}</td>
                                    <td>{{ $product_out_sortir->product->part_number ?? "N/A" }}</td>
                                    <td>{{ $product_out_sortir->product->part_name ?? "N/A" }}</td>
                                    <td>{{ $product_out_sortir->sortir ?? "N/A" }}</td>
                                    <td>{{ $product_out_sortir->product->dim_long ?? "N/A" }}</td>
                                    <td>{{ $product_out_sortir->product->dim_width ?? "N/A" }}</td>
                                    <td>{{ $product_out_sortir->product->dim_height ?? "N/A" }}</td>
                                    <td>{{ $product_out_sortir->product->dim_weight ?? "N/A" }}</td>
                                    <td>{{$product_out_sortir->description}}</td>
                                    
                                </tr>

                                @endforeach


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
<link rel="stylesheet" href="{{asset('assets')}}/vendors/datatable/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="{{asset('assets')}}/vendors/datatable/css/responsive.dataTables.min.css" />
<link rel="stylesheet" href="{{asset('assets')}}/vendors/datatable/css/buttons.dataTables.min.css" />
@endpush
@push('js')

<script src="{{asset('assets')}}/vendors/datatable/js/jquery.dataTables.min.js"></script>
<script src="{{asset('assets')}}/vendors/datatable/js/dataTables.responsive.min.js"></script>
<script src="{{asset('assets')}}/vendors/datatable/js/dataTables.buttons.min.js"></script>

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

    function detailMaterial(id) {
        $.confirm({
            title: 'Detail Material',
            theme : 'material',
            backgroundDismiss: true, // this will just close the modal
            content: 'url:/mrp/bom/bom-show/detail/'+id,
            onContentReady: function () {
                var self = this;
                // this.setContentPrepend('<div>Prepended text</div>');
                // setTimeout(function () {
                //     self.setContentAppend('<div>Appended text after 2 seconds</div>');
                // }, 2000);
            },
            columnClass: 'medium',
        });
    }
  
    var urlDelete = `{{route('mrp.bom-delete')}}`
    function deleteData(event,id,textData){
        event.preventDefault();
        $.confirm({
            title: 'Are you sure for delete data ?',
            content: textData,
            buttons: {
                confirm:   {
                    btnClass: 'btn-red',
                    keys: ['enter'],
                    action: function(){
                        axios.delete(urlDelete,{params:{id:id,text:textData}})
                            .then(function (response) {
                                // handle success
                                location.reload();
                            })
                            .catch(function (error) {
                                // handle error
                                console.log(error);
                            })
                            .then(function () {
                                // always executed
                            });

                    }
                },
                cancel:  {
                    btnClass: 'btn-dark',
                    keys: ['esc'],
                    
                },
                
            }
        });
    }
</script>
@endpush
