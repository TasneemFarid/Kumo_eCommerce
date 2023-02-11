@extends('layouts.dashboard')

@section('content')
    <div class="page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('profile')}}">Profile</a></li>
        </ol>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h3>Change Name</h3>
                    </div>
                    <div class="card-body">
                        @if (session('name_success'))
                            <div class="alert alert-success">{{session('name_success')}}</div>
                        @endif
                        <form action="{{route('name_update')}}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" value="{{Auth::user()->name}}">
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Change Name</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h3>Change Password</h3>
                    </div>
                    <div class="card-body">
                        @if (session('pass_success'))
                            <div class="alert alert-success">{{session('pass_success')}}</div>
                        @endif
                        <form action="{{route('password_update')}}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="" class="form-label">Old Password</label>
                                <input type="password" name="old_password" class="form-control">
                                @error('old_password')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                                @if (session('wrong_pass'))
                                <strong class="text-danger">{{session('wrong_pass')}}</strong>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control">
                                @error('password')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control">
                                @error('password_confirmation')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Change Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h3>Change Photo</h3>
                    </div>
                    <div class="card-body">
                        @if (session('photo_success'))
                            <div class="alert alert-success">{{session('photo_success')}}</div>
                        @endif
                        <form action="{{route('photo_update')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="" class="form-label">Photo</label>
                                <input type="file" name="image" class="form-control">
                                @error('image')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Change Photo</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection