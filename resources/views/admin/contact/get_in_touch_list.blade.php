@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item">
            <a href="{{ route('role') }}">Role</a>
        </li>
    </ol>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3>Messages</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Sl</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($messages as $sl=>$message)
                        <tr>
                            <th>{{$sl+1}}</th>
                            <th>{{$message->name}}</th>
                            <th>{{$message->email}}</th>
                            <th>{{$message->subject}}</th>
                            <th>{{$message->message}}</th>
                            <th><a class="btn btn-danger" href="{{route('inbox_delete', $message->id)}}">Delete</a></th>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endsection