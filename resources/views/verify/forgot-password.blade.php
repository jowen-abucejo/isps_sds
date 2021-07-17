@extends('layouts.layout')

@section('content')
    <div class="col-10 col-sm-8 col-md-6 col-lg-5 col-xl-4 bg-white text-center p-5 rounded shadow">
        <h4 class="mb-4">Reset Password</h4 > 
        @if (session('status'))
            <p class="alert-danger rounded p-1"> 
                {{ session('status') }}
            </p>    
        @endif       
        <form action="{{ route('password.email') }}" method="post" >
            @csrf
            <div class="input-group form-group mt-4 mb-0">
                   <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                </div>
                <input type="email" name="email" id="email" placeholder="Enter Your Email" class="form-control">
            </div>
            @error('email')
                <p class="text-danger text-left mb-0 pb-0"><small> {{ $message }} </small></p>
            @enderror
            
            <button type="submit" class="btn btn-success btn-block mt-4">Reset Password</button>         
        </form>
    </div> 
@endsection