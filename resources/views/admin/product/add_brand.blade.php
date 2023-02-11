@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="">Product</a></li>
        <li class="breadcrumb-item"><a href="">Add Brand</a></li>
    </ol>
</div>
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3>Brands</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>SL</th>
                        <th>Brand</th>
                        <th>Logo</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($brands as $sl=>$brand)
                        <tr>
                            <td>{{$sl+1}}</td>
                            <td>{{$brand->brand_name}}</td>
                            <td><img src="{{asset('uploads/brand')}}/{{$brand->brand_logo}}" width="50" alt=""></td>
                            <td><a class="btn btn-danger" href="">Delete</a></td>
                        </tr>
                    @endforeach
                    
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3>Add Brand</h3>
            </div>
            <div class="card-body">
                @if (session('color_success'))
                <div class="alert alert-success">{{session('color_success')}}</div>
                @endif
                <form action="{{route('brand_store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <input type="text" name="brand_name" placeholder="Brand Name" class="form-control">
                    </div>
                    <div class="mb-4">
                        <input type="file" name="brand_logo" placeholder="Brand Logo" class="form-control">
                    </div>
                    <div class="mb-4">
                     <button type="submit" class="btn btn-primary">Add Brand</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection