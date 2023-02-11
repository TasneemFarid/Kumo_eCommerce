@extends('layouts.dashboard') 

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item">
            <a href="{{ route('subcategory')}}">Subcategory</a>
        </li>
    </ol>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card-header">
            <h3>SubCategory List</h3>
        </div>
        <div class="card-body">
             @if (session('add_succes'))
            <div class="alert alert-success">{{session('add_succes')}}</div>
            @endif
             @if (session('delete_success'))
            <div class="alert alert-success">{{session('delete_success')}}</div>
            @endif
            <table id="table_id" class="table table-striped">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Image</th>
                        <th>Category Name</th>
                        <th>Subcategory Name</th>
                        <th>Added By</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subcategories as $key=>$subcategory)   
                    <tr>
                        <td>{{$key+1}}</td>
                        <td><img width="100" src="{{asset('uploads/subcategory')}}/{{$subcategory->subcategory_image}}" alt=""></td>
                        <td>{{($subcategory->rel_to_category->deleted_at==NULL?$subcategory->rel_to_category->category_name:'uncategorised')}}</td>
                        <td>{{$subcategory->subcategory_name}}</td>
                        <td>{{$subcategory->rel_to_user->name}}</td>
                        <td>{{$subcategory->created_at->diffForHumans()}}</td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                    <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('subcategory_edit', $subcategory->id)}}">Edit</a>
                                    <a class="dropdown-item" href="{{ route('subcategory_delete', $subcategory->id)}}">Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3>Add Subcategory</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('subcategory_add')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mt-3">
                        <label for="" class="form-label">Category Name</label>
                        <select name="category_id" class="form-control">
                            <option value="">--Select Category--</option>
                            @foreach ($categories as $category)
                            <option value="{{$category->id}}">{{$category->category_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mt-3">
                        <label for="" class="form-label">Subcategory Name</label>
                        <input type="text" class="form-control" name="subcategory_name" placeholder="Enter Subcategory">
                    </div>
                    <div class="mt-3">
                        <label for="" class="form-label">Subcategory Image</label>
                        <input type="file" class="form-control" name="subcategory_image">
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Add Subcategory</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card-header">
            <h3>Trashed SubCategory List</h3>
        </div>
        <div class="card-body">
             @if (session('restore_success'))
            <div class="alert alert-success">{{session('restore_success')}}</div>
            @endif
             @if (session('forceDelete_success'))
            <div class="alert alert-success">{{session('forceDelete_success')}}</div>
            @endif
            <table id="table_id" class="table table-striped">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Image</th>
                        <th>Category Name</th>
                        <th>Subcategory Name</th>
                        <th>Added By</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($trashed as $key=>$trash)   
                    <tr>
                        <td>{{$key+1}}</td>
                        <td><img width="100" src="{{asset('uploads/subcategory')}}/{{$trash->subcategory_image}}" alt=""></td>
                        <td>{{$trash->rel_to_category->category_name}}</td>
                        <td>{{$trash->subcategory_name}}</td>
                        <td>{{$trash->rel_to_user->name}}</td>
                        <td>{{$trash->created_at->diffForHumans()}}</td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                    <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('subcategory_restore', $trash->id)}}">Restore</a>
                                    <a class="dropdown-item" href="{{ route('subcategory_force_delete', $trash->id)}}">Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('footer_script')
    <script>
        // $(document).ready( function () {
        //     $('#table_id').DataTable();
        // } );
    </script>
@endsection