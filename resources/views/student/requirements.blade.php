@extends('layouts.mainview')

@section('active_view')
@if(auth()->user()->student->scholarships->where('id', $sch_id)->first()->status === 'REQUIREMENTS FOR UPLOAD')
    <h4 class="mb-4">
        Upload Requiremnts
    </h4>
    @if (session('status'))
        <p class="alert-danger rounded p-1"> {{ session('status') }} </p>    
    @endif
    <p class="text-left"><i>Accepted file type: .PDF, .JPG, .JPEG</i></p>
    <form action="{{ route('student.requirements') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" value="{{ $sch_id }}" name="sch_id">
        @if($rq = $requirements->where('status', 'TO UPLOAD')->all())
        @foreach ($rq as $requirement)
            <div class="form-group text-left mb-3">
                <label for="rq{{ $requirement->requirement_id }}">{{ $requirement->requirement->document_name }}</label>
                <input type="file" name="rq{{ $requirement->requirement_id }}" id="rq{{ $requirement->requirement_id }}" class="form-control-file border" required>
            </div>

        @error('rq'.$requirement->requirement_id)
            <p class="text-danger text-left mb-0 pb-0"><small> {{ $message }} </small></p>
        @enderror
        @endforeach
        @endif
        <button type="submit" class="btn btn-success btn-block mt-4">Upload Requirements</button>
        <a href="{{ route('student.scholarships', ['scholarship_id' => $sch_id]) }}" class="btn btn-sm px-4 btn-info btn-block mt-4">BACK</a>
    </form>
@else 
    <h4>Requirements</h4>
    <a href="{{ route('student.scholarships', ['scholarship_id' => $sch_id]) }}" class="btn btn-sm px-4 btn-info btn-block mt-4">Back</a>
@endif
@endsection
@section('bottom_view')
<table class="table table-bordered table-hover text-center table-sm table-striped table-light">
    <thead>
        <tr>
            <th>Document</th> 
            <th>Status</th> 
            <th>Comments</th> 
        </tr>
    </thead>
    <tbody>
        @foreach ($requirements as $requirement)
        <tr>
            <td>{{ $requirement->requirement->document_name }}</td>
            <td>{{ $requirement->status }}</td>
            <td>{{ $requirement->comments }}</td>
        </tr>      
        @endforeach    
        <tr>
            <td colspan="3">
                @if (!$requirements->count())
                  <p class="d-block alert-warning">No Records Found</p>  
                @endif
            </td>
        </tr>        
    </tbody>
</table>
@endsection