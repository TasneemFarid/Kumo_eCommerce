@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item">
            <a href="{{ route('category') }}">Coupon</a>
        </li>
    </ol>
</div>
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3>Coupon List</h3>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <tr>
                        <th>SL</th>
                        <th>Coupon Code</th>
                        <th>Type</th>
                        <th>Discount Amount</th>
                        <th>Validity</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($coupons as $sl=>$coupon)
                        <tr>
                            <td>{{$sl+1}}</td>
                            <td>{{$coupon->coupon_code}}</td>
                            <td>{{$coupon->type == 1 ? 'Percentage' : 'Solid Amount'}}</td>
                            <td>{{$coupon->amount}}</td>
                            <td><div class="badge badge-primary">
                                {{Carbon\Carbon::now()->diffInDays($coupon->validity, false) > 0 ? Carbon\Carbon::now()->diffInDays($coupon->validity, false).' days left' : 'Expired' }}    
                            </div></td>
                            <td>
                                <a href="" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
       @can('add_coupon')
       <div class="card">
        <div class="card-header">
            <h3>Add Coupon</h3>
        </div>
        <div class="card-body">
            <form action="{{route('coupon_store')}}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Coupon Code</label>
                    <input type="text" class="form-control" name="coupon_code">
                </div>     
                <div class="mb-3">
                    <label class="form-label">Coupon Type</label>
                    <select class="form-control" name="type">
                        <option value=""> -- Select Type -- </option>
                        <option value="1">Percentage</option>
                        <option value="2">Solid Amount</option>
                    </select>
                </div>     
                <div class="mb-3">
                    <label class="form-label">Discount Amount</label>
                    <input type="number" class="form-control" name="amount">
                </div>
                <div class="mb-3">
                    <label class="form-label">Validity</label>
                    <input type="date" class="form-control" name="validity" placeholder="dd/mm/yyy">
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Add Coupon</button>
                </div>
            </form>
        </div>
    </div>
       @endcan
    </div>
</div>
@endsection