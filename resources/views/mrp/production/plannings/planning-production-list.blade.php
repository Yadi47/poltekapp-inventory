@extends('mrp')

@section('title', $page_title)

@section('content')
<div class="row ">
    <div class="col-xl-12">
        <div class="white_card mb_30 shadow pt-4">
            <div class="white_card_body" style="overflow: auto">
                <div class="QA_section">
                    <div class="white_box_tittle list_header">
                        <h4>{{ $page_title }}</h4>

                        <div class="box_right d-flex lms_block">
                            <a href="{{ route('mrp.production-index') }}">
                                <div class="btn btn-warning ml-10">
                                    <i class="ti-back-left"></i>
                                    Back
                                </div>
                            </a>
                            @if (auth()->user()->can('planning-create'))
                            <a href="{{ route('mrp.production.planning-create') }}">
                                <div class="btn btn-primary ml-10">
                                    <i class="ti-plus"></i>
                                    Add New
                                </div>
                            </a>
                            @endif
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
                        <table class="table lms_table_active3">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Planning Code</th>
                                    <th scope="col">Planning Name</th>
                                    <!-- <th scope="col">Part Name</th>
                                        <th scope="col">Part Number</th> -->
                                    {{-- <th scope="col">Bom Code</th> --}}
                                    <th scope="col">Product</th>
                                    <th scope="col">Customer</th>
                                    <th scope="col">Proc.Code</th>
                                    <th scope="col">Batch</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Start Date</th>
                                    {{-- <th scope="col">Finish Date</th> --}}
                                    <th scope="col">Target Date</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Confirm</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($plannings as $planning)
                                <tr>
                                    <th scope="row">{{$loop->iteration}}</th>
                                    <td>{{$planning->plan_code}}</td>
                                    <td>{{$planning->plan_name}}</td>
                                     {{-- <td>{{$planning->bom->part_name}}</td> --}}
                                    {{-- <td>{{$planning->bom->part_number}}</td>  --}}
                                    {{-- <td>{{$planning->bom->bom_name}}</td> --}}
                                    <td>
                                        <button onclick="detailProduct({{$planning->id}})" class="btn btn-info btn-sm"><i class="ti-eye"></i> View Product </button>
                                    </td>
                                    <td>
                                        <button onclick="detailCustomer({{$planning->id}})" class="btn btn-info btn-sm"><i class="ti-eye"></i> View Customer </button>
                                    </td>
                                    <td>
                                        <button onclick="detailProcess({{$planning->id}})"
                                            class="btn btn-info btn-sm"><i class="ti-eye"></i> View Process </button>
                                    </td>
                                    <td>{{$planning->batch}}</td>
                                    <td>{{$planning->date}}</td>
                                    <td>{{$planning->start_date}}</td>
                                    {{-- <td>{{$planning->finish_date}}</td> --}}
                                    <td>{{$planning->target_date}}</td>
                                    <td>{{$planning->description}}</td>
                                    <td>
                                        <div>
                                            <input type="checkbox" class="col-sm-4 " name="confirm" value="true"
                                                id="{{ $planning->id }}" onchange="onCbChange(this)"
                                                {{ $planning->status ? 'checked' : "" }}>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="action_btns d-flex">
                                            @if (auth()->user()->can('planning-edit'))
                                            <a href="{{route('mrp.production.planning-edit',$planning->id)}}"
                                                class="action_btn mr_10"> <i class="far fa-edit"></i> </a>
                                            @endif 
                                            @if (auth()->user()->can('planning-delete'))
                                            <a href=""
                                                onclick="deleteData(event,{{$planning->id}},'{{$planning->plan_name}}')"
                                                class="action_btn"> <i class="fas fa-trash"></i> </a>
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
<link rel="stylesheet" href="{{ asset('assets') }}/vendors/datatable/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="{{ asset('assets') }}/vendors/datatable/css/responsive.dataTables.min.css" />
<link rel="stylesheet" href="{{ asset('assets') }}/vendors/datatable/css/buttons.dataTables.min.css" />

<style>
    .table {
        overflow: auto !important;
    }

</style>
@endpush
@push('js')

<script src="{{ asset('assets') }}/vendors/datatable/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('assets') }}/vendors/datatable/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('assets') }}/vendors/datatable/js/dataTables.buttons.min.js"></script>
<script>
    function detailProcess(id) {
        $.confirm({
            title: 'Detail Process',
            theme: 'material',
            backgroundDismiss: true, // this will just close the modal
            content: 'url:planning-show/detail/' + id,
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
    // planning-show-product/detail/{id}
    function detailProduct(id) {
        $.confirm({
            title: 'Detail Product',
            theme: 'material',
            backgroundDismiss: true, // this will just close the modal
            content: 'url:planning-show-product/detail/' + id,
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

    function detailCustomer(id) {
        $.confirm({
            title: 'Detail Customer',
            theme: 'material',
            backgroundDismiss: true, // this will just close the modal
            content: 'url:planning-show-customer/detail/' + id,
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
            responsive: false,
            searching: true,
            info: true,
            paging: true
        });
    }

    var urlDelete = `{{ route('mrp.production.planning-delete') }}`

    function deleteData(event, id, textData) {
        event.preventDefault();
        $.confirm({
            title: 'Are you sure for delete data ?',
            content: textData,
            buttons: {
                confirm: {
                    btnClass: 'btn-red',
                    keys: ['enter'],
                    action: function () {
                        axios.delete(urlDelete, {
                                params: {
                                    id: id,
                                    text: textData
                                }
                            })
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
                cancel: {
                    btnClass: 'btn-dark',
                    keys: ['esc'],

                },

            }
        });
    }

</script>

<script>
    function onCbChange(cb) {
        var b = document.getElementById(cb.id).checked;

        if (b) {
            document.getElementById(cb.id).checked = false;

            $.confirm({
                title: 'Confirm!',
                content: 'Do you want to checklist?!',
                buttons: {
                    Ok: function () {
                        document.getElementById(cb.id).checked = true;
                        axios({
                                method: 'post',
                                url: "/mrp/planning/api/confirm/" + cb.id,
                                data: {
                                    confirm: true
                                }
                            }).then(function (response) {
                                // handle success
                                console.log(response);
                            })
                            .catch(function (error) {
                                // handle error
                                console.log(error);
                            })
                            .then(function () {
                                // always executed
                            });

                    },
                    Cancel: {
                        text: 'Cancel',
                        btnClass: 'btn-blue',
                        keys: ['enter', 'shift'],
                        action: function () {

                        }
                    }
                }
            });
        } else {
            document.getElementById(cb.id).checked = true;

            $.confirm({
                title: 'Confirm!',

                content: 'This data cannot be procceced in production.<br>Do you want to unchecklist?',
                buttons: {
                    Ok: function () {
                        document.getElementById(cb.id).checked = false;
                        axios({
                                method: 'post',
                                url: "/mrp/planning/api/confirm/" + cb.id,
                                data: {
                                    confirm: false
                                }
                            }).then(function (response) {
                                // handle success
                                console.log(response);
                            })
                            .catch(function (error) {
                                // handle error
                                console.log(error);
                            })
                            .then(function () {
                                // always executed
                            });
                    },
                    Cancel: {
                        text: 'Cancel',
                        btnClass: 'btn-blue',
                        keys: ['enter', 'shift'],
                        action: function () {

                        }
                    }
                }
            });
        }
    }

</script>
@endpush