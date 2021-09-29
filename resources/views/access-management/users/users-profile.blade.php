@extends('mrp')

@section('title', $page_title)
@section('content')
    <style>
        .info-box-icon {
    border-radius: 5px;
    align-items: center;
    display: flex;
    padding: 5px;
    font-size: 2.5rem;
    justify-content: center;
  }
  .info-box-text{
    display: block;
    font-size: 21px;
    margin-top: .776rem;
    margin-left: .776rem;
  }

  .box-body {
        padding: 1rem;
        -ms-flex: 1 1 auto;
        flex: 1 1 auto;
        border-radius: 10px; 
    }
    
    .card {
        cursor: pointer;
        transition: all 0.7s;
    }

    .card:hover {
        transform: scale(1.07) !important;
        box-shadow: 0 10px 20px rgba(0, 0, 0, .12), 0 5px 8px rgba(0, 0, 0, .06);
    }

    .mt-30 {
        margin-top: 30px;
    }

    .me-15 {
        margin-right: 15px !important; 
    }

    .h-50 {
        height: 50px !important; 
    }  

    .w-50 {
        width: 50px !important; 
    }

    .l-h-50 {
        line-height: 3.0714285714rem!important; 
    }

    .rounded { 
        border-radius: .25rem !important;
    }

    @media (max-width: 767px) {
        .small-box {
            text-align: center; 
            }
            .small-box .icon {
            display: none; 
            }
            .small-box p {
            font-size: 0.8571rem; 
            } 
        }
        .box {
            position: relative;
            margin-bottom: 1.5rem;
            width: 100%;
            background-color: #ffffff;
            border-radius: 10px;
            padding: 0px;
            -webkit-transition: .5s;
            transition: .5s;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            -webkit-box-shadow: 0 0 30px 0 rgba(82, 63, 105, 0.05);
            box-shadow: 0 0 30px 0 rgba(82, 63, 105, 0.05); 
        }
    }

    .border-image{
        border: solid 2px black;
        padding: 10px;
    }
    </style>
<div class="row">
    <div class="col-md-4 col-lg-4 col-xl-4 box-col-4">
        <div class="card custom-card">
            <div class="card-header"><img class="img-fluid" style="ima" src="{{asset('backend/images/background7.png')}}" alt="" data-original-title="" title=""></div>
                <div class="card-profile"><img class="rounded-circle" src="{{asset('backend')}}/images/{{ Auth::user()->avatar ?? 'user.svg' }}" alt="" data-original-title="" title=""></div>
                    <div class="text-center profile-details">
                        <h4>{{ Auth::user()->name }}</h4>
                        <h6>{{ Auth::user()->roles->pluck('name')[0] }}</h6>
                    </div>
                    <div class="card-footer row">
                        <div class="row ">
                            <div>
                                <p class="mb-2 mt-20 float-left">Name &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<span class="text-gray"> {{ Auth::user()->name }}</span> </p>
                                <span class="clearfix"></span>
                                <p class="mb-2 float-left">Username &nbsp;&nbsp;:<span class="text-gray"> {{ Auth::user()->username }}</span></p>
                                <span class="clearfix"></span>
                                <p class="mb-2 float-left">Role &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<span class="text-gray"> {{ Auth::user()->roles->pluck('name')[0] }}</span></p>
                                <span class="clearfix"></span>
                                <p class="mb-2 float-left">Email &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<span class="text-gray"> {{ Auth::user()->email }}</span> </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 col-md-8 col-lg-8">
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
                        <div class="QA_section">
                            
                            <form action="{{route('access-management.user-update', Auth::user()->id)}}" method="post" enctype="multipart/form-data">
                                @method('patch')
                                @csrf
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" value="{{ $user->name }}" class="form-control @error('name') is-invalid @enderror" name="name" >
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                </div>

                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" value="{{ $user->username }}" class="form-control @error('username') is-invalid @enderror" name="username" >
                                    @error('username')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" value="{{ $user->email }}" class="form-control @error('email') is-invalid @enderror" name="email" >
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" value class="form-control @error('password') is-invalid @enderror" name="password">
                                    <span class="text-secondary">Don't fill in, if you don't want to change the password !</span>
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- <div class="form-group">
                                    <label for="password_confirm">Password Confirm</label>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div> --}}

                                <div class="form-group">
                                    <label for="password_confirm">Role</label>
                                    <select name="roles" id="roles" class="form-control">
                                        @foreach($roles as $role)
                                            <option value="{{$role->id}}" {{($role->id == $role->id) ? 'selected' : ''}}>{{$role->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="file">Avatar</label>
                                    <input type="file" value="{{ $user->file }}" class="form-control @error('avatar') is-invalid @enderror" name="avatar" >
                                    @error('file')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <br>
                                    <label for="">Current Avatar</label>
                                    <br>
                                    <img class="d-block mx-auto" style=" border: 1px solid #ddd; border-radius: 4px; padding:10px;" width="125" src="{{asset('backend')}}/images/{{ Auth::user()->avatar ?? 'user.svg' }}" alt="" >
                                </div>
                                <a href="{{ route('access-management.user-list') }}">
                                    <button type="button" class="btn btn-warning btn-sm">Back</button>
                                    </a>
                                <button class="btn btn-success btn-sm">Save</button>
                            </form>
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
    <link rel="stylesheet" href="{{ asset('assets') }}/vendors/datatable/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendors/datatable/css/responsive.dataTables.min.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendors/datatable/css/buttons.dataTables.min.css" />
@endpush
@push('js')

    <script src="{{ asset('assets') }}/vendors/datatable/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('assets') }}/vendors/datatable/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('assets') }}/vendors/datatable/js/dataTables.buttons.min.js"></script>

    <script src="{{ asset('assets') }}/vendors/echart/echarts.min.js"></script>
    <script src="{{ asset('assets') }}/vendors/apex_chart/apex-chart2.js"></script>
    <script src="{{ asset('assets') }}/vendors/apex_chart/apex_dashboard.js"></script>

    {{-- SEARCH --}}
    <script>
        const dictionary = ['planning', 'production', 'report'];
        const searchInput = document.getElementById("search");

        searchInput.addEventListener("keyup", (e) => {
            dictionary.forEach(element => {
                let id = '#' + element;
                $(id).addClass('hidden')
            });

            const inputText = e.target.value.toLowerCase();
            let filtered = dictionary.filter((data) => {
                return data.indexOf(inputText.toLowerCase()) !== -1;
            });

            filtered.forEach(element => {
                let id = '#' + element;
                $(id).removeClass('hidden')
            });
            console.log(filtered)
        });

    </script>


@endpush
