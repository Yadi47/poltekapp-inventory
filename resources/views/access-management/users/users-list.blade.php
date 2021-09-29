@extends('index')
@section('content')
<div class="row ">
    <div class="col-xl-2"></div>
    <div class="col-xl-8">
            <div class="white_card mb_30 shadow">
                <div class="white_card_header">
                    <div class="row align-items-center justify-content-between flex-wrap">
                        <div class="col-lg-12">
                            <div class="main-title">
                                <h3 class="m-0"></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="white_card_body ">
                    {{-- <img src="{{asset('/assets/img/logo/itokin.png')}}" alt=""> --}}
                    {{-- <h5>PT. Itokin Indonesia</h5> --}}
                    <div class="QA_section">
                        <div class="white_box_tittle list_header">
                            <h4>{{$page_title}}</h4>
    
                            <div class="box_right d-flex lms_block">
                                <a href="{{route('home')}}">
                                    <div class="btn btn-warning ml-10">
                                        Back
                                    </div>
                                </a>
                                <a href="{{route('access-management.user-create')}}" >
                                <div class="btn btn-primary ml-10">
                                    Add New
                                </div>
                                </a>
                            </div>
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
                                        <th scope="col" width="10%">No</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Username</th>
                                        <th scope="col">Avatar</th>
                                        <th scope="col" width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                    <tr>
                                        <th scope="row">{{$loop->iteration}}</th>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->username}}</td>
                                        <td><img width="40" src="{{asset('backend/images/'.$user->avatar)}}" alt="profile"></td>
                                        <td>
                                            <div class="action_btns d-flex">
                                                <a href="{{route('access-management.user-edit', $user->id)}}" class="action_btn mr_10"> <i class="far fa-edit"></i> </a>
                                                <a href="" onclick="deleteData(event,{{$user->id}},'{{$user->name}}')"  class="action_btn"> <i class="fas fa-trash"></i> </a>
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
  
    var urlDelete = `{{route('access-management.user-delete')}}`
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
