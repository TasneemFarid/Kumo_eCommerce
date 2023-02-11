@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item">
            <a href="#">Product Variation</a>
        </li>
    </ol>
</div>
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3>Added Color List</h3>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <tr>
                        <th>SL</th>
                        <th>Color Name</th>
                        <th>Color Code</th>
                        <th>Color Preview</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($colors as $key=>$color)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$color->color_name}}</td>
                            <td>{{$color->color_code==NULL?'NA':$color->color_code}}</td>
                            <td>
                                <div style="width:40px; height:40px; border-radius:50%; background:{{$color->color_code}}">
                                    {{$color->color_code==NULL?'NA':''}}
                                </div>
                            </td>
                            <td>
                                <button class="btn btn-danger">Delete</button>
                             </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3>Add Color</h3>
            </div>
            <div class="card-body">
                @if (session('color_success'))
                <div class="alert alert-success">{{session('color_success')}}</div>
                @endif
                <form action="{{route('add_color')}}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <input type="text" name="color_name" placeholder="Color Name" class="form-control">
                    </div>
                    <div class="mb-4">
                        <input type="text" name="color_code" placeholder="Color Code" class="form-control">
                    </div>
                    <div class="mb-4">
                     <button type="submit" class="btn btn-primary">Add Color</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3>Added Size List</h3>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <tr>
                        <th>SL</th>
                        <th>Size Name</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($sizes as $key=>$size)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$size->size_name}}</td>
                            <td>
                               <button class="btn btn-danger">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3>Add Size</h3>
            </div>
            <div class="card-body">
                @if (session('size_success'))
                <div class="alert alert-success">{{session('size_success')}}</div>
                @endif
                <form action="{{route('add_size')}}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <input type="text" name="size_name" placeholder="Size Name" class="form-control">
                    </div>
                    <div class="mb-4">
                     <button type="submit" class="btn btn-primary">Add Size</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection