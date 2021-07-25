@extends('layouts.mainview')

@section('active_view')
        <h4 class="mb-4">
            {{ ($read_course)? 'Update ' : 'Register New '  }} Course
        </h4 > 
        @if (session('status'))
            <p class="alert-danger rounded p-1"> {{ session('status') }} </p>    
        @endif  

        <form action="{{ route('su.courses') }}" method="POST">
            @csrf
            @if ($read_course)
                <input type="hidden" name="toUpdate" value="{{ $read_course->id }}">
            @endif
            <div class="input-group form-group mt-4 mb-0">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-pen"></i></span>
                </div>
                <input type="text"  name="course_code" id="course_code" placeholder="Course Code" class="form-control" value="{{ ($read_course)?$read_course->course_code : old('course_code')}}">
            </div>
            @error('course_code')
                <p class="text-danger text-left mb-0 pb-0"><small> {{ $message }} </small></p>
            @enderror

            <div class="input-group form-group mt-4 mb-0">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-pen"></i></span>
                </div>
                <input type="text"  name="course_desc" id="course_desc" placeholder="Course Description" class="form-control" value="{{ ($read_course)?$read_course->course_desc : old('course_desc') }}">
            </div>
            @error('course_desc')
                <p class="text-danger text-left mb-0 pb-0"><small> {{ $message }} </small></p>
            @enderror

            <div class="input-group form-group mt-4 mb-0">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-pen"></i></span>
                </div>
                <input type="text"  name="major" id="major" placeholder="Major" class="form-control" value="{{ ($read_course)?$read_course->major : old('major') }}">
            </div>
            @error('major')
                <p class="text-danger text-left mb-0 pb-0"><small> {{ $message }} </small></p>
            @enderror

            <button type="submit" class="btn btn-block mt-4 {{ ($read_course)? 'btn-success' : 'btn-info' }}">{{ ($read_course)? 'Update ' : 'Register'  }} Course</button>
            @if ($read_course)
                <a href="{{ route('su.courses') }}" class="btn btn-block btn-info mt-4">Cancel Edit</a>
            @endif
        </form>
@endsection
@section('bottom_view')
    <table class="table table-bordered table-hover text-center table-sm table-striped table-light">
        <thead>
            <tr>
                <th>Course Code</th> 
                <th>Course Description</th> 
                <th>Major</th> 
                <th>Status</th>
                <th>Action</th> 
            </tr>
        </thead>
        <tbody>
            @foreach ($courses as $course)
            <tr>
                <td>{{ $course->course_code }}</td>
                <td>{{ $course->course_desc }}</td>
                <td>{{ $course->major }}</td>
                <td>{{ $course->active }}</td>
                <td>
                <form action="{{ route('su.courses') }}" method="post" class="btn btn-sm">
                    @csrf
                    @method('patch')
                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                    <input type="hidden" name="active" value="{{ ($course->active == 'ACTIVE')? 'ACTIVE' : 'INACTIVE' }}">
                    <button type="submit" class="btn btn-sm {{ ($course->active == 'ACTIVE')? ' btn-danger ': 'btn-success' }}">{{ ($course->active == 'ACTIVE')? 'DEACTIVATE':'ACTIVATE' }}</button>
                </form>
                <a href="{{ route('su.courses', ['course_id' => $course->id]) }}" class="btn btn-sm btn-info px-4"> EDIT </a>
                </td>          
            </tr>      
            @endforeach    
            <tr>
                <td colspan="5">
                    @if (!$courses->count())
                      <p class="d-block alert-warning">No Records Found</p>  
                    @endif
                </td>
            </tr>        
        </tbody>
    </table>
@endsection