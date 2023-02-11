@extends('layouts.dashboard')

@section('content')
    <div class="row">
        <div class="col-lg-10 m-auto">
            <div class="card">
                <div class="card-header">
                    <h3>Edit Role Permission</h3>
                </div>
                <div class="card-body">
                    <form action="{{route('update_role')}}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="" class="form-label">Role Name</label>
                            <input type="text" readonly class="form-control" value="{{$role->name}}">
                            <input type="hidden" class="form-control" name="role_id" value="{{$role->id}}">
                        </div>
                        <div class="mb-3">
                            <div class="form-group">
                                <h5>Select Permission</h5>
                                @foreach ($permissions as $permission)
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input type="checkbox" {{($role->hasPermissionTo($permission->id))?'checked':''}} class="form-check-input" name="permission[]" value="{{$permission->id}}">{{$permission->name}}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Edit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection