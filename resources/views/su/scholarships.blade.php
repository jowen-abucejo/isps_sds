@extends('layouts.mainview')

@section('active_view')
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
                <input type="number" min="1.00" max="5.00" step="0.01" name="gpa_min" id="gpa_min" placeholder="Minimum GPA" class="form-control" value="{{ ($read_sch)?$read_sch->qualification->gpa_min : old('gpa_min') }}">
            </div>
            @error('gpa_min')
                <p class="text-danger text-left mb-0 pb-0"><small> {{ $message }} </small></p>
            @enderror

            <div class="input-group form-group mt-4 mb-0">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-pen"></i></span>
                </div>
                <input type="number" min="1.00" max="5.00" step="0.01" name="gpa_max" id="gpa_max" placeholder="Maximum GPA" class="form-control" value="{{ ($read_sch)?$read_sch->qualification->gpa_max : old('gpa_max') }}">
            </div>
            @error('gpa_max')
                <p class="text-danger text-left mb-0 pb-0"><small> {{ $message }} </small></p>
            @enderror

            <div class="input-group form-group mt-4 mb-0">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-pen"></i></span>
                </div>
                <input type="number" step="0.01" name="lowest_grade" id="lowest_grade" placeholder="Lowest Grade Required" class="form-control" value="{{ ($read_sch)?$read_sch->qualification->lowest_grade : old('lowest_grade') }}">
            </div>
            @error('lowest_grade')
                <p class="text-danger text-left mb-0 pb-0"><small> {{ $message }} </small></p>
            @enderror

            <div class="input-group form-group mt-4 mb-4">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-pen"></i></span>
                </div>
                <input type="number" step="1" name="minimum_units" min="0" id="minimum_units" placeholder="Minimum Units" class="form-control" value="{{ ($read_sch)?$read_sch->qualification->minimum_units : old('minimum_units') }}">
            </div>
            @error('minimum_units')
                <p class="text-danger text-left mb-0 pb-0"><small> {{ $message }} </small></p>
            @enderror

            <div class="form-group form-check-inline">
                <input name="allow_inc" type="checkbox" class="form-check-input" id="allow_inc" @if($read_sch) {{ ($read_sch->qualification->allow_inc)? 'checked': '' }} @else {{ (old('allow_inc'))? 'checked' : '' }} @endif>
                <label class="form-check-label" for="allow_inc">Allow INC grades</label>
            </div>
            
            <div class="form-group form-check-inline">
                <input name="allow_drop" type="checkbox" class="form-check-input" id="allow_drop" @if($read_sch) {{ ($read_sch->qualification->allow_drop)? 'checked': '' }} @else {{ (old('allow_drop'))? 'checked' : '' }} @endif>
                <label class="form-check-label" for="allow_drop">Allow DROP grades</label>
            </div>

            <button type="submit" class="btn btn-block mt-4 {{ ($read_sch)? 'btn-success' : 'btn-info'}}">{{ ($read_sch)? 'Update ' : 'Register'  }} Scholarship</button>
            @if ($read_sch)
            <a href="{{ route('su.scholarships') }}" class="btn btn-block btn-info mt-4">Cancel Edit</a>
            @endif
        </form>
@endsection
@section('bottom_view')

    <div class="table-responsive m-0 p-0 mb-5">
    <table class="table table-bordered table-hover text-center table-sm table-striped table-light">
        <thead>
            <tr aria-rowspan="2">
                <th>Code</th> 
                <th>Description</th> 
                <th>Type</th> 
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
                <td colspan="5">
                    @if (!$scholarships->count())
                      <p class="d-block alert-warning">No Records Found</p>  
                    @endif
                </td>
            </tr>         
        </tbody>
    </table>
@endsection