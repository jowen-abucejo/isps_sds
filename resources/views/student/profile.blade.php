@extends('layouts.mainview')

@section('active_view')
<h4 class="mb-4">
    @auth
    @if (!auth()->user()->student)
        Create Your
    @endif  
    Student Profile      
    @endauth
</h4 > 
@if (session('status'))
    <p class="alert-danger rounded p-1"> {{ session('status') }} </p>    
@endif       

<form action="{{ route('student.profile') }}" method="post" >
    @csrf
    <div class="input-group form-group mt-4 mb-0">
        <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-user-graduate"></i></span>
        </div>
        <input type="text" pattern="[0-9]+" name="student_id" id="student_id" placeholder="Student ID" class="form-control" value="{{ (auth()->user()->student)? auth()->user()->student->student_id: old('first_name') }}">
    </div>
    @error('student_id')
        <p class="text-danger text-left mb-0 pb-0"><small> {{ $message }} </small></p>
    @enderror

    <div class="input-group form-group mt-4 mb-0">
        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-award"></i></span></div>
        <select name="course" id="course" class="form-control">
            <option value="">** Select Program/Course **</option>
            @foreach ($courses as $course )
                <option value="{{ $course->id }}" @php if(auth()->user()->student) echo (auth()->user()->student->course_id == $course->id)? "selected" : "" @endphp>{{ $course->course_code }} @if($course->major) - Major in {{ $course->major }} @endif</option>
            @endforeach
        </select>
    </div>  
        @error('course')
            <p class="text-danger text-left mb-0 pb-0"><small> {{ $message }} </small></p>
        @enderror
    
    <div class="input-group form-group mt-4 mb-0">
        <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-pen"></i></span>
        </div>
        <input type="text" pattern="[a-zA-Z Ññ]+" name="first_name" id="first_name" placeholder="First Name" class="form-control" value="{{ (auth()->user()->student)? auth()->user()->student->first_name : old('first_name') }}">
    </div>
    @error('first_name')
        <p class="text-danger text-left mb-0 pb-0"><small> {{ $message }} </small></p>
    @enderror

    <div class="input-group form-group mt-4 mb-0">
        <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-pen"></i></span>
        </div>
        <input type="text" pattern="[a-zA-Z Ññ]+" name="middle_name" id="middle_name" placeholder="Middle Name" class="form-control" value="{{(auth()->user()->student)? auth()->user()->student->middle_name : old('middle_name') }}">
    </div>
    @error('middle_name')
        <p class="text-danger text-left mb-0 pb-0"><small> {{ $message }} </small></p>
    @enderror

    <div class="input-group form-group mt-4 mb-0">
        <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-pen"></i></span>
        </div>
        <input type="text" pattern="[a-zA-Z Ññ]+" name="last_name" id="last_name" placeholder="Last Name" class="form-control" value="{{ (auth()->user()->student)? auth()->user()->student->last_name : old('last_name') }}">
    </div>
    @error('last_name')
        <p class="text-danger text-left mb-0 pb-0"><small> {{ $message }} </small></p>
    @enderror
    
    <div class="input-group form-group mt-4 mb-0">
        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-genderless"></i></span></div>
        <select name="gender" id="gender" class="form-control">
            <option value="">** Select Gender **</option>
            <option value="MALE" @php if(auth()->user()->student) echo (auth()->user()->student->gender == "MALE")? "selected" : "" @endphp>MALE</option>
            <option value="FEMALE" @php if(auth()->user()->student) echo (auth()->user()->student->gender == "FEMALE")? "selected" : "" @endphp>FEMALE</option>                    
        </select>
    </div>
    @error('gender')
        <p class="text-danger text-left mb-0 pb-0"><small> {{ $message }} </small></p>
    @enderror

    <div class="input-group form-group mt-4 mb-0">
        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-calendar"></i></span></div>
        <input type="date" name="birth_date" id="birth_date" class="form-control" value="{{ (auth()->user()->student)? auth()->user()->student->birth_date : old('birth_date') }}">
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
        <input type="text" pattern="[0-9]{11}" name="mobile" id="mobile" placeholder="11-digit Mobile Number" class="form-control" value="{{ (auth()->user()->student)? auth()->user()->student->mobile : old('mobile') }}">
    </div>
    @error('mobile')
        <p class="text-danger text-left mb-0 pb-0"><small> {{ $message }} </small></p>
    @enderror

    <div class="input-group form-group mt-4 mb-0">
        <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-home"></i></span>
        </div>
        <input type="text" name="address" id="address" placeholder="Address" class="form-control" value="{{ (auth()->user()->student)? auth()->user()->student->address : old('address') }}">
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
@endsection