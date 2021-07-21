@extends('layouts.layout')

@section('content')
<div class="col-12 min-vh-100">
    <div class="col-12 col-sm-10 offset-sm-1 col-md-6 offset-md-3 bg-light rounded shadow mb-4 text-center p-5">
        <h4 class="mb-4">
            {{ ($read_sch)? 'Update ' : 'Offer New '  }} Scholarship
        </h4 >  
        @if (session('status'))
            <p class="alert-danger rounded p-1"> {{ session('status') }} </p>    
        @endif  

        <form action="{{ route('su.scholarships') }}" method="POST">
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
                <input type="number" step="0.01" name="gpa_min" id="gpa_min" placeholder="Minimum GPA" class="form-control" value="{{ ($read_sch)?$read_sch->gpa_min : old('gpa_min') }}">
            </div>
            @error('gpa_min')
                <p class="text-danger text-left mb-0 pb-0"><small> {{ $message }} </small></p>
            @enderror

            <div class="input-group form-group mt-4 mb-0">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-pen"></i></span>
                </div>
                <input type="number" step="0.01" name="gpa_max" id="gpa_max" placeholder="Maximum GPA" class="form-control" value="{{ ($read_sch)?$read_sch->gpa_max : old('gpa_max') }}">
            </div>
            @error('gpa_max')
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

            <button type="submit" class="btn btn-block mt-4 {{ ($read_sch)? 'btn-success' : 'btn-info'}}">{{ ($read_sch)? 'Update ' : 'Register'  }} Scholarship</button>
            @if ($read_sch)
            <a href="{{ route('su.scholarships') }}" class="btn btn-block btn-info mt-4">Cancel Edit</a>
            @endif
        </form>
    </div>
    <div class="table-responsive m-0 p-0 mb-5">
    <table class="table table-bordered table-hover text-center table-sm table-striped table-light">
        <thead>
            <tr aria-rowspan="2">
                <th>Code</th> 
                <th>Description</th> 
                <th>Type</th> 
                <th>Min GPA</th>
                <th>Max GPA</th>
                <th>Lowest Grade</th>
                <th>Status</th> 
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($scholarships as $scholarship)
            <tr>
                <td>{{ $scholarship->scholarship_code }}</td>
                <td>{{ $scholarship->description }}</td>
                <td>{{ $scholarship->type }}</td>
                <td>{{ $scholarship->gpa_min }}</td>
                <td>{{ $scholarship->gpa_max }}</td>
                <td>{{ $scholarship->lowest_grade }}</td>
                <td>{{ $scholarship->active }}</td>
                <td>
                <form action="{{ route('su.scholarships') }}" method="post" class="btn btn-sm">
                    @csrf
                    @method('patch')
                    <input type="hidden" name="scholarship_id" value="{{ $scholarship->id }}">
                    <input type="hidden" name="active" value="{{ ($scholarship->active == 'ACTIVE')? 'ACTIVE' : 'INACTIVE' }}">
                    <button type="submit" class="btn btn-sm {{ ($scholarship->active == 'ACTIVE')? ' btn-danger ': 'btn-success' }}">{{ ($scholarship->active == 'ACTIVE')? 'DEACTIVATE':'ACTIVATE' }}</button>
                </form>
                <a href="{{ route('su.scholarships', ['scholarship_id' => $scholarship->id]) }}" class="btn btn-sm btn-info px-4"> EDIT </a>
                </td>          
            </tr>      
            @endforeach   
            <tr>
                <td colspan="9">
                    @if (!$scholarships->count())
                      <p class="d-block alert-warning">No Records Found</p>  
                    @endif
                </td>
            </tr>         
        </tbody>
    </table>
    </div>
</div>


@endsection