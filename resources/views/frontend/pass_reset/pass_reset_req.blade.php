@extends('frontend.master')

@section('content')
<section class="middle">
    <div class="container">
        <div class="row align-items-start justify-content-between">
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 m-auto">
                <div class="mb-3">
                    <h3>Reset Password</h3>
                </div>
                @if (session('send'))
                    <div class="alert alert-warning">{{session('send')}}</div>
                @endif
                <form class="border p-3 rounded" action="{{route('customer_pass_reset_req_send')}}" method="POST">	
                    @csrf			
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter Email">
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-md full-width bg-dark text-light fs-md ft-medium">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection