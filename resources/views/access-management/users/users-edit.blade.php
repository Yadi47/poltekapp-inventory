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
                        
                        <form action="{{route('access-management.user-update', $user->id)}}" method="post" enctype="multipart/form-data">
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
                                 <label for="">Current Avatar</label>
                                 <br>
                                 <img src="{{asset('backend/images/' . $user->avatar)}}" alt="" width="50%">
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
