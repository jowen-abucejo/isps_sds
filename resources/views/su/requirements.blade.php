@extends('layouts.mainview')
@section('active_view')
        <h4 class="mb-4">
            {{ ($read_req)? 'Update ' : 'Register New '  }} Requirement
        </h4 > 
        @if (session('status'))
            <p class="alert-danger rounded p-1"> {{ session('status') }} </p>    
        @endif  

        <form action="{{ route('su.requirements') }}" method="POST">
            @csrf
            @if ($read_req)
                <input type="hidden" name="toUpdate" value="{{ $read_req->id }}">
            @endif
            <div class="input-group form-group mt-4 mb-0">
                <textarea class="form-control" id="document_name" name="document_name" rows="2" placeholder="Document Name">{{ ($read_req)?$read_req->document_name : old('document_name') }}</textarea>
            </div>
            @error('document_name')
                <p class="text-danger text-left mb-0 pb-0"><small> {{ $message }} </small></p>
            @enderror

            <div class="text-left p-0 m-0 mb-2 mt-4">Require This For:</div>
            <div class="input-group form-group mb-0">
                @if($scholarships->count())
                @foreach ($scholarships as $scholarship )
                <div class="form-group form-check-inline  text-left w-100 px-3">
                    <input name="required_for[]" type="checkbox" class="form-check-input" id="{{ $scholarship->scholarship_code }}{{ $scholarship->id }}" value="{{ $scholarship->id }}"@if($read_req) @if($read_req->scholarships->contains($scholarship->id)) checked @endif @endif>
                    <label class="form-check-label" for="{{ $scholarship->scholarship_code }}{{ $scholarship->id }}">{{ $scholarship->description }}  {{ $scholarship->type }}</label>
                </div>
                @endforeach
                @endif
            </div>

            <button type="submit" class="btn btn-block mt-4 {{ ($read_req)? 'btn-success' : 'btn-info' }}">{{ ($read_req)? 'Update ' : 'Register'  }} Requirement</button>
            @if ($read_req)
                <a href="{{ route('su.requirements') }}" class="btn btn-block btn-info mt-4">Cancel Edit</a>
            @endif
        </form>
@endsection
@section('bottom_view')
    <table class="table table-bordered table-hover text-center table-sm table-striped table-light">
        <thead>
            <tr>
                <th>Document</th> 
                <th>Required For</th> 
                <th>Status</th>
                <th>Action</th> 
            </tr>
        </thead>
        <tbody>
            @if($requirements->count())
            @foreach ($requirements as $requirement)
            <tr>
                <td>{{ $requirement->document_name }}</td>
                <td>
                    @isset($requirement->scholarships)
                    @foreach ($requirement->scholarships as $scholarship)
                    {{(!$scholarship->type)? $scholarship->scholarship_code : $scholarship->type }},&nbsp;
                    @endforeach
                    @endisset
                </td>
                <td>{{ $requirement->status }}</td>
                <td>
                <form action="{{ route('su.requirements') }}" method="post" class="btn btn-sm">
                    @csrf
                    @method('patch')
                    <input type="hidden" name="req_id" value="{{ $requirement->id }}">
                    <input type="hidden" name="status" value="{{ ($requirement->status == 'ACTIVE')? 'ACTIVE' : 'INACTIVE' }}">
                    <button type="submit" class="btn btn-sm {{ ($requirement->status == 'ACTIVE')? ' btn-danger ': 'btn-success' }}">{{ ($requirement->status == 'ACTIVE')? 'DEACTIVATE':'ACTIVATE' }}</button>
                </form>
                <a href="{{ route('su.requirements', ['requirement_id' => $requirement->id]) }}" class="btn btn-sm btn-info px-4"> EDIT </a>
                </td>          
            </tr>      
            @endforeach  
            @endif  
            <tr>
                <td colspan="4">
                    @if (!$requirements->count())
                      <p class="d-block alert-warning">No Records Found</p>  
                    @endif
                </td>
            </tr>        
        </tbody>
    </table>
@endsection