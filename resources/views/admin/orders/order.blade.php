@extends('layouts.dashboard');

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item">
            <a href="{{ route('orders') }}">Orders</a>
        </li>
    </ol>
</div>

<div class="row">
    <div class="col-lg-12">
        @can('show_orders')
        <div class="card">
            <div class="card-header">
                <h3>Order List</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>SL</th>
                        <th>Order Date</th>
                        <th>Order ID</th>
                        <th>Sub Total</th>
                        <th>Discount</th>
                        <th>Charge</th>
                        <th>Total</th>
                        <th>Payment Method</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($orders as $sl=>$order)
                    <tr>
                        <td>{{$sl+1}}</td>
                        <td>{{$order->created_at->format('d-M-Y')}}</td>
                        <td>{{$order->order_id}}</td>
                        <td>{{$order->subtotal}}</td>
                        <td>{{$order->discount}}</td>
                        <td>{{$order->charge}}</td>
                        <td>{{$order->total}}</td>
                        <td>
                            @php
                                if($order->payment_method == 1){
                                    echo "Cash on Delivery";
                                }
                                else if($order->payment_method == 2){
                                    echo "SSL Commerz";
                                }
                                else{
                                    echo "Stripe";
                                }
                            @endphp
                        </td>
                        <td>
                            <span class="badge badge-{{$order->status==4?'success':'primary'}}">
                                @php
                                if($order->status == 0){
                                    echo "Placed";
                                }
                                else if($order->status == 1){
                                    echo "Packaging";
                                }
                                else if($order->status == 2){
                                    echo "Shipped";
                                }
                                else if($order->status == 3){
                                    echo "Out for Delivery";
                                }
                                else{
                                    echo "Delivered";
                                }
                            @endphp
                            </span>
                        </td>
                        <td>
                            <form action="{{route('order_status')}}" method="POST">
                                @csrf
                                <div class="dropdown">
                                    <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                        <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg>
                                    </button>
                                    <div class="dropdown-menu">
                                        <button type="submit" name="status" value="{{$order->order_id.','.'0'}}" class="dropdown-item">Placed</button>
                                        <button type="submit" name="status" value="{{$order->order_id.','.'1'}}" class="dropdown-item">Packaging</button>
                                        <button type="submit" name="status" value="{{$order->order_id.','.'2'}}" class="dropdown-item">Shipped</button>
                                        <button type="submit" name="status" value="{{$order->order_id.','.'3'}}" class="dropdown-item">Out for Delivery</button>
                                        <button type="submit" name="status" value="{{$order->order_id.','.'4'}}" class="dropdown-item">Delivered</button>
                                    </div>
                                </div>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
        @endcan
    </div>
</div>
@endsection