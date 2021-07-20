@extends('layouts.layout')

@section('content')
<div class="col-10 col-sm-8 col-md-6 col-lg-5 col-xl-4">
    <div class="bg-white text-center p-5 rounded shadow mb-4">
        <h4 class="mb-4">Sign in</h4 > 
        @if (session('status'))
            <p class="alert-danger rounded p-1"> 
                {{ session('status') }}
            </p>    
        @endif       
        <div class="form-group mb-4">
            <a href="{{ route('auth.google') }}" class="btn btn-danger fab fa-google"> Sign in with Google</a>
        </div>
        <p><b>OR</b></p>
        <form action="{{ route('auth.signin') }}" method="post" >
            @csrf
            
            <div class="input-group form-group mt-4 mb-0">
                   <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                </div>
                <input type="email" name="email" id="email" placeholder="Use Email" class="form-control">
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
            
            <button type="submit" class="btn btn-success btn-block mt-4">Sign in</button>

            <div class="form-group mt-2">
                <input type="checkbox" name="remember" id="remember" class="form-check-input">
                <label for="remember" class="form-check-label"> Remember Me </label>
            </div>
        </form>

        <a href="{{ route('password.request') }}" class="btn btn-link btn-sm mt-2 mb-0 ">Forgot Password</a>
    </div> 
</div>
@endsection