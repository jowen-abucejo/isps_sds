@extends('layouts.mainview')
@php
    $is_editable = 1;
@endphp
@section('active_view')
    <h4 class="mb-4">
        @if($read_sch) {{ ($is_editable = $read_sch->status === 'REQUIREMENTS FOR UPLOAD')? 'Update Scholarship Application' : 'Scholarship Application Details' }}@else Apply for Scholarship @endif
    </h4 >  
    @if (session('status'))
        <p class="alert-danger rounded p-1"> {{ session('status') }} </p>    
    @endif
    @if (!auth()->user()->student)
    <p class="alert-danger rounded p-1">Please <a class="alert-link" href="{{ route('student.profile') }}">Create Your Student Profile</a> First!</p>    
    @elseif ($scholarships->count() === 0)
    <p class="alert-danger rounded p-1">No Open Scholarships as of Now!</p>   
    @else 
    @if($read_sch) 
        @if(!$is_editable)
        <div class="px-0 mx-0" > 
        @else 
        <form action="{{ route('student.scholarships') }}" method="POST">
        <input type="hidden" name="toUpdate" value="{{ $read_sch->id }}">
        @endif
    @else
    <form action="{{ route('student.scholarships') }}" method="POST">
    @endif    
    @csrf
        <div class="input-group form-group mt-4 mb-0">
            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-ribbon"></i></span></div>
            <select name="scholarship_id" id="scholarship_id" class="form-control" {{ (!$is_editable)? 'disabled' : '' }}>
                <option value="">** Select Scholarship **</option>
                @foreach ($scholarships as $scholarship )
                <option value="{{ $scholarship->id }}" @if($read_sch) {{ ($read_sch->scholarship_id === $scholarship->id)? 'selected' : '' }}  @endif>{{ $scholarship->description}} {{ $scholarship->type }}</option>
                @endforeach
            </select>
        </div>  
        @error('scholarship_id')
            <p class="text-danger text-left mb-0 pb-0"><small> {{ $message }} </small></p>
        @enderror

        <div class="input-group form-group mt-4 mb-0">
            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-pen"></i></span></div>
            <select name="year_level" id="year_level" class="form-control" {{ (!$is_editable)? 'disabled' : '' }}>
                <option value="">** Select Your Year Level **</option>
                <option value="1" @if($read_sch) {{ ($read_sch->year_level === 1)? 'selected' : '' }}  @endif>First Year</option>
                <option value="2" @if($read_sch) {{ ($read_sch->year_level === 2)? 'selected' : '' }}  @endif>Second Year</option>
                <option value="3" @if($read_sch) {{ ($read_sch->year_level === 3)? 'selected' : '' }}  @endif>Third Year</option>
                <option value="4" @if($read_sch) {{ ($read_sch->year_level === 4)? 'selected' : '' }}  @endif>Fourth Year</option>
            </select>
        </div>  
        @error('year_level')
            <p class="text-danger text-left mb-0 pb-0"><small> {{ $message }} </small></p>
        @enderror


        <div class="input-group form-group mt-4 mb-0">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-pen"></i></span>
            </div>
            <input type="text"  name="school_year" id="school_year" placeholder="School Year (e.g. 2020-2021)" class="form-control" value="{{ ($read_sch)? ($read_sch->sy) : old('school_year') }}" {{ (!$is_editable)? 'disabled' : '' }}>
        </div>
        @error('school_year')
            <p class="text-danger text-left mb-0 pb-0"><small> {{ $message }} </small></p>
        @enderror

        <div class="input-group form-group mt-4 mb-0">
            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-pen"></i></span></div>
            <select name="semester" id="semester" class="form-control" {{ (!$is_editable)? 'disabled' : '' }}>
                <option value="">** Select Semester **</option>
                <option value="1" @if($read_sch) {{ ($read_sch->sem === 1)? 'selected' : '' }} @endif>First Semester</option>
                <option value="2" @if($read_sch) {{ ($read_sch->sem === 2)? 'selected' : '' }} @endif>Second Semester</option>
            </select>
        </div>
        @error('semester')
            <p class="text-danger text-left mb-0 pb-0"><small> {{ $message }} </small></p>
        @enderror

        <div class="input-group form-group mt-4 mb-0">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-pen"></i></span>
            </div>
            <input type="number" step="0.01" min="1.00" max="5.00" name="gpa" id="gpa" placeholder="Enter Your GPA (e.g. 1.27)" class="form-control" @if($read_sch) value="{{$read_sch->gpa}}" @else  value="{{ old('gpa') }}" @endif {{ (!$is_editable)? 'disabled' : '' }}>
        </div>
        @error('gpa')
            <p class="text-danger text-left mb-0 pb-0"><small> {{ $message }} </small></p>
        @enderror

        <div class="input-group form-group mt-4 mb-0">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-pen"></i></span>
            </div>
            <input type="number" step="0.01" min="1.00" max="5.00" name="lowest_grade" id="lowest_grade" placeholder="Lowest Subject Grade (e.g 2.00)" class="form-control" @if($read_sch) value="{{$read_sch->lowest_grade}}" @else  value="{{ old('lowest_grade') }}" @endif {{ (!$is_editable)? 'disabled' : '' }}>
        </div>
        @error('lowest_grade')
            <p class="text-danger text-left mb-0 pb-0"><small> {{ $message }} </small></p>
        @enderror

        <div class="input-group form-group mt-4 @error('num_of_units') mb-0 @else mb-4 @endif">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-pen"></i></span>
            </div>
            <input type="number" step="1" min="0" name="num_of_units" id="num_of_units" placeholder="Number of Units" class="form-control" @if($read_sch) value="{{$read_sch->num_of_units}}" @else  value="{{ old('num_of_units') }}" @endif {{ (!$is_editable)? 'disabled' : '' }}>
        </div>
        @error('num_of_units')
            <p class="text-danger text-left mb-0 pb-4"><small> {{ $message }} </small></p>
        @enderror

        <div class="form-group form-check-inline">
            <input name="has_inc" type="checkbox" class="form-check-input" id="has_inc" @if($read_sch) {{ ($read_sch->has_inc)? 'checked': '' }} @else {{ (old('has_inc'))? 'checked' : '' }} @endif {{ (!$is_editable)? 'disabled' : '' }}>
            <label class="form-check-label" for="has_inc">I have INC grade</label>
        </div>
        @error('has_inc')
            <p class="text-danger text-left mb-0 pb-0"><small> {{ $message }} </small></p>
        @enderror
        <div class="form-group form-check-inline">
            <input name="has_drop" type="checkbox" class="form-check-input" id="has_drop" @if($read_sch) {{ ($read_sch->has_drop)? 'checked': '' }} @else {{ (old('has_drop'))? 'checked' : '' }} @endif {{ (!$is_editable)? 'disabled' : '' }}>
            <label class="form-check-label" for="has_drop">I have DROP grade</label>
        </div>
        @error('has_drop')
            <p class="text-danger text-left mb-0 pb-0"><small> {{ $message }} </small></p>
        @enderror
        @if($read_sch) 
            @if($is_editable)
            <button type="submit" class="btn btn-success btn-block mt-4">Update</button> 
            @endif
            <a href="{{ route('student.requirements', ['sch_id' => $read_sch->id]) }}" class="btn btn-info btn-block mt-4">Next</a>  
            <a href="{{ route('student.scholarships') }}" class="btn btn-danger btn-block mt-4">{{ ($is_editable)? 'Cancel Edit' : 'Close' }}</a>  
        @else 
        <button type="submit" class="btn btn-info btn-block mt-4">Next Step</button>
        @endif
    @if($read_sch) 
        @if($read_sch->status != 'REQUIREMENTS FOR UPLOAD')
        </div>
        @else
        </form>
        @endif
    @else    
    </form>
    @endif
    @endif  
@endsection

@section('bottom_view')
    <table class="table table-bordered table-hover text-center table-sm table-striped table-light">
        <thead>
            <tr>
                <th>#</th> 
                <th>SY-Semester</th>
                <th>Scholarship</th> 
                <th>Type</th> 
                <th>Status</th> 
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if (auth()->user()->student)
            @foreach ($sch_applications =  auth()->user()->student->scholarships as $sch_application)
            <tr>
                <td>{{ $sch_application->id }}</td>
                <td>{{ $sch_application->sy }} - {{ $sch_application->sem }}</td>                
                <td>{{ $sch_application->scholarship->description }}</td>
                <td>{{ $sch_application->scholarship->type }}</td>
                <td>{{ $sch_application->status }}</td>
                <td>
                <a href="{{ route('student.scholarships', ['scholarship_id' => $sch_application->id]) }}" class="btn btn-sm px-4 @if($sch_application->status === 'REQUIREMENTS FOR UPLOAD') btn-info">EDIT @else btn-success">READ @endif</a>
                </td>           
            </tr>      
            @endforeach   
            <tr>
                @if (!$sch_applications->count())
                <td colspan="6" class="text-danger">No Records Found!</td>      
                @endif
            </tr>   
            @endif         
        </tbody>
    </table>
@endsection