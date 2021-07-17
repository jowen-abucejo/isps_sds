@extends('layouts.layout')

@section('content')
    <div class="col-10 col-sm-8 col-md-6 col-lg-5 col-xl-4 bg-white p-5 rounded text-center shadow">
        <h4 class="mb-4">Enter Your New Password</h4 > 
        @if (session('status'))
            <p class="alert-danger rounded p-1"> {{ session('status') }} </p>    
        @endif       

        <form action="{{ route('password.update') }}" method="post" >
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            
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
            
            <button type="submit" class="btn btn-success btn-block mt-4">Reset Password</button>
        </form>
    </div> 
@endsection