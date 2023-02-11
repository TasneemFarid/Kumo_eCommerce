@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="">Contact Info</a></li>
    </ol>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3>Update Contact</h3>
            </div>
            <div class="card-body">
                <form action="{{route('contact_update')}}" method="POST">
                    @csrf
                <div class="row">
                    <div class="form-group col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                        </div>
                        <div class="mb-3">
                            <input type="email" name="email" class="form-control" value="{{$contacts->email}}">
                            <input type="hidden" name="id" value="1" class="form-control">
                        </div>
                    </div>
                    <div class="form-group col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="address" class="form-control" value="{{$contacts->address}}">
                        </div>
                    </div>
                    <div class="form-group col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Customer Care Number</label>
                        </div>
                        <div class="mb-3">
                            <input type="number" name="customer_care" class="form-control" value="{{$contacts->customer_care}}">
                        </div>
                    </div>
                    <div class="form-group col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Career Number</label>
                        </div>
                        <div class="mb-3">
                            <input type="number" name="career" class="form-control" value="{{$contacts->career}}">
                        </div>
                    </div>
                    <div class="form-group col-lg-6">
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection