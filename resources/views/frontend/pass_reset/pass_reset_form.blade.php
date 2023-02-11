@extends('frontend.master')

@section('content')
<section class="middle">
    <div class="container">
        <div class="row align-items-start justify-content-between">
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 m-auto">
                <div class="mb-3">
                    <h3>Reset Password Form</h3>
                </div>
                <form class="border p-3 rounded" action="{{route('pass_reset')}}" method="POST">	
                    @csrf			
                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter New Password">
                        <input type="hidden" name="token" value="{{$token}}">
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Enter New Password">
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-md full-width bg-dark text-light fs-md ft-medium">Reset Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection