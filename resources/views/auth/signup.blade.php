@extends('layouts.layout')

@section('content')
    <div class="col-10 col-sm-8 col-md-6 col-lg-5 col-xl-4 bg-white p-5 rounded text-center shadow">
        <h4 class="mb-4">Sign up</h4 > 
        @if (session('status'))
            <p class="alert-danger rounded p-1"> {{ session('status') }} </p>    
        @endif       
       
        <div class="form-group mb-4">
            <a href="{{ route('auth.google') }}" class="btn btn-danger fab fa-google"> Sign up with Google</a>
        </div>
        <p><b>OR</b></p>
        <form action="{{ route('auth.signup') }}" method="post" >
            @csrf
            <div class="input-group form-group mt-4 mb-0">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                </div>
                <input type="text" pattern="[a-zA-Z Ññ]+" name="name" id="name" placeholder="Name" class="form-control">
            </div>
            @error('name')
                <p class="text-danger text-left mb-0 pb-0"><small> {{ $message }} </small></p>
            @enderror
            
            <div class="input-group form-group mt-4 mb-0">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                </div>
                <input type="email" name="email" id="email" placeholder="Email" class="form-control">
            </div>
            @error('email')
                <p class="text-danger text-left mb-0 pb-0"><small> {{ $message }} </small></p>
            @enderror
            
            <div class="input-group form-group mt-4 mb-0">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                </div>
                <input type="password" name="password" id="password" placeholder="Password" class="form-control">
            </div>
            @error('password')
                <p class="text-danger text-left mb-0 pb-0"><small> {{ $message }} </small></p>
            @enderror
            
            <div class="input-group form-group mt-4 mb-0">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                </div>
                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" class="form-control">
            </div>
            @error('password')
                <p class="text-danger text-left mb-0 pb-0"><small> {{ $message }} </small></p>
            @enderror
            
            <button type="submit" class="btn btn-success btn-block mt-4">Sign up</button>
        </form>
    </div> 
@endsection