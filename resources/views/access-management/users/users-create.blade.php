@extends('index')
@section('content')
<div class="row ">
    <div class="col-xl-3"></div>
    <div class="col-xl-6">
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
                        <!-- Fungsi Enctype buat ngirim format file gambar ataupun file lainnya -->
                        <form action="{{route('access-management.user-store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                               <div class="form-group">
                                   <label for="name">Name</label>
                                   <input type="text" value="{{old('name')}}" class="form-control @error('name') is-invalid @enderror" name="name" >
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                               </div>

                               <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" value="{{old('username')}}" class="form-control @error('username') is-invalid @enderror" name="username" >
                                 @error('username')
                                     <span class="text-danger">{{ $message }}</span>
                                 @enderror
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" value="{{old('email')}}" class="form-control @error('email') is-invalid @enderror" name="email" >
                                 @error('email')
                                     <span class="text-danger">{{ $message }}</span>
                                 @enderror
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" value="{{old('password')}}" class="form-control @error('password') is-invalid @enderror" name="password" >
                                 @error('password')
                                     <span class="text-danger">{{ $message }}</span>
                                 @enderror
                            </div>

                            <div class="form-group">
                                <label for="password_confirm">Password Confirm</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                 @error('password')
                                     <span class="text-danger">{{ $message }}</span>
                                 @enderror
                            </div>

                            <div class="form-group">
                                <label for="password_confirm">Role</label>
                                <select name="roles" id="roles" class="form-control">
                                    @foreach($roles as $role)
                                    <option value="{{$role->name}}">{{$role->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group ">
                                <label for="">Avatar</label>
                                <input class="form-control{{ $errors->has('avatar') ? ' is-invalid' : '' }}"  type="file"
                                    name="avatar">
                                @if ($errors->has('avatar'))
                                    <small class="text-danger">{{ $errors->first('avatar') }}</small>
                                @endif
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
@endsection
