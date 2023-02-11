@extends('layouts.dashboard') 

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item">
            <a href="{{ route('category') }}">Category</a>
        </li>
    </ol>
</div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card-header">
                <h3>Category List</h3>
            </div>
            <div class="card-body">
                @if (session('delete_success'))
                <div class="alert alert-success">{{session('delete_success')}}</div>
                @endif
                @if (session('force_delete_success'))
                <div class="alert alert-success">{{session('force_delete_success')}}</div>
                @endif
                <table class="table table-striped">
                    <tr>
                        <th>SL</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Added By</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($categories as $key=>$category)   
                    <tr>
                        <td>{{$key+1}}</td>
                        <td><img width="100" src="{{asset('uploads/category')}}/{{$category->category_image}}" alt=""></td>
                        <td>{{$category->category_name}}</td>
                        <td>{{$category->rel_to_user->name}}</td>
                        <td>{{$category->created_at->diffForHumans()}}</td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                    <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                </button>
                                <div class="dropdown-menu">
                                    @can('edit_category')
                                    <a class="dropdown-item" href="{{route('category_edit', $category->id)}}">Edit</a>
                                    @endcan
                                    @can('delete_category')
                                    <a class="dropdown-item" href="{{route('category_delete', $category->id)}}">Delete</a>
                                    @endcan
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <div class="col-lg-4 mt-4">
            @can('add_category')
            <div class="card">
                <div class="card-header">
                    <h3>Category</h3>
                </div>
                <div class="card-body">
                    @if (session('add_success'))
                        <div class="alert alert-success">{{session('add_success')}}</div>
                    @endif
                    <form action="{{route('category_store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="" class="form-label">Category Name</label>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" name="category_name" placeholder="Enter Category Name"/>
                            @error('category_name')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Category Image</label>
                        </div>
                        <div class="mb-3">
                            <input type="file" class="form-control" name="category_image" onchange="document.getElementById('category_img').src = window.URL.createObjectURL(this.files[0])"/>
                            <br>
                            <img width="200" id="category_img" src="" alt="">
                            @error('category_image')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Add Category</button>
                        </div>
                    </form>
                </div>
            </div>
            @endcan
        </div>
        <div class="col-lg-8">
            <div class="card-header">
                <h3>Trash Category List</h3>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <tr>
                        <th>SL</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Added By</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($trashed as $key=>$trash)   
                    <tr>
                        <td>{{$key+1}}</td>
                        <td><img width="100" src="{{asset('uploads/category')}}/{{$trash->category_image}}" alt=""></td>
                        <td>{{$trash->category_name}}</td>
                        <td>{{$trash->added_by}}</td>
                        <td>{{$trash->created_at->diffForHumans()}}</td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                    <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{route('category_restore', $trash->id)}}">Restore</a>
                                    <a class="dropdown-item" href="{{route('category_force_delete', $trash->id)}}">Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

@endsection
