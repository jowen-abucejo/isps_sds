@extends('layouts.layout')

@section('content')
    <div class="col-10 col-sm-8 col-md-6 col-xl-5 bg-white p-5 rounded text-center shadow">
        <h4 class="mb-4">Create Your Student Profile</h4 > 
        @if (session('status'))
            <p class="alert-danger rounded p-1"> {{ session('status') }} </p>    
        @endif       

        <form action="{{ route('student.profile') }}" method="post" >
            @csrf
            <div class="input-group form-group mt-4 mb-0">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user-graduate"></i></span>
                </div>
                <input type="text" pattern="[0-9]+" name="student_id" id="student_id" placeholder="Student ID" class="form-control">
            </div>
            @error('student_id')
                <p class="text-danger text-left mb-0 pb-0"><small> {{ $message }} </small></p>
            @enderror

            <div class="input-group form-group mt-4 mb-0">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-award"></i></span>
                </div>
                <input type="course" name="course" id="course" placeholder="Course Taken" class="form-control">
            </div>
            @error('course')
                <p class="text-danger text-left mb-0 pb-0"><small> {{ $message }} </small></p>
            @enderror

            <div class="input-group form-group mt-4 mb-0">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-pen"></i></span>
                </div>
                <input type="text" pattern="[a-zA-Z Ññ]" name="first_name" id="first_name" placeholder="First Name" class="form-control" value="{{ auth()->user()->name }}">
            </div>
            @error('first_name')
                <p class="text-danger text-left mb-0 pb-0"><small> {{ $message }} </small></p>
            @enderror

            <div class="input-group form-group mt-4 mb-0">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-pen"></i></span>
                </div>
                <input type="text" pattern="[a-zA-Z Ññ]" name="middle_name" id="middle_name" placeholder="Middle Name" class="form-control">
            </div>
            @error('middle_name')
                <p class="text-danger text-left mb-0 pb-0"><small> {{ $message }} </small></p>
            @enderror

            <div class="input-group form-group mt-4 mb-0">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-pen"></i></span>
                </div>
                <input type="text" pattern="[a-zA-Z Ññ]" name="last_name" id="last_name" placeholder="Last Name" class="form-control">
            </div>
            @error('last_name')
                <p class="text-danger text-left mb-0 pb-0"><small> {{ $message }} </small></p>
            @enderror
            
            <div class="input-group form-group mt-4 mb-0">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-genderless"></i></span></div>
                <select name="gender" id="gender" class="form-control">
                    <option value="">** Select Gender **</option>
                    <option value="MALE">MALE</option>
                    <option value="FEMALE">FEMALE</option>                    
                </select>
            </div>
            @error('gender')
                <p class="text-danger text-left mb-0 pb-0"><small> {{ $message }} </small></p>
            @enderror

            <div class="input-group form-group mt-4 mb-0">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-calendar"></i></span></div>
                <input type="date" name="birth_date" id="birth_date" class="form-control">
            </div>
            @error('birth_date')
                <p class="text-danger text-left mb-0 pb-0"><small> {{ $message }} </small></p>
            @enderror

            <div class="input-group form-group mt-4 mb-0">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                </div>
                <input type="email" name="email" id="email" placeholder="Email" class="form-control" @auth value="{{ auth()->user()->email }}" readonly @endauth>
            </div>
            @error('email')
                <p class="text-danger text-left mb-0 pb-0"><small> {{ $message }} </small></p>
            @enderror          

            <div class="input-group form-group mt-4 mb-0">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                </div>
                <input type="text" pattern="[0-9]{11}" name="contact_number" id="contact_number" placeholder="Mobile Number" class="form-control">
            </div>
            @error('contact_number')
                <p class="text-danger text-left mb-0 pb-0"><small> {{ $message }} </small></p>
            @enderror

            <div class="input-group form-group mt-4 mb-0">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-home"></i></span>
                </div>
                <input type="password" name="address" id="address" placeholder="Address" class="form-control">
            </div>
            @error('address')
                <p class="text-danger text-left mb-0 pb-0"><small> {{ $message }} </small></p>
            @enderror
            
            <button type="submit" class="btn btn-success btn-block mt-4">
            @if (auth()->user()->student)
                Update Student Profile
            @else
                Create Student Profile
            @endif
            </button>
        </form>
    </div> 
@endsection