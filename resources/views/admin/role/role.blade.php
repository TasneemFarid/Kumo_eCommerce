@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item">
            <a href="{{ route('role') }}">Role</a>
        </li>
    </ol>
</div>

<div class="row">
    <div class="col-lg-9">
        @can('show_role')
        <div class="card">
            <div class="card-header">
                <h3>Permission List</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>SL</th>
                        <th>Role</th>
                        <th>Permission</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($roles as $sl=>$role)
                        <tr>
                            <th>{{$sl+1}}</th>
                            <th>{{$role->name}}</th>
                            <th>
                                @foreach ($role->getAllPermissions() as $permission)
                                    <span class="badge badge-primary my-2">{{$permission->name}}</span>
                                @endforeach
                            </th>
                            <th>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                        <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{route('role_edit', $role->id)}}">Edit</a>
                                        <a class="dropdown-item" href="">Delete</a>
                                    </div>
                                </div>
                            </th>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div> 
        @endcan
        <div class="card">
            <div class="card-header">
                <h3>User List</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Sl</th>
                        <th>User</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($users as $sl=>$user)
                        <tr>
                            <th>{{$sl+1}}</th>
                            <th>{{$user->name}}</th>
                            <th>
                                @forelse ($user->getRoleNames() as $role)
                                    {{$role}}
                                @empty
                                Not assigned
                                @endforelse
                            </th>
                            <th>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                        <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{route('assign_role_delete', $user->id)}}">Delete</a>
                                    </div>
                                </div>
                            </th>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        {{-- <div class="card">
            <div class="card-header">
                <h3>Add Permission</h3>
            </div>
            <div class="card-body">
                <form action="{{route('add_permission')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Permission</label>
                        <input type="text" class="form-control" name="permission">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div> --}}
        <div class="card">
            <div class="card-header">
                <h3>Add Role</h3>
            </div>
            <div class="card-body">
                <form action="{{route('add_role')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Role Name</label>
                        <input type="text" class="form-control" name="role_name">
                    </div>
                    <div class="mb-3">
                        <div class="form-group">
                            <h5>Select Permission</h5>
                            @foreach ($permissions as $permission)
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input" name="permission[]" value="{{$permission->id}}">{{$permission->name}}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h3>Assign Role</h3>
            </div>
            <div class="card-body">
                <form action="{{route('assign_role')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">User</label>
                        <select name="user_id" id="" class="form-control">
                            <option value="">Select User</option>
                            @foreach ($users as $user)
                                <option value="{{$user->id}}">{{$user->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Role</label>
                        <select name="role_id" id="" class="form-control">
                            <option value="">Select Role</option>
                            @foreach ($roles as $role)
                                <option value="{{$role->id}}">{{$role->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Assign Role</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection