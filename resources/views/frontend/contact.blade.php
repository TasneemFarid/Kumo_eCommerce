@extends('frontend.master')

@section('content')
<!-- ======================= Top Breadcrubms ======================== -->
<div class="gray py-3">
    <div class="container">
        <div class="row">
            <div class="colxl-12 col-lg-12 col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route("index")}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Pages</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- ======================= Top Breadcrubms ======================== -->

<!-- ======================= Contact Page Detail ======================== -->
<section class="middle">
    <div class="container">
    
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="sec_title position-relative text-center">
                    <h2 class="off_title">Contact Us</h2>
                    <h3 class="ft-bold pt-3">Get In Touch</h3>
                </div>
            </div>
        </div>
        
        <div class="row align-items-start justify-content-between">
        
            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
                <div class="card-wrap-body mb-4">
                    <h4 class="ft-medium mb-3 theme-cl">Visit Us</h4>
                    <p>{{$contacts->address}}</p>
                </div>
                
                <div class="card-wrap-body mb-3">
                    <h4 class="ft-medium mb-3 theme-cl">Make a Call</h4>
                    <h6 class="ft-medium mb-1">Customer Care:</h6>
                    <p class="mb-2">+880{{$contacts->customer_care}}</p>
                    <h6 class="ft-medium mb-1">Careers::</h6>
                    <p>+880{{$contacts->career}}</p>
                </div>
                
                <div class="card-wrap-body mb-3">
                    <h4 class="ft-medium mb-3 theme-cl">Drop A Mail</h4>
                    <p>Fill out our form and we will contact you within 24 hours.</p>
                    {{-- <p class="lh-1 text-dark">{{$contacts->email}}</p> --}}
                </div>
            </div>
            
            <div class="col-xl-7 col-lg-8 col-md-12 col-sm-12">
                @if (session('send'))
                    <div class="alert alert-success">{{session('send')}}</div>
                @endif
                <form class="row" action="{{route('get_in_touch')}}" method="POST">
                @csrf
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group">
                            <label class="small text-dark ft-medium">Your Name *</label>
                            <input type="text" name="name" class="form-control" placeholder="Your Name">
                            @error('name')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group">
                            <label class="small text-dark ft-medium">Your Email *</label>
                            <input type="email" name="email" class="form-control" placeholder="Your Email">
                            @error('email')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group">
                            <label class="small text-dark ft-medium">Subject</label>
                            <input type="text" name="subject" class="form-control" placeholder="Type Your Subject">
                            @error('subject')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group">
                            <label class="small text-dark ft-medium">Message</label>
                            <textarea name="message" class="form-control ht-80" placeholder="Type Your Message"></textarea>
                            @error('message')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-dark">Send Message</button>
                        </div>
                    </div>
                    
                </form>
            </div>
            
        </div>
    </div>
</section>
<!-- ======================= Contact Page End ======================== -->
@endsection