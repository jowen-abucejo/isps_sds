@extends('layouts.layout')

@section('content')
<div class="col-12 min-vh-100">
    <div class="col-12 col-sm-10 offset-sm-1 col-md-6 offset-md-3 bg-light rounded shadow mb-4 text-center p-5">
        <h4 class="mb-4">
            Apply for Scholarship
        </h4 >  
        @if (session('status'))
            <p class="alert-danger rounded p-1"> {{ session('status') }} </p>    
        @endif
        @if (!auth()->user()->student)
        <p class="alert-danger rounded p-1">Please <a class="alert-link" href="{{ route('student.profile') }}">Create Your Student Profile</a> First!</p>    
        @elseif ($scholarships->count() === 0)
        <p class="alert-danger rounded p-1">No Open Scholarships as of Now!</p>    
        @else
        <form action="{{ route('student.scholarships') }}" method="POST">
            @csrf
            <div class="input-group form-group mt-4 mb-0">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-ribbon"></i></span></div>
                <select name="scholarship" id="scholarship" class="form-control">
                    <option value="">** Select Scholarship **</option>
                    @foreach ($scholarships as $scholarship )
                    <option value="{{ $scholarship->id }}">{{ $scholarship->description}} {{ $scholarship->type }}</option>
                    @endforeach
                </select>
            </div>  
            @error('scholarship')
                <p class="text-danger text-left mb-0 pb-0"><small> {{ $message }} </small></p>
            @enderror

            <div class="input-group form-group mt-4 mb-0">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-pen"></i></span></div>
                <select name="year_level" id="year_level" class="form-control">
                    <option value="">** Select Your Year Level **</option>
                    <option value="1">First Year</option>
                    <option value="2">Second Year</option>
                    <option value="3">Third Year</option>
                    <option value="4">Fourth Year</option>
                </select>
            </div>  
            @error('year_level')
                <p class="text-danger text-left mb-0 pb-0"><small> {{ $message }} </small></p>
            @enderror


            <div class="input-group form-group mt-4 mb-0">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-pen"></i></span>
                </div>
                <input type="text"  name="school_year" id="school_year" placeholder="School Year (e.g. 2020-2021)" class="form-control" value="{{ old('school_year') }}">
            </div>
            @error('school_year')
                <p class="text-danger text-left mb-0 pb-0"><small> {{ $message }} </small></p>
            @enderror

            <div class="input-group form-group mt-4 mb-0">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-pen"></i></span></div>
                <select name="semester" id="semester" class="form-control">
                    <option value="">** Select Semester **</option>
                    <option value="1">First Semester</option>
                    <option value="2">Second Semester</option>
                </select>
            </div>
            @error('semester')
                <p class="text-danger text-left mb-0 pb-0"><small> {{ $message }} </small></p>
            @enderror

            <div class="input-group form-group mt-4 mb-0">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-pen"></i></span>
                </div>
                <input type="number" step="0.01" min="1.00" max="5.00" name="gpa" id="gpa" placeholder="Enter Your GPA (e.g. 1.27)" class="form-control" value="{{ old('gpa') }}">
            </div>
            @error('gpa_limit')
                <p class="text-danger text-left mb-0 pb-0"><small> {{ $message }} </small></p>
            @enderror

            <div class="input-group form-group mt-4 mb-0">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-pen"></i></span>
                </div>
                <input type="number" step="0.01" min="1.00" max="5.00" name="lowest_grade" id="lowest_grade" placeholder="Lowest Grade (e.g 2.00)" class="form-control" value="{{ old('lowest_grade') }}">
            </div>
            @error('lowest_grade')
                <p class="text-danger text-left mb-0 pb-0"><small> {{ $message }} </small></p>
            @enderror

            <button type="submit" class="btn btn-info btn-block mt-4">Next Step</button>

        </form>
        @endif  

        {{-- <form action="{{ route('su.scholarships') }}" method="POST">
            @csrf
            @if ($read_sch)
                <input type="hidden" name="toUpdate" value="{{ $read_sch->id }}">
            @endif
            <div class="input-group form-group mt-4 mb-0">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-pen"></i></span>
                </div>
                <input type="text"  name="scholarship_code" id="scholarship_code" placeholder="Scholarship Code" class="form-control" value="{{ ($read_sch)?$read_sch->scholarship_code : old('scholarship_code')}}">
            </div>
            @error('scholarship_code')
                <p class="text-danger text-left mb-0 pb-0"><small> {{ $message }} </small></p>
            @enderror

            <div class="input-group form-group mt-4 mb-0">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-pen"></i></span>
                </div>
                <input type="text"  name="description" id="description" placeholder="Scholarship Description" class="form-control" value="{{ ($read_sch)?$read_sch->description : old('description') }}">
            </div>
            @error('description')
                <p class="text-danger text-left mb-0 pb-0"><small> {{ $message }} </small></p>
            @enderror

            <div class="input-group form-group mt-4 mb-0">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-pen"></i></span>
                </div>
                <input type="text"  name="type" id="type" placeholder="Type (Optional)" class="form-control" value="{{ ($read_sch)?$read_sch->type : old('type') }}">
            </div>
            @error('type')
                <p class="text-danger text-left mb-0 pb-0"><small> {{ $message }} </small></p>
            @enderror

            <div class="input-group form-group mt-4 mb-0">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-pen"></i></span>
                </div>
                <input type="number" step="0.01" name="gpa_limit" id="gpa_limit" placeholder="Minimum GPA Required" class="form-control" value="{{ ($read_sch)?$read_sch->gpa_limit : old('gpa_limit') }}">
            </div>
            @error('gpa_limit')
                <p class="text-danger text-left mb-0 pb-0"><small> {{ $message }} </small></p>
            @enderror

            <div class="input-group form-group mt-4 mb-0">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-pen"></i></span>
                </div>
                <input type="number" step="0.01" name="lowest_grade" id="lowest_grade" placeholder="Lowest Grade Required" class="form-control" value="{{ ($read_sch)?$read_sch->lowest_grade : old('lowest_grade') }}">
            </div>
            @error('lowest_grade')
                <p class="text-danger text-left mb-0 pb-0"><small> {{ $message }} </small></p>
            @enderror

            <button type="submit" class="btn btn-info btn-block mt-4">{{ ($read_sch)? 'Update ' : 'Register'  }} Scholarship</button>
        </form> --}}
    </div>
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
            @foreach ($sch_applications =  auth()->user()->student->scholarships as $sch_application)
            <tr>
                <td>{{ $sch_application->id }}</td>
                <td>{{ $sch_application->sy }}</td>                
                <td>{{ $sch_application->scholarships->description }}</td>
                <td>{{ $sch_application->scholarships->type }}</td>
                <td>{{ $sch_application->scholarships->status }}</td>
                <td>
                <form action="{{ route('su.scholarships') }}" method="post" class="btn btn-sm">
                    @csrf
                    @method('patch')
                    <input type="hidden" name="scholarship_id" value="{{ $sch_application->id }}">
                    <input type="hidden" name="active" value="{{ ($sch_application->active == 'ACTIVE')? 'ACTIVE' : 'INACTIVE' }}">
                    <button type="submit" class="btn btn-sm {{ ($sch_application->active == 'ACTIVE')? ' btn-danger ': 'btn-success' }}">{{ ($sch_application->active == 'ACTIVE')? 'DEACTIVATE':'ACTIVATE' }}</button>
                </form>
                <a href="{{ route('su.scholarships', ['scholarship_id' => $sch_application->id]) }}" class="btn btn-sm btn-info px-4"> EDIT </a>
                </td>           
            </tr>      
            @endforeach   
            <tr>
                @if (!$sch_applications->count())
                <td colspan="6" class="text-danger">No Records Found!</td>      
                @endif
            </tr>         
        </tbody>
    </table>
</div>
@endsection