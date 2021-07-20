@extends('layouts.layout')

@section('content')
<div class="col-12 min-vh-100">
    <div class="col-12 col-sm-10 offset-sm-1 col-md-6 offset-md-3 bg-secondary rounded shadow mb-4 text-center py-5">
        <h4 class="mb-4">
            {{ ($read_course)? 'Update ' : 'Register New '  }} Course
        </h4 > 
        @if (session('status'))
            <p class="alert-danger rounded p-1"> {{ session('status') }} </p>    
        @endif  
    </div>
    <table class="table table-bordered table-hover text-center table-sm table-striped">
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
                <td>{{ $course->status }}</td>
                <td>
                <form action="{{ route('su.courses') }}" method="post" class="btn btn-sm">
                    @csrf
                    @method('patch')
                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                    <input type="hidden" name="active" value="{{ ($course->status == 'ACTIVE')? 'ACTIVE' : 'INACTIVE' }}">
                    <button type="submit" class="btn btn-sm {{ ($course->status == 'ACTIVE')? ' btn-danger ': 'btn-success' }}">{{ ($course->status == 'ACTIVE')? 'DEACTIVATE':'ACTIVATE' }}</button>
                </form>
                <a href="{{ route('su.courses', ['course_id' => $course->id]) }}" class="btn btn-sm btn-info px-4"> EDIT </a>
                </td>          
            </tr>      
            @endforeach            
        </tbody>
    </table>
</div>


@endsection