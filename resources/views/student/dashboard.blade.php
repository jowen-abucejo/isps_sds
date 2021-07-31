@extends('layouts.mainview')

@section('active_view')
<div class="col text-center">
    <h4>Profile and Scholarships Overview</h4>
</div>
@if (session('status'))
    <p class="alert-danger rounded p-1"> {{ session('status') }} </p>   
@endif
@endsection

@section('bottom_view')
<div class="row p-0 m-0">
<div class="card col-12 col-md-5 text-center p-0 mx-auto my-3">
    <div class="card-header">
        <h4>Student Profile</h4>
    </div>
    <div class="card-body">
        <h5><a href="{{ route('student.profile') }}" class="text-dark">{{ auth()->user()->student->first_name }} {{ auth()->user()->student->middle_name }} {{ auth()->user()->student->last_name }}</a></h5>
        <p><small>{{ auth()->user()->student->student_id }}</small></p>
        <p>{{ auth()->user()->student->course->course_desc }}</p>
        <p>{{ auth()->user()->student->birth_date }}</p>
        <p>{{ auth()->user()->student->address }}</p>
    </div>
    <div class="card-footer">
    </div>
</div>
<div class="card col-12 col-md-5 text-center p-0 mx-auto my-3">
    <div class="card-header">
        <h4>Previous Scholarships</h4>
    </div>
    <div class="card-body">
        @if($schs = auth()->user()->student->scholarships)
        @for($i=0; $i<$schs->where('status', 'OK')->count() || $i>4; $i++)
            <p><a class="text-dark" href="{{ route('student.scholarships', ['scholarship_id' => $schs->get($i)->id]) }}" > {{ $schs->get($i)->scholarship->description }} <br><small>SY {{ $schs->get($i)->sy }}</small> <small>{{ $schs->get($i)->sem }}</small></a></p>
        @endfor
        @else
            <p><i>Nothing to show.</i></p>
        @endif
    </div>
    <div class="card-footer">
    </div>
</div>
</div>
            
@endsection