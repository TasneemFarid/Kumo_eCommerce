@extends('layouts.dashboard') 

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item">
            <a href="#">Category Update</a>
        </li>
    </ol>
</div>

    <div class="row">
        <div class="col-lg-8 m-auto">
            <div class="card">
                <div class="card-header">
                    <h3>Edit Category</h3>
                </div>
                <div class="card-body">
                    @if (session('update_succes'))
                        <div class="alert alert-success">{{session('update_succes')}}</div>
                    @endif
                    <form action="{{route('category_update')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="" class="form-label">Category Name</label>
                        </div>
                        <div class="mb-3">
                            <input type="hidden" name="category_id" value="{{$category_info->id}}">
                            <input type="text" class="form-control" name="category_name" placeholder="Enter Category Name" value="{{$category_info->category_name}}"/>
                            @error('category_name')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Category Image</label>
                        </div>
                        <div class="mb-3">
                            <input type="file" class="form-control" name="category_image" onchange="document.getElementById('category_img').src = window.URL.createObjectURL(this.files[0])"/>
                            <img id="category_img" width="300" src="{{asset('uploads/category')}}/{{$category_info->category_image}}" alt="">
                            @error('category_image')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Update Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
