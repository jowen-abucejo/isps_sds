@extends('auth.profile')

@section('verify-email')
    <div class="vw-100 vh-100 transparent-div fixed-top d-flex justify-content-center align-items-center">
        <div class="card card-body border border-danger shadow text-center col-11 col-sm-8 p-3 alert-danger">
            <p class="h4"> <span class="text-center fas fa-exclamation-circle"> Verify Account to Proceed!</span> </p>
            <p> Check your email for verification link. </p>
            @if (session('message'))
                <p class="h6"> {{ session('message') }} </p>
            @endif
            <form action="{{ route('verification.send') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-success">Resend Email Verification</button>
            </form>
        </div>
    </div>
@endsection