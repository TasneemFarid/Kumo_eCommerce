@extends('layouts.dashboard') 

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item">
            <a href="#">Subcategory Update</a>
        </li>
    </ol>
</div>

    <div class="row">
        <div class="col-lg-8 m-auto">
            <div class="card">
                <div class="card-header">
                    <h3>Edit Subcategory</h3>
                </div>
                <div class="card-body">
                    @if (session('update_succes'))
                <div class="alert alert-success">{{session('update_succes')}}</div>
                @endif
                    <form action="{{ route('subcategory_update')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{-- <div class="mt-3">
                            
                            <label for="" class="form-label">Category Name</label>
                            <select name="category_id" class="form-control">
                                <option value="">--Select Category--</option>
                                @foreach ($categories as $category)
                                <option value="{{$category->id}}">{{$category->category_name}}</option>
                                @endforeach
                            </select>
                        </div> --}}
                        <input type="hidden" name="subcategory_id" value="{{$subcategories->id}}">
                        <div class="mt-3">
                            <label for="" class="form-label">Subcategory Name</label>
                            <input type="text" class="form-control" name="subcategory_name" placeholder="Enter Subcategory" value="{{$subcategories->subcategory_name}}">
                            @error('subcategory_name')
                            <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="mt-3">
                            <label for="" class="form-label">Subcategory Image</label>
                            <input type="file" class="form-control" name="subcategory_image"  onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                            @error('subcategory_image')
                            <strong class="text-danger">{{$message}}</strong>
                            @enderror
                            <br>
                            <img id="blah" width="200" src="{{asset('uploads/subcategory')}}/{{$subcategories->subcategory_image}}" alt="">
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">Update Subcategory</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
