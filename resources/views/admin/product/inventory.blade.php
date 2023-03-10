@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item">
            <a href="{{ route('product_list') }}">Product List</a>
        </li>
    </ol>
</div>
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3>Inventory of -> {{$product->product_name}}</h3>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <tr>
                        <th>SL</th>
                        <th>Color</th>
                        <th>Size</th>
                        <th>Quantity</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($inventories as $key=>$inventory)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$inventory->rel_to_color->color_name}}</td>
                            <td>{{$inventory->rel_to_size->size_name}}</td>
                            <td>{{$inventory->quantity}}</td>
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
                <h3>Add Inventory</h3>
            </div>
            <div class="card-body">
                <form action="{{route('inventory_store')}}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <input type="hidden" name="product_id" class="form-control" value="{{$product->id}}">
                        <input type="text" readonly class="form-control" value="{{$product->product_name}}">
                    </div>
                    <div class="mb-4">
                        <select name="color_id" class="form-control">
                            <option value="">--Select Color--</option>
                            @foreach ($colors as $color)
                                <option value="{{$color->id}}">{{$color->color_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <select name="size_id" class="form-control">
                            <option value="">--Select Size--</option>
                            @foreach ($sizes as $size)
                                <option value="{{$size->id}}">{{$size->size_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <input type="number" name="quantity" placeholder="Quantity" class="form-control">
                    </div>
                    <div class="mb-4">
                        <button type="submit" class="btn btn-primary">Add inventory</button>
                       </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection