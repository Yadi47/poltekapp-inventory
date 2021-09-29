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
                        <div class="box_right d-flex lms_block">
                            <a href="{{url('/')}}">
                                <div class="btn btn-warning ml-10">
                                    <i class="ti-back-left"></i>
                                    Back
                                </div>
                            </a>
                            @if (auth()->user()->can('forecast-create'))
                            <a href="{{route('mrp.forecast-create')}}" >
                            <div class="btn btn-primary ml-10">
                                <i class="ti-plus"></i>
                                Add New
                            </div>
                            </a>
                            @endif
                        </div>
                    </div>
                
                    <form action="" class="row">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Select Month</label> 
                                <input placeholder="Select Month" autocomplete="off"  class="form-control datepicker-here  digits @error('start_date') is-invalid @enderror"
                                type="text" data-language="en" data-min-view="months" data-view="months"
                                data-date-format="MM yyyy" name="start_date">
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <div class="form-group">
                                <label for="">_</label>
                                <button class="btn btn-secondary form-control"><i class="bi bi-search"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                                </svg></i></button>
                            </div>
                        </div>
                    </form>

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
                                    <th scope="col">No</th>
                                    <th scope="col">Customer</th>
                                    <th scope="col">DOCK-CD</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Part Name</th>
                                    <th scope="col">Part No</th>
                                    <th scope="col">Date</th>    
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($forecasts as $forecast)
                                <tr>
                                    <th scope="row">{{$loop->iteration}}</th>
                                    <td>{{$forecast->customer->customer_name ?? 'N/A'}}</td>
                                    <td><button onclick="detailCustomer({{$forecast->id}})"
                                        class="btn btn-info btn-sm"><i class="ti-eye"></i> View DOCK-CD </button></td>
                                    <td>{{$forecast->qty_forecast}}</td>
                                    <td>{{$forecast->product->part_name ?? 'N/A'}}</td>
                                    <td>{{$forecast->product->part_number ?? 'N/A'}}</td>
                                    <td>{{$forecast->forecast_date}}</td>
                                    <td>
                                        <div class="action_btns d-flex">
                                        @if (auth()->user()->can('forecast-edit'))
                                            <a href="{{route('mrp.forecast-edit',$forecast->id)}}" class="action_btn mr_10"> <i class="far fa-edit"></i> </a>
                                            @endif
                                            @if (auth()->user()->can('forecast-delete'))
                                            <a href="" onclick="deleteData(event,{{$forecast->id}},'{{$forecast->dock_cd}}')"  class="action_btn"> <i class="fas fa-trash"></i> </a>
                                            @endif
                                        </div>
                                    </td>
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
<link rel="stylesheet" href="{{ asset('assets') }}/vendors/datepicker/date-picker.css">
@endpush
@push('js')

<script src="{{asset('assets')}}/vendors/datatable/js/jquery.dataTables.min.js"></script>
<script src="{{asset('assets')}}/vendors/datatable/js/dataTables.responsive.min.js"></script>
<script src="{{asset('assets')}}/vendors/datatable/js/dataTables.buttons.min.js"></script>

<script src="{{ asset('assets') }}/vendors/datepicker/datepicker.js"></script>
<script src="{{ asset('assets') }}/vendors/datepicker/datepicker.en.js"></script>
<script src="{{ asset('assets') }}/vendors/datepicker/datepicker.custom.js"></script>
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
  
    var urlDelete = `{{route('mrp.forecast-delete')}}`
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

    function detailCustomer(id) {
        $.confirm({
            title: 'Detail Customer',
            theme: 'material',
            backgroundDismiss: true, // this will just close the modal
            content: 'url:forecast-show/detail/' + id,
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
</script>
@endpush
