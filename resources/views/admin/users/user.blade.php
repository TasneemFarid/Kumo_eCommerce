@extends('layouts.dashboard')

@section('content')

    <div class="page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">User</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">User List</a></li>
        </ol>
    </div> 
           
    @can('show_user_list')
    <div class="row">
        <div class="col-lg-9 m-auto">
            <div class="card">
                <div class="card-header d-flex">
                    <h3>User Info </h3>
                    <h3>Total Users: {{$total_count}}</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <tr>
                            <th>SL</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>

                        @foreach ($users as $key=>$user)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>
                                @if ($user->image == null)
                                    <img width=50 src="{{ Avatar::create($user->name)->toBase64() }}" />
                                @else
                                    <img src="{{asset('uploads/users')}}/{{$user->image}}" width="50" alt=""/>
                                @endif
                            </td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->created_at->diffForHumans()}}</td>
                            <td>
                                @can('delete_user')
                                <a href="{{route('delete', $user->id)}}" class="btn btn-danger">Delete</a>
                                @endcan
                            </td>
                        </tr>
                        @endforeach

                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card">
                <div class="card-header">
                    <h3>Add User</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('user_register') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="mb-1 text-white"><strong>Name</strong></label>
                            <input type="text" name="name" class="form-control" placeholder="Name">
                            @error('name')
                                <strong>{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="mb-1 text-white"><strong>Email</strong></label>
                            <input type="email" name="email" class="form-control" placeholder="hello@example.com">
                            @error('email')
                                <strong>{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="mb-1 text-white"><strong>Password</strong></label>
                            <input type="password" name="password" class="form-control" value="Password">
                            @error('password')
                                <strong>{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="mb-1 text-white"><strong>Confirm Password</strong></label>
                            <input type="password" name="password_confirmation" class="form-control" value="Password">
                            @error('password_confirmation')
                                <strong>{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit" class="btn bg-white text-primary btn-block">Sign me up</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endcan

@endsection